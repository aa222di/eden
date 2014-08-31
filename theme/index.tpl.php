<!doctype html>
<html lang='<?=$lang?>' class='no-js'>
	<head>
		<meta charset='utf-8'/>
		<title><?=get_title($title)?></title>
		
		<?php if(isset($favicon)): ?><link rel='shortcut icon' href='<?=$favicon?>'/><?php endif; ?>
		
		<?php foreach($stylesheets as $val): ?>
		<link rel='stylesheet' type='text/css' href='<?=$val?>'/>
		<?php endforeach; ?>
		<script src='<?=$modernizr?>'></script>
	</head>
	<body>
		
	
	  <div class='wrapper'>

	  	<header class="top-nav">
	  		<div class="grid">
	  		<?php if(isset($topnav)): ?><?=get_navbar($topnav)?><?php endif; ?>
	  	</div>
	  	</header>
	  
	    <header class="main-nav">
	    	<div class="grid">
			<?=$header?>
			<?=$searchfield?>
			<?php if(isset($navbar)): ?><?=get_navbar($navbar)?><?php endif; ?>
			</div>
	    </header>
	    
	    <div id='content' class='page-content'><?=$main?></div>
	    
	  </div>
	    
	    <div class="push"></div>
	    <footer class="site-footer"><?=$footer?></footer>
	    
	<?php if(isset($jQuery)):?><script src='<?=$jQuery?>'></script><?php endif; ?>
	<?php if(isset($javascript_include)): foreach($javascript_include as $val): ?>
	<script src='<?=$val?>'></script>
	<?php endforeach; endif; ?>
	</body>
</html>
