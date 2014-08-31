<!doctype html>
<html lang='<?=$lang?>'>
	<head>
		<meta charset='utf-8'/>
		<title><?=get_title($title)?></title>
		
		<?php if(isset($favicon)): ?><link rel='shortcut icon' href='<?=$favicon?>'/><?php endif; ?>
		
		<?php foreach($stylesheets as $val): ?>
		<link rel='stylesheet' type='text/css' href='<?=$val?>'/>
		<?php endforeach; ?>
	</head>
	<body>
	
	  <div class='wrapper'>

	  	<header class="top-nav">
	  	
	  		<?php if(isset($topnav)): ?><?=get_navbar($topnav)?><?php endif; ?>
	  
	  	</header>
	  
	    <header class="side-nav">
	    	
			<?=$headerAdmin?>
			<?php if(isset($adminnav)): ?><?=get_navbar($adminnav)?><?php endif; ?>
			
	    </header>
	    
	    <div class='dashboard'><?=$main?></div>
	    
	  </div>
	    
	    <div class="push"></div>
	    <footer class="site-footer"><?=$footer?></footer>
	    
	
	</body>
</html>
