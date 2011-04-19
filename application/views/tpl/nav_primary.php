        <nav id="primary">
        	<?php echo anchor(index_page(), 'Home');?>
        	<?php echo anchor('blog', 'Blog Demo');?>
            <?php if(!$this->tank_auth->is_logged_in()) echo anchor('auth/login', 'Login');?>
            <?php echo anchor('user_guide', 'User Guide');?>
        </nav>
