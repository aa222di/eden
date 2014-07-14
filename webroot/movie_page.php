<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 


// Connect to a MySQL database using PHP PDO
$dsn      = 'mysql:host=localhost;dbname=Movie;';
$login    = 'root';
$password = 'root';
$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

//$pdo = new PDO($dsn, $login, $password, $options);
try {
  $pdo = new PDO($dsn, $login, $password, $options);
}
catch(Exception $e) {
  //throw $e; // For debug purpose, shows all connection details
  throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
}
// Fetch as object as default
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);



// RESTORE

// Restore the database to its original settings
$sql      = 'movie.sql';
$mysql    = '/Applications/MAMP/Library/bin/mysql';
$host     = 'localhost';
$login    = 'root';
$password = 'root';
$output = null;
 
if(isset($_POST['restore']) || isset($_GET['restore'])) {
  $cmd = "$mysql -h{$host} -u{$login} -p{$password} < $sql 2>&1";
  $res = exec($cmd);
  $output = "<p>Databasen är återställd via kommandot<br/><code>{$cmd}</code></p><p>{$res}</p>";
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
  return $prepend . http_build_query($query);
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
 
echo getHitsPerPage(array(2, 4, 8));

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
  $nav  = "<a href='" . getQueryString(array('page' => $min)) . "'>&lt;&lt;</a> ";
  $nav .= "<a href='" . getQueryString(array('page' => ($page > $min ? $page - 1 : $min) )) . "'>&lt;</a> ";
 
  for($i=$min; $i<=$max; $i++) {
    $nav .= "<a href='" . getQueryString(array('page' => $i)) . "'>$i</a> ";
  }
 
  $nav .= "<a href='" . getQueryString(array('page' => ($page < $max ? $page + 1 : $max) )) . "'>&gt;</a> ";
  $nav .= "<a href='" . getQueryString(array('page' => $max)) . "'>&gt;&gt;</a> ";
  return $nav;
}
 

// Get parameters for sorting
$hits  = isset($_GET['hits']) ? $_GET['hits'] : 8;
$page  = isset($_GET['page']) ? $_GET['page'] : 1;


// Check that incoming is valid
is_numeric($hits) or die('Check: Hits must be numeric.');
is_numeric($page) or die('Check: Page must be numeric.');



// Get max pages from table, for navigation
$sql = "SELECT COUNT(id) AS rows FROM VMovie";
$sth = $pdo->prepare($sql);
$sth->execute();
$res = $sth->fetchAll();

// Get maximal pages
$max = ceil($res[0]->rows / $hits);


// Do SELECT from a table
$sql = "SELECT * FROM VMovie LIMIT $hits OFFSET " . (($page - 1) * $hits);
$sth = $pdo->prepare($sql);
$sth->execute();
$res = $sth->fetchAll();

// Create TABLE change
$table = "<table><thead><th>Bild</th><th>Id</th><th>Titel</th><th>År</th><th>Genre</th></thead><tbody>";

foreach($res as $key=>$val) {
	$table .= "<tr><td><img class='thumbnail' src='{$val->image}' alt='{$val->title}'></td><td>{$val->id}</td><td>{$val->title}</td><td>{$val->year}</td></tr>";
}
$table .= "</tbody></table>";


$hitsPerPage = getHitsPerPage(array(2, 4, 8));
$navigatePage = getPageNavigation($hits, $page, $max);

// Do it and store it all in variables in the Eden container.
$eden['title'] = "Visa alla";
 

 
$eden['main'] = <<<EOD

<div class="grid">
	<a class="right" href="?restore">Återställ databasen</a>
	$output
	<h2>MovieDB</h2>
	
	
	<form method='get' >
	
		<fieldset>
		<legend>Sök</legend>
			<div class="grid-1-2">
				<label>Välj genre:</label>

				
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
	$navigatePage
</div>
<hr>


EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);





