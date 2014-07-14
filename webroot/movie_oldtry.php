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
 * Function to create links for sorting
 *
 * @param string $column the name of the database column to sort by
 * @return string with links to order by column.
 */
function orderby($column) {
  return "<a href='?orderby={$column}&amp;order=asc'>&darr;</a><a href='?orderby={$column}&amp;order=desc'>&uarr;</a>";
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

$querystring = array();
parse_str($_SERVER['QUERY_STRING'], $querystring);



$paramsDefault = array('title'=>'%','year1'=> 0, 'year2' => 5000, 'hits'=>5, 'page'=>1, 'orderby'=>'id', 'order'=>'asc', 'genre'=>'SELECT genre FROM VMovie');
$params = array_merge($paramsDefault, $querystring );
$params['title'] = "%". $params['title'] ."%";
$querystring ="<pre>". var_dump($querystring) . "</pre>";



// Do SELECT from a table to get all active genres
	$sql = "SELECT DISTINCT G.name
			FROM Genre AS G
			INNER JOIN Movie2Genre AS M2G
			ON G.id = M2G.idGenre;";

	$res = $db->ExecuteSelectQueryAndFetchAll($sql);
	
	
	$categories = "<ul class='horizontal'>";
	foreach($res as $key=>$val) {
		$categories .= "<li><a class='smallbutton' href='?genre={$val->name}'>{$val->name}</a></li>";
		
	}
	$categories .= "</ul>";





	
	
// Paginering
$hits = isset($_GET['hits']) ? $_GET['hits'] : 5; // How many rows to display per page.
$page = isset($_GET['page']) ? $_GET['page'] : 1; ; // Which is the current page to display, use this to calculate the offset value


// Get max pages from table, for navigation
$sql = "SELECT COUNT(id) AS rows FROM VMovie";
$res = $db->ExecuteSelectQueryAndFetchAll($sql);

$max = ceil($res[0]->rows / $hits);
$min = 1; // Startpage, usually 0 or 1, what you feel is convienient

$hitsPerPage = getHitsPerPage(array(2, 4, 8));
$pageNav = getPageNavigation($hits, $page, $max);

// Create table in html to represent the database
// Get parameters for sorting
$orderby  = isset($_GET['orderby']) ? strtolower($_GET['orderby']) : 'id';
$order    = isset($_GET['order'])   ? strtolower($_GET['order'])   : 'asc';

$sql = "SELECT * FROM VMovie WHERE title LIKE ? AND year >= ? AND year <= ? AND genre in ({$params['genre']}) ORDER BY {$params['orderby']} {$params['order']} LIMIT {$params['hits']} OFFSET " . (($page - 1) * $hits);


$res = $db->ExecuteSelectQueryAndFetchAll($sql, array($params['title'],$params['year1'],$params['year2']));

$table = "<table><thead><th>Bild</th><th>Id " . orderby('id') . "</th><th>Titel" . orderby('title') . "</th><th>År" . orderby('year') . "</th><th>Genre</th></thead><tbody>";

foreach($res as $key=>$val) {
	$table .= "<tr><td><img class='thumbnail' src='{$val->image}' alt='{$val->title}'></td><td>{$val->id}</td><td>{$val->title}</td><td>{$val->year}</td><td>{$val->genre}</td></tr>";


}
$table .= "</tbody></table>";


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
			<div class="grid-1-2">
				<label>Välj genre:</label>
				$categories
				
			</div>
			<div class="grid-1-2">
				<label for="title">Titel:</label> <input id="title" type='search' name='title' value=''/>
			
				<label for="years">Skapad mellan åren: </label>
				<p id="years">
					<input type='text' name='year1' />
					- 
					<input type='text' name='year2' />
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





