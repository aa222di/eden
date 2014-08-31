<?php 

// Include the CImage class
require_once('../src/CImage/CImage.php');

// Settings for image object
$settings =  array(
  'imageDir' => __DIR__ . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR , 
  'cacheDir' => __DIR__ . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR ,
  'maxWidth' => 2000,
  'maxHeight' => 2000,
  );

// Create the image object
$image = new CImage($settings);

// Set parameters for image
if(isset($_GET['src']))         { $image->set_src($_GET['src']); }
if(isset($_GET['save-as']))     { $image->set_saveAs($_GET['save-as']); }
if(isset($_GET['quality']))     { $image->set_quality($_GET['quality']); }
if(isset($_GET['no-cache']))    { $image->set_ignoreCache(true); }
if(isset($_GET['width']))       { $image->set_newWidth($_GET['width']); }
if(isset($_GET['height']))      { $image->set_newHeight($_GET['height']); }
if(isset($_GET['crop-to-fit'])) { $image->set_cropToFit(true); }
if(isset($_GET['sharpen']))     { $image->set_sharpen(true); }
if(isset($_GET['verbose']))     { $image->set_verbose(true); }

// Display the image
$image->displayImage();