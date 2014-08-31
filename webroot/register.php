<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 

$CUser = new CUser($eden['database'], 'userRM');

// Info to memeber who are about to register
$output =  <<<EOD
<p>We are happy that you have decided to register your membership at Rental Movies. As a member you get 1$ discount everytime you rent a film. You
also get to have your own profile page which you can fill with information about yourself and your favourite movies.</p>
<P>And don't forget to check out our other members and their favourite films!</p>
EOD;


$form = $CUser->registerForm();
//$movie = $CAdmin->getObject($table, $id);

if (isset($_POST['submit'])) {
	$output = $CUser->register();
}


// Do it and store it all in variables in the Anax container.
$eden['title'] = "Register";
 
$eden['main'] = <<<EOD
<div class='grid'>
<h1>Register</h1>
<section class="grid-1-2">
$form
</section>
<section class="member-info grid-1-2">
$output
</section>
</div>
EOD;

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);