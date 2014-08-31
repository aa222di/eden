<?php

/**
 *	CEdit extends CRUD but specifies in creating and editing data for the tables movies, user and blog/content in the database
 *
 *
 */

class CEdit extends CCRUD {

// MEMBERS
	private $CForm; // Form object
	private $disabled; // boolean, keeps track of user authority and enables/disables form accordingly
	private $message; // string, informs memeber about admin authority

// PUBLIC METHODS
public function __construct($options) {
	
		parent::__construct($options);
		
		$this->CForm = new CForm();	

		// Check user authority and toggle disabled
		$this->disabled = ($_SESSION['user']->authority == 'admin') ? false : true;
		$this->message = ($_SESSION['user']->authority == 'admin') ? null : "<output class='info'>Only members with admin authority can change, create or update content</output>";
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////// FORM METHODS (movie, blog and profile) ////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * Creates form filled with content or empty if param id is null
 * @param $id, int, 
 * @return string
 */
public function movieForm($id) {
	
	if($id) {
		$res = $this->SELECT(array('equals' => array('id' => $id,),), 'vmovieRM');
	}

	
	// Get all genres and chosen genres for movie
	$allGenres = $this->Select(array('distinct' => 'name'), 'genresRM');
	foreach ($allGenres as $key) {
		$genres[] = $key->name;
	}
	if($id){
		$inQuery = '(SELECT DISTINCT idGenre FROM movie2genreRM WHERE idMovie =' . $id . ');';
		$selectedGenres = $this->Select(array('distinct' => 'name',		'in' => array( 'id' => $inQuery,)), 'genresRM');

		foreach ($selectedGenres as $key) {
			$selected[] = $key->name;
		}
	}

	// Get form values
	$title		= isset($res[0]->title)		? htmlspecialchars($res[0]->title, ENT_QUOTES, 'UTF-8')		: null;
	$director	= isset($res[0]->director)	? htmlspecialchars($res[0]->director, ENT_QUOTES, 'UTF-8')	: null;
	$year		= isset($res[0]->year)		? $res[0]->year										: null;
	$price		= isset($res[0]->price)		? $res[0]->price									: null;
	$img		= isset($res[0]->img)		? htmlspecialchars($res[0]->img, ENT_QUOTES, 'UTF-8')			: null;
	$imgfolder	= isset($res[0]->imgfolder)	? htmlspecialchars($res[0]->imgfolder, ENT_QUOTES, 'UTF-8')	: null;
	$info		= isset($res[0]->info)		? strip_tags($res[0]->info,'<p><a><br><b>')			: null;
	$link		= isset($res[0]->link)		? $res[0]->link										: null;
	$trailer	= isset($res[0]->trailer)	? $res[0]->trailer									: null;
	$selected	= isset($selected)			? $selected											: array();
	$submit		= isset($res) 				? 'Save changes'									: 'Add movie';

	// Create the array for storing the form 
	$inputfields = array();

	$inputfields[]['text'] =		array('name' => 'title', 		'label' => 'Title', 				'value' => $title,							'disabled' => $this->disabled,);
	$inputfields[]['text'] =		array('name' => 'director', 	'label' => 'Director', 				'value' => $director,						'disabled' => $this->disabled,);
	$inputfields[]['number'] =		array('name' => 'year', 		'label' => 'Year', 					'value' => $year,							'disabled' => $this->disabled,);
	$inputfields[]['number'] =		array('name' => 'price', 		'label' => 'Price', 				'value' => $price,							'disabled' => $this->disabled,);
	$inputfields[]['text'] =		array('name' => 'img', 			'label' => 'Path to cover image', 	'value' => $img,							'disabled' => $this->disabled,);
	$inputfields[]['text'] =		array('name' => 'imgfolder', 	'label' => 'Image directory', 		'value' => $imgfolder,						'disabled' => $this->disabled,);
	$inputfields[]['textarea'] =	array('name' => 'info', 		'label' => 'Plot', 					'value' => $info,							'disabled' => $this->disabled,);
	$inputfields[]['text'] =		array('name' => 'link', 		'label' => 'Link to imdb', 			'value' => $link,							'disabled' => $this->disabled,);
	$inputfields[]['text'] =		array('name' => 'trailer', 		'label' => 'Link to trailer', 		'value' => $trailer,						'disabled' => $this->disabled,);
	$inputfields[]['checkbox'] =	array('name' => 'genre[]', 		'label' => 'Genre', 				'value' => $genres, 'chosen' => $selected,	'disabled' => $this->disabled,);

	$inputfields[]['submit'] = array('name' => 'submit', 'value' => $submit,'disabled' => $this->disabled,);
	$form = $this->message;
	$form .= $this->CForm->getForm($inputfields, 'POST', 'edit-movie');

	$this->parameters = $this->CForm->getData();

	//var_dump($res);
	return $form;
}

/**
 * Creates form filled with content or empty if param id is null
 * @param $id, int, 
 * @return string
 */
public function blogForm($id) {
	$inputfields = array();
	if($id) {
		$res = $this->SELECT(array('equals' => array('id' => $id,),), 'ContentRM');
	}
		$categories = $this->SELECT(array('distinct' => 'category',), 'ContentRM');
		foreach ($categories as $key) {
			$categoryList[] = $key->category;
		}
		

	// Get form values
	$title				= isset($res[0]->title)		? strip_tags($res[0]->title)			: null;
	$selectedCategory	= isset($res[0]->category)	? htmlspecialchars($res[0]->category, ENT_QUOTES, 'UTF-8')	: null;
	$data				= isset($res[0]->data)		? strip_tags($res[0]->data,'<p><a><br><b>')			: null;
	$published			= isset($res[0]->published)	? htmlspecialchars($res[0]->published, ENT_QUOTES, 'UTF-8')	: date("Y-m-d H:i:s"); 
	$created			= isset($res[0]->created)	? htmlspecialchars($res[0]->created, ENT_QUOTES, 'UTF-8')		: date("Y-m-d H:i:s"); 
	$submit				= isset($res) 				? 'Save changes'		: 'Publish';

	
	// Create the array for storing the form 

	
	$inputfields[]['text'] =		array('name' => 'title', 		'label' => 'Title', 				'value' => $title,											'disabled' => $this->disabled,);
	$inputfields[]['select'] =		array('name' => 'category', 	'label' => 'Choose category', 		'value' => $categoryList, 'selected' => $selectedCategory,	'disabled' => $this->disabled,);
	$inputfields[]['text'] =		array('name' => 'newcategory', 	'label' => 'Create new category', 	'value' => null,											'disabled' => $this->disabled,);
	$inputfields[]['textarea'] =	array('name' => 'data', 		'label' => 'Article', 				'value' => $data,											'disabled' => $this->disabled,);
	if(isset($res)){$inputfields[]['text'] =array('name' => 'slug', 'label' => 'Slug', 					'value' => $res[0]->slug,									'disabled' => $this->disabled,);}
	$inputfields[]['date'] =		array('name' => 'published', 	'label' => 'Publish/ed', 			'value' => $published,										'disabled' => $this->disabled,);
	$inputfields[]['date'] =		array('name' => 'created', 		'label' => 'Created', 				'value' => $created,										'disabled' => true,);


	$inputfields[]['submit'] = array('name' => 'submit', 'value' => $submit,'disabled' => $this->disabled,);

	$form = $this->message;
	$form .= $this->CForm->getForm($inputfields, 'POST', 'edit-movie');

	$this->parameters = $this->CForm->getData();

	//var_dump($res);
	return $form;
}

/**
 * Creates form filled with content or empty if param id is null
 * @param $id, int, 
 * @return string
 */
public function pageForm($id) {
	$inputfields = array();
	if($id) {
		$res = $this->SELECT(array('equals' => array('url' => $id,),), 'ContentRM');
	}
		

	// Get form values
	$title				= isset($res[0]->title)		? strip_tags($res[0]->title)			: null;
	$data				= isset($res[0]->data)		? strip_tags($res[0]->data,'<p><a><br><b>')			: null;
	$published			= isset($res[0]->published)	? htmlspecialchars($res[0]->published, ENT_QUOTES, 'UTF-8')	: date("Y-m-d H:i:s"); 
	$created			= isset($res[0]->created)	? htmlspecialchars($res[0]->created, ENT_QUOTES, 'UTF-8')		: date("Y-m-d H:i:s"); 
	$submit				= isset($res) 				? 'Save changes'		: 'Publish';

	
	// Create the array for storing the form 

	
	$inputfields[]['text'] =		array('name' => 'title', 		'label' => 'Title', 				'value' => $title,											'disabled' => $this->disabled,);
	$inputfields[]['textarea'] =	array('name' => 'data', 		'label' => 'Article', 				'value' => $data,											'disabled' => $this->disabled,);
	$inputfields[]['date'] =		array('name' => 'published', 	'label' => 'Publish/ed', 			'value' => $published,										'disabled' => $this->disabled,);
	$inputfields[]['date'] =		array('name' => 'created', 		'label' => 'Created', 				'value' => $created,										'disabled' => true,);


	$inputfields[]['submit'] = array('name' => 'submit', 'value' => $submit,'disabled' => $this->disabled,);

	$form = $this->message;
	$form .= $this->CForm->getForm($inputfields, 'POST', 'edit-movie');

	$this->parameters = $this->CForm->getData();

	//var_dump($res);
	return $form;
}


/**
 * Creates form filled with content or empty if param id is null
 * @param $id, int, 
 * @return string
 */
public function profileForm($user = 'current') {
	// Toggle authority
	$disable = ($user == 'current') ? false : true;
	if($_SESSION['user']->authority == 'admin') { $disable = false;}
	// Get user or null
	$id = ($user == 'current') ? $_SESSION['user']->id : $user;
	
	if($id){
		$res = $this->SELECT(array('equals' => array('id' => $id,),), 'userRM');
	}

	
	// Get form values
	$name		= isset($res[0]->name)		? htmlspecialchars($res[0]->name, ENT_QUOTES, 'UTF-8') : null;
	$info 		= isset($res[0]->info)		? strip_tags($res[0]->info,'<p><a><br><b>') : null;
	$authority 	= isset($res[0]->authority)	? $res[0]->authority : 'member';
	$acronym 	= isset($res[0]->acronym)	? htmlspecialchars($res[0]->acronym, ENT_QUOTES, 'UTF-8') : null;
	$img 		= isset($res[0]->img)		? $res[0]->img : 'user1.png';
	$password 	= null;
	$submit				= isset($res[0]) 				? 'Save changes'		: 'Add new user';

	$images = array('user1.png','user2.png','user3.png','user4.png','user5.png','user6.png','user7.png','user8.png',);

	
	// Create the array for storing the form 
	if(isset($res[0])) { $inputfields[]['hidden'] =array('name' => 'acronym', 'value' => $acronym,);
						 $inputfields[]['hidden'] =array('name' => 'password','value' => $res[0]->password,); }

	
	$inputfields[]['text'] =		array('name' => 'name', 		'label' => 'Name', 				'value' => $name, 	 'disabled' => $disable,);
	$inputfields[]['select'] =		array('name' => 'authority', 	'label' => 'Authority', 		'value' => array('member', 'admin',), 'selected' => $authority, 'disabled' => $this->disabled,);
	$inputfields[]['textarea'] =	array('name' => 'info', 		'label' => 'Profile text', 		'value' => $info,	 'disabled' => $disable,);
	$inputfields[]['radiobutton'] =	array('name' => 'img', 			'label' => 'Profile image', 	'value' => $images, 'chosen' => array($img,),	'disabled' => $disable,);
	if(!isset($res[0])){
		$inputfields[]['text'] =		array('name' => 'acronym', 		'label' => 'Username', 			'value' => $acronym,'disabled' => $this->disabled,);
		$inputfields[]['password'] =	array('name' => 'password', 	'label' => 'Password', 			'value' => $password,'disabled' => $this->disabled,);
	}


	$inputfields[]['submit'] = array('name' => 'submit', 'value' => $submit, 'disabled' => $disable,);

	
	$form = $this->CForm->getForm($inputfields, 'POST', 'edit-user');

	$this->parameters = $this->CForm->getData();

	//var_dump($res);
	return $form;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////// UPDATE METHODS (movie, blog and profile) //////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/**
 * updateBlog updates information on certain row in movie database
 * @param $id, int, id on row to be updated
 * @return nothing but relocates page
 */
public function updateBlog($id) {
	$params = $this->getFormInput('posts');
	if (isset($params['slug'])) {
		$params['slug'] = $this->slugify($params['slug']);
	}
	$res = $this->UPDATE($params, 'ContentRM', array('field' => 'id', 'value' => $id,));
	if ($res) {
		header('Location: edit.php?id=' . $id . '&table=posts&output=success');
	}
	else { header('Location: edit.php?id=' . $id . '&table=posts&output=failure');}
}

/**
 * updateBlog updates information on certain row in movie database
 * @param $id, int, id on row to be updated
 * @return nothing but relocates page
 */
public function updatePage($id) {
	$params = $this->getFormInput('page');
	$res = $this->UPDATE($params, 'ContentRM', array('field' => 'url', 'value' => $id,));
	if ($res) {
		header('Location: edit.php?id=' . $id . '&table=page&output=success');
	}
	else { header('Location: edit.php?id=' . $id . '&table=page&output=failure');}
}

/**
 * updateProfile updates information on certain row in movie database
 * @param $id, int or string, id on row to be updated or current if user is online
 * @return nothing but relocates page
 */
public function updateProfile($user = 'current') {
	// Get user id
	$id = ($user == 'current') ? $_SESSION['user']->id : $user;
	
	// Get parameters
	$params = $this->getFormInput('users');
	$password = $params['password'];
	unset($params['password']);
	
	// Update and get new user obj
	$res = $this->UPDATE($params, 'userRM', array('field' => 'id', 'value' => $id,));
	$userObj = $this->SELECT(array('equals' => array('id' => $id,),), 'userRM');

	// If success refresh page and update $_SESSION if current user was updated
	if ($res) {
		$_SESSION['user'] = ($userObj[0]->id == $_SESSION['user']->id) ? $userObj[0] : $_SESSION['user'];
		header('Location: edit.php?id=' . $user . '&table=users&output=success');
	}
	else { header('Location: edit.php?id=' . $user . '&table=users&output=failure');}
	
}

/**
 * updateMovie updates information on certain row in movie database
 * @param $id, int, id on row to be updated
 * @return nothing but relocates page
 */
public function updateMovie($id) {
	$params = $this->getFormInput('movies');
	$params['lastedit'] = date("Y-m-d H:i:s");
	$res = $this->UPDATE($params, 'moviesRM', array('field' => 'id', 'value' => $id,));
	//var_dump($_POST);

	if(isset($_POST['genre'])) {
		// Get corresponding genre id's
		foreach ($_POST['genre'] as $value) {
			$in[] = "'" . $value . "'";
		}
		$in = ' (' . implode(',', $in) . ') ';
		$genreId = $this->SELECT(array( 'in' => array('name' => $in,), 'distinct' => 'id',), 'genresRM');
		foreach ($genreId as $key) {
			$newGenres[] = $key->id;
		}
		$genreId = $this->SELECT(array( 'equals' => array('idMovie' => $id,), 'distinct' => 'idGenre',), 'movie2genreRM');
		foreach ($genreId as $key) {
			$oldGenres[] = $key->idGenre;
		}
		foreach ($oldGenres as $genre) {
			if (!in_array($genre, $newGenres)) {
				$this->DELETE(array('idGenre' => $genre, 'idMovie' => $id,), 'movie2genreRM');
			}
		}
		foreach ($newGenres as $genre) {
			if (!in_array($genre, $oldGenres)) {
				$this->INSERT(array('idGenre' => $genre, 'idMovie' => $id,), 'movie2genreRM');
			}
		}
		
	}

	if ($res) { header('Location: edit.php?id=' . $id . '&table=movies&output=success');}
	else { header('Location: edit.php?id=' . $id . '&table=movies&output=failure');}
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////// CREATE METHODS (movie, blog) //////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * createPost inserts new post into the database
 *
 */
public function createPost() {
	$params = $this->getFormInput('posts');
	$params['created'] = 'NOW()';
	$params['slug'] = $this->slugify($params['title']); 
	$params['type'] = 'post';
	$params['filter'] = 'nl2br,markdown';
	$res = $this->INSERT($params, 'ContentRM');
	if ($res) {
		header('Location: edit.php?id=' . $res . '&table=posts&output=success');
	}
	else { header('Location: createpost.php?output=failure');}
}

/**
 * createUser inserts new user into the database
 *
 */
public function createUser() {
	$params = $this->getFormInput('users');

	$params['salt'] = 'unix_timestamp()';
	$params['img'] = 'user1.png';
	$password = $params['password'];
	unset($params['password']);

	$existentUser = $this->SELECT(array('equals' => array('acronym' => $params['acronym'],),), 'userRM');
	if($existentUser){header('Location: createuser.php?output=userexists');}
	else {
		$res = $this->INSERT($params, 'userRM');
		$setPassword = $this->UPDATE(array('password' => $password,), 'userRM', array('field' => 'id', 'value' => $res,));
		
		if ($res && $setPassword) { header('Location: edit.php?id=' . $res . '&table=users&output=success');}
		else { header('Location: createuser.php?output=failure');}
	}
}

/**
 * createMovie inserts new movie into the database
 *
 */
public function createMovie() {
	$params = $this->getFormInput('movies');
	$params['lastedit'] = 'NOW()';
	$id = $this->INSERT($params, 'moviesRM');

	if(isset($_POST['genre'])) {
		// Get corresponding genre id's
		foreach ($_POST['genre'] as $value) {
			$in[] = "'" . $value . "'";
		}
		$in = ' (' . implode(',', $in) . ') ';
		$genreId = $this->SELECT(array( 'in' => array('name' => $in,), 'distinct' => 'id',), 'genresRM');
		foreach ($genreId as $key) {
			$genres[] = $key->id;
		}
		foreach ($genres as $genre) {
				$this->INSERT(array('idGenre' => $genre, 'idMovie' => $id,), 'movie2genreRM');
		}
		
	}
	
	if ($id) {
		header('Location: edit.php?id=' . $id . '&table=movies&output=success');
	}
	else { header('Location: createmovie.php?output=failure');}
}

// PRIVATE METHODS


/**
 * getFormInput handles POST.
 * @return associative array without empty values
 *
 */
private function getFormInput($table) {
	if ($table == 'movies') {
		$params['title']		= isset($_POST['title'])	&& !empty($_POST['title'])		&& ($_POST['title'] != '') 		? $_POST['title']		: die ('Title must be set');
		$params['director']		= isset($_POST['director'])	&& !empty($_POST['director'])	&& ($_POST['director'] != '')	? $_POST['director']	: null;
		$params['year']			= isset($_POST['year'])		&& !empty($_POST['year'])		&& ($_POST['year'] != '')		? $_POST['year']		: 1990;
		$params['price']		= isset($_POST['price'])	&& !empty($_POST['price'])		&& ($_POST['price'] != '')		? $_POST['price']		: 4; 
		$params['img']			= isset($_POST['img'])		&& !empty($_POST['img'])		&& ($_POST['img'] != '')		? $_POST['img']			: null;
		$params['imgfolder']	= isset($_POST['imgfolder'])&& !empty($_POST['imgfolder'])	&& ($_POST['imgfolder'] != '')	? $_POST['imgfolder']	: null;
		$params['info']			= isset($_POST['info'])		&& !empty($_POST['info'])		&& ($_POST['info'] != '')		? $_POST['info']		: null;
		$params['link']			= isset($_POST['link'])		&& !empty($_POST['link'])		&& ($_POST['link'] != '')		? $_POST['link']		: null;
		$params['trailer']		= isset($_POST['trailer'])	&& !empty($_POST['trailer'])	&& ($_POST['trailer'] != '')	? $_POST['trailer']		: null; 

		is_numeric($params['price']) or is_null($params['price']) or die ('Price must be numeric');
		is_numeric($params['year']) or is_null($params['year']) or die ('Year must be numeric');
		
	}
	elseif ($table == 'posts') {
		$params['title']		= isset($_POST['title'])		? $_POST['title']		: die ('Title must be set');
		$params['category']		= isset($_POST['newcategory']) && ($_POST['newcategory'] != '')	? $_POST['newcategory']	: null;
		$params['data']			= isset($_POST['data'])			? $_POST['data']		: null;
		$params['published']	= isset($_POST['published'])	? $_POST['published']	: date("Y-m-d H:i:s"); 
		$params['created']		= isset($_POST['created'])		? $_POST['created']		: null;
		if ($params['created'] == null) {
			unset($params['created']);
		}
		if ($params['category'] == null) {
			$params['category'] = isset($_POST['category']) ? $_POST['category'] : null;
			if ($params['category'] == null) { unset($params['category']); }
		}
	}
	elseif ($table == 'page') {
		$params['title']		= isset($_POST['title'])		? $_POST['title']		: die ('Title must be set');
		$params['data']			= isset($_POST['data'])			? $_POST['data']		: null;
		$params['published']	= isset($_POST['published'])	? $_POST['published']	: date("Y-m-d H:i:s"); 
	}
	elseif ($table == 'users') {
		$params['name']			= isset($_POST['name'])			? $_POST['name']		: die ('Name must be set');
		$params['acronym']		= isset($_POST['acronym'])		? $_POST['acronym']		: die ('Acronym must be set');
		$params['password']		= isset($_POST['password'])	&&  ($_POST['password'] != '')	? $_POST['password']	: die ('Password must be set');
		$params['info']			= isset($_POST['info'])			? $_POST['info']		: null;
		$params['img']			= isset($_POST['img'])			? $_POST['img']			: 'user1.png';
		$params['authority']	= isset($_POST['authority'])	? $_POST['authority']	: null;
		if ($params['authority'] == null) {
			unset($params['authority']);
		}
		
	}

	return $params;

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