<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bid/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/
/************* INCLUDE NEEDED FILES ***************/

/*
1. library/bid.php
	- head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
	- custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once('library/theme.php'); // if you remove this, bid will break
/*
2. library/custom-post-type.php
	- an example custom post type
	- example custom taxonomy (like categories)
	- example custom taxonomy (like tags)
*/
require_once('library/post-types/products-post-type.php'); // you can disable this if you like
/*
3. library/admin.php
	- removing some default WordPress dashboard widgets
	- an example custom dashboard widget
	- adding custom login css
	- changing text in footer of admin
*/
// require_once('library/admin.php'); // this comes turned off by default
/*
4. library/translation/translation.php
	- adding support for other languages
*/
// require_once('library/translation/translation.php'); // this comes turned off by default

require_once('library/theme-options.php'); // this comes turned off by default
	
/*
5. library/metaboxes/metaboxes.php
	- Metaboxes 
*/
require_once('library/metaboxes/metaboxes.php'); // this comes turned off by default

/*
6. library/widgets/widgets.php
	- Widgets 
*/
require_once('library/widgets/widget.php'); // this comes turned off by default

/*
6. library/inc/paypal_pro.php
	- Paypal pro
*/
require_once('library/inc/paypal_pro.php'); // this comes turned off by default


