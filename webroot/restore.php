<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
$eden['stylesheets'][] = 'css/admin.css'; 
$CAdmin = new CAdmin($eden['database']);
$CDatabase = new CDatabase($eden['database']);
$output = null;

if (isset($_POST['restore'])) {
	$output = $CDatabase->ResetDatabase($eden['database']);
}


// Do it and store it all in variables in the Anax container.
$eden['title'] = "Restore the database";
 
$eden['main'] = <<<EOD
<div class='grid'>
<h1>Restore the database</h1>
<h4>The database will be restored with it's original content. Are you sure this is what to want?</h4>

<form method='POST' class='delete'>
	<fieldset>
		<input id="submit" type="submit"  name="restore" value="Confirm restore" >
	</fieldset>
</form>

<a href="profile.php" class="regretbutton" title='Cancel delete'>No, go back!</a>

</div>
<div class='grid'>
$output
</div>
EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
