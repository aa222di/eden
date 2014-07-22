<?php
/**
 * CContent to manage CRUD for given database
 *
 */

class CContent extends CDatabase {

	//MEMBERS

	private $table = null; // Chosen table to query

	// CONSTRUCTOR

  /**
   * Constructor creating a PDO object connecting to a choosen database.
   *
   * @param array $options containing details for connecting to the database.
   *
   */
  public function __construct($options, $table) {
  	parent::__construct($options);
  	$this->table = $table;
	}




	// METHODS



	/**
	 * showAllContent shows a list of all the content 
	 * @param published boolean defaults to true
	 * @param params array, parameters to be included in query, default empty
	 * @return string to display result
	 *
	 */
public function showAllContent($published = true, $params = array()) {
	$html = null;
	// Get content
	$res = $this->getContent($published, $params);

	// Display it
	$html = "<h2>Innehåll</h2><p>Här visas allt innehåll i Edenpress</p><ul>";

	foreach ($res as $key => $value) {
		$editLink = isset($_SESSION['user']) ? "<a href='edenpress_edit.php?id={$value->id}'>editera</a>" : null;
		$deleteLink = isset($_SESSION['user']) ? "<a href='?delete&id={$value->id}'>radera</a>" : null;
		$html .= "<li>{$value->TYPE} - <a href='" . $this->getUrlToContent($value) . "'' title ='{$value->title}'>{$value->title}</a> - (" . (!$value->available ? "inte " : null) . "publicerad) - {$editLink} - {$deleteLink}</li>\n";
	}
	$html .= "</ul>";
	$createLink = isset($_SESSION['user']) ? '<p><a href="edenpress_create.php" title="Skapa nytt innehåll">Skapa nytt innehåll</a></p>' : null;
	$html .= $createLink;

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
	$sql = "DELETE FROM Content WHERE id = ? LIMIT 1;";
	$res = $this->ExecuteQuery($sql, array($id,));
	$output = ($this->RowCount() == 1) ? "1 rad raderades från databasen": null;
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
		$slug   = isset($_POST['slug'])  ? $_POST['slug']  : null;
		$url    = isset($_POST['url']) && !empty($_POST['url']) ? strip_tags($_POST['url']) : null;
		$data   = isset($_POST['data'])  ? $_POST['data'] : array();
		$type   = isset($_POST['type'])  ? strip_tags($_POST['type']) : array();
		$filter = isset($_POST['filter']) ? $_POST['filter'] : 'nl2br';
		$published = isset($_POST['published'])  ? strip_tags($_POST['published']) : array();


		 $sql = '
	    UPDATE ' . $this->table . ' SET
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
	$filter = isset($_POST['filter']) ? $_POST['filter'] : array('nl2br',);
	$user = isset($_SESSION['user']) ? $_SESSION['user']->name : null;


	// Check that incoming parameters are valid
	isset($user) or die('Check: You must login to create.');

	// Check if form was submitted
	$output = null;

	  $sql = '
	    INSERT INTO  ' . $this->table . ' 
	    (slug, url, TYPE, title, FILTER, published, created) 
	    VALUES (?, ?, ?, ?, ?, NOW(), NOW());';

	  $url = empty($url) ? null : $url;
	  $params = array($slug, $url, $type, $title, $filter,);
	  $res = $this->ExecuteQuery($sql, $params);
	  if($res) {
	    header('Location: edenpress_edit.php?id=' . $this->LastInsertId());
	  }
	  else {
	    $output = 'Informationen sparades EJ.<br><pre>' . print_r($db->ErrorInfo(), 1) . '</pre>';
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
	$res = $this->getContent(true, array('id' => $id,));
	$html = null;
	if($res){
	$html = <<<EOD
	<p>Är du säker på att du vill radera {$res[0]->title} ({$res[0]->TYPE} med id: {$res[0]->id})?</p>
	<a class="button" href="?confirm&delete&id={$res[0]->id}" title="radera">Radera</a>
	<a class="button" href="?" title="regret">Ångra</a>
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
	 * getContent builds query 
	 * @param published boolean defaults to true
	 * @param params array, parameters to be included in query
	 * @return array with objects from query
	 *
	 */
private function getContent($published = true, $params) {

	// Parameters
	$id = null;
	$type = null;
	$parameters = array();

	// Build query
	$sqlOrig = "SELECT *";
	$onlyPublished = $published ? ", (published <= NOW()) AS available" : null;

	if (isset($params['id'])) {
		$id = " AND id = ?";
		$parameters[] = $params['id'];
	}
		if (isset($params['type'])) {
		$type = " AND TYPE = ?";
		$parameters[] = $params['type'];
	}
	$where = " WHERE 1" . $id . $type . ";";
	$sql = $sqlOrig . $onlyPublished . " FROM " . $this->table . $where;

	// Do SELECT from a table
	$res = $this->ExecuteSelectQueryAndFetchAll($sql, $parameters);

	return $res;

}

	/**
	 * getEditForm builds the form for editing content
	 * @param int id, content to be updated
	 * @param string output
	 * @return string 
	 *
	 */

private function getEditForm($id, $output) {
	$res = $this->getContent(false, array('id' => $id,));
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

	<form method=post>
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
	  <p class=buttons><input type='submit' name='save' value='Spara'/></p>
	  <p><a href='view.php'>Visa alla</a></p>
	  <output></output>
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
  $str = mb_strtolower(trim($str));
  $str = str_replace(array('å','ä','ö'), array('a','a','o'), $str);
  $str = preg_replace('/[^a-z0-9-]/', '-', $str);
  $str = trim(preg_replace('/-+/', '-', $str), '-');
  return $str;
}




}