<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title><?php // title tag ?></title>
	<meta name="description" content="">
	<meta name="author" content="">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <?php echo link_tag('static/css/style.css?v=2'); // html5boilerplate?>
	<?php echo link_tag('static/css/jquery-ui-themes/pepper-grinder/jquery-ui-1.8.11.custom.css'); // jquery ui theme "Pepper Grinder"?>
    
    <?php $this->load->view('tpl/footer_javascripts', array('option'=>'for_the_future')); ?>    
    
</head>

<body>
	<div id="container">

		<header>
        	
            <p>Wes Broadway&rsquo;s CodeIgniter + HTML5 ✰ Boilerplate</p>

		</header>
        
        <nav id="primary">
        
        	<?php echo anchor(index_page(), 'Home');?>
        	<?php echo anchor('blog', 'Blog Demo');?>
            <?php echo anchor('user_guide', 'CodeIgniter User Guide');?>
        </nav>

		<div id="main" role="main">
