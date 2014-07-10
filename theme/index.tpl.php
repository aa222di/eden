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
	
	  <div id='wrapper'>
	  
	    <header>
	    	
			<?=$header?>
			<?php if(isset($navbar)): ?><?=get_navbar($navbar)?><?php endif; ?>
			
	    </header>
	    
	    <div id='content'><?=$main?></div>
	    
	  </div>
	    
	    <div class="push"></div>
	    <footer><?=$footer?></footer>
	    
	
	</body>
</html>
