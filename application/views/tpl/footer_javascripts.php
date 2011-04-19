	<!-- load modernizer -->
	<script src="<?php echo site_url('static/js/libs/modernizr-1.7.min.js'); ?>"></script>    

	<!-- load jquery+ui, cuz its awesome, yo -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo site_url("static/js/libs/jquery-1.5.2.min.js");?>"%3E%3C/script%3E'))</script>
	<script type="text/javascript" src="<?php echo site_url('static/js/jquery-ui-1.8.11.custom.min.js');?>"></script>
       
    <!-- load our js plugins & other -->
	<script src="<?php echo site_url("static/js/plugins.js");?>"></script>
	<script src="<?php echo site_url("static/js/script.js");?>"></script>
    
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
    
    <?php /*
	<script>
		var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']]; // Change UA-XXXXX-X to be your site's ID
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>
	*/ ?>
