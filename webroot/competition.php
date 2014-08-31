<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
$eden['stylesheets'][] = 'css/calendar.css';
$eden['stylesheets'][] = 'css/dice.css'; 
$CCalendar = new CCalendar();
$CMovie = new CMovie($eden['database']);

if(isset($_POST['reset'])){
	unset($_SESSION['CGame']);
}
if(!isset($_SESSION['CGame'])){
$_SESSION['CGame'] = new CGameboard(1);
}

//$roll = $_SESSION['CGame']->Play();
//$image = $_SESSION['CGame']->GetDiceImage();
//$total = $_SESSION['CGame']->getTotal();
$gameboard = $_SESSION['CGame']->getGameboard();

$calendar = $CCalendar->getCalendar();
$movie = $CMovie->movieOfTheMonth($CCalendar->newMonth);



// Do it and store it all in variables in the Eden container.
$eden['title'] = "Competition";
 
$eden['main'] = <<<EOD
<section class="grid">
<header class='competition-header'><h1>Movie of the month</h1><h2>Compete and win the movie of the month</h2></header>
<div class='grid-2-3'>
$movie
</div>
<div class='grid-1-3'>
$calendar
</div>
</section>
<div class='grey'>
	<section class="grid">
	<h4 class="center">Play the fantastic dice game and win the movie of the month!</h4>
	<h5 class='center'>You need to get 60 points in less than 5 rounds, if you succeed we'll send you the movie of the month right away</h5>
	<h5 class='center'>Remember to save your points before you roll 1 because when you get 1 you total gets reset to 0 and your round counts anyway</h5>
	</section>
</div>
<div class="grid" id='dice'>
$gameboard
</div>

EOD;

 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
