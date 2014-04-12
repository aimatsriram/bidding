<?php 
global $wpdb;
$message = "";
$products_credits = getMeta('numcredits', get_the_ID());
if(empty($products_credits)) { $products_credits = ThemeOptions('numcredits'); }

$request = $_REQUEST['submit'];
if($request != ""){
	$bidprice = getMeta('price', get_the_ID());
	$bidding_price = $_REQUEST['bidding_price'];
	$bidid = $_REQUEST['bidid'];
	$userid = $_REQUEST['userid'];
	$tablname = $wpdb->prefix.'biddings';
	$data = array( 'bid'=>$bidid, 'uid' => $userid, 'user_bid_amount' => $bidding_price, 'bid_amount' => $bidprice, 'status_of_user_of_bid' => 'active');
	$wpdb->insert( $tablname, $data );
	$insertedid = $wpdb->insert_id;

	if($insertedid){
		$current_credits = get_user_meta(get_current_user_id(),'_credits',true);
		$update_credits = $current_credits-$products_credits;
		if($current_credits >0 ) {
			update_user_meta(get_current_user_id(),'_credits',$update_credits);
		}
		$message = 'You have successfully placed';
	} 
	else {
		$message = "Error in processing at moment please try again later";
	}
} 
$current_user_credits = get_user_meta(get_current_user_id(),'_credits',true);
get_header();
$date = date( 'm/d/Y g:i:s A', current_time( 'timestamp', 0 ) );
$sd = date('m/d/Y g:i:s A',getMeta('startdate', get_the_ID()));
$ed = date('m/d/Y g:i:s A',getMeta('enddate', get_the_ID()));
$startdate = new DateTime($sd);
$enddate = new DateTime($ed); 
$todaydate = new DateTime($date); 
?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">
					<?php if( $message != ""){ ?> 
						<div class="alert-help ">
							<?php echo $message; ?>
						</div>
						<?php }?>
					<div id="main" class="twelvecol first clearfix" role="main">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
									
								</header> <!-- end article header -->

								<section class="entry-content clearfix" itemprop="articleBody">
								<div  class="clearfix">
									<div class="product_featured_image"><?php the_post_thumbnail('full'); ?></div>
									<div class="product_info">
									<ul>
										<li><label>Original Price:</label> &euro;<?php echo getMeta('priceorginal', get_the_ID()); ?></li>
										<li><label>Bidding Price:</label> &euro;<?php echo getMeta('price', get_the_ID()); ?></li>
										<li><label>Start Date:</label> <?php echo date('F j, Y g:i:s A',getMeta('startdate', get_the_ID())); ?></li>
										<li><label>Close Date:</label> <?php echo date('F j, Y g:i:s A',getMeta('enddate', get_the_ID())); ?></li>
										<li>
											<?php if(($enddate > $todaydate) && ($todaydate > $startdate)) { ?>
												<div id="bid_time_counter"></div>
											<?php } elseif($todaydate > $enddate) { ?>
												<span class="bid_closed">Closed</span>
											<?php } else { ?>
												<span class="bid_coming">Coming soon</span>
											<?php } ?>
										</li>
										</ul>
									<?php if( is_user_logged_in() ) { 
									if(($enddate > $todaydate) && ($todaydate > $startdate)) {
									if($current_user_credits >= $products_credits) { ?>
									<div class="bid_button">
										<a href="#" id="bid_it" class="button">Bid It Now</a>
										<div class="bid_now_details">
											<form name="biditform" id="biditform" method="post" action="">
											<label for="bidding_price">Set Price</label>
											<input type="text" class="input_text" name="bidding_price" id="bidding_price" value="" />
											<input type="hidden" name="bidid" id="bidid" value="<?php echo get_the_ID(); ?>" />
											<input type="hidden" name="userid" id="userid" value="<?php echo get_current_user_id(); ?>" />
											<input type="submit" class="button" value="Start" name="submit">
											</form>
										</div>
									</div>
									<?php } else { ?><p>You have less credits. Please <a href="<?php echo get_url('page-topup.php'); ?>">Top up credits</a> and try again.</p> <?php } } }
									else { ?><p>You must <?php add_modal_login_button( $login_text = 'Login', $logout_text = 'Logout', $logout_url = '', $show_admin = true ); ?> to bid this product.</p><?php } ?>
									</div>
									
								</div>
								<div class="content">
									<?php the_content(); ?>
								</div>
								</section> <!-- end article section -->

							</article> <!-- end article -->

						<?php endwhile;  endif; ?>

					</div> <!-- end #main -->

					<?php //get_sidebar(); ?>

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->
<script>
jQuery(document).ready(function() {
	var newYear = new Date('<?php echo $ed; ?>'); 
	jQuery('#bid_time_counter').countdown({until: newYear, timezone: +2}); 
	jQuery('#bid_it').click( function() { 
		jQuery('.bid_now_details').fadeIn();
		return false;
	});
	jQuery('#biditform').submit( function() { 
		var bidprice = jQuery('#bidding_price').val();
		var bidactualprice = '<?php echo getMeta('price', get_the_ID()); ?>';
		if(isNaN(bidprice) || bidprice == "") {
			alert('Please check your bid price');
			jQuery('#bidding_price').focus();
			jQuery('#bidding_price').select();
			return false;
		}
		else if(parseInt(bidprice) > parseInt(bidactualprice)){
			alert('Youe price should be below than '+bidactualprice);
			jQuery('#bidding_price').focus();
			jQuery('#bidding_price').select();
			return false;
		}
		else{
			return true;
			/*var data = jQuery(this).serialize();
			alert(ajax_object.ajax_url);
			/*jQuery.post(
				ajaxurl, 
				{
					'action': 'bid_it_now',
					'data': data  
				}, 
				function(response){
					alert('The server responded: ' + response);
				}
			);
			return false; */
		}
	});
});
</script>
<?php get_footer(); ?>