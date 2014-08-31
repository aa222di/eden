<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
$eden['stylesheets'][] = 'css/start.css'; 
$eden['stylesheets'][] = 'css/movie.css'; 
$CMovie = new CMovie($eden['database']);
$CBlog = new CBlog($eden['database']);

$genres = $CMovie->getGenres(null, 'moviecatalogue.php');
$movies = $CMovie->getLatestMovies(4);
$posts = $CBlog->getPosts(null, null, 3);
 
// Do it and store it all in variables in the Anax container.
$eden['title'] = "Hello World";
 

 
$eden['main'] = <<<EOD
<img src='img.php?src=darjeelingBIG.jpg&amp;height650&amp;quality=50' alt='Picture from the movie The Darjeeling Limited'>
<div class="grid biglogo">
<img src='img/isoLogotypeBIG.png' alt='Big isologotype for Rental Movies'>
<h2>-bringing you the latest from the movie world, always</h2>
<a href='register.php' class='registerbutton'>Register now!</a>
</div>
<div class='grey'>
<div class='grid'>
$genres
</div>
</div>
<div class='grid'>
<h1>Our latest movies</h1>
$movies
</div>
<div class='grey'>
<div class='grid'>
<h1>Latest news</h1>
$posts
</div>
</div>
EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
