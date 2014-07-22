<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
$db = new CDatabase($eden['database']); 



// Restore the database to its original settings
$sql      = 'movie.sql';
$mysql    = '/Applications/MAMP/Library/bin/mysql';
$host     = 'localhost';
$output = null;
 
if(isset($_POST['restore']) || isset($_GET['restore'])) {
  $output = $db->ResetDatabase($sql, $mysql, $host);
}


// FUNCTIONS

/**
 * Use the current querystring as base, modify it according to $options and return the modified query string.
 *
 * @param array $options to set/change.
 * @param string $prepend this to the resulting query string
 * @return string with an updated query string.
 */
function getQueryString($options, $prepend='?') {
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
function orderby($column) {
  return "<a href=". getQueryString(array('orderby' => $column, 'order' => 'asc')) . ">&darr;</a><a href=". getQueryString(array('orderby' => $column, 'order' => 'desc')) . ">&uarr;</a>";
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
function getPageNavigation($hits, $page, $max, $min=1) {
	$nav  = "<nav class='pagenav'>";
	$nav .= "<a href='" . getQueryString(array('page' => $min)) . "'>&lt;&lt;</a> ";
	$nav .= "<a href='" . getQueryString(array('page' => ($page > $min ? $page - 1 : $min) )) . "'>&lt;</a> ";
 
  for($i=$min; $i<=$max; $i++) {
    $nav .= "<a href='" . getQueryString(array('page' => $i)) . "'>$i</a> ";
  }
 
  $nav .= "<a href='" . getQueryString(array('page' => ($page < $max ? $page + 1 : $max) )) . "'>&gt;</a> ";
  $nav .= "<a href='" . getQueryString(array('page' => $max)) . "'>&gt;&gt;</a> ";
  $nav .= "</nav>";
  return $nav;
}


/**
 * Create links for hits per page.
 *
 * @param array $hits a list of hits-options to display.
 * @return string as a link to this page.
 */
function getHitsPerPage($hits) {
  $nav = "Träffar per sida: ";
  foreach($hits AS $val) {
  	
    $nav .= "<a href='" . getQueryString(array('hits' => $val)) . "'>$val</a> ";
  }  
  return $nav;
}

/**
 * Create links for genres.
 *
 * @param array $genre a list of genres.
 * @return string as a link to this page.
 */
function getGenres($genres){
	$categories = "<ul class='horizontal'>";
	foreach($genres as $key=>$val) {
		$categories .= "<li><a class='smallbutton' href='" . getQueryString(array('genre' => $val->name)) . "''>{$val->name}</a></li>";
	}
	$categories .= "</ul>";
	return $categories;
}









// Do SELECT from a table to get all active genres
	$sql = "SELECT DISTINCT G.name
			FROM Genre AS G
			INNER JOIN Movie2Genre AS M2G
			ON G.id = M2G.idGenre;";
	$res = $db->ExecuteSelectQueryAndFetchAll($sql);
	$categories = getGenres($res);

	

// Get parameters 
$title    = isset($_GET['title']) ? $_GET['title'] : null;
$genre    = isset($_GET['genre']) ? $_GET['genre'] : null;
$hits     = isset($_GET['hits'])  ? $_GET['hits']  : 8;
$page     = isset($_GET['page'])  ? $_GET['page']  : 1;
$year1    = isset($_GET['year1']) && !empty($_GET['year1']) ? $_GET['year1'] : null;
$year2    = isset($_GET['year2']) && !empty($_GET['year2']) ? $_GET['year2'] : null;
$orderby  = isset($_GET['orderby']) ? strtolower($_GET['orderby']) : 'id';
$order    = isset($_GET['order'])   ? strtolower($_GET['order'])   : 'asc';
$hits 	  = isset($_GET['hits']) && is_numeric($_GET['hits']) ? $_GET['hits']  : '8'; // How many rows to display per page.
$page 	  = isset($_GET['page']) ? $_GET['page'] : 1; ; // Which is the current page to display, use this to calculate the offset value


// Check that incoming parameters are valid
is_numeric($hits) or die('Check: Hits must be numeric.');
is_numeric($page) or die('Check: Page must be numeric.');
is_numeric($year1) || !isset($year1)  or die('Check: Year must be numeric or not set.');
is_numeric($year2) || !isset($year2)  or die('Check: Year must be numeric or not set.');

// Prepare the query based on incoming arguments
$sqlOrig = '
  SELECT 
    M.*,
    GROUP_CONCAT(G.name) AS genre
  FROM Movie AS M
    LEFT OUTER JOIN Movie2Genre AS M2G
      ON M.id = M2G.idMovie
    INNER JOIN Genre AS G
      ON M2G.idGenre = G.id
';
$where    	 = null;
$groupby  	 = ' GROUP BY M.id';
$limit    	 = null;
$sort     	 = " ORDER BY $orderby $order";
$params   	 = array();
$searchInput = null;
// Select by title
if($title) {
  $searchInput = $title;
  $title = '%' . $title . '%';	
  $where .= ' AND title LIKE ?';
  $params[] = $title;
} 

// Select by year
if($year1) {
  $where .= ' AND YEAR >= ?';
  $params[] = $year1;
} 
if($year2) {
  $where .= ' AND YEAR <= ?';
  $params[] = $year2;
} 

// Select by genre
if($genre) {
  $where .= ' AND G.name = ?';
  $params[] = $genre;
} 

// Pagination
if($hits && $page) {
  $limit = " LIMIT $hits OFFSET " . (($page - 1) * $hits);
}

// Complete the sql statement
$where = $where ? " WHERE 1 {$where}" : null;
$sql = $sqlOrig . $where . $groupby . $sort . $limit;
$res = $db->ExecuteSelectQueryAndFetchAll($sql, $params);

// Create table to display result
$table = "<table><thead><th>Bild</th><th>Id " . orderby('id') . "</th><th>Titel" . orderby('title') . "</th><th>År" . orderby('year') . "</th><th>Genre</th></thead><tbody>";

foreach($res as $key=>$val) {
	$table .= "<tr><td><img class='thumbnail' src='{$val->image}' alt='{$val->title}'></td><td>{$val->id}</td><td>{$val->title}</td><td>{$val->year}</td><td>{$val->genre}</td></tr>";
}
$table .= "</tbody></table>";


// Get max pages for current query, for navigation
$sql = "
  SELECT
    COUNT(id) AS rows
  FROM 
  (
    $sqlOrig $where $groupby
  ) AS Movie
";
$res = $db->ExecuteSelectQueryAndFetchAll($sql, $params);
$rows = $res[0]->rows;
$max = ceil($rows / $hits);

// Get max pages from table, for navigation

$hitsPerPage = getHitsPerPage(array(2, 4, 8));
$pageNav = getPageNavigation($hits, $page, $max);




$sqlDebug = $db->Dump();
// Do it and store it all in variables in the Eden container.
$eden['title'] = "Filmdatabasen";
 

 
$eden['main'] = <<<EOD

<div class="grid">
	<a class="right" href="?restore">Återställ databasen</a>
	<h2>MovieDB</h2>
	
	
	<form method='get' >
	
		<fieldset>
		<legend>Sök</legend>
		<input type=hidden name=genre value='{$genre}'/>
 		 <input type=hidden name=hits value='{$hits}'/>
 		 <input type=hidden name=page value='1'/>
			<div class="grid-1-2">
				<label>Välj genre:</label>
				$categories
			</div>

			<div class="grid-1-2">
				<label for="title">Titel:</label> <input id="title" type='search' name='title' value='{$searchInput}'/>
				<label for="years">Skapad mellan åren: </label>
				<p id="years">
					<input type='text' name='year1' value='{$year1}' />
					- 
					<input type='text' name='year2' value='{$year2}'/>
				</p>  
				<input class="right clear" type='submit' name='submit' value='Sök'/>
			</div>

		</fieldset>
	</form>
	<hr>
	<p><a class="smallbutton" href='?'>Visa alla</a></p>
	$hitsPerPage
	$table
	$pageNav
</div>
<div class=debug>{$sqlDebug}</div>
EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);





