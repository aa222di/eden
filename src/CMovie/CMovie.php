<?php
/* 
 CMovie specifically handles the Movie database and it's tables
 CMovie extends CCRUD which in turn has CDatabase as an object
 CMovie has CForm as an object
 CMovie only displays data, for editing see CEdit
 */


class CMovie extends CCRUD {

// MEMBERS
	private $CForm;
	private $parameters;
	
	

// CONSTRUCTOR
  
  
  /**
   * Constructor creating a PDO object connecting to a choosen database.
   *
   * @param array $options containing details for connecting to the database.
   *
   */
  public function __construct($options) {
  	parent::__construct($options);
  	$this->CForm = new CForm();
  	$this->filter = new CTextFilter();
	}


	
 // PUBLIC METHODS

/**
 * Build the catalogue
 * getCatalogue is dependent on getForm from which it gets its parameters
 * @return string html table of search result
 */
public function getCatalogue() {
	unset($_SESSION['search-link']);
	$this->getBreadcrumb();
	$htmlid = '&num;movies';
	// Get parameters

	$this->getParameters();

	// Get result set
	$res = $this->SELECT($this->parameters, 'vmovieRM');

	if($res) {
		// Get current page and page hits
		$pageNavigation = $this->pageNavigation($this->parameters,$htmlid);

		// Build catalogue
		$catalogue = "<section>\n";
		$catalogue .=  "<nav class='orderby grid-1-2'>\n<h3>Order by:</h3><p class='clear'>Title " . $this->orderby('title', $htmlid) . "&#124; Price " . $this->orderby('price', $htmlid) . "&#124; Director " . $this->orderby('director', $htmlid) . "</p></nav>\n" ;
		$catalogue .= "<nav class='hits-per-page right grid-1-2'>\n<h3 class='right'>Hits per page:</h3><p class='clear hits-per-page'>" . $pageNavigation['hitsPerPage'] . "</p></nav>\n" ;
		$catalogue .= "</section>\n";
		$catalogue .= "<section class='catalogue clear' id='movies'>\n";

		$i = null;
		foreach($res as $key=>$val) {
			$i += 1;
			if($i > 6) {
				$i = 1; 
				$catalogue .= "</section>\n<section class='catalogue clear'>\n";
				$catalogue .= "<a href='moviesingle.php?id={$val->id}' class='grid-1-6'>\n<figure><img src='img.php?src={$val->img}&amp;width=300&amp;height=450&amp;crop-to-fit&amp;quality=80' alt='{$val->title}'><figcaption><p class='movie-title'>{$val->title}</p><p class='movie-director'>By {$val->director}</p></figcaption></figure>\n</a>\n";
			}
			else {
				$catalogue .= "<a href='moviesingle.php?id={$val->id}' class='grid-1-6'>\n<figure><img src='img.php?src={$val->img}&amp;width=300&amp;height=450&amp;crop-to-fit&amp;quality=80' alt='{$val->title}'><figcaption><p class='movie-title'>{$val->title}</p><p class='movie-director'>By {$val->director}</p></figcaption></figure>\n</a>\n";
			}
		}	

		$catalogue .= "</section>\n";
		$catalogue .= $pageNavigation['pageNav'];

	}

	else { $catalogue = "<h4 class='center'>Sorry, we can't find what you're looking for. Try to generalize your search.</h4>";}

	return $catalogue;
}

/**
 * Build the catalogue
 * getCatalogue is dependent on getForm from which it gets its parameters
 * @return string html table of search result
 */
public function getLatestMovies($limit = 3) {
	$res = $this->SELECT(array('hits' => $limit, 'page' => 1, 'orderby' => 'lastedit', 'order'=> 'DESC',), 'vmovieRM');
	$movies = "<section class='latest-movies'>";
	foreach ($res as $key => $val) {
		$movies .= "<a href='moviesingle.php?id={$val->id}' class='grid-1-" . $limit . "'>\n<figure><img src='img.php?src={$val->img}&amp;width=300&amp;height=450&amp;crop-to-fit&amp;quality=80' alt='{$val->title}'><figcaption><p class='movie-title'>{$val->title}</p><p class='movie-director'>By {$val->director}</p></figcaption></figure>\n</a>\n";
	}
	$movies .= "</section>";
	return $movies;
}


/**
 * Get movie data
 * @return obj with movie data
 */
public function getMovieRaw($id) {

	// Get result set
	$res = $this->SELECT(array('equals' => array('id' => $id,),), 'vmovieRM');

	$data = $res[0];
	return $data;
}

/**
 * Present movie data
 * @return string html Movie page
 */
public function getMovie($id) {


	// Get result set
	$res = $this->SELECT(array('equals' => array('id' => $id,),), 'vmovieRM');
	$breadcrumb = $this->getBreadcrumb();
	foreach($res as $key=>$val) {
		$directorLink = htmlentities(strtolower($val->director));
		$directorLink = str_replace(' ', '+', $directorLink);

		$info   = $this->filter->doFilter(htmlentities($val->info, null, 'UTF-8'), 'markdown,nl2br');
		$movie 	= <<<EOD
		<div class="grid movie">
		$breadcrumb
			<header class="movie-header">
				<h1>{$val->title}</h1>
				<a href="moviecatalogue.php?director={$directorLink}" title="More movies by {$val->director}"><h2>({$val->director})</h2></a>
			</header>
			<figure class="grid-1-3 poster"><img src="img.php?src={$val->img}&amp;width=300&amp;quality=70" alt="{$val->title}"></figure>
			<article class="movie-info grid-2-3">
				{$info}
			
			<footer class='movie-footer'>
				<dl>
					<dt>Price</dt>
					<dd>{$val->price} &dollar;</dd>
				</dl>
				<dl>
					<dt>Year</dt>
					<dd>{$val->year}</dd>
				</dl>
				<dl>
					<dt>Genres</dt>
					<dd>{$val->genre}</dd>
				</dl>
				<dl>
					<dt>More info</dt>
					<dd><a href="{$val->trailer}" title="trailer on youtube">Trailer on YouTube</a><br>
					<a href="{$val->link}" title="link to imdb">Information on IMDB</a></dd>
				</dl>
				
			</footer>
			</article>
		</div>
EOD;
	}

	return $movie;
}

/**
 * Create links for categories.
 *
 */
public function getGenres($current, $link = 'query'){
	// Do SELECT from a table to get all active genres
	$sql = "SELECT DISTINCT G.name
			FROM genresRM AS G
			INNER JOIN movie2genreRM AS M2G
			ON G.id = M2G.idGenre;";
	$cats = $this->db->ExecuteSelectQueryAndFetchAll($sql);



	$categories = "<nav class='genres'>";
	foreach($cats as $key=>$val) {
		$href = ($link == 'query') ? $this->getQueryString(array('genre' => $val->name)) : $link . "?genre=" . $val->name;

		if($val->name == $current){
			$categories .= "<p><a class='selected-genre' href='" . $href . "&num;movies'>{$val->name}</a></p>";
		}
		else {
		$categories .= "<p><a href='" . $href . "&num;movies'>{$val->name}</a></p>";
		}
	}
	$categories .= "</nav>";
	return $categories;
}

/**
 * Creates form for searching out data from VMovie
 * @return string, html form
 */
public function getSearchForm(){
	// Create the array for storing the form 
	$inputfields = array();

	$inputfields[]['search'] = array('name' => 'title', 	'label' => 'Title', 	'value' => 'keep',);
	$inputfields[]['search'] = array('name' => 'director', 	'label' => 'Director', 	'value' => 'keep',);
	$inputfields[]['number'] = array('name' => 'price1', 	'label' => 'Price', 	'value' => 'keep',);
	$inputfields[]['number'] = array('name' => 'price2', 							'value' => 'keep',);
	$inputfields[]['submit'] = array('name' => 'submit', 'value' => 'Search',);

	$form = $this->CForm->getForm($inputfields, 'GET', 'movie-search');

	$this->parameters = $this->CForm->getData();
	return $form;
}


/**
 * Searches for similar movies based on genres and director
 * @param obj $movie, movie to be matched
 * @param int $count, number of similar movies to be found
 * @return string, html presentation of movies
 *
 */

public function getSimilarMovies($movie, $count = 6) {

	$lastBox = $count -1;
	// Get genres
	$genres = explode( ',', $movie->genre );

	// Get id
	$id = array($movie->id,);

	// Get director
	$director = $movie->director;

	// Search for film with exakt same genre combination
	$params['distinct'] = 'id';
	$params['like']['genre'] = null;
	foreach ($genres as $genre) {
		$params['like']['genre'] .= '%' . $genre;
	}
	$params['like']['genre'] .= '%';
	$params['not']['id'] = $id;
	$res = $this->SELECT($params, 'vmovieRM');

	// If $count isn't reached search for movie with at least one genre in common and same director
	if (!isset($res[$lastBox])) {
		foreach ($res as $key => $value) {
			$id[] = $value->id;
		}
		foreach ($genres as $genre) {
			$params['like']['genre'] =  '%' . $genre . '%';
			$params['equals']['director'] = $director;

			$res = $this->SELECT($params, 'vmovieRM');
			foreach ($res as $key => $value) {
				$id[] = $value->id;
				if(isset($id[$count])) { goto write; }
			}

			if(isset($id[$count])) { goto write; }
		}
		// If $count still isn't reached get films with at least one genre in common with target film
		foreach ($genres as $genre) {
			$params['like']['genre'] =  '%' . $genre . '%';
			unset($params['equals']['director']);

			$res = $this->SELECT($params, 'vmovieRM');
			foreach ($res as $key => $value) {
				$id[] = $value->id;
				if(isset($id[$count])) { goto write; }
			}

			if(isset($id[$count])) { goto write; }
		}


	}
	// If $count was reached from first search, gather all id's.
	else if (isset($res[$lastBox])){
		foreach ($res as $key => $value) {
				$id[] = $value->id;
				if(isset($id[$count])) { goto write; }
			}
	}

	write:
	unset($params);

	// Strip out target movie
    $key = array_search($movie->id, $id);
    unset($id[$key]);

    // Convert to string
    $id = '(' . implode(',', $id) . ')' ;

    // Get similar movies
    $params['in']['id'] = $id;
	$movies = $this->SELECT($params, 'vmovieRM');

	$catalogue = "<section class='catalogue similar-movies clear'>\n";
	foreach($movies as $key=>$val) {
		
			$catalogue .= "<a href='moviesingle.php?id={$val->id}' class='grid-1-6'>\n<figure><img src='img.php?src={$val->img}&amp;width=300&amp;height=450&amp;crop-to-fit&amp;quality=80' alt='{$val->title}'><figcaption><p class='movie-title'>{$val->title}</p><p class='movie-director'>By {$val->director}</p></figcaption></figure>\n</a>\n";

	}	
	$catalogue .= "</section>\n";
	return $catalogue;
}

/**
 * Get breadcrumb creates breadcrumb 
 * @return string, All movies, last search, movie
 *
 */
public function getBreadcrumb() {

	$breadcrumb = null;

	if(basename($_SERVER['SCRIPT_FILENAME']) == 'moviecatalogue.php' && $_SERVER['QUERY_STRING'] != '') {
      $_SESSION['search-link'] = "<a href='" . $_SERVER['REQUEST_URI'] . "'>&laquo;  Search </a>";
    }

	if(basename($_SERVER['SCRIPT_FILENAME']) == 'moviesingle.php') {
		$movie = $this->SELECT(array('equals' 	=> array( 'id' => $_GET['id'],),), 'moviesRM');
		$movie = $movie[0]->title;

		$breadcrumb = "<nav class='breadcrumb'>"; 
		$breadcrumb .= "<a href='moviecatalogue.php'>All movies </a>";
		$breadcrumb .= isset($_SESSION['search-link']) ? $_SESSION['search-link'] : null;
		$breadcrumb .= "&laquo; " . $movie;
		$breadcrumb .= "</nav>";

	}
		return $breadcrumb;
	}

/**
 * Creates a list of twelve movies, one for each month
 * @param month, int
 * @return string, movie of the month
 *
 */
public function movieOfTheMonth($month) {
	$movies = $this->SELECT(array('orderby' => 'id', 'order' => 'ASC', 'page' => 1, 'hits' => 12,), 'vmovieRM');
	$month -= 1;
	$movie = $movies[$month];
	$synopsis = htmlentities(substr($movie->info, 0, 260), null, 'UTF-8') . "... <a href='moviesingle.php?id=" . $movie->id . "' title='See more info'>Read&nbsp;more&nbsp;&raquo;</a>";
	$poster = "<a href='moviesingle.php?id=" . $movie->id . "' title='See more info'>\n";
	$poster .= "<img class='movie-of-the-month' src='img.php?src=" . $movie->img . "&amp;height=340' alt='" . $movie->title . "'></a>";
	$poster .= "<article class='synopsis'><h4>" . $movie->title . "</h4><p>" . $synopsis . "</p></article>";

	return $poster;
}

// PRIVATE METHODS

/**
 * Creates associative array for SELECT method in CRUD
 * 
 */
private function getParameters(){

	$this->parameters['genre']	= isset($_GET['genre']) ? strtolower($_GET['genre']) : null;

	$this->parameters = $this->getValidParameters($this->parameters);
	

	$this->parameters['orderby']		= isset($_GET['orderby']) ? strtolower($_GET['orderby']) : 'title';
	$this->parameters['order']			= isset($_GET['order'])   ? strtolower($_GET['order'])   : 'asc';
	$this->parameters['hits'] 			= isset($_GET['hits']) && is_numeric($_GET['hits']) ? $_GET['hits']  : 12; // How many rows to display per page.
	$this->parameters['page']			= isset($_GET['page']) ? $_GET['page'] : 1; // Which is the current page to display, use this to calculate the offset value

	
}


/**
 * Creates associative array for SELECT method in CRUD - arranges parameters and deletes empty ones.
 * 
 */
private function getValidParameters($params) {
	
	foreach ($params as $param => $value) {
		if(!empty($value) && ($value != '') && ($value != array()) && ($param != 'submit')) {

			if(!is_numeric($value)) {
				$params['like'][$param] = '%' . $value . '%';
			}

			if(is_numeric($value)) {
				
				if($param == 'price2') { $params['less-or-equal']['price'] = $value;}
				if($param == 'price1') { $params['greater-or-equal']['price'] = $value;}	
			}

		}
	}
	return $params;
}




}