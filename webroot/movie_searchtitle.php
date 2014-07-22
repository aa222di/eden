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

$dsn      = 'mysql:host=blu-ray.student.bth.se;dbname=amab14;';
$login    = 'amab14';
$password = 'pkDx9lF+';
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
$title = isset($_GET['title']) ? $_GET['title']: null;
$title = '%'.htmlentities($title).'%';
 
 
// Do SELECT from a table
if($title) {
  $sql = "SELECT * FROM Movie WHERE title LIKE ?;";
  $sth = $pdo->prepare($sql);
  $params = array($title, );
  $sth->execute($params);
} 
else {
  $sql = "SELECT * FROM Movie;";
  $sth = $pdo->prepare($sql);
  $sth->execute();
  
  
}

$res = $sth->fetchAll();



// Create TABLE change

$table = "<table><thead><th>Bild</th><th>Id</th><th>Titel</th><th>År</th><th>Genre</th></thead><tbody>";

foreach($res as $key=>$val) {
	$table .= "<tr><td><img class='thumbnail' src='{$val->image}' alt='{$val->title}'></td><td>{$val->id}</td><td>{$val->title}</td><td>{$val->YEAR}</td></tr>";


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

	$table

</div>
<hr>


EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);





