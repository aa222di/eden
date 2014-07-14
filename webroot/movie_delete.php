<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
$db = new CDatabase($eden['database']); 

$id = $_GET['id'];

// Select information on the movie 
$sql = 'SELECT * FROM Movie WHERE id = ?';
$params = array($id);
$res = $db->ExecuteSelectQueryAndFetchAll($sql, $params);
 
if(isset($res[0])) {
  $movie = $res[0];
}
else {
  die('Failed: There is no movie with that id');
}


// Get parameters 
$id     = isset($_POST['id'])    ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
$delete = isset($_POST['delete'])  ? true : false;
$reset  = isset($_POST['reset'])  ? true : false;

// Check that incoming parameters are valid
is_numeric($id) or die('Check: Id must be numeric.');


// Check if form was submitted
$output = null;
if($delete) {
 
  $sql = 'DELETE FROM Movie2Genre WHERE idMovie = ?';
  $db->ExecuteQuery($sql, array($id));
  $db->SaveDebug("Det raderades " . $db->RowCount() . " rader från databasen.");
 
  $sql = 'DELETE FROM Movie WHERE id = ? LIMIT 1';
  $db->ExecuteQuery($sql, array($id));
  $db->SaveDebug("Det raderades " . $db->RowCount() . " rader från databasen.");
 
  header('Location: movie_deleteview.php');
}

elseif($reset) {
	header('Location: movie_deleteview.php');
}

$sqlDebug = $db->Dump();
// Do it and store it all in variables in the Eden container.
$eden['title'] = "Ta bort filmer";
 

 
$eden['main'] = <<<EOD
<h2>Uppdatera filmer</h2>

<form method=post>
  <fieldset>
  <legend>Radera film</legend>
  <p> Är du säker på att du vill radera $movie->title ?</p>
  <input type='hidden' name='id' value='{$id}'/>

  <p><input type='submit' name='delete' value='Radera'/><input type='submit' name='reset' value='Tillbaka'/></p> 
  <output>{$output}</output>
  </fieldset>
</form>
<hr>
$sqlDebug

EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
