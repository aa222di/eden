<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $eden variable with its defaults.

include(__DIR__.'/config.php'); 
$table = 'USER';
$CUser = new CUser( $eden['database']['edenpress'], $table ); 

// Build Form

$form = $CUser->loginForm();

//Check if the password and username exist in the table

if(isset($_POST['login'])) {
$CUser->logIn(array($_POST['user'], $_POST['pswd']));
}

// Logout the user
if(isset($_POST['logout'])) {
$CUser->logOut();
}

print_r($_SESSION['user']);


$eden['title'] = (isset($_SESSION['user'])) ? 'Logga ut' : 'Logga in'; 
$eden['navbar']['items']['login']['text'] = (isset($_SESSION['user'])) ? 'Logga ut' : 'Logga in'; 
$eden['navbar']['items']['login']['title'] = (isset($_SESSION['user'])) ? 'Logga ut' : 'Logga in'; 
$eden['main'] = $form;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
