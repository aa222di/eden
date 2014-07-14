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
$title  = isset($_POST['title']) ? strip_tags($_POST['title']) : null;
$year   = isset($_POST['year'])  ? strip_tags($_POST['year'])  : null;
$image  = isset($_POST['image']) ? strip_tags($_POST['image']) : null;
//$genre  = isset($_POST['genre']) ? $_POST['genre'] : array();
$save   = isset($_POST['save'])  ? true : false;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;


// Check that incoming parameters are valid
isset($acronym) or die('Check: You must login to edit.');
is_numeric($id) or die('Check: Id must be numeric.');

// Check if form was submitted
$output = null;
if($save) {
  $sql = '
    UPDATE Movie SET
      title = ?,
      year = ?,
      image = ?
    WHERE 
      id = ?
  ';
  $params = array($title, $year, $image, $id);
  $db->ExecuteQuery($sql, $params);
  $output = 'Informationen sparades.';
}

$sqlDebug = $db->Dump();
// Do it and store it all in variables in the Eden container.
$eden['title'] = "Uppdatera filmer";
 

 
$eden['main'] = <<<EOD
<h2>Uppdatera filmer</h2>

<form method=post>
  <fieldset>
  <legend>Uppdatera info om film</legend>
  <input type='hidden' name='id' value='{$id}'/>
  <p><label>Titel:<br/><input type='text' name='title' value='{$movie->title}'/></label></p>
  <p><label>År:<br/><input type='text' name='year' value='{$movie->year}'/></label></p>
  <p><label>Bild:<br/><input type='text' name='image' value='{$movie->image}'/></label></p>
  <p><input type='submit' name='save' value='Spara'/> <input type='reset' value='Återställ'/></p>
  <output>{$output}</output>
  </fieldset>
</form>
<hr>
$sqlDebug

EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
