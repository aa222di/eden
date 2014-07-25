<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
 
$page = new CPage($eden['database']['edenpress']);

// Get parameters
$url = isset($_GET['url']) ? $_GET['url'] : null;

// Get content
$c = $page->getPage($url);
$debug = $page->Dump();
// Do it and store it all in variables in the Anax container.
$eden['title'] = "Edenpress | {$c['title']}"; 
$eden['main'] = <<<EOD
<div class="grid">
	<h2>{$c['title']}</h2>
	<section class="grid-2-3">
		<article>
			{$c['data']}
		</article>
	</section>
</div>
$debug
EOD;
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
