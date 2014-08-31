<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
$eden['stylesheets'][] = 'css/about.css'; 
$CView = new CView($eden['database']);
$CUser = new CUser($eden['database'], 'userRM');

$page = $CView->viewPage('about-us'); 
$users = $CView->displayUser();
$userProfile = null;
if (isset($_GET['id'])) {
	$id = is_numeric($_GET['id']) ? $_GET['id'] : die('Id has to be numeric');
	 $userProfile = $CUser->getProfile($id);
}

 
// Do it and store it all in variables in the Anax container.
$eden['title'] = "Hello World";
 
 
$eden['main'] = <<<EOD
<div class="grid">
	<section class=" grid-1-3">
		<img class='logotype' alt='Rental Movies Logotype' src='img/Logo.png'>
	</section>
	<article class="grid-2-3 about-us">
	$page
	</article>
</div>
<div class="grey">
<h1 class='center'>Our members</h1>
<section class="grid users">
$users
</section>
</div>
<section class='grid' id='user'>
$userProfile
</section>
EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
