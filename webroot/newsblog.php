<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
$eden['stylesheets'][] = 'css/blog.css'; 
 
 
// Do it and store it all in variables in the Anax container.
$eden['title'] = "News";
 
 $CBlog = new CBlog($eden['database']);

 $categories = $CBlog->getCategories();

$slug = isset($_GET['slug']) ? $_GET['slug']: null;
$category = isset($_GET['category']) ? $_GET['category']: null;
$news = $CBlog->getPosts($slug, $category);
//echo $CBlog->db->Dump();

$breadcrumb = $CBlog->getBreadcrumb();
 
$eden['main'] = <<<EOD
<img src="img.php?src=readingnews.jpg&quality=50" alt="Movie news header">
<div class='grid'>
<header class="newsheader">
	<h1>Movie News</h1>
	<h2>-We bring you the latest news and reviews from the movie world!</h2>
</header>

$breadcrumb

<section class="grid-1-4">
<h4 class='categories-header'>Categories</h4>
$categories
</section>
<section class="grid-2-3">
$news
</section>
</div>
EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
