	<!-- load modernizer -->
	<script src="<?php echo site_url('static/js/libs/modernizr-2.0.6.min.js'); ?>"></script>    

	<!-- load jquery+ui, cuz its awesome, yo -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write(unescape('%3Cscript src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"%3E%3C/script%3E'))</script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
       
    <!-- load our js plugins & other -->
	<script defer src="<?php echo site_url("static/js/plugins.js");?>"></script>
	<script defer src="<?php echo site_url("static/js/script.js");?>"></script>
    
    <?php 
		if($this->tank_auth->is_logged_in()):
			$html_class = 'is_logged_in';
			if($this->uri->segment(2) == 'admin'):
				$html_class .= ' admin';
			endif;
			?>
            <!-- custom scripts for admin -->
            <script>$(document).ready(function(){ $('html').addClass('<?php echo $html_class;?>'); });</script>
    		<?php 
		endif; 
	?>
    
    <?php /* Google Analytics code for you to use: ?>
	<script> // Change UA-XXXXX-X to be your site's ID
        window._gaq = [['_setAccount','UAXXXXXXXX1'],['_trackPageview'],['_trackPageLoadTime']];
        Modernizr.load({
            load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
        });
    </script>
	<?php */ ?>

    <!--[if lt IE 7 ]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
        <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
    <![endif]-->
