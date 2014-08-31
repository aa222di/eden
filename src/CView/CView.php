<?php

class CView extends CCRUD {

// MEMBERS
	private $parameters; // parameters for sorting table

// PUBLIC METHODS
public function __construct($options) {
	
		parent::__construct($options);
		
	
}

/**
 * Builds table for viewing Movies, supports paging and sorting
 * @return string
 */
public function viewMovies(){

	$htmlid = null;
	// Get parameters
	$this->getParameters();

	// Get result set
	$res = $this->SELECT($this->parameters, 'vmovieRM');

		if($res) {

		// Get current page and page hits
		$pageNavigation = $this->pageNavigation($this->parameters,$htmlid);
		$table = "<nav class='hits-per-page right grid-1-2''>\n<h3 class='right'>Hits per page:</h3><p class='clear hits-per-page'>" . $pageNavigation['hitsPerPage'] . "</p></nav>\n" ;
		
		// Build table
		$table .= "<table class='movietable'><thead class='orderby'><th>Id " . $this->orderby('id', $htmlid) . "</th><th>Title" . $this->orderby('title', $htmlid) . "</th><th>Director" . $this->orderby('director', $htmlid) . "</th><th>Year" . $this->orderby('year', $htmlid) . "</th><th>Price" . $this->orderby('price', $htmlid) . "</th><th>Action</th></thead>\n<tbody>";
		

	
		foreach($res as $key=>$val) {
			
				$table .= "<tr>\n";
				$table .= "<td>{$val->id}</td><td>{$val->title}</td><td>{$val->director}</td><td>{$val->year}</td><td>{$val->price}</td><td><a href='edit.php?id={$val->id}&amp;table=movies'>edit</a> <a href='delete.php?id={$val->id}&amp;table=movies'>delete</a></td>";
				$table .= "</tr>\n";
			
		}	

		$table .= "</tbody></table>";
		$table .= $pageNavigation['pageNav'];
		

	}

	return $table;

}


/**
 * Builds table for viewing Posts, supports paging and sorting
 * @return string
 */
public function viewPosts(){

	$htmlid = null;
	// Get parameters
	$this->getParameters();

	// Get result set
	$res = $this->SELECT($this->parameters, 'ContentRM');

		if($res) {

		// Get current page and page hits
		$pageNavigation = $this->pageNavigation($this->parameters,$htmlid);
		$table = "<nav class='hits-per-page right grid-1-2''>\n<h3 class='right'>Hits per page:</h3><p class='clear hits-per-page'>" . $pageNavigation['hitsPerPage'] . "</p></nav>\n" ;
		
		// Build table
		$table .= "<table><thead class='orderby'><th>Id " . $this->orderby('id', $htmlid) . "</th><th>Title" . $this->orderby('title', $htmlid) . "</th><th>Content" . $this->orderby('data', $htmlid) . "</th><th>Published" . $this->orderby('published', $htmlid) . "</th><th>Created" . $this->orderby('created', $htmlid) . "</th><th>Action</th></thead>\n<tbody>";
		

	
		foreach($res as $key=>$val) {
				
				$data	= substr($val->data, 0, 80) . "...";
				$table .= "<tr>\n";
				$table .= "<td>{$val->id}</td><td>{$val->title}</td><td>{$data}</td><td>{$val->published}</td><td>{$val->created}</td><td><a href='edit.php?id={$val->id}&amp;table=posts'>edit</a> <a href='delete.php?id={$val->id}&amp;table=posts'>delete</a></td>";
				$table .= "</tr>\n";
			
		}	

		$table .= "</tbody></table>";
		$table .= $pageNavigation['pageNav'];
		

	}

	return $table;

}

/**
 * Builds table for viewing Posts, supports paging and sorting
 * @return string
 */
public function viewPage($url){

	// Get result set
	$res = $this->SELECT(array('equals' => array('url' => $url,),), 'ContentRM');

	if($res) {

		foreach($res as $key=>$val) {
			$page = "<h1>" . $val->title . "</h1>";
			$data = strip_tags($val->data, '<p><a><br><b>');
			$page .= $data;
				
		}
	}

	else {$page = false;}

	return $page;

}


/**
 * Displays users with picture and name
 * @return string
 */
public function displayUser(){
	$htmlid = '#user';


	// Get result set
	$res = $this->SELECT(null, 'userRM');

	if($res) {
		$users = null;
		$i = 0;
		$users .= "<section class='row'>\n";
		foreach ($res as $key => $val) {
			$i += 1;
			$users .= "<a href='?id=" . $val->id . $htmlid . "' title='See profile' class='userPortrait'><figure>\n<img src='img/userimg/" . $val->img . "' alt='User image for" . $val->name . "'>\n";
			$users .= "<figcaption><p class='username'>" . $val->name . "</p><p class='userauthority'>" . $val->authority . "</p></figcaption>\n";
			$users .= "</figure></a>\n";
			if($i == 4){ $users .= "</section><section class='row'>\n";}	
		}
		$users.= "</section>";
	}
	else { $users = false;}

	return $users;

}

/**
 * Builds table for viewing Posts, supports paging and sorting
 * @return string
 */
public function viewUsers(){

	$htmlid = null;
	// Get parameters
	$this->getParameters();

	// Get result set
	$res = $this->SELECT($this->parameters, 'userRM');

		if($res) {

		// Get current page and page hits
		$pageNavigation = $this->pageNavigation($this->parameters,$htmlid);
		$table = "<nav class='hits-per-page right grid-1-2''>\n<h3 class='right'>Hits per page:</h3><p class='clear hits-per-page'>" . $pageNavigation['hitsPerPage'] . "</p></nav>\n" ;
		
		// Build table
		$table .= "<table><thead class='orderby'><th>Image</th><th>Id " . $this->orderby('id', $htmlid) . "</th><th>Name" . $this->orderby('name', $htmlid) . "</th><th>Info</th><th>Username" . $this->orderby('acronym', $htmlid) . "</th><th>Authority" . $this->orderby('authority', $htmlid) . "</th><th>Action</th></thead>\n<tbody>";
		

	
		foreach($res as $key=>$val) {
				
				$info	= substr($val->info, 0, 40) . "...";
				$table .= "<tr>\n";
				$table .= "<td><img src='img.php?src=userimg/{$val->img}&amp;width=50&amp;height=50&amp;crop-to-fit&amp;save-as=png' alt='User Image'></td><td>{$val->id}</td><td>{$val->name}</td><td>{$info}</td><td>{$val->acronym}</td><td>{$val->authority}</td><td><a href='edit.php?id={$val->id}&amp;table=users'>edit</a> <a href='delete.php?id={$val->id}&amp;table=users'>delete</a></td>";
				$table .= "</tr>\n";
			
		}	

		$table .= "</tbody></table>";
		$table .= $pageNavigation['pageNav'];
		

	}

	return $table;

}

// PRIVATE METHODS

/**
 * Creates associative array for SELECT method in CRUD
 * 
 */
private function getParameters(){

	$this->parameters['orderby']		= isset($_GET['orderby']) ? strtolower($_GET['orderby']) : 'id';
	$this->parameters['order']			= isset($_GET['order'])   ? strtolower($_GET['order'])   : 'asc';
	$this->parameters['hits'] 			= isset($_GET['hits']) && is_numeric($_GET['hits']) ? $_GET['hits']  : 12; // How many rows to display per page.
	$this->parameters['page']			= isset($_GET['page']) ? $_GET['page'] : 1; // Which is the current page to display, use this to calculate the offset value

}



}