<?php

class CBlog extends CContent {

	// MEMBERS
	private $filter; // Obj to filter text

 /**
   * Constructor creating the filter object 
   *
   */
  public function __construct($options) {
  	parent::__construct($options);
  	$this->filter = new CTextFilter();
	}


public function getPosts($slug) {
	if($slug){
	$res = $this->Select(array('equals'		=> array('type' => 'post', 'slug' => $slug,),
								'published'	=> true,), 'VComplete');
	}
	else {
	$res = $this->Select(array('equals'		=> array('type' => 'post',),
							   'published'	=> true,), 'VComplete');
	}

	$html = null;
	if(isset($res[1])) {
  		foreach($res as $c) {
		    $title  = htmlentities($c->title, null, 'UTF-8');
		    $data   = $this->filter->doFilter(htmlentities($c->DATA, null, 'UTF-8'), $c->FILTER);
		 
		    $html .= <<<EOD
		<section>
		  <article>
		  <header class="blogheader">
		  <h2><a href='edenpress_blog.php?slug={$c->slug}'>{$title}</a></h2>
		  </header>
		  {$data}
		  </article>
		</section>
		<hr>
EOD;
  		}
	}
	else if(!isset($res[1])) {
  		foreach($res as $c) {
		    $title  = htmlentities($c->title, null, 'UTF-8');
		    $data   = $this->filter->doFilter(htmlentities($c->DATA, null, 'UTF-8'), $c->FILTER);
		 
		    $html .= <<<EOD
		    <p><a href="?" title="se alla blogposter">Se alla bloggposter</a></p>
		<section>
		  <article>
		  <header class="blogheader">
		  <h2>{$title}</h2>
		  </header>
		  {$data}
		  </article>
		  <footer class="pagefooter">
			<p>Skriven av {$c->user} ({$c->created})</p>
			<p>Kategori: {$c->categories}</p>
		</footer>
		</section>
	
EOD;
  		}
	}
	else if($slug) {
	  $html = "Det fanns inte en sådan bloggpost.";
	}
	else {
	  $html = "Det fanns inga bloggposter.";
	}

	return $html;
}	

}