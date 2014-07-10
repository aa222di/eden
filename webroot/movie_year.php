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



// Fetch search input, prepare stmt and execute it

// Get parameters for sorting
$year1 = isset($_GET['year1']) && !is_nan($_GET['year1']) ? $_GET['year1'] : null;
$year2 = isset($_GET['year2']) && !is_nan($_GET['year2']) ? $_GET['year2'] : null;

 
 
// Do SELECT from a table


if($year1 && $year2) {
  $sql = "SELECT * FROM Movie WHERE year >= ? AND year <= ?;";
  $params = array(
    $year1,
    $year2,
  );  
} 
elseif($year1) {
  $sql = "SELECT * FROM Movie WHERE year >= ?;";
  $params = array(
    $year1,
  );  
} 
elseif($year2) {
  $sql = "SELECT * FROM Movie WHERE year <= ?;";
  $params = array(
    $year2,
  );  
} 

else {
	 $sql = "SELECT * FROM Movie;";
	 $params = null;
}

$sth = $pdo->prepare($sql);
$sth->execute($params);
$res = $sth->fetchAll();



// Create TABLE

$table = "<table><thead><th>Bild</th><th>Id</th><th>Titel</th><th>År</th><th>Genre</th></thead><tbody>";

foreach($res as $key=>$val) {
	$table .= "<tr><td><img class='thumbnail' src='{$val->image}' alt='{$val->title}'></td><td>{$val->id}</td><td>{$val->title}</td><td>{$val->year}</td></tr>";


}
$table .= "</tbody></table>";



//var_dump($res);

// Do it and store it all in variables in the Eden container.
$eden['title'] = "Visa alla";
 

 
$eden['main'] = <<<EOD

<div class="grid">
	<a class="right" href="?restore">Återställ databasen</a>

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
					<input type='number' name='year1' />
					- 
					<input type='number' name='year2' />
				</p>  
				
				<input class="right clear" type='submit' name='submit' value='Sök'/>
			</div>
		</fieldset>
		
	</form>
	
	
	
	
	<hr>
	<p><a class="smallbutton" href='?'>Visa alla</a></p>

	$table

</div>
<hr>


EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);





