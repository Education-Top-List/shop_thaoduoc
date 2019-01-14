
<?php 
/*
Template Name: page-template-tracnghiem
*/
get_header(); 
?>	

<div class="page-wrapper">

	<div class="g_content">
		<div class="container">
			<div class="content_left">
				<div class="col-md-9 col-sm-9">
					<div class="area_start_button">
						<h3>Một bài test nhỏ trắc nghiệm kiến thức của bạn về các lĩnh vực</h3>
						<div class="button_start">
							Bắt đầu bài test 
						</div>
					</div>
					<?php echo do_shortcode( '[wp_quiz id="109"]' ); ?>
				</div>


			</div><!-- content_left -->


			<div class="col-md-3 col-sm-3 sidebar">
				<?php dynamic_sidebar('sidebar1'); ?> 
			</div> 
		</div><!-- container -->

	</div>

</div>


<?php get_footer(); ?>




