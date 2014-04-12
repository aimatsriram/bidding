<?php
/**
Template Name: Biddings
*/
get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

						<div id="main" class="twelvecol first clearfix" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
									
								</header> <!-- end article header -->

								<section class="entry-content clearfix" itemprop="articleBody">
									<?php the_content(); ?>
									<div class="products-list">
									<?php
									$args = array(
											'post_type' => 'products',
											'posts_per_page' => 9,
											'paged' => get_query_var( 'paged' )
											);
									$the_query = new WP_Query( $args );
									if ( $the_query->have_posts() ) { ?> <ul class="clearfix">
											<?php while ( $the_query->have_posts() ) {
											$the_query->the_post(); ?>
											<li>
												<div class="product_title_info">
													<a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a>
													<span>RRP &euro;<?php echo getMeta('priceorginal',get_the_ID()); ?></span>
												</div>
												<div class="product_thumb"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('bid-thumb-300'); ?></a></div>
												<div class="product_meta_info clearfix">
												<span class="left">&euro;<?php echo getMeta('price',get_the_ID()); ?></span>
												<span class="right"><a href="<?php the_permalink(); ?>" class="button">Bid It</a></span>
												</div>
											</li>
												<?php } ?> </ul> <?php } wp_reset_postdata(); 
									?>
									</div>
							</section> <!-- end article section -->

							</article> <!-- end article -->

							<?php endwhile; endif; ?>

						</div> <!-- end #main -->

					

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>