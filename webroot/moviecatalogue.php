<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
$eden['stylesheets'][] = 'css/movie.css'; 
 
 
$CMovie = new CMovie($eden['database']);


$form = $CMovie->getSearchForm();
$currentGenre = isset($_GET['genre']) ? $_GET['genre'] : null;
$genres = $CMovie->getGenres($currentGenre);
$catalogue = $CMovie->getCatalogue();

// Do it and store it all in variables in the Anax container.
$eden['title'] = "Movie Catalogue";
 

 
$eden['main'] = <<<EOD
<div class="grid">
	<h1>Movie Catalogue</h1>
	$form
</div>
<div class="grey">
	<div class="grid">
	$genres
	</div>
</div>
<div class="grid">
	$catalogue
</div>

EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
