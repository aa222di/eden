<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
 
// Connect to databases
$db = new CDatabase ($eden['database']['edenpress']);


// FUNCTIONS

$content = new CContent($eden['database']['edenpress'], 'Content');

$output = isset($_POST['save']) ? $content->createContent() : null;


// Do it and store it all in variables in the Anax container.
$eden['title'] = "Skapa nytt innehåll";
 

 
$eden['main'] = <<<EOD
<h2>{$eden['title']}</h2>

<form method=post>
  <fieldset>
  <legend>Skapa nytt innehåll</legend>

  <p><label>Titel:<br/><input type='text' name='title'/></label></p>
  <p><label>Typ:<br/>
  <select name="type">
    <option value="post" selected>post</option>
    <option value="page">page</option>
  </select> 
  </label>
  </p>
  <p class=buttons><input type='submit' name='save' value='Spara'/></p>
  <output>{$output}</output>
  </fieldset>
</form>

EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
