
<div class="scrolltop">
	<i class="fa fa-angle-up" aria-hidden="true"></i>	
</div>
<footer class="footer">
	<div class="container">
		<div class="row">
			<?php if(is_active_sidebar('footer1')) :?>
				<div class="footer-widget-area col-md-4">
					<?php dynamic_sidebar('footer1'); ?>
				</div>
			<?php endif ?>
			<?php if(is_active_sidebar('footer2')) :?>
				<div class="footer-widget-area  col-md-4">
					<?php dynamic_sidebar('footer2'); ?>
				</div>
			<?php endif ?>
			<?php if(is_active_sidebar('footer3')) :?>
				<div class="footer-widget-area  col-md-4">
					<?php dynamic_sidebar('footer3'); ?>
				</div>
			<?php endif ?>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>


<div class="messenger_fb">
	 <a href="https://m.me/100004177124321">
   	<img src="<?php echo BASE_URL;?>/images/messenger_icon.png" alt="">
 	</a>
</div>
 <script>      
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '1953938748210615',
          xfbml      : true,
          version    : 'v2.6'
        });
      };

      (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));      
   </script>

   <?php get_template_part('order_fixedf'); ?>
<script src="<?php echo BASE_URL; ?>/js/wow.min.js"></script>
<script src="<?php echo BASE_URL; ?>/js/slick.js"></script>


</body>
</html>