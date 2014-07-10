<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
$db = new CDatabase($eden['database']); 


$create = isset($_POST['create']) ? strip_tags( $_POST['create'] ) : null;
$title = isset($_POST['create']) ? strip_tags( $_POST['title'] ) : null;

// Check if form was submitted
if($create) {
  $sql = 'INSERT INTO Movie (title) VALUES (?)';
  $db->ExecuteQuery($sql, array($title));
  $db->SaveDebug();
  header('Location: movie_update.php?id=' . $db->LastInsertId());
  exit;
}



// Do it and store it all in variables in the Eden container.
$eden['title'] = "Lägga till filmer";
 

 
$eden['main'] = <<<EOD
<h2>Lägg till filmer</h2>
<form method=post>
  <fieldset>
  <legend>Skapa ny film</legend>
  <p><label>Titel:<br/><input type='text' name='title'/></label></p>
  <p><input type='submit' name='create' value='Skapa'/></p>
  </fieldset>
</form>


EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
