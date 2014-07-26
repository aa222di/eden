<?php
/**
 * CContent to manage CRUD for given database
 *
 */

class CContent extends CDatabase {

	// MEMBERS
	private $user;

	// CONSTRUCTOR

  /**
   * Constructor creating a PDO object connecting to a choosen database.
   *
   * @param array $options containing details for connecting to the database.
   *
   */
  public function __construct($options) {
  	parent::__construct($options);
  	$this->user = new CUser($options, 'USER');

  	
	}

	// METHODS

	/**
	 * createTable initiates the table structure 
	 *
	 */
public function createTable() {
	$sql = <<<EOD
USE edenpress;

Drop view if exists VComplete;
Drop view if exists VContent;
DROP TABLE IF EXISTS User2Content;
Drop table if exists Cat2Content;
--
-- Create table for Content
--
DROP TABLE IF EXISTS Content;
CREATE TABLE Content
(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  slug CHAR(80) UNIQUE,
  url CHAR(80) UNIQUE,
 
  TYPE CHAR(80),
  title VARCHAR(80),
  DATA TEXT,
  FILTER CHAR(80),
 
  published DATETIME,
  created DATETIME,
  updated DATETIME,
  deleted DATETIME
 
) ENGINE INNODB CHARACTER SET utf8;

SHOW CHARACTER SET;
SHOW COLLATION LIKE 'utf8%';

INSERT INTO Content (slug, url, TYPE, title, DATA, FILTER, published, created) VALUES
  ('hem', 'hem', 'page', 'Hem', "Detta är min hemsida. Den är skriven i [url=http://en.wikipedia.org/wiki/BBCode]bbcode[/url] vilket innebär att man kan formattera texten till [b]bold[/b] och [i]kursiv stil[/i] samt hantera länkar.\n\nDessutom finns ett filter 'nl2br' som lägger in <br>-element istället för \\n, det är smidigt, man kan skriva texten precis som man tänker sig att den skall visas, med radbrytningar.", 'bbcode,nl2br', NOW(), NOW())
  ;

DROP TABLE IF EXISTS USER;
CREATE TABLE `USER` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acronym` char(12) NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `salt` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acronym` (`acronym`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO USER (acronym, name, salt) VALUES 
  ('amanda', 'Amanda Åberg', unix_timestamp()),
  ('doe', 'John/Jane Doe', unix_timestamp())
;
 
UPDATE USER SET password = md5(concat('amanda', salt)) WHERE acronym = 'amanda';
UPDATE USER SET password = md5(concat('doe', salt)) WHERE acronym = 'doe';

CREATE TABLE `User2Content` (
  `idUser` int(11) NOT NULL,
  `idContent` int(11) NOT NULL,
  PRIMARY KEY (`idUser`,`idContent`),
  KEY `idContent` (`idContent`),
  CONSTRAINT `user2content_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `USER` (`id`),
  CONSTRAINT `user2content_ibfk_2` FOREIGN KEY (`idContent`) REFERENCES `Content` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `User2Content`
(`idUser`,
`idContent`)
VALUES
(5, 1)
;


Create view VContent AS
Select C.*, U.name AS user, U.id as Uid FROM Content C 
left join User2Content U2C on U2C.idContent = C.id
left join USER U on U2C.idUser = U.id
group by C.id;

Drop table if exists Categories;
Create table Categories
(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  name CHAR(20) NOT NULL 
) ENGINE INNODB CHARACTER SET utf8;

Insert into Categories (name) values
('personligt'), ('webbutveckling'), ('nyheter'), ('css'), ('php')
;

Create table Cat2Content
(
  idCat INT(11) NOT NULL,
  idContent INT(11) NOT NULL,
  Primary Key (idCat, idContent),

  FOREIGN KEY (idCat) REFERENCES Categories (id),
  FOREIGN KEY (idContent) REFERENCES Content (id)

) ENGINE INNODB CHARACTER SET utf8;

Insert into Cat2Content (idCat, idContent) values
(1, 1)
;

CREATE VIEW VComplete
AS
SELECT 
  C.*,
  GROUP_CONCAT(Cat.name) AS categories
FROM VContent AS C
  LEFT OUTER JOIN Cat2Content AS C2C
    ON C.id = C2C.idContent
  LEFT OUTER JOIN Categories AS Cat
    ON C2C.idCat = Cat.id
GROUP BY C.id
;

 
EOD;

$this->ExecuteQuery($sql, array());

 header('Location: edenpress_create.php');


}


	/**
	 * showAllContent shows a list of all the content 
	 * @param published boolean defaults to true
	 * @param params array, parameters to be included in query, default empty
	 * @return string to display result
	 *
	 */
public function showAllContent($params = array('published' => true,)) {
	$html = null;
	// Get content
	$res = $this->Select($params);

	if (!$res) {
		$html = "<p>Just nu finns det inget innehåll, vill du <a href='?create'>börja skapa innehåll?</a></p>";
	}
	else {
	// Display it
	$html = "<h2>Innehåll</h2><p>Här visas allt innehåll i Edenpress</p><ul>";

	foreach ($res as $key => $value) {
		$editLink = isset($_SESSION['user']) ? "<a href='edenpress_edit.php?id={$value->id}'> - editera</a>" : null;
		$deleteLink = isset($_SESSION['user']) ? "<a href='?delete&id={$value->id}'> - radera</a>" : null;
		$html .= "<li>{$value->TYPE} - <a href='" . $this->getUrlToContent($value) . "'' title ='{$value->title}'>{$value->title}</a> skriven av {$value->user} (" . (!$value->available ? "inte " : null) . "publicerad) {$editLink} {$deleteLink}</li>\n";
	}
	$html .= "</ul>";
	$createLink = isset($_SESSION['user']) ? '<a href="edenpress_create.php" title="Skapa nytt innehåll" class="smallbutton">Skapa nytt innehåll</a>' : null;
	$html .= $createLink;
	}

	return $html;

}


	/**
	 * deleteContent deletes content from database
	 * @param int id, content o be deleted
	 * @return string 
	 *
	 */
public function deleteContent($id) {
		// Check for user
	$user = isset($_SESSION['user']) ? $_SESSION['user']->name : null;
	isset($user) or die('Check: You must login to delete.');
	$confirm = isset($_GET['confirm']) ? true : false;
	if (!$confirm) {
		$output = $this->confirmDelete($id);
	}
	elseif($confirm) {

		$output = null;

	  $sql = 'DELETE FROM User2Content WHERE idContent= ?';
	  $this->ExecuteQuery($sql, array($id));
	  $output = $this->SaveDebug("Det raderades " . $this->RowCount() . " rader från databasen: User2Content.");
	 
	  $sql = 'DELETE FROM Cat2Content WHERE idContent= ?';
	  $this->ExecuteQuery($sql, array($id));
	  $output = $this->SaveDebug("Det raderades " . $this->RowCount() . " rader från databasen: Cat2Content.");
	 
	  $sql = 'DELETE FROM Content WHERE id = ? LIMIT 1';
	  $this->ExecuteQuery($sql, array($id));
	  $output .= $this->SaveDebug(" Det raderades " . $this->RowCount() . " rader från databasen: Content.");
	}

	return $output;
}


	/**
	 * updateContent updates the content in the chosen database
	 * @param int id, content to be updated
	 * @return string 
	 *
	 */

public function updateContent($id) {
	$output = null;
	// Check for user
	$user = isset($_SESSION['user']) ? $_SESSION['user']->name : null;
	isset($user) or die('Check: You must login to update.');

	if (isset($_POST['save'])) {
		// Get parameters 
		$id     = isset($_POST['id'])    ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
		$title  = isset($_POST['title']) ? $_POST['title'] : null;
		$slug   = isset($_POST['slug'])  ? $this->slugify($_POST['slug'])  : null;
		$url    = isset($_POST['url']) && !empty($_POST['url']) ? strip_tags($_POST['url']) : null;
		$data   = isset($_POST['data'])  ? $_POST['data'] : array();
		$type   = isset($_POST['type'])  ? strip_tags($_POST['type']) : array();
		$filter = isset($_POST['filter']) ? $_POST['filter'] : 'nl2br';
		$published = isset($_POST['published'])  ? strip_tags($_POST['published']) : array();
		$categories = isset($_POST['categories']) ? $_POST['categories'] : array();

		$values = array();
		// Tie content to categories
		foreach ($categories as $key) {
			$values[]= '('. $id . ',' . $key . ')';
		}
		$VALUES = implode(',', $values);
		$sql = 'INSERT INTO Cat2Content (idContent, idCat) VALUES ' . $VALUES . ';';
		$this->ExecuteQuery($sql);

		// Update content
		 $sql = '
	    UPDATE Content SET
	      title   = ?,
	      slug    = ?,
	      url     = ?,
	      data    = ?,
	      type    = ?,
	      filter  = ?,
	      published = ?,
	      updated = NOW()
	    WHERE 
	      id = ?
	  ';
	    $params = array($title, $slug, $url, $data, $type, $filter, $published, $id);
	    $res = $this->ExecuteQuery($sql, $params);

	     if($res) {
	    $output = 'Informationen sparades.';
	  }
	  else {
	    $output = 'Informationen sparades EJ.<br><pre>' . print_r($db->ErrorInfo(), 1) . '</pre>';
	  }
	  	$html = $this->getEditForm($id, $output);
	}
	else {
		$html = $this->getEditForm($id, $output);
	}
	return $html;
}

	/**
	 * createContent
	 * @return string 
	 *
	 */

 public function createContent() {

 	// Get parameters 
	$title  = isset($_POST['title']) ? $_POST['title'] : null;
	$slug   = isset($title)  ? $this->slugify($title)  : null;
	$url    = isset($slug)   ? $slug : null;
	$type   = isset($_POST['type'])  ? strip_tags($_POST['type']) : array();
	$filter = isset($_POST['filter']) ? $_POST['filter'] : 'nl2br';
	$user   = isset($_SESSION['user']) ? $_SESSION['user']->id : null;


	// Check that incoming parameters are valid
	isset($user) or die('Check: You must login to create.');

	// Check if form was submitted
	$output = null;

	  $sql = "
	    INSERT INTO Content
	    (slug, url, TYPE, title, FILTER, published, created) 
	    VALUES (?, ?, ?, ?, ?, NOW(), NOW());";

	  $url = empty($url) ? null : $url;
	  $params = array($slug, $url, $type, $title, $filter,);
	  $res = $this->ExecuteQuery($sql, $params);
	  $idContent = $this->LastInsertId();

	  $this->user->User2Content($idContent);
	

	  if($res) {
	    header('Location: edenpress_edit.php?id=' . $idContent);
	  }
	  else {
	    $output = 'Informationen sparades EJ.<br><pre>' . print_r($this->ErrorInfo(), 1) . '</pre>';
	  }
	
	return $output;

 }

	/**
	 * confirmDelete to build confirm form for deletion of content
	 * @param id, content o be deleted
	 * @return string 
	 *
	 */
private function confirmDelete($id) {
	$res = $this->Select(array( 'equals' 	=> array('id' => $id,),
									'published' => true,));
	$html = null;
	if($res){
	$html = <<<EOD
	<p>Är du säker på att du vill radera {$res[0]->title} ({$res[0]->TYPE} med id: {$res[0]->id})?</p>
	<a class="smallbutton" href="?confirm&delete&id={$res[0]->id}" title="radera">Radera</a>
	<a class="smallbutton" href="?" title="regret">Ångra</a>
EOD;
	}
	else {
		$html = "<p>Det finns inget innehåll med id: {$id}";
	}
	return $html;

}



	/**
	 * Create a link to the content, based on its type.
	 *
	 * @param object $content to link to.
	 * @return string with url to display content.
	 */
private function getUrlToContent($content) {
	  switch($content->TYPE) {
	    case 'page': return "edenpress_page.php?url={$content->url}"; break;
	    case 'post': return "edenpress_blog.php?slug={$content->slug}"; break;
	    default: return null; break;
	  }
	}


	/**
	 * Select builds query 
	 * @param params multidimensional array sets conditions for select
	 * @param table string, table to be queried
	 * @return array with objects from query
	 *
	 */
public function Select($params = array(), $table = 'VContent') {
	// Build query
	$sqlOrig = "SELECT *";
	$onlyPublished = isset($params['published']) ? ", (published <= NOW()) AS available" : null;

	$condition = null;
	$parameters = array();
		if (isset($params['equals'])) {
			foreach ($params['equals'] as $key => $value) {
				$condition .= " AND " . $key . " = ?";
				$parameters[] = $value;
			}
		}
		if (isset($params['like'])) {
			foreach ($params['like'] as $key => $value) {
				$condition .= " AND " . $key . " LIKE ?";
				$parameters[] = $value;
			}
		}
	$where = " WHERE 1" . $condition . ";";
	$sql = $sqlOrig . $onlyPublished . " FROM " . $table . $where;

	// Do SELECT from a table
	$res = $this->ExecuteSelectQueryAndFetchAll($sql, $parameters);

	return $res;

}



private function getCategoriesAsCheckboxes($id) {
	// Get all categories
	$categories = $this->Select(array(), 'Categories');
	// Check if content is already tied to some catgories
	$Cat2Content = $this->Select(array('equals' => array( 'idContent' => $id,)), 'Cat2Content');
	$chosenCategories = array();
	foreach ($Cat2Content as $key) {
		$chosenCategories[] = $key->idCat;
	}

	$catCheckbox = null;
	$checked = null;
	foreach ($categories as $key) {
		$checked = in_array($key->id, $chosenCategories) ? 'checked' : null;
		$catCheckbox .= '<input type="checkbox" name="categories[]" value="' . $key->id . '" '. $checked .'> ' . $key->name . '<br>';
	}

	return $catCheckbox;
}

	/**
	 * getEditForm builds the form for editing content
	 * @param int id, content to be updated
	 * @param string output
	 * @return string 
	 *
	 */

private function getEditForm($id, $output) {
	// Get categories
	$categories = $this->getCategoriesAsCheckboxes($id);

	$res = $this->Select(array('equals' => array('id' => $id,),), 'VContent');

	if(isset($res[0])) {
	  $c = $res[0];
	}
	else {
	  die('Misslyckades: det finns inget innehåll med sådant id.');
	}

	// Sanitize content before using it.
	$title  = htmlentities($c->title, null, 'UTF-8');
	$slug   = htmlentities($c->slug, null, 'UTF-8');
	$url    = htmlentities($c->url, null, 'UTF-8');
	$data   = htmlentities($c->DATA, null, 'UTF-8');
	$type   = htmlentities($c->TYPE, null, 'UTF-8');
	$filter = htmlentities($c->FILTER, null, 'UTF-8');
	$published = htmlentities($c->published, null, 'UTF-8');



	$html = <<<EOD
	<h2>Uppdatera innehåll för {$title}</h2>
	<p>skriven av {$c->user}</p>

	<form method=post class="edit">
	  <fieldset>
	  <legend>Uppdatera innehåll</legend>
	  {$output}
	  <input type='hidden' name='id' value='{$id}'/>
	  <p><label>Titel:<br/><input type='text' name='title' value='{$title}'/></label></p>
	  <p><label>Slug:<br/><input type='text' name='slug' value='{$slug}'/></label></p>
	  <p><label>Url:<br/><input type='text' name='url' value='{$url}'/></label></p>
	  <p><label>Text:<br/><textarea name='data'>{$data}</textarea></label></p>
	  <p><label>Type:<br/><input type='text' name='type' value='{$type}'/></label></p>
	  <p><label>Filter:<br/><input type='text' name='filter' value='{$filter}'/></label></p>
	  <p><label>Publiceringsdatum:<br/><input type='text' name='published' value='{$published}'/></label></p>
	  {$categories}
	  <p class=buttons><input type='submit' name='save' value='Spara'/></p>
	  
	  </fieldset>
	</form>
EOD;

	return $html;
 }

 /**
 * Create a slug of a string, to be used as url.
 *
 * @param string $str the string to format as slug.
 * @returns str the formatted slug. 
 */
private function slugify($str) {
  $str = mb_strtolower(trim($str), 'UTF-8');
  $str = str_replace(array('å','ä','ö'), array('a','a','o'), $str);
  $str = preg_replace('/[^a-z0-9-]/', '-', $str);
  $str = trim(preg_replace('/-+/', '-', $str), '-');
  return $str;
}




}