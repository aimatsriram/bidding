<?php
/* Template Name: Top Up
*/
if( is_user_logged_in() ) { 
global $wpdb;
$result = array();
if(isset($_REQUEST['top_up_submit']) && !empty($_REQUEST['top_up'])) {
	// Set request-specific fields.
	$paymentType = urlencode('Sale');				// 'Authorization' or 'Sale'
	$firstName = urlencode($_POST['user_first_name']);
	$lastName = urlencode($_POST['user_last_name']);
	$creditCardType = urlencode($_POST['user_credit_card_type']);
	$creditCardNumber = urlencode($_POST['user_credit_card_number']);
	$expDateMonth = $_POST['cc_expiration_month'];
	// Month must be padded with leading zero
	$padDateMonth = urlencode(str_pad($expDateMonth, 2, '0', STR_PAD_LEFT));
	$expDateYear = urlencode($_POST['cc_expiration_year']);
	$cvv2Number = urlencode($_POST['cc_cvv2_number']);
	$address1 = urlencode($_POST['user_address']);
	$city = urlencode($_POST['user_city']);
	$state = urlencode($_POST['user_state']);
	$zip = urlencode($_POST['user_zip']);
	$country = urlencode($_POST['user_country']);	// US or other valid country code
	update_user_meta(get_current_user_id(),'user_country',$country);
	$amount = urlencode(ThemeOptions('tup'.$_POST['top_up']));
	$credits = $_POST['top_up'];
	$currencyID = urlencode('EUR');			// or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
	 
	// Add request-specific fields to the request string.
	$nvpStr =	"&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber".
				"&EXPDATE=$padDateMonth$expDateYear&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName".
				"&STREET=$address1&CITY=$city&STATE=$state&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyID";
	 
	// Execute the API operation; see the PPHttpPost function above.
	$httpParsedResponseAr = PPHttpPost('DoDirectPayment', $nvpStr);
	 
	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
	
		$current_credits = get_user_meta(get_current_user_id(),'_credits',true);
		$update_credits = $current_credits+$credits;
		update_user_meta(get_current_user_id(),'_credits',$update_credits);
		
		$tablname = $wpdb->prefix.'bidding_payments';
		$data  = array(
					'uid'=>get_current_user_id(),
					'payment_type'=>'credits',
					'amount'=>ThemeOptions('tup'.$credits),
					'trans_id'=>$httpParsedResponseAr['TRANSACTIONID'],
					'status'=>strtolower($httpParsedResponseAr["ACK"])
				);
		$wpdb->insert( $tablname, $data );
		$insertedid = $wpdb->insert_id;
		if($insertedid) {
			$result['status'] = 'success';
			$result['msg'] = 'Your transaction completed successfully and credits added.';
		}
		
	} else  {
		$result['status'] = 'error';
		$result['msg'] = 'Error in processing at moment please try again later';
		//exit('DoDirectPayment failed: ' . print_r($httpParsedResponseAr, true));
	}

}

