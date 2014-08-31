<?php
/**
 * CImage to output, modify and cache image files
 *
 */

class CGallery {

	// MEMBERS
	private $GALLERY_PATH; // path to the gallery dir
	private $GALLERY_BASEURL;
	private $path; // Full path to dir or image file
	private $validImages = array('png', 'jpg', 'jpeg');

	// CONSTRUCTOR
	public function __construct($GALLERY_PATH, $GALLERY_BASEURL) {
		$this->GALLERY_PATH = $GALLERY_PATH; 
		$this->GALLERY_BASEURL = $GALLERY_BASEURL;
		// Validate path
		is_dir($this->GALLERY_PATH) or $this->errorMessage('The gallery dir is not a valid directory.');
	}

	// Public Method

	/**
	 * Get gallery
	 *
	 */
	public function getGallery($path, $breadcrumb=true, $noCaption = true) {
		$this->path = realpath($this->GALLERY_PATH . DIRECTORY_SEPARATOR . $path);

		// Validate
		substr_compare($this->GALLERY_PATH, $this->path, 0, strlen($this->GALLERY_PATH)) == 0 or $this->errorMessage('Security constraint: Source gallery is not directly below the directory GALLERY_PATH.');
		
		// Read and present images in the current directory
		if(is_dir($this->path)) {
		  $gallery = $this->readAllItemsInDir($this->path, $noCaption);
		}
		else if(is_file($this->path)) {
		  $gallery = $this->readItem($this->path);
		}
		$breadcrumbHTML = null;
		if($breadcrumb){$breadcrumbHTML = $this->createBreadcrumb();}

		$html = $breadcrumbHTML . $gallery;

		return $html;

	}




	// Private Methods

	/**
	 * Display error message.
	 *
	 * @param string $message the error message to display.
	 */
	private function errorMessage($message) {
	  header("Status: 404 Not Found");
	  die('gallery.php says 404 - ' . htmlentities($message));
	}

	/**
	 * Read directory and return all items in a ul/li list.
	 *
	 * @param string $path to the current gallery directory.
	 * @param array $validImages to define extensions on what are considered to be valid images.
	 * @return string html with ul/li to display the gallery.
	 */
	private function readAllItemsInDir($noCaption) {
	  $files = glob($this->path . '/*'); 
	  $gallery = "<ul class='gallery'>\n";
	  $len = strlen($this->GALLERY_PATH);

	  foreach($files as $file) {
	    $parts = pathinfo($file);
	    $href  = str_replace('\\', '/', substr($file, $len + 1));

	    // Is this an image or a directory
	    if(is_file($file) && in_array($parts['extension'], $this->validImages)) {
	      $item    = "<a href='img.php?src=" . $this->GALLERY_BASEURL . $href . "' title='See Image Fullsize'><img src='img.php?src=" . $this->GALLERY_BASEURL . $href . "&amp;height=160&amp;' alt=''/></a>";
	      $caption = basename($file); 
	    }
	    elseif(is_dir($file)) {
	      $item    = "<img src='img/folder.png' alt=''/>";
	      $caption = basename($file) . '/';
	    }
	    else {
	      continue;
	    }
	

	if(!$noCaption) {
	    // Avoid to long captions breaking layout
	    $fullCaption = $caption;
	    if(strlen($caption) > 18) {
	      $caption = substr($caption, 0, 10) . '…' . substr($caption, -5);
	    }

	    $gallery .= "<li><a href='?path={$href}' title='{$fullCaption}'><figure class='figure overview'>{$item}<figcaption>{$caption}</figcaption></figure></a></li>\n";
	   	
	}

	else {
		$gallery .= "<li>" . $item . "</li>";

	}
	
}
	$gallery .= "</ul>\n"; 

	  return $gallery;
	}


	/**
	 * Read and return info on choosen item.
	 *
	 * @param string $path to the current gallery item.
	 * @param array $validImages to define extensions on what are considered to be valid images.
	 * @return string html to display the gallery item.
	 */
	private function readItem() {
	  $parts = pathinfo($this->path);
	  if(!(is_file($this->path) && in_array($parts['extension'], $this->validImages))) {
	    return "<p>This is not a valid image for this gallery.</p>";
	  }

	  // Get info on image
	  $imgInfo = list($width, $height, $type, $attr) = getimagesize($this->path);
	  $mime = $imgInfo['mime'];
	  $gmdate = gmdate("D, d M Y H:i:s", filemtime($this->path));
	  $filesize = round(filesize($this->path) / 1024); 

	  // Get constraints to display original image
	  $displayWidth  = $width > 800 ? "&amp;width=800" : null;
	  $displayHeight = $height > 600 ? "&amp;height=600" : null;

	  // Display details on image
	  $len = strlen($this->GALLERY_PATH);
	  $href = $this->GALLERY_BASEURL . str_replace('\\', '/', substr($this->path, $len + 1));
	  $item = <<<EOD
	<p><img src='img.php?src={$href}{$displayWidth}{$displayHeight}' alt=''/></p>
	<p>Original image dimensions are {$width}x{$height} pixels. <a href='img.php?src={$href}'>View original image</a>.</p>
	<p>File size is {$filesize}KBytes.</p>
	<p>Image has mimetype: {$mime}.</p>
	<p>Image was last modified: {$gmdate} GMT.</p>
EOD;

	  return $item;
	}

	/**
	 * Create a breadcrumb of the gallery query path.
	 *
	 * @param string $path to the current gallery directory.
	 * @return string html with ul/li to display the thumbnail.
	 */
	function createBreadcrumb() {
	  $parts = explode('/', trim(substr($this->path, strlen($this->GALLERY_PATH) + 1), '/'));
	  $breadcrumb = "<ul class='breadcrumb'>\n<li><a href='?'>Hem</a> »</li>\n";

	  if(!empty($parts[0])) {
	    $combine = null;
	    foreach($parts as $part) {
	      $combine .= ($combine ? '/' : null) . $part;
	      $breadcrumb .= "<li><a href='?path={$combine}'>$part</a> » </li>\n";
	    }
	  }

	  $breadcrumb .= "</ul>\n";
	  return $breadcrumb;
	}

}