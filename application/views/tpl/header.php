<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    
    <title><?php // title tag ?></title>

    <meta name="description" content="">

    <meta name="author" content="">
    
    <meta name="viewport" content="width=device-width,initial-scale=1">
    
	<?php $css_version = '2.0'; // arbitrary number, useful for debugging & beating back the cache demons ?>
    <?php echo link_tag('static/css/style.css?v=' . $css_version); // html5boilerplate?>
    <?php echo link_tag('static/css/style_custom.css?v=' . $css_version); // custom sheet for this site ?>
	<?php echo link_tag('static/css/jquery-ui-themes/pepper-grinder/jquery-ui-1.8.11.custom.css'); // jquery ui theme "Pepper Grinder"?>
	<?php echo link_tag('static/css/jquery-ui-themes/site_extras.css'); // jquery ui extras?>
    
    <?php $this->load->view('tpl/footer_javascripts', array('option'=>'for_the_future')); ?>    
</head>

<body>

    <div id="container">
		<header>
        	
            <p>CodeIgniter (RDNZL Mutation) + HTML5 ✰ Boilerplate</p>

		</header>
        
		<?php $this->load->view('tpl/nav_primary'); ?>
        <?php if( $this->tank_auth->is_logged_in() ) $this->load->view('tpl/nav_admin'); ?>
		<div id="main" role="main">

