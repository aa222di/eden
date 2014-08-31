<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
 
$CUser = new CUser($eden['database'], 'userRM');

$form = $CUser->loginForm();
$output = null; 

if(isset($_POST['submit'])) {
	
	$output = $CUser->logIn();
	
}

if(isset($_GET['logout'])) {
	$CUser->logOut();
}


// Do it and store it all in variables in the Anax container.
$eden['title'] = "Login";
 

 
$eden['main'] = <<<EOD
<div class="grid">
$output
$form
<a class='registerbutton' href='register.php' title='register'>Not yet a member? Register now! &rarr;</a>
</div>
EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