/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bid-thumb-600', 600, 150, true );
add_image_size( 'bid-thumb-300', 300, 9999, false );
/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bid-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bid-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bid_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __('Sidebar 1', 'bidtheme'),
		'description' => __('The first (primary) sidebar.', 'bidtheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __('Sidebar 2', 'bidtheme'),
		'description' => __('The second (secondary) sidebar.', 'bidtheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/

// Comment Layout
function bid_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
				<?php
				/*
					this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
					echo get_avatar($comment,$size='32',$default='<path_to_url>' );
				*/
				?>
				<!-- custom gravatar call -->
				<?php
					// create variable
					$bgauthemail = get_comment_author_email();
				?>
				<img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
				<!-- end custom gravatar call -->
				<?php printf(__('<cite class="fn">%s</cite>', 'bidtheme'), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__('F jS, Y', 'bidtheme')); ?> </a></time>
				<?php edit_comment_link(__('(Edit)', 'bidtheme'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
				<div class="alert alert-info">
					<p><?php _e('Your comment is awaiting moderation.', 'bidtheme') ?></p>
				</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
	<!-- </li> is added by WordPress automatically -->
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bid_wpsearch($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __('Search for:', 'bidtheme') . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search the Site...','bidtheme').'" />
	<input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
	</form>';
	return $form;
} // don't remove this bracket!


// Country select 
function getCountries($selected = null) {
	$countries = array(
	'AF' => 'Afghanistan',
	'AX' => 'Aland Islands',
	'AL' => 'Albania',
	'DZ' => 'Algeria',
	'AS' => 'American Samoa',
	'AD' => 'Andorra',
	'AO' => 'Angola',
	'AI' => 'Anguilla',
	'AQ' => 'Antarctica',
	'AG' => 'Antigua And Barbuda',
	'AR' => 'Argentina',
	'AM' => 'Armenia',
	'AW' => 'Aruba',
	'AU' => 'Australia',
	'AT' => 'Austria',
	'AZ' => 'Azerbaijan',
	'BS' => 'Bahamas',
	'BH' => 'Bahrain',
	'BD' => 'Bangladesh',
	'BB' => 'Barbados',
	'BY' => 'Belarus',
	'BE' => 'Belgium',
	'BZ' => 'Belize',
	'BJ' => 'Benin',
	'BM' => 'Bermuda',
	'BT' => 'Bhutan',
	'BO' => 'Bolivia',
	'BA' => 'Bosnia And Herzegovina',
	'BW' => 'Botswana',
	'BV' => 'Bouvet Island',
	'BR' => 'Brazil',
	'IO' => 'British Indian Ocean Territory',
	'BN' => 'Brunei Darussalam',
	'BG' => 'Bulgaria',
	'BF' => 'Burkina Faso',
	'BI' => 'Burundi',
	'KH' => 'Cambodia',
	'CM' => 'Cameroon',
	'CA' => 'Canada',
	'CV' => 'Cape Verde',
	'KY' => 'Cayman Islands',
	'CF' => 'Central African Republic',
	'TD' => 'Chad',
	'CL' => 'Chile',
	'CN' => 'China',
	'CX' => 'Christmas Island',
	'CC' => 'Cocos (Keeling) Islands',
	'CO' => 'Colombia',
	'KM' => 'Comoros',
	'CG' => 'Congo',
	'CD' => 'Congo, Democratic Republic',
	'CK' => 'Cook Islands',
	'CR' => 'Costa Rica',
	'CI' => 'Cote D\'Ivoire',
	'HR' => 'Croatia',
	'CU' => 'Cuba',
	'CY' => 'Cyprus',
	'CZ' => 'Czech Republic',
	'DK' => 'Denmark',
	'DJ' => 'Djibouti',
	'DM' => 'Dominica',
	'DO' => 'Dominican Republic',
	'EC' => 'Ecuador',
	'EG' => 'Egypt',
	'SV' => 'El Salvador',
	'GQ' => 'Equatorial Guinea',
	'ER' => 'Eritrea',
	'EE' => 'Estonia',
	'ET' => 'Ethiopia',
	'FK' => 'Falkland Islands (Malvinas)',
	'FO' => 'Faroe Islands',
	'FJ' => 'Fiji',
	'FI' => 'Finland',
	'FR' => 'France',
	'GF' => 'French Guiana',
	'PF' => 'French Polynesia',
	'TF' => 'French Southern Territories',
	'GA' => 'Gabon',
	'GM' => 'Gambia',
	'GE' => 'Georgia',
	'DE' => 'Germany',
	'GH' => 'Ghana',
	'GI' => 'Gibraltar',
	'GR' => 'Greece',
	'GL' => 'Greenland',
	'GD' => 'Grenada',
	'GP' => 'Guadeloupe',
	'GU' => 'Guam',
	'GT' => 'Guatemala',
	'GG' => 'Guernsey',
	'GN' => 'Guinea',
	'GW' => 'Guinea-Bissau',
	'GY' => 'Guyana',
	'HT' => 'Haiti',
	'HM' => 'Heard Island & Mcdonald Islands',
	'VA' => 'Holy See (Vatican City State)',
	'HN' => 'Honduras',
	'HK' => 'Hong Kong',
	'HU' => 'Hungary',
	'IS' => 'Iceland',
	'IN' => 'India',
	'ID' => 'Indonesia',
	'IR' => 'Iran, Islamic Republic Of',
	'IQ' => 'Iraq',
	'IE' => 'Ireland',
	'IM' => 'Isle Of Man',
	'IL' => 'Israel',
	'IT' => 'Italy',
	'JM' => 'Jamaica',
	'JP' => 'Japan',
	'JE' => 'Jersey',
	'JO' => 'Jordan',
	'KZ' => 'Kazakhstan',
	'KE' => 'Kenya',
	'KI' => 'Kiribati',
	'KR' => 'Korea',
	'KW' => 'Kuwait',
	'KG' => 'Kyrgyzstan',
	'LA' => 'Lao People\'s Democratic Republic',
	'LV' => 'Latvia',
	'LB' => 'Lebanon',
	'LS' => 'Lesotho',
	'LR' => 'Liberia',
	'LY' => 'Libyan Arab Jamahiriya',
	'LI' => 'Liechtenstein',
	'LT' => 'Lithuania',
	'LU' => 'Luxembourg',
	'MO' => 'Macao',
	'MK' => 'Macedonia',
	'MG' => 'Madagascar',
	'MW' => 'Malawi',
	'MY' => 'Malaysia',
	'MV' => 'Maldives',
	'ML' => 'Mali',
	'MT' => 'Malta',
	'MH' => 'Marshall Islands',
	'MQ' => 'Martinique',
	'MR' => 'Mauritania',
	'MU' => 'Mauritius',
	'YT' => 'Mayotte',
	'MX' => 'Mexico',
	'FM' => 'Micronesia, Federated States Of',
	'MD' => 'Moldova',
	'MC' => 'Monaco',
	'MN' => 'Mongolia',
	'ME' => 'Montenegro',
	'MS' => 'Montserrat',
	'MA' => 'Morocco',
	'MZ' => 'Mozambique',
	'MM' => 'Myanmar',
	'NA' => 'Namibia',
	'NR' => 'Nauru',
	'NP' => 'Nepal',
	'NL' => 'Netherlands',
	'AN' => 'Netherlands Antilles',
	'NC' => 'New Caledonia',
	'NZ' => 'New Zealand',
	'NI' => 'Nicaragua',
	'NE' => 'Niger',
	'NG' => 'Nigeria',
	'NU' => 'Niue',
	'NF' => 'Norfolk Island',
	'MP' => 'Northern Mariana Islands',
	'NO' => 'Norway',
	'OM' => 'Oman',
	'PK' => 'Pakistan',
	'PW' => 'Palau',
	'PS' => 'Palestinian Territory, Occupied',
	'PA' => 'Panama',
	'PG' => 'Papua New Guinea',
	'PY' => 'Paraguay',
	'PE' => 'Peru',
	'PH' => 'Philippines',
	'PN' => 'Pitcairn',
	'PL' => 'Poland',
	'PT' => 'Portugal',
	'PR' => 'Puerto Rico',
	'QA' => 'Qatar',
	'RE' => 'Reunion',
	'RO' => 'Romania',
	'RU' => 'Russian Federation',
	'RW' => 'Rwanda',
	'BL' => 'Saint Barthelemy',
	'SH' => 'Saint Helena',
	'KN' => 'Saint Kitts And Nevis',
	'LC' => 'Saint Lucia',
	'MF' => 'Saint Martin',
	'PM' => 'Saint Pierre And Miquelon',
	'VC' => 'Saint Vincent And Grenadines',
	'WS' => 'Samoa',
	'SM' => 'San Marino',
	'ST' => 'Sao Tome And Principe',
	'SA' => 'Saudi Arabia',
	'SN' => 'Senegal',
	'RS' => 'Serbia',
	'SC' => 'Seychelles',
	'SL' => 'Sierra Leone',
	'SG' => 'Singapore',
	'SK' => 'Slovakia',
	'SI' => 'Slovenia',
	'SB' => 'Solomon Islands',
	'SO' => 'Somalia',
	'ZA' => 'South Africa',
	'GS' => 'South Georgia And Sandwich Isl.',
	'ES' => 'Spain',
	'LK' => 'Sri Lanka',
	'SD' => 'Sudan',
	'SR' => 'Suriname',
	'SJ' => 'Svalbard And Jan Mayen',
	'SZ' => 'Swaziland',
	'SE' => 'Sweden',
	'CH' => 'Switzerland',
	'SY' => 'Syrian Arab Republic',
	'TW' => 'Taiwan',
	'TJ' => 'Tajikistan',
	'TZ' => 'Tanzania',
	'TH' => 'Thailand',
	'TL' => 'Timor-Leste',
	'TG' => 'Togo',
	'TK' => 'Tokelau',
	'TO' => 'Tonga',
	'TT' => 'Trinidad And Tobago',
	'TN' => 'Tunisia',
	'TR' => 'Turkey',
	'TM' => 'Turkmenistan',
	'TC' => 'Turks And Caicos Islands',
	'TV' => 'Tuvalu',
	'UG' => 'Uganda',
	'UA' => 'Ukraine',
	'AE' => 'United Arab Emirates',
	'GB' => 'United Kingdom',
	'US' => 'United States',
	'UM' => 'United States Outlying Islands',
	'UY' => 'Uruguay',
	'UZ' => 'Uzbekistan',
	'VU' => 'Vanuatu',
	'VE' => 'Venezuela',
	'VN' => 'Viet Nam',
	'VG' => 'Virgin Islands, British',
	'VI' => 'Virgin Islands, U.S.',
	'WF' => 'Wallis And Futuna',
	'EH' => 'Western Sahara',
	'YE' => 'Yemen',
	'ZM' => 'Zambia',
	'ZW' => 'Zimbabwe',
);

	foreach($countries as $code=>$country) {
		$select = "";
		if($selected == $code) { $select = 'selected="selected"'; }
		$option = '<option value="'.$code.'" '.$select.'>'.$country.'</option>';
		$options = $options.$option;
	}
	return $options;
}

function getMeta($key, $post_id) {
	$prefix = '_bid_';
	$meta_key = $prefix.$key;
	$meta_value = get_post_meta($post_id, $meta_key, true);
	return $meta_value;
}

add_action( 'wp_ajax_bid_it_now', 'bid_ajax_bid_it_now' );

function bid_ajax_bid_it_now() {
   echo 'working';
}

function update_all_bids_status() {
	global $wpdb;
	$tablename = $wpdb->prefix.'biddings';
	$bids = get_posts(array('post_type'=>'products','posts_per_page'=>-1));
	if(count($bids) > 0) {
		foreach($bids as $bid) {
			$date = date( 'm/d/Y g:i:s A', current_time( 'timestamp', 0 ) );
			$sd = date('m/d/Y g:i:s A',getMeta('startdate', $bid->ID));
			$ed = date('m/d/Y g:i:s A',getMeta('enddate', $bid->ID));
			$startdate = new DateTime($sd);
			$enddate = new DateTime($ed); 
			$todaydate = new DateTime($date); 	
			if(($enddate > $todaydate) && ($todaydate > $startdate)) { 
				update_post_meta($bid->ID,'_bid_status','running');
				$status = "running";
			}
			elseif($todaydate > $enddate) {
				update_post_meta($bid->ID,'_bid_status','closed');
				$status = "closed";
			}
			else {
				update_post_meta($bid->ID,'_bid_status','coming');
				$status = "coming";
			}
				$where = array('bid'=>$bid->ID);
				$data = array('status'=>$status);
				$wpdb->update( $tablename, $data, $where );
		}
	} 
}

update_all_bids_status();


function update_all_bids_users_status() {
	global $wpdb;
	$tablename = $wpdb->prefix.'biddings';
	$bids = $wpdb->get_results( "SELECT DISTINCT bid FROM ".$tablename." WHERE status='running'" );
	if(count($bids) > 0) {
		foreach($bids as $bid) {
			$where = array('bid' => $bid->bid);
			$data = array('status_of_user' => 'loser');
			$wpdb->update( $tablename, $data, $where );
			$check_unique_bids = $wpdb->get_results( "SELECT DISTINCT user_bid_amount AS count, id, ( SELECT COUNT( user_bid_amount ) FROM ".$tablename." WHERE user_bid_amount = count ) AS number_of FROM ".$tablename." WHERE bid = ".$bid->bid." and status_of_user_of_bid = 'active' GROUP BY count" );
			foreach($check_unique_bids as $cbid) {
				if($cbid->number_of == 1) {
					$where = array('id' => $cbid->id);
					$data = array('status_of_user' => 'unique');
					$wpdb->update( $tablename, $data, $where );
				}
				else{
					$where = array('id' => $cbid->id);
					$data = array('status_of_user' => 'loser');
					$wpdb->update( $tablename, $data, $where );
				}
			}
			$wid = "";
			$unique_bids = $wpdb->get_results( "SELECT * FROM ".$tablename." WHERE status_of_user='unique' and bid=".$bid->bid." ORDER BY user_bid_amount ASC " );	
			$wid = $unique_bids[0]->id;
			$where = array('id' => $wid);
			$data = array('status_of_user' => 'winner');
			$wpdb->update( $tablename, $data, $where );
			$least_bids = $wpdb->get_results( "SELECT * FROM ".$tablename." WHERE bid=".$bid->bid." ORDER BY user_bid_amount ASC " );	
			if($least_bids[0]->status_of_user != 'winner') {
				$lid = $least_bids[0]->id;
				$where = array('id' => $lid);
				$data = array('status_of_user' => 'least');
				$wpdb->update( $tablename, $data, $where );
			}
			$i=1;
			foreach($least_bids as $lbid) {
				if($lbid->status_of_user != 'winner' && $i>1) {
					if($lbid->user_bid_amount == $least_bids[0]->user_bid_amount) {
						$where = array('id' => $lbid->id);
						$data = array('status_of_user' => 'least');
						$wpdb->update( $tablename, $data, $where );
					}
				}
				$i++;
			}
			$inactive_bids = $wpdb->get_results( "SELECT * FROM ".$tablename." WHERE bid=".$bid->bid." and status_of_user!='winner' ORDER BY user_bid_amount ASC " );
			if(count($inactive_bids) > 0) {
				foreach($inactive_bids as $inbid) {
					$where = array('id' => $inbid->id, );
					$data = array('status_of_user_of_bid' => 'inactive');
					$wpdb->update( $tablename, $data, $where );	
				}
			}
		}
		
	} 
}

update_all_bids_users_status();


function get_user_running_bids(){
	global $wpdb;
	$tablename = $wpdb->prefix.'biddings';
	if( is_user_logged_in() ) {
		$user_id = get_current_user_id();
		$bids = $wpdb->get_results( "SELECT DISTINCT bid, id FROM ".$tablename." WHERE uid=".$user_id." and status='running' ORDER BY id DESC " );
		return $bids;
	}
}

function get_user_bid_status($bid_id,$user_id) {
	global $wpdb;
	$tablename = $wpdb->prefix.'biddings';
	if( is_user_logged_in() ) {
		$bid = $wpdb->get_row( "SELECT * FROM ".$tablename." WHERE uid=".$user_id." and id=".$bid_id." and status='running'" );	
		return $bid->status_of_user;
	}
}

function get_user_status_message($status,$bid) {
	if($status) {
		switch($status) {
			case 'loser':
			$status_message = 'Sorry! your price is not unique and least but time keep running. <a href="'.get_permalink($bid).'">Click here</a> to bid it again';
			break;
			case 'least':
			$status_message = 'Your price is least but not unique. Time keep running. <a href="'.get_permalink($bid).'">Click here</a> to bid it again';
			break;
			case 'unique':
			$status_message = 'Your price is unique but not least. Time keep running. <a href="'.get_permalink($bid).'">Click here</a> to bid it again';
			break;
			case 'winner':
			$status_message = 'Congrats! your price is unique and least. Time keep running.';
			break;
		}
		return $status_message;
	}
}

function show_user_bids_status() {
if( is_user_logged_in() ) {
	update_all_bids_users_status();
	$output = '';
	$user_running_bids = get_user_running_bids();
	
	
	if(count($user_running_bids) > 0) {
		foreach($user_running_bids as $bid) {
			$user_bid_status = get_user_bid_status($bid->id,get_current_user_id());
			$status_message = get_user_status_message($user_bid_status,$bid->bid);
			$bid_id = $bid->bid;
			switch($user_bid_status) {
				case 'winner':
				$status_class = 'success';
				break;
				case 'loser':
				$status_class = 'error';
				break;
				default:
				$status_class = 'info';
				break;
			} 
			$output = $output.'<div class="alert-'.$status_class.'">
				<h2>'.get_the_title($bid_id).'</h2>
				<p>'.$status_message.'</p>
			</div>';
			}
		}
		
	return $output;
	
	}
}


add_action( 'wp_ajax_load_user_bid_status', 'load_user_bid_status' );
add_action( 'wp_ajax_nopriv_load_user_bid_status', 'load_user_bid_status' );

function load_user_bid_status() {
	echo json_encode(array('html'=> show_user_bids_status()));
	die();
}

function convert_credits_to_money($num_credits) {
	$credit_value = ThemeOptions('credit_value');
	if(!empty($num_credits)) {
		return $num_credits*$credit_value;
	}
	
}

function get_page_id($template){
	global $wpdb;
	$permalink = "";
	$post_meta = $wpdb->prefix . "postmeta"; 
	$result = $wpdb->get_row("SELECT * from $post_meta WHERE meta_key = '_wp_page_template' and meta_value = '$template'");
	$post_id = $result->post_id;
	return $post_id;
}

function get_url($template){
	$post_id = get_page_id($template);
	return get_permalink($post_id);
}

?>