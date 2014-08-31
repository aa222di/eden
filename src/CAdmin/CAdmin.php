<?php

/**
 * CAdmin handles the admin interface. 
 * It has three objects CEdit, CView, and CForm where most of th executing methods are
 *
 *
 */

class CAdmin extends CCRUD {

// MEMBERS
	private $parameters; // parameters for sorting table
	private $CView; // Object handles viewing
	private $CEdit; // Object handles editing

// PUBLIC METHODS
public function __construct($options) {
	if(isset($_SESSION['user'])){
		parent::__construct($options);
		$_SESSION['admininterface'] = true;
		$this->CForm = new CForm();
		$this->CView = new CView($options);
		$this->CEdit = new CEdit($options);

		// Check user authority and toggle disabled
		$this->disabled = ($_SESSION['user']->authority == 'admin') ? false : true;
		$this->message = ($_SESSION['user']->authority == 'admin') ? null : "<output class='info'>Only members with admin authority can change, create or update content</output>";
	}
	else{
		header('Location: login.php');
	}
}

/**
 * View, checks for which table to view and gets the right method from CView
 * @param type, string
 * @return string, html representation of database table
 */
public function view($type) {
	if ($type == 'movies') {
		$table = $this->CView->viewMovies();
	}
	else if ($type == 'posts') {
		$table = $this->CView->viewPosts();
	}
	else if ($type == 'users') {
		$table = $this->CView->viewUsers();
	}

	return $table;
}

/**
 * getForm 
 * @param id, string or int or null, id for post, movie page or null if empty form is required
 * @param table, string. To specify which table
 * @return string, html form
 *
 */
public function getForm($table, $id) {
	
	if ($table == 'movies') {
		$form = $this->CEdit->movieForm($id);
	}
	else if ($table == 'posts') {
		$form = $this->CEdit->blogForm($id);
	}
	else if ($table == 'page') {
		$form = $this->CEdit->pageForm($id);
	}
	else if ($table == 'users') {
		$form = $this->CEdit->profileForm($id);
	}

	return $form;
}

/**
 *	getObject 
 * @param id, string or int or null, id for post, movie page or null if empty form is required
 * @param table, string. To specify which table
 * @return object
 */
public function getObject($table, $id) {
	
		if ($table == 'movies') {
		$res = $this->SELECT(array('equals' => array('id' => $id,),), 'vmovieRM');
	}
	else if ($table == 'posts') {
		$res = $this->SELECT(array('equals' => array('id' => $id,),), 'ContentRM');
	}
	else if ($table == 'page') {
		$res = $this->SELECT(array('equals' => array('url' => $id,),), 'ContentRM');
	}
	else if ($table == 'users') {
		if($id == 'current'){ $res[0] = $_SESSION['user']; }
		else $res = $this->SELECT(array('equals' => array('id' => $id,),), 'userRM');	
	}

	return $res[0];
}

/**
 *	update Content 
 * @param id, string or int or null, id for post, movie page or null if empty form is required
 * @param table, string. To specify which table
 * @return redirects user to same page with $_GET['output'] set to success or failure
 */
public function updateContent($table, $id) {

	if ($table == 'movies') {
		$res = $this->CEdit->updateMovie($id);
	}
	else if ($table == 'posts') {
		$res = $this->CEdit->updateBlog($id);
	}
	else if ($table == 'page') {
		$res = $this->CEdit->updatePage($id);
	}
	else if ($table == 'users') {
		$res = $this->CEdit->updateProfile($id);
	}
	
	return $res;

}
/**
 *	create Content 
 * @param id, string or int or null, id for post, movie page or null if empty form is required
 * @param table, string. To specify which table
 * @return redirects user to edit.php?id=id=table=table with $_GET['output'] set to success or failure
 */
public function createContent($table, $id) {

	if ($table == 'movies') {
		$this->CEdit->createMovie();
	}
	else if ($table == 'posts') {
		$this->CEdit->createPost();
	}
	else if ($table == 'users') {
		$this->CEdit->createUser();
	}
}

/**
 *	delete form
 * @param id, string or int or null, id for post, movie page or null if empty form is required
 * @param table, string. To specify which table
 * @return string , html form to confirm deletion
 */
public function deleteForm($table, $id){

	$content = $this->getObject($table, $id);

	$inputfields[]['submit'] =array('name' => 'submit', 'value' => 'Confirm delete','disabled' => $this->disabled,);
	$form = $this->CForm->getForm($inputfields, 'POST', 'delete');
	$title = ($table == 'users') ? $content->name : $content->title;
	$output = <<<EOD
	<h1>Delete "{$title}"</h1>
	{$this->message}
	<h4>Are you sure you want to delete "{$title}" with id: {$content->id}?</h4>
	$form
	<a href="view$table.php" class="regretbutton" title='Cancel delete'>No, go back!</a>
EOD;

	return $output;
}

/**
 *	delete form
 * @param id, string or int or null, id for post, movie page or null if empty form is required
 * @param table, string. To specify which table
 * @return string, then redirects user to view$table.php
 */
public function deleteContent($table, $id) {

	if ($table == 'movies') {
		$res = $this->DELETE(array('idMovie'=>$id,), 'movie2genreRM', true);
		$res = $this->DELETE(array('id'=>$id,), 'moviesRM');
	}
	else if ($table == 'posts') {
		$res = $this->DELETE(array('id'=>$id,), 'ContentRM');
	}
	else if ($table == 'users') {
		$res = $this->DELETE(array('id'=>$id,), 'userRM');
	}

	header( "refresh:2;url=view" . $table . ".php" ); 
	
	if($res)  { return "<output class='success'>" . $res . " row has been deleted</output>";}
	
	if(!$res) { return "<output class='failure'>Something went wrong, no post has been deleted</output>";}

}

public function __destruct() {
	unset($_SESSION['admininterface']);
}
}