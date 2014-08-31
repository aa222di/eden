<?php
/**
 * Render content to theme.
 *
 */
 
// Extract the data array to variables for easier access in the template files.
extract($eden);
 
// Include the template functions.
include(__DIR__ . '/functions.php');
 
// Include the template file.
if(isset($_SESSION['admininterface'])) {
	include(__DIR__ . '/admin.tpl.php');
}

else {
include(__DIR__ . '/index.tpl.php');
}
