<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
$table = 'VMovie';
$db = new CDatabaseTable($eden['database'], $table); 



// Restore the database to its original settings
$sql      = 'movie.sql';
$mysql    = '/Applications/MAMP/Library/bin/mysql';
$host     = 'localhost';
$output = null;
 
if(isset($_POST['restore']) || isset($_GET['restore'])) {
  $output = $db->ResetDatabase($sql, $mysql, $host);
}

// Get genres



// Do SELECT from a table to get all active genres
	$sql = "SELECT DISTINCT G.name
			FROM Genre AS G
			INNER JOIN Movie2Genre AS M2G
			ON G.id = M2G.idGenre;";
	$res = $db->ExecuteSelectQueryAndFetchAll($sql);
	$categories = $db->getCategories($res);


// Create the html from databasetable

// Get parameters 
$title    = isset($_GET['title']) ? $_GET['title'] : null;
$genre    = isset($_GET['genre']) ? $_GET['genre'] : null;
$year1    = isset($_GET['year1']) && !empty($_GET['year1']) ? $_GET['year1'] : null;
$year2    = isset($_GET['year2']) && !empty($_GET['year2']) ? $_GET['year2'] : null;
$orderby  = isset($_GET['orderby']) ? strtolower($_GET['orderby']) : 'id';
$order    = isset($_GET['order'])   ? strtolower($_GET['order'])   : 'asc';
$hits 	  = isset($_GET['hits']) && is_numeric($_GET['hits']) ? $_GET['hits']  : '8'; // How many rows to display per page.
$page 	  = isset($_GET['page']) ? $_GET['page'] : 1; ; // Which is the current page to display, use this to calculate the offset value



$parameters = array(
	'title' 	=> $title,
	'hits'		=> $hits,
	'page'		=> $page,
	'year1'		=> $year1,
	'year2'		=> $year2,
	'orderby'	=> $orderby,
	'order' 	=> $order,
	'genre'		=> $genre,
	 );

$html = $db->getHTML($parameters);
$table = $html['table'];
$pageNav = $html['pageNav'];
$hitsPerPage = $html['hitsPerPage'];



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
				<label for="title">Titel:</label> <input id="title" type='search' name='title' value='{$title}'/>
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





