<?php
/**
 * CDatabaseTable collects methods to display searchresult and navigationlinks from a database 
 *
 */
class CDatabaseTable extends CDatabase {

// MEMBERS
	private $sql = null; // The sqlquery to be built and used i various methods
	private $parameters = array(); // Parameters used in query 
	private $table = null; // table to be used

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
 * Create links for categories.
 *
 * @param array $cats a list of categories.
 * @return string as a link to this page.
 */
public function getCategories($cats){
	$categories = "<ul class='horizontal'>";
	foreach($cats as $key=>$val) {
		$categories .= "<li><a class='smallbutton' href='" . $this->getQueryString(array('genre' => $val->name)) . "''>{$val->name}</a></li>";
	}
	$categories .= "</ul>";
	return $categories;
}

/**
 * Use the current querystring as base, modify it according to $options and return the modified query string.
 *
 * @param array $options to set/change.
 * @param string $prepend this to the resulting query string
 * @return string with an updated query string.
 */
private function getQueryString($options, $prepend='?') {
  // parse query string into array
  $query = array();
  parse_str($_SERVER['QUERY_STRING'], $query);
 
  // Modify the existing query string with new options
  $query = array_merge($query, $options);
 
  // Return the modified querystring
  return $prepend .htmlentities(http_build_query($query));
}

/**
 * Function to create links for sorting
 *
 * @param string $column the name of the database column to sort by
 * @return string with links to order by column.
 */
 private function orderby($column) {
  return "<a href=". $this->getQueryString(array('orderby' => $column, 'order' => 'asc')) . ">&darr;</a><a href=". $this->getQueryString(array('orderby' => $column, 'order' => 'desc')) . ">&uarr;</a>";
}

/**
 * Create navigation among pages.
 *
 * @param integer $hits per page.
 * @param integer $page current page.
 * @param integer $max number of pages. 
 * @param integer $min is the first page number, usually 0 or 1. 
 * @return string as a link to this page.
 */
private function getPageNavigation($hits, $page, $max, $min=1) {
	$nav  = "<nav class='pagenav'>";
	$nav .= "<a href='" . $this->getQueryString(array('page' => $min)) . "'>&lt;&lt;</a> ";
	$nav .= "<a href='" . $this->getQueryString(array('page' => ($page > $min ? $page - 1 : $min) )) . "'>&lt;</a> ";
 
  for($i=$min; $i<=$max; $i++) {
    $nav .= "<a href='" . $this->getQueryString(array('page' => $i)) . "'>$i</a> ";
  }
 
  $nav .= "<a href='" . $this->getQueryString(array('page' => ($page < $max ? $page + 1 : $max) )) . "'>&gt;</a> ";
  $nav .= "<a href='" . $this->getQueryString(array('page' => $max)) . "'>&gt;&gt;</a> ";
  $nav .= "</nav>";
  return $nav;
}

/**
 * Create links for hits per page.
 *
 * @param array $hits a list of hits-options to display.
 * @return string as a link to this page.
 */
private function getHitsPerPage($hits) {
  $nav = "Träffar per sida: ";
  foreach($hits AS $val) {
  	
    $nav .= "<a href='" . $this->getQueryString(array('hits' => $val)) . "'>$val</a> ";
  }  
  return $nav;
}


/**
 * Query the database 
 * @param array $params for the parameters and $table for the chosen table
 * @return result from query
 */
private function buildSqlQuery($params) {
	$sqlOrig = "SELECT * FROM ({$this->table})";

	$where    	 = null;
	$limit    	 = null;
	$sort     	 = " ORDER BY {$params['orderby']} {$params['order']}";
	$parameters  = array();
	$searchInput = null;

	// Select by title
	if($params['title']) {
	  $title = '%' . $params['title']. '%';	
	  $where .= ' AND title LIKE ?';
	  $parameters[] = $title;
	} 
	// Select by genre
	if($params['genre']) {
	  $genre = '%' . $params['genre'] . '%';	
	  $where .= ' AND genre LIKE ?';
	  $parameters[] = $genre;
	} 
	// Select by year
	if($params['year1']) {
	  $where .= ' AND year >= ?';
	  $parameters[] = $params['year1'];
	} 
	if($params['year2']) {
	  $where .= ' AND year <= ?';
	  $parameters[] = $params['year2'];
	} 

	// Pagination
	if($params['hits'] && $params['page']) {
	  $limit = " LIMIT {$params['hits']} OFFSET " . (($params['page'] - 1) * $params['hits']);
	}

	// Complete the sql statement
	$where = $where ? " WHERE 1 {$where}" : null;
	$sql = $sqlOrig . $where . $sort . $limit;
	$this->sql = $sqlOrig . $where;
	$this->parameters = $parameters;
	$res = $this->ExecuteSelectQueryAndFetchAll($sql, $parameters);

	return $res;
}


/**
 * Build table
 * @param $databaseTable the table to query from
 * @return string html table of search result
 */
private function buildTable($params) {
	$res = $this->buildSqlQuery($params);
	
	$table = "<table><thead><th>Bild</th><th>Id " . $this->orderby('id') . "</th><th>Titel" . $this->orderby('title') . "</th><th>År" . $this->orderby('year') . "</th><th>Genre</th></thead><tbody>";

	foreach($res as $key=>$val) {
		$table .= "<tr><td><img class='thumbnail' src='{$val->image}' alt='{$val->title}'></td><td>{$val->id}</td><td>{$val->title}</td><td>{$val->year}</td><td>{$val->genre}</td></tr>";
	}
	$table .= "</tbody></table>";	

	return $table;
}

/**
 * Build pagenavigation
 * @param $params the parameters from the $_GET-array
 * @return array hits per page and pagenavigation 
 */

private function pageNavigation($params) {
	$hitsPerPage = $this->getHitsPerPage(array(2, 4, 8));

	$hits = isset($params['hits']) && is_numeric($params['hits']) ? $params['hits'] : 8;
	$page = isset($params['page']) && is_numeric($params['page']) ? $params['page'] : 1;
	$sql  = "SELECT COUNT(id) AS rows FROM ({$this->sql}) AS {$this->table};";
	$res  = $this->ExecuteSelectQueryAndFetchAll($sql, $this->parameters);
	$rows = $res[0]->rows;
	$max = ceil($rows / $hits);
	$pageNav = $this->getPageNavigation($hits, $page, $max);

	return array(
		'hitsPerPage' => $hitsPerPage,
		'pageNav'	  => $pageNav,
					);
}

public function getHTML($params) {

	// Check that incoming parameters are valid
is_numeric($params['hits']) or die('Check: Hits must be numeric.');
is_numeric($params['page']) or die('Check: Page must be numeric.');
is_numeric($params['year1']) || !isset($params['year1'])  or die('Check: Year must be numeric or not set.');
is_numeric($params['year2']) || !isset($params['year2'])  or die('Check: Year must be numeric or not set.');

	$htmlTable = $this->buildTable($params);
	$pageNavigation = $this->pageNavigation($params);
	$html = array(
		'hitsPerPage'	=> $pageNavigation['hitsPerPage'],
		'pageNav'		=> $pageNavigation['pageNav'],
		'table'			=> $htmlTable,
		);
	return $html;
}


}