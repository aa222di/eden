<?php

class CBlog extends CCRUD {

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


/**
 *	get categories
 * @return string , ul/li of categories
 */
public function getCategories() {
	$res = $this->SELECT(array('equals'		=> array('type' => 'post',),
							   'distinct'	=> 'category'), 'ContentRM');
	$categories = "<ul class='categories'>";
	foreach ($res as $key => $value) {
		$categories .= "<li><a href='?category=" . $value->category . "'>" . $value->category . "</a></li>";		
	}
	$categories .= "</ul>";

	return $categories;
}

/**
 *	get breadcrumb
 * @return string , links for breadcrumb in <nav>
 */
public function getBreadcrumb() {

	$category = null;
	$title = null;
	$breadcrumb = "<nav class='breadcrumb'>"; 
	parse_str($_SERVER['QUERY_STRING'], $query);
	
	// Get category for chosen post
	if(!isset($query['category']) && isset($query['slug'])) {

		$category = $this->SELECT(array('equals' 	=> array( 'type' => 'post', 'slug' => $query['slug'],),
										'distinct'	=> 'category',), 'ContentRM');

		$category = $category[0]->category;
		$category = "<a href='?category=$category'> &laquo; $category </a>";
	}

	// Get title
	if(isset($query['slug'])) {
		$title = $this->SELECT(array('equals' 	=> array( 'type' => 'post', 'slug' => $query['slug'],),
										'distinct'	=> 'title',), 'ContentRM');

		$title = $title[0]->title;
	}

	// Get chosen category if no post is chosen
	if(!isset($query['slug']) && isset($query['category'])) {
		$category = '&laquo; ' . $query['category'];
	}

	$breadcrumb .= "<a href='?'>All posts </a>";
	$breadcrumb .= isset($category) ? $category : null;
	$breadcrumb .= isset($title) ? "&laquo; " . $title : null;
	$breadcrumb .= "</nav>";
		
		return $breadcrumb;
	}

/**
 *	get posts
 * @param slug, string
 * @param category, string or null
 * @param limit, int
 * @return string 
 */
public function getPosts($slug, $category, $limit=7) {
	$hits 	= $limit; // How many posts to display per page.
	$page	= isset($_GET['page']) ? $_GET['page'] : 1; // Which is the current page to display, use this to calculate the offset value
	if($slug){
	$res = $this->SELECT(array('equals'		=> array('type' => 'post', 'slug' => $slug,),
							   'published'	=> true,), 'ContentRM');
	}

	else if($category){
	$res = $this->SELECT(array('equals'		=> array('type' => 'post', 'category' => $category,),
							   'published'	=> true,
							   'orderby' 	=> 'published', 
							   'order' 		=> 'DESC',
							   'hits'		=> $hits,
							   'page'		=> $page,
							   ), 'ContentRM');
	}

	else {
	$res = $this->SELECT(array('equals'		=> array('type' => 'post',),
							   'published'	=> true,
							   'orderby' 	=> 'published', 
							   'order' 		=> 'DESC',
							   'hits'		=> $hits,
							   'page'		=> $page,), 'ContentRM');
	}

	$html = null;
	if(isset($res[1])) {
  		foreach($res as $c) {
		    $title  = htmlentities($c->title, null, 'UTF-8');
		    $data   = $this->filter->doFilter(htmlspecialchars($c->data, null, 'UTF-8'), $c->filter);
		    $data	= substr($data, 0, 250) . "... <a href='newsblog.php?slug={$c->slug}'>Read&nbsp;more&nbsp;&rarr;</a>";
		 
		    $html .= <<<EOD
		<section class="excerpt">
		  <article>
		  <header class="blogheader">
		  <h1><a href='newsblog.php?slug={$c->slug}'>{$title}</a></h1>
		   <h2 class='right'>{$c->published}</h2>
		  </header>
		  {$data}
		  </article>
		</section>
		
EOD;
  		}
  		$pageNav = $this->pageNavigation(array('hits' => $hits, 'page' => $page,));
  		$html .= $pageNav['pageNav'];
	}
	else if(!isset($res[1])) {
  		foreach($res as $c) {
  			// Get previous and next post links
  			$prev = $this->SELECT(array( 'less'		=> array('published' => $c->published,),
							   			'published'	=> true,
							   			'hits'		=> 1,
							   			'page' 		=> 1,
							   			'orderby' 	=> 'published', 
							   			'order' 	=> 'DESC',), 'ContentRM');
  			$prevLink = isset($prev[0]) ? "<a class='previous-post' href='newsblog.php?slug=" . $prev[0]->slug . "'>&laquo " . $prev[0]->title . "</a>" : null;

  			$next = $this->SELECT(array('greater'	=> array('published' => $c->published,),
							   			'published'	=> true,
							   			'hits'		=> 1,
							   			'page' 		=> 1,
							   			'orderby' 	=> 'published', 
							   			'order' 	=> 'ASC',), 'ContentRM');
  			$nextLink = isset($next[0]) ? "<a class='next-post' href='newsblog.php?slug=" . $next[0]->slug . "'>" . $next[0]->title . " &raquo</a>" : null;

  			// Present post
		    $title  = htmlentities($c->title, null, 'UTF-8');
		    $data   = $this->filter->doFilter(htmlentities($c->data, null, 'UTF-8'), $c->filter);
		 
		    $html .= <<<EOD
		  <article>
		  <header class="blogheader">
		  <h1>{$title}</h1>
		  <h2 class='right'>{$c->published}</h2>
		  </header>
		  {$data}
		  </article>
		  <footer class="blogfooter">
			
			<p>Category: <a href='?category=$c->category'>$c->category</a></p>
		</footer>
		$prevLink
		$nextLink
	
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