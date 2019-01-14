
<?php 
/*
Template Name: page-template-trangchu
*/
get_header(); 
?>	

<div class="page-wrapper">

	<div class="g_content">
		<div class="container">
			<div class="content_left">
				<?php 
				$arg_big_post_query = array(
					'posts_per_page' => 1,
					'cat' => 6,
					'orderby' => 'post_date',
					'order' => 'DESC',
					'post_type' => 'post',
					'post_status' => 'publish'
				);
				$big_post_query = new WP_Query();
				$big_post_query->query($arg_big_post_query);
				?>
				<div class="hot_big_post_area">
					<div class="row">
						<div class="col-md-7">
							<?php if(have_posts()) : 
								while($big_post_query->have_posts()) : $big_post_query->the_post();

									?>
									<div class="hot_big_post pw">
										<?php  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );  ?>
										<figure class="thumbnail" style="background:url('<?php echo $image[0]; ?>');">
											<a href="<?php the_permalink(); ?>"><!-- <?php //the_post_thumbnail();?> --></a> 
										</figure>
										<h2><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
										<div class="excerpt">
											<p><?php echo excerpt(25); ?></p>
										</div>
									</div>

									<?php

								endwhile;
							else:
							endif;
							?>
						</div>
						<div class="col-md-5">
							<div class="list_hot_post_others">
								<?php 
								$arg_fpost_query = array(
									'order' => 'DESC',
									'cat' => 6,
									'posts_per_page'=>2,
									'offset'=>1
								);
								$exclude_fpost_query = new WP_Query();
								$exclude_fpost_query->query($arg_fpost_query);
								?>
								<?php 
								if(have_posts()) : 
									while($exclude_fpost_query->have_posts()) : $exclude_fpost_query->the_post();
										?>
										<div class="item_list_hot pw">
											<?php  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );  ?>
											<figure class="thumbnail" style="background:url('<?php echo $image[0]; ?>');">
												<a href="<?php the_permalink(); ?>"></a>
											</figure>
											<h2><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>

										</div>

										<?php  
									endwhile;
								else:
								endif;
								?>
							</div>
						</div>
					</div>
				</div><!-- hot_big_post_area -->

				<div class="focal_week">
					<div class="lb_focal_week">
						Tin tức hot
					</div>
					<?php 
					$arg_focal_week = array(
						'posts_per_page' => 5,
						'cat' => 7,
						'orderby' => 'post_date',
						'order' => 'DESC',
						'post_type' => 'post',
						'post_status' => 'publish'
					);
					$focal_week_query = new WP_Query();
					$focal_week_query->query($arg_focal_week);
					?>
					<ul>
						<?php if(have_posts()) : 
							while($focal_week_query->have_posts()) : $focal_week_query->the_post();
								?>
								<li class="item_focal_week pw">
									<figure class="thumbnail"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail();?></a> </figure>
									<h2><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
								</li>

								<?php  
							endwhile;
						else:
						endif;
						?>
					</ul>
				</div>
				<div class="cat_post_area_idx">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<?php 
							$argsQuery = array(
								'posts_per_page'   => 3,
								'category__not_in' => array(6,7),
								'cat' => 2
							);?>
							<div class="common_diseases">
								<h2><a href="<?php echo get_category_link(2); ?>"><span><i class="fa fa-leaf" aria-hidden="true"></i><?php echo get_cat_name(2);  ?></span></a></h2>
								<div class="list_post_content">

									<?php
									$wp_query = new WP_Query(); $wp_query->query($argsQuery);
									if(have_posts()): 
										while($wp_query->have_posts()) : $wp_query->the_post(); 
											get_template_part('content');		
										endwhile;
									else:
									endif;
									?>

									<?php wp_reset_postdata();?>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<?php 
							$argsQuery = array(
								'posts_per_page'   => 3,
								'category__not_in' => array(4,6,7),
								'cat' => 3
							);?>
							<div class="common_diseases">
								<h2><a href="<?php echo get_category_link(3); ?>"><span><i class="fa fa-leaf" aria-hidden="true"></i><?php echo get_cat_name(3);  ?></span></a></h2>
								<div class="list_post_content">

									<?php
									$wp_query = new WP_Query(); $wp_query->query($argsQuery);
									if(have_posts()): 
										while($wp_query->have_posts()) : $wp_query->the_post(); 
											get_template_part('content');		
										endwhile;
									else:
									endif;
									?>

									<?php wp_reset_postdata();?>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<div class="product_area_index">
					<div class="row">
						<div class="col-md-3 col-sm-3">
							<h3 class="title_list_catpd">Danh mục sản phẩm <i></i></h3>
							<?php get_template_part('includes/product/list_product_categories'); ?>
						</div>
						<div class="col-md-9 col-sm-9">
							<h2 class="title_top_pdcat"><span>Sản phẩm mới nhất</span></h2>
							<div class="row">
								<ul class="list_products">
									<?php
									$args = array( 'post_type' => 'product', 'posts_per_page' => 9, 'orderby' => 'date' );
									$loop = new WP_Query( $args );
									while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
										<li class="col-md-4 col-sm -4 list_item_product">    
											<div class="product_inner">
												<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'single-post-thumbnail' );?>
												<figure class="thumbnail" style="background:url(<?php  echo $image[0]; ?>);" class="thumb_product" >
													<a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">

														<?php woocommerce_show_product_sale_flash( $post, $product ); ?>
													</a>
												</figure>
												
												<div class="product_meta">
													<h3><a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>"><?php the_title(); ?></a></h3>

													<div class="price">
														<span>
															<?php echo $product->get_price_html(); ?>
														</span>      
													</div>
												</div>
												<?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>
											</div>
											
										</li>
									<?php endwhile; ?>
									<?php wp_reset_query(); ?>
								</ul><!--/.products-->
							</div>
						</div>
					</div>
				</div>


			</div><!-- content_left -->


				<!-- <div class="col-md-3 col-sm-3 sidebar">
					<?php //dynamic_sidebar('sidebar1'); ?> 
				</div> -->
			</div>
		</div>

	</div>


	<?php get_footer(); ?>




