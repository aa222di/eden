<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
$eden['stylesheets'][] = 'css/movie.css'; 
 
$Movie = new CMovie($eden['database']);
$id = isset($_GET['id']) ? $_GET['id'] : null;

$moviepage = $Movie->getMovie($id); 
$moviedata = $Movie->getMovieRaw($id);

// Create the gallery object
$CGallery = new CGallery( __DIR__ . DIRECTORY_SEPARATOR . 'img', '');
$filmstrip = null;
if(!$moviedata->imgfolder == null) {
$gallery = $CGallery->getGallery($moviedata->imgfolder, false, false); 
$filmstrip = '<div class="grid filmstrip">' . $gallery . '</div>';
}

// Find similar movies
$similarMovies = $Movie->getSimilarMovies($moviedata);

// Do it and store it all in variables in the Anax container.
$eden['title'] = $moviedata->title;
 

 
$eden['main'] = <<<EOD

$moviepage
<div class="grid">
$filmstrip
</div>
<section class="grey">
<div class="grid">
<a href="#" class="rent-button">Rent this movie</a>
</div>
</section>
<section class="grid similar-movies-section">
<h2>We think you might also like these movies</h2>
$similarMovies
</section>


EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