get_header();
?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">
						<?php if( count($result) > 0){ ?> 
						<div class="alert-<?php echo $result['status']; ?>">
							<?php echo $result['msg']; ?>
						</div>
						<?php }?>

						<div id="main" class="eightcol first clearfix" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
									

								</header> <!-- end article header -->

								<section class="entry-content clearfix" itemprop="articleBody">
									<?php the_content(); ?>
									<form name="top_up_credits" id="top_up_credits" method="post" action="">
										<ul class="top_up_options clearfix">
											<li><input type="radio" name="top_up" value="50" id="top_up_50" checked="checked" /><label for="top_up_50">50 Credits</label></li>
											<li><input type="radio" name="top_up" value="100" id="top_up_100" /><label for="top_up_100">100 Credits</label></li>
											<li><input type="radio" name="top_up" value="150" id="top_up_150" /><label for="top_up_150">150 Credits</label></li>											
										</ul>
										<div class="fieldSet">
											<label for="user_first_name">First Name</label> <input type="text" name="user_first_name" value="<?php echo get_user_meta(get_current_user_id(), 'first_name', true); ?>" id="user_first_name" required="required" />
										</div>
										<div class="fieldSet">
											<label for="user_last_name">Last Name</label> <input type="text" name="user_last_name" id="user_last_name" value="<?php echo get_user_meta(get_current_user_id(), 'last_name', true); ?>" required="required" />
										</div>
										<div class="fieldSet">
											<label for="user_address">Address</label> <textarea name="user_address" id="user_address" required="required"><?php echo get_user_meta(get_current_user_id(), 'user_address', true); ?></textarea>
										</div>
										<div class="fieldSet">
											<label for="user_city">City</label> <input type="text" name="user_city" id="user_city" value="<?php echo get_user_meta(get_current_user_id(), 'user_city', true); ?>" required="required" />
										</div>
										<div class="fieldSet">
											<label for="user_state">State</label> <input type="text" name="user_state" id="user_state" value="<?php echo get_user_meta(get_current_user_id(), 'user_state', true); ?>" required="required" />
										</div>
										<div class="fieldSet">
											<label for="user_zip">Zip code</label> <input type="text" name="user_zip" id="user_zip" value="<?php echo get_user_meta(get_current_user_id(), 'user_zip', true); ?>" required="required" />
										</div>
										<div class="fieldSet">
											<label for="user_country">Country</label> 
											<select name="user_country" id="user_country" required="required">
												<?php echo getCountries(get_user_meta(get_current_user_id(), 'user_country', true)); 	?>
											</select>
										</div>
										<div class="fieldSet">
											<label for="user_credit_card_type">Credit card type</label> 
											<select name="user_credit_card_type" id="user_credit_card_type" required="required">
												<option value="visa">Visa</option>
												<option value="master_card">Master Card</option>
												<option value="discocer">Discover</option>
												<option value="visa">Visa</option>
											</select>
										</div>
										<div class="fieldSet">
											<label for="user_credit_card_number">Credit Card No</label> <input type="text" name="user_credit_card_number" id="user_credit_card_number" required="required" />
										</div>
										<div class="fieldSet">
											<label for="user_credit_card_expire">Expiration Date</label> 
														<select name="cc_expiration_month" style="width: 95px;">
                            	                                	<option value="1">1</option>
                                                                	<option value="2">2</option>
                                                                	<option value="3">3</option>
                                                                	<option value="4">4</option>
                                                                	<option value="5">5</option>
                                                                	<option value="6">6</option>
                                                                	<option value="7">7</option>
                                                                	<option value="8">8</option>
                                                                	<option value="9">9</option>
                                                                	<option value="10">10</option>
                                                                	<option value="11">11</option>
                                                                	<option value="12">12</option>
                                                            </select>
															<select name="cc_expiration_year" style="width: 95px; margin-left: 10px;">
                            	                                	<option value="2012">2012</option>
                                                                	<option value="2013">2013</option>
                                                                	<option value="2014">2014</option>
                                                                	<option value="2015">2015</option>
                                                                	<option value="2016">2016</option>
                                                                	<option value="2017">2017</option>
                                                                	<option value="2018">2018</option>
                                                                	<option value="2019">2019</option>
                                                                	<option value="2020">2020</option>
                                                            </select>
										</div>
										<div class="fieldSet">
											<label for="cc_cvv2_number">Card Varification No</label> <input type="text" name="cc_cvv2_number" id="cc_cvv2_number" required="required" />
										</div>
										<div class="fieldSet">
											<label>&nbsp;</label> 
											<input type="submit" class="button" value="Pay Now" name="top_up_submit" />
										</div>
									</form>
							</section> <!-- end article section -->
							
							
							</article> <!-- end article -->

							<?php endwhile;
							endif; ?>

						</div> <!-- end #main -->

						<?php get_sidebar(); ?>

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); 
}
 else {  wp_redirect( home_url() ); exit; }
?>
