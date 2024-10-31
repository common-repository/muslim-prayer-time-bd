<?php
/*
Plugin Name: Muslim Prayer Time BD
Plugin URI: http://wordpress.org/plugins/muslim-prayer-time-bd/
Description: Muslim Prayer Time BD plugin provides the ability to display prayer (salah) times for Muslims with pretty widget.
Author: Realwebcare
Author URI: https://www.realwebcare.com/
Version: 2.4
Text Domain: mptb
*/

/*  Copyright 2021 Realwebcare (email: realwebcare@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if(is_admin()) {
	include 'admin-settings.php';
}
/**
 * Internationalization
 */
function mptb_textdomain() {
	$domain = 'mptb';
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
	load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
	load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'mptb_textdomain' );
/**
 * Plugin action links
 */
function mptb_plugin_actions( $links ) {
	$links[] = '<a href="'.menu_page_url('muslim-prayer-time-bd/admin-settings.php', false).'">'. __('Settings','mptb') .'</a>';
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'mptb_plugin_actions' );

function prayer_time_format($pr_time) {
	$pr_time= str_replace("0", "০", $pr_time);
	$pr_time= str_replace("1", "১", $pr_time);
	$pr_time= str_replace("2", "২", $pr_time);
	$pr_time= str_replace("3", "৩", $pr_time);
	$pr_time= str_replace("4", "৪", $pr_time);
	$pr_time= str_replace("5", "৫", $pr_time);
	$pr_time= str_replace("6", "৬", $pr_time);
	$pr_time= str_replace("7", "৭", $pr_time);
	$pr_time= str_replace("8", "৮", $pr_time);
	$pr_time= str_replace("9", "৯", $pr_time);
	$pr_time= str_replace("AM", "পূর্বাহ্ণ", $pr_time);
	$pr_time= str_replace("PM", "অপরাহ্ণ", $pr_time);
	return $pr_time;
}
function district_lists(){
	$prayer_ln = get_option('prayer_ln') != '' ? get_option('prayer_ln') : 'bn';
	if($prayer_ln == 'bn') {
		$district_lists = array( '15' => 'কক্সবাজার', '7' => 'কুমিল্লা', '1' => 'কিশোরগঞ্জ', '40' => 'কুষ্টিয়া', '30' => 'কুড়িগ্রাম', '16' => 'খাগড়াছড়ি', '34' => 'খুলনা', '35' => 'গাইবান্ধা', '57' => 'গাজীপুর', '23' => 'গোপালগঞ্জ', '13' => 'চট্টগ্রাম', '2' => 'চাঁদপুর', '55' => 'চাঁপাইনবাবগঞ্জ', '46' => 'চুয়াডাঙ্গা', '24' => 'জামালপুর', '47' => 'জয়পুরহাট', '41' => 'ঝিনাইদহ', '20' => 'ঝালকাঠি', '25' => 'টাঙ্গাইল', '56' => 'ঠাকুরগাঁও', '58' => 'ঢাকা', '51' => 'দিনাজপুর', '48' => 'নওগাঁ', '49' => 'নাটোর', '3' => 'নেত্রকোনা', '4' => 'নরসিংদী', '59' => 'নারায়ণগঞ্জ', '50' => 'নীলফামারী', '8' => 'নোয়াখালী', '36' => 'নড়াইল', '60' => 'পটুয়াখালী', '52' => 'পঞ্চগড়', '42' => 'পাবনা', '26' => 'পিরোজপুর', '10' => 'ফেনী', '27' => 'ফরিদপুর', '31' => 'বাগেরহাট', '37' => 'বগুড়া', '18' => 'বান্দরবান', '21' => 'বরগুনা', '61' => 'বরিশাল', '9' => 'ব্রাহ্মণবাড়িয়া', '5' => 'ভোলা', '38' => 'মাগুরা', '22' => 'মাদারীপুর', '28' => 'মানিকগঞ্জ', '62' => 'মুন্সিগঞ্জ', '14' => 'মৌলভীবাজার', '63' => 'ময়মনসিংহ', '53' => 'মেহেরপুর', '43' => 'যশোর', '19' => 'রাঙামাটি', '33' => 'রাজবাড়ী', '54' => 'রাজশাহী', '44' => 'রংপুর', '39' => 'লালমনিরহাট', '6' => 'লক্ষ্মীপুর', '29' => 'শেরপুর', '64' => 'শরিয়তপুর', '45' => 'সাতক্ষীরা', '11' => 'সুনামগঞ্জ', '32' => 'সিরাজগঞ্জ', '17' => 'সিলেট', '12' => 'হবিগঞ্জ' );
	} else {
		$district_lists = array( '31' => 'Bagerhat', '18' => 'Bandarban', '21' => 'Barguna', '61' => 'Barishal', '5' => 'Bhola', '37' => 'Bogura', '9' => 'Brahmanbaria', '2' => 'Chandpur', '55' => 'Chapainawabganj', '13' => 'Chattogram', '46' => 'Chuadanga', '15' => 'Cox\'s Bazar', '7' => 'Cumilla', '58' => 'Dhaka', '51' => 'Dinajpur', '27' => 'Faridpur', '10' => 'Feni', '35' => 'Gaibandha', '57' => 'Gazipur', '23' => 'Gopalganj', '12' => 'Habiganj', '24' => 'Jamalpur', '43' => 'Jashore', '20' => 'Jhalokati', '41' => 'Jhenaidah', '47' => 'Joypurhat', '16' => 'Khagrachhari', '34' => 'Khulna', '1' => 'Kishoreganj', '30' => 'Kurigram', '40' => 'Kushtia', '6' => 'Lakshmipur', '39' => 'Lalmonirhat', '22' => 'Madaripur', '38' => 'Magura', '28' => 'Manikganj', '53' => 'Meherpur', '14' => 'Moulvibazar', '62' => 'Munshiganj', '63' => 'Mymensingh', '48' => 'Naogaon', '36' => 'Narail', '59' => 'Narayanganj', '4' => 'Narsingdi', '49' => 'Natore', '3' => 'Netrokona', '50' => 'Nilphamari', '8' => 'Noakhali', '42' => 'Pabna', '52' => 'Panchagarh', '60' => 'Patuakhali', '26' => 'Pirojpur', '33' => 'Rajbari', '54' => 'Rajshahi', '19' => 'Rangamati', '44' => 'Rangpur', '45' => 'Satkhira', '64' => 'Shariatpur', '29' => 'Sherpur', '32' => 'Sirajgonj', '11' => 'Sunamganj', '17' => 'Sylhet', '25' => 'Tangail', '56' => 'Thakurgaon' );
	}
	return $district_lists;
}
function period_of_time(){
	$period_lists = array( 'fajr', 'duhr', 'asr', 'maghrib', 'isha', 'sunrise' );
	return $period_lists;
}
function prayer_district_time($prayer_name, $mod_time = '', $type = '') {
	$prayer_ln = get_option('prayer_ln') != '' ? get_option('prayer_ln') : 'bn';
	$time_format = get_option('time_fm') != '' ? get_option('time_fm') : '12';
	$time = strtotime($prayer_name);
	if($time_format == '12') {
		if(get_option('ampm_option') == 'Yes') {
			$prayer_time = date("g:i A", strtotime($mod_time, $time));
		} else {
			$prayer_time = date("g:i", strtotime($mod_time, $time));
		}
	} else {
		if(get_option('ampm_option') == 'Yes') {
			$prayer_time = date("G:i A", strtotime($mod_time, $time));
		} else {
			$prayer_time = date("G:i", strtotime($mod_time, $time));
		}
	}
	if($type == 'sehri') {
		$time = strtotime($prayer_time);
		$sehri_adjust = get_option('sehri_adjust') != '' ? get_option('sehri_adjust').' minutes' : '0 minutes';
		if($time_format == '12') {
			if(get_option('ampm_option') == 'Yes') {
				$prayer_time = date("g:i A", strtotime($sehri_adjust, $time));
			} else {
				$prayer_time = date("g:i", strtotime($sehri_adjust, $time));
			}
		} else {
			if(get_option('ampm_option') == 'Yes') {
				$prayer_time = date("G:i A", strtotime($sehri_adjust, $time));
			} else {
				$prayer_time = date("G:i", strtotime($sehri_adjust, $time));
			}
		}
	} else {
		$time = strtotime($prayer_time);
		$prayer_adjust = get_option('prayer_adjust') != '' ? get_option('prayer_adjust').' minutes' : '0 minutes';
		if($time_format == '12') {
			if(get_option('ampm_option') == 'Yes') {
				$prayer_time = date("g:i A", strtotime($prayer_adjust, $time));
			} else {
				$prayer_time = date("g:i", strtotime($prayer_adjust, $time));
			}
		} else {
			if(get_option('ampm_option') == 'Yes') {
				$prayer_time = date("G:i A", strtotime($prayer_adjust, $time));
			} else {
				$prayer_time = date("G:i", strtotime($prayer_adjust, $time));
			}
		}
	}
	if($prayer_ln == 'bn') {$prayer_time = prayer_time_format($prayer_time);}
	return $prayer_time;
}
function prayer_default_time($prayer_name, $mod_time = '') {
	$prayer_ln = get_option('prayer_ln') != '' ? get_option('prayer_ln') : 'bn';
	$time_format = get_option('time_fm') != '' ? get_option('time_fm') : '12';
	$time = strtotime($prayer_name);
	if($time_format == '12') {
		if(get_option('ampm_option') == 'Yes') {
			$prayer_time = date("g:i A", strtotime($mod_time, $time));
		} else {
			$prayer_time = date("g:i", strtotime($mod_time, $time));
		}
	} else {
		if(get_option('ampm_option') == 'Yes') {
			$prayer_time = date("G:i A", strtotime($mod_time, $time));
		} else {
			$prayer_time = date("G:i", strtotime($mod_time, $time));
		}
	}
	if($prayer_ln == 'bn') {$prayer_time = prayer_time_format($prayer_time);}
	return $prayer_time;
}
function mptb_admin_settings() {
	wp_register_script('mptbjs', plugins_url( 'js/mptb-admin.js', __FILE__ ), array('jquery'), '2.4');
	wp_enqueue_script('mptbjs');
	wp_enqueue_script('wp-color-picker');
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_style('mptbadmin', plugins_url( 'css/mptb-admin.css', __FILE__ ), '', '2.4');
}
add_action('admin_init', 'mptb_admin_settings');



/**
 * Return an ID of an attachment by searching the database with the file URL.
 *
 * First checks to see if the $url is pointing to a file that exists in
 * the wp-content directory. If so, then we search the database for a
 * partial match consisting of the remaining path AFTER the wp-content
 * directory. Finally, if a match is found the attachment ID will be
 * returned.
 *
 * @param string $url The URL of the image (ex: http://mysite.com/wp-content/uploads/2013/05/test-image.jpg)
 * 
 * @return int|null $attachment Returns an attachment ID, or null if no attachment is found
 */
function mptbd_get_attachment_id_by_url( $url ) {
	// Split the $url into two parts with the wp-content directory as the separator
	$parsed_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );

	// Get the host of the current site and the host of the $url, ignoring www
	$this_host = str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
	$file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );

	// Return nothing if there aren't any $url parts or if the current host and $url host do not match
	if ( ! isset( $parsed_url[1] ) || empty( $parsed_url[1] ) || ( $this_host != $file_host ) ) {
		return;
	}

	// Now we're going to quickly search the DB for any attachment GUID with a partial path match
	// Example: /uploads/2013/05/test-image.jpg
	$parsed_url[1] = preg_replace( '/-[0-9]{1,4}x[0-9]{1,4}\.(jpg|jpeg|png|gif|bmp)$/i', '.$1', $parsed_url[1] );
	global $wpdb;

	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $parsed_url[1] ) );

	// Returns null if no attachment is found
	return $attachment[0];
}

function mptb_enqueue_scripts(){
	wp_register_script('mptbjs', plugins_url( 'js/prayer-time.js', __FILE__ ), array('jquery'), '2.4', true);
	wp_enqueue_script('mptbjs');
	wp_enqueue_style('prayer-time', plugins_url( 'css/prayer-time.css', __FILE__ ), '', '2.4');
	wp_localize_script('mptbjs', 'mptbajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('wp_enqueue_scripts', 'mptb_enqueue_scripts');

function mptb_muslim_prayer_time($atts) {
	extract( shortcode_atts( array(
		'pt' => 'on',
		'sc' => 'on',
		'pid' => 'mptb-'.rand(99, 999)
	), $atts, 'prayer_time' ) );
	ob_start();
	$t4b = 0;
	$city_states = district_lists();
	$prayer_ln = get_option('prayer_ln') != '' ? get_option('prayer_ln') : 'bn';
	$mptb_city = get_option('default_city') != '' ? get_option('default_city') : 58;
	$city_id = isset($_POST['cityid']) ? $_POST['cityid'] : '';
	// $prayerID = isset($_POST['prid']) ? $_POST['prid'] : $id;
	$prayerID = $pid;
	$prtime = isset($_POST['prtime']) ? $_POST['prtime'] : $pt;
	$srcard = isset($_POST['srcard']) ? $_POST['srcard'] : $sc;
	$prayer_adjust = get_option('prayer_adjust') != '' ? get_option('prayer_adjust').' minutes' : '0 minutes';
	$prayer_names = get_option('pr_names') != '' ? get_option('pr_names') : 'ফজর, যোহর, আছর, মাগরিব, এশা, সূর্যোদয়';
	$prayer_names = explode(',', $prayer_names);
	$period_times = get_option('pr_times') != '' ? get_option('pr_times') : ', , , , ,';
	$period_times = explode(',', $period_times);
	$dist_bg = get_option('dist_bg') != '' ? get_option('dist_bg') : '#FAFAFA';
	$dist_font = get_option('dist_font') != '' ? get_option('dist_font') : '#666666';
	$mptbg_one = get_option('mptbg_one') != '' ? get_option('mptbg_one') : '#FAFAFA';
	$mptbg_two = get_option('mptbg_two') != '' ? get_option('mptbg_two') : '#DFDFDF';
	$pname_weight = get_option('pname_weight') != '' ? get_option('pname_weight') : 'bold';
	$ptime_weight = get_option('ptime_weight') != '' ? get_option('ptime_weight') : 'normal';
	$prayer_name = get_option('prayer_name') != '' ? get_option('prayer_name') : '#666666';
	$prayer_time = get_option('prayer_time') != '' ? get_option('prayer_time') : '#666666';
	$pname_align = get_option('pname_align') != '' ? get_option('pname_align') : 'center';
	$ptime_align = get_option('ptime_align') != '' ? get_option('ptime_align') : 'center';
	$sehri_adjust = get_option('sehri_adjust') != '' ? get_option('sehri_adjust').' minutes' : '0 minutes';
	$sehri_title = get_option('sehri_title') != '' ? get_option('sehri_title') : 'সেহরির শেষ সময় - ভোর';
	$iftar_title = get_option('iftar_title') != '' ? get_option('iftar_title') : 'ইফতার শুরু - সন্ধ্যা';
	$sehri_bg = get_option('sehri_bg') != '' ? get_option('sehri_bg') : '#DFDFDF';
	$iftar_bg = get_option('iftar_bg') != '' ? get_option('iftar_bg') : '#DFDFDF';
	$sehri_font = get_option('sehri_font') != '' ? get_option('sehri_font') : '#666666';
	$sehri_weight = get_option('sehri_weight') != '' ? get_option('sehri_weight') : 'normal';
	$sehri_align = get_option('sehri_align') != '' ? get_option('sehri_align') : 'center';
	$image_id = mptbd_get_attachment_id_by_url(get_option('prayer_image'));
	if ( wp_get_attachment_image($image_id) ) {
		$image_output = wp_get_attachment_image( $image_id, 'full', false, array('class' => 'attachment-medium size-medium rwcot-img-responsive') );
	} else {
		if(get_option('prayer_image') == '') {
			$image_output = '<img src="'.plugins_url( '/images/mosque-black.png', __FILE__ ).'" alt="pricing-table-image" />';
		} else {
			$image_output = '<img src="'.get_option('prayer_image').'" alt="prayer-image" />';
		}
	}
	$pr_names = period_of_time();
	$month = date('m');
	$day_number = date('j');
	$adjust_time = '';
	if($month == 1) {
		if($day_number < 5) {
			$time_schedule = array( 'sehri' => '5:19', 'fajr' => '5:24', 'sunrise' => '6:41', 'duhr' => '12:06', 'asr' => '15:46', 'maghrib' => '17:27', 'isha' => '18:45' );
		} elseif($day_number > 4 && $day_number < 10) {
			$time_schedule = array( 'sehri' => '5:21', 'fajr' => '5:26', 'sunrise' => '6:42', 'duhr' => '12:08', 'asr' => '15:49', 'maghrib' => '17:29', 'isha' => '18:48' );
		} elseif($day_number > 9 && $day_number < 15) {
			$time_schedule = array( 'sehri' => '5:22', 'fajr' => '5:27', 'sunrise' => '6:43', 'duhr' => '12:10', 'asr' => '15:53', 'maghrib' => '17:33', 'isha' => '18:51' );
		} elseif($day_number > 14 && $day_number < 20) {
			$time_schedule = array( 'sehri' => '5:23', 'fajr' => '5:28', 'sunrise' => '6:43', 'duhr' => '12:12', 'asr' => '15:56', 'maghrib' => '17:36', 'isha' => '18:53' );
		} elseif($day_number > 19 && $day_number < 25) {
			$time_schedule = array( 'sehri' => '5:23', 'fajr' => '5:28', 'sunrise' => '6:43', 'duhr' => '12:13', 'asr' => '16:00', 'maghrib' => '17:40', 'isha' => '18:56' );
		} else {
			$time_schedule = array( 'sehri' => '5:22', 'fajr' => '5:27', 'sunrise' => '6:41', 'duhr' => '12:14', 'asr' => '16:03', 'maghrib' => '17:43', 'isha' => '19:00' );
		}
	} elseif($month == 2) {
		if($day_number < 5) {
			$time_schedule = array( 'sehri' => '5:21', 'fajr' => '5:26', 'sunrise' => '6:39', 'duhr' => '12:16', 'asr' => '16:08', 'maghrib' => '17:48', 'isha' => '19:04' );
		} elseif($day_number > 4 && $day_number < 10) {
			$time_schedule = array( 'sehri' => '5:19', 'fajr' => '5:24', 'sunrise' => '6:37', 'duhr' => '12:16', 'asr' => '16:11', 'maghrib' => '17:51', 'isha' => '19:06' );
		} elseif($day_number > 9 && $day_number < 15) {
			$time_schedule = array( 'sehri' => '5:17', 'fajr' => '5:22', 'sunrise' => '6:34', 'duhr' => '12:16', 'asr' => '16:14', 'maghrib' => '17:54', 'isha' => '19:09' );
		} elseif($day_number > 14 && $day_number < 20) {
			$time_schedule = array( 'sehri' => '5:14', 'fajr' => '5:19', 'sunrise' => '6:31', 'duhr' => '12:16', 'asr' => '16:16', 'maghrib' => '17:57', 'isha' => '19:11' );
		} elseif($day_number > 19 && $day_number < 25) {
			$time_schedule = array( 'sehri' => '5:11', 'fajr' => '5:16', 'sunrise' => '6:28', 'duhr' => '12:16', 'asr' => '16:19', 'maghrib' => '18:00', 'isha' => '19:14' );
		} else {
			$time_schedule = array( 'sehri' => '5:07', 'fajr' => '5:12', 'sunrise' => '6:24', 'duhr' => '12:15', 'asr' => '16:21', 'maghrib' => '18:03', 'isha' => '19:17' );
		}
	} elseif($month == 3) {
		if($day_number < 5) {
			$time_schedule = array( 'sehri' => '5:04', 'fajr' => '5:09', 'sunrise' => '6:20', 'duhr' => '12:14', 'asr' => '16:22', 'maghrib' => '18:05', 'isha' => '19:18' );
		} elseif($day_number > 4 && $day_number < 10) {
			$time_schedule = array( 'sehri' => '5:01', 'fajr' => '5:06', 'sunrise' => '6:17', 'duhr' => '12:14', 'asr' => '16:24', 'maghrib' => '18:06', 'isha' => '19:19' );
		} elseif($day_number > 9 && $day_number < 15) {
			$time_schedule = array( 'sehri' => '4:56', 'fajr' => '5:01', 'sunrise' => '6:12', 'duhr' => '12:13', 'asr' => '16:25', 'maghrib' => '18:09', 'isha' => '19:22' );
		} elseif($day_number > 14 && $day_number < 20) {
			$time_schedule = array( 'sehri' => '4:51', 'fajr' => '4:56', 'sunrise' => '6:07', 'duhr' => '12:11', 'asr' => '16:26', 'maghrib' => '18:11', 'isha' => '19:24' );
		} elseif($day_number > 19 && $day_number < 25) {
			$time_schedule = array( 'sehri' => '4:46', 'fajr' => '4:51', 'sunrise' => '6:03', 'duhr' => '12:10', 'asr' => '16:27', 'maghrib' => '18:13', 'isha' => '19:26' );
		} else {
			$time_schedule = array( 'sehri' => '4:41', 'fajr' => '4:46', 'sunrise' => '5:57', 'duhr' => '12:08', 'asr' => '16:28', 'maghrib' => '18:15', 'isha' => '19:28' );
		}
	} elseif($month == 4) {
		if($day_number < 5) {
			$time_schedule = array( 'sehri' => '4:32', 'fajr' => '4:37', 'sunrise' => '5:50', 'duhr' => '12:06', 'asr' => '16:29', 'maghrib' => '18:18', 'isha' => '19:33' );
		} elseif($day_number > 4 && $day_number < 10) {
			$time_schedule = array( 'sehri' => '4:27', 'fajr' => '4:32', 'sunrise' => '5:46', 'duhr' => '12:05', 'asr' => '16:29', 'maghrib' => '18:20', 'isha' => '19:35' );
		} elseif($day_number > 9 && $day_number < 15) {
			$time_schedule = array( 'sehri' => '4:23', 'fajr' => '4:28', 'sunrise' => '5:41', 'duhr' => '12:03', 'asr' => '16:30', 'maghrib' => '18:22', 'isha' => '19:37' );
		} elseif($day_number > 14 && $day_number < 20) {
			$time_schedule = array( 'sehri' => '4:17', 'fajr' => '4:22', 'sunrise' => '5:37', 'duhr' => '12:02', 'asr' => '16:30', 'maghrib' => '18:24', 'isha' => '19:40' );
		} elseif($day_number > 19 && $day_number < 25) {
			$time_schedule = array( 'sehri' => '4:12', 'fajr' => '4:17', 'sunrise' => '5:33', 'duhr' => '12:01', 'asr' => '16:30', 'maghrib' => '18:26', 'isha' => '19:43' );
		} else {
			$time_schedule = array( 'sehri' => '4:08', 'fajr' => '4:13', 'sunrise' => '5:28', 'duhr' => '12:00', 'asr' => '16:31', 'maghrib' => '18:28', 'isha' => '19:47' );
		}
	} elseif($month == 5) {
		if($day_number < 5) {
			$time_schedule = array( 'sehri' => '4:02', 'fajr' => '4:07', 'sunrise' => '5:24', 'duhr' => '11:59', 'asr' => '16:31', 'maghrib' => '18:31', 'isha' => '19:50' );
		} elseif($day_number > 4 && $day_number < 10) {
			$time_schedule = array( 'sehri' => '3:57', 'fajr' => '4:02', 'sunrise' => '5:21', 'duhr' => '11:59', 'asr' => '16:31', 'maghrib' => '18:33', 'isha' => '19:53' );
		} elseif($day_number > 9 && $day_number < 15) {
			$time_schedule = array( 'sehri' => '3:53', 'fajr' => '3:58', 'sunrise' => '5:18', 'duhr' => '11:58', 'asr' => '16:32', 'maghrib' => '18:35', 'isha' => '19:57' );
		} elseif($day_number > 14 && $day_number < 20) {
			$time_schedule = array( 'sehri' => '3:50', 'fajr' => '3:55', 'sunrise' => '5:16', 'duhr' => '11:58', 'asr' => '16:32', 'maghrib' => '18:37', 'isha' => '20:00' );
		} elseif($day_number > 19 && $day_number < 25) {
			$time_schedule = array( 'sehri' => '3:47', 'fajr' => '3:52', 'sunrise' => '5:13', 'duhr' => '11:58', 'asr' => '16:33', 'maghrib' => '18:40', 'isha' => '20:03' );
		} else {
			$time_schedule = array( 'sehri' => '3:45', 'fajr' => '3:50', 'sunrise' => '5:12', 'duhr' => '11:59', 'asr' => '16:34', 'maghrib' => '18:42', 'isha' => '20:06' );
		}
	} elseif($month == 6) {
		if($day_number < 5) {
			$time_schedule = array( 'sehri' => '3:42', 'fajr' => '3:47', 'sunrise' => '5:10', 'duhr' => '12:00', 'asr' => '16:35', 'maghrib' => '18:46', 'isha' => '20:11' );
		} elseif($day_number > 4 && $day_number < 10) {
			$time_schedule = array( 'sehri' => '3:42', 'fajr' => '3:47', 'sunrise' => '5:10', 'duhr' => '12:00', 'asr' => '16:36', 'maghrib' => '18:47', 'isha' => '20:12' );
		} elseif($day_number > 9 && $day_number < 15) {
			$time_schedule = array( 'sehri' => '3:41', 'fajr' => '3:46', 'sunrise' => '5:10', 'duhr' => '12:01', 'asr' => '16:37', 'maghrib' => '18:49', 'isha' => '20:15' );
		} elseif($day_number > 14 && $day_number < 20) {
			$time_schedule = array( 'sehri' => '3:41', 'fajr' => '3:46', 'sunrise' => '5:10', 'duhr' => '12:02', 'asr' => '16:38', 'maghrib' => '18:51', 'isha' => '20:17' );
		} elseif($day_number > 19 && $day_number < 25) {
			$time_schedule = array( 'sehri' => '3:41', 'fajr' => '3:46', 'sunrise' => '5:11', 'duhr' => '12:03', 'asr' => '16:40', 'maghrib' => '18:52', 'isha' => '20:18' );
		} else {
			$time_schedule = array( 'sehri' => '3:42', 'fajr' => '3:47', 'sunrise' => '5:12', 'duhr' => '12:04', 'asr' => '16:41', 'maghrib' => '18:53', 'isha' => '20:20' );
		}
	} elseif($month == 7) {
		if($day_number < 5) {
			$time_schedule = array( 'sehri' => '3:45', 'fajr' => '3:50', 'sunrise' => '5:14', 'duhr' => '12:06', 'asr' => '16:42', 'maghrib' => '18:54', 'isha' => '20:20' );
		} elseif($day_number > 4 && $day_number < 10) {
			$time_schedule = array( 'sehri' => '3:47', 'fajr' => '3:52', 'sunrise' => '5:15', 'duhr' => '12:07', 'asr' => '16:42', 'maghrib' => '18:54', 'isha' => '20:20' );
		} elseif($day_number > 9 && $day_number < 15) {
			$time_schedule = array( 'sehri' => '3:49', 'fajr' => '3:54', 'sunrise' => '5:18', 'duhr' => '12:07', 'asr' => '16:43', 'maghrib' => '18:53', 'isha' => '20:18' );
		} elseif($day_number > 14 && $day_number < 20) {
			$time_schedule = array( 'sehri' => '3:52', 'fajr' => '3:57', 'sunrise' => '5:19', 'duhr' => '12:08', 'asr' => '16:43', 'maghrib' => '18:53', 'isha' => '20:17' );
		} elseif($day_number > 19 && $day_number < 25) {
			$time_schedule = array( 'sehri' => '3:55', 'fajr' => '4:00', 'sunrise' => '5:22', 'duhr' => '12:08', 'asr' => '16:43', 'maghrib' => '18:51', 'isha' => '20:14' );
		} else {
			$time_schedule = array( 'sehri' => '3:59', 'fajr' => '4:04', 'sunrise' => '5:24', 'duhr' => '12:08', 'asr' => '16:43', 'maghrib' => '18:49', 'isha' => '20:11' );
		}
	} elseif($month == 8) {
		if($day_number < 5) {
			$time_schedule = array( 'sehri' => '4:03', 'fajr' => '4:08', 'sunrise' => '5:27', 'duhr' => '12:08', 'asr' => '16:42', 'maghrib' => '18:45', 'isha' => '20:05' );
		} elseif($day_number > 4 && $day_number < 10) {
			$time_schedule = array( 'sehri' => '4:06', 'fajr' => '4:11', 'sunrise' => '5:29', 'duhr' => '12:08', 'asr' => '16:41', 'maghrib' => '18:42', 'isha' => '20:02' );
		} elseif($day_number > 9 && $day_number < 15) {
			$time_schedule = array( 'sehri' => '4:09', 'fajr' => '4:14', 'sunrise' => '5:31', 'duhr' => '12:07', 'asr' => '16:40', 'maghrib' => '18:39', 'isha' => '19:58' );
		} elseif($day_number > 14 && $day_number < 20) {
			$time_schedule = array( 'sehri' => '4:12', 'fajr' => '4:17', 'sunrise' => '5:33', 'duhr' => '12:06', 'asr' => '16:38', 'maghrib' => '18:35', 'isha' => '19:53' );
		} elseif($day_number > 19 && $day_number < 25) {
			$time_schedule = array( 'sehri' => '4:15', 'fajr' => '4:20', 'sunrise' => '5:35', 'duhr' => '12:05', 'asr' => '16:36', 'maghrib' => '18:31', 'isha' => '19:48' );
		} else {
			$time_schedule = array( 'sehri' => '4:18', 'fajr' => '4:23', 'sunrise' => '5:37', 'duhr' => '12:04', 'asr' => '16:33', 'maghrib' => '18:27', 'isha' => '19:43' );
		}
	} elseif($month == 9) {
		if($day_number < 5) {
			$time_schedule = array( 'sehri' => '4:21', 'fajr' => '4:26', 'sunrise' => '5:39', 'duhr' => '12:02', 'asr' => '16:29', 'maghrib' => '18:20', 'isha' => '19:35' );
		} elseif($day_number > 4 && $day_number < 10) {
			$time_schedule = array( 'sehri' => '4:23', 'fajr' => '4:28', 'sunrise' => '5:41', 'duhr' => '12:00', 'asr' => '16:26', 'maghrib' => '18:16', 'isha' => '19:31' );
		} elseif($day_number > 9 && $day_number < 15) {
			$time_schedule = array( 'sehri' => '4:25', 'fajr' => '4:30', 'sunrise' => '5:42', 'duhr' => '11:59', 'asr' => '16:23', 'maghrib' => '18:11', 'isha' => '19:25' );
		} elseif($day_number > 14 && $day_number < 20) {
			$time_schedule = array( 'sehri' => '4:27', 'fajr' => '4:32', 'sunrise' => '5:44', 'duhr' => '11:57', 'asr' => '16:19', 'maghrib' => '18:06', 'isha' => '19:20' );
		} elseif($day_number > 19 && $day_number < 25) {
			$time_schedule = array( 'sehri' => '4:30', 'fajr' => '4:35', 'sunrise' => '5:46', 'duhr' => '11:55', 'asr' => '16:15', 'maghrib' => '18:00', 'isha' => '19:14' );
		} else {
			$time_schedule = array( 'sehri' => '4:31', 'fajr' => '4:36', 'sunrise' => '5:47', 'duhr' => '11:53', 'asr' => '16:11', 'maghrib' => '17:56', 'isha' => '19:09' );
		}
	} elseif($month == 10) {
		if($day_number < 5) {
			$time_schedule = array( 'sehri' => '4:34', 'fajr' => '4:39', 'sunrise' => '5:49', 'duhr' => '11:51', 'asr' => '16:06', 'maghrib' => '17:49', 'isha' => '19:02' );
		} elseif($day_number > 4 && $day_number < 10) {
			$time_schedule = array( 'sehri' => '4:35', 'fajr' => '4:40', 'sunrise' => '5:51', 'duhr' => '11:50', 'asr' => '16:03', 'maghrib' => '17:45', 'isha' => '18:58' );
		} elseif($day_number > 9 && $day_number < 15) {
			$time_schedule = array( 'sehri' => '4:42', 'fajr' => '4:42', 'sunrise' => '5:53', 'duhr' => '11:49', 'asr' => '15:59', 'maghrib' => '17:41', 'isha' => '18:54' );
		} elseif($day_number > 14 && $day_number < 20) {
			$time_schedule = array( 'sehri' => '4:39', 'fajr' => '4:44', 'sunrise' => '5:56', 'duhr' => '11:48', 'asr' => '15:55', 'maghrib' => '17:36', 'isha' => '18:50' );
		} elseif($day_number > 19 && $day_number < 25) {
			$time_schedule = array( 'sehri' => '4:41', 'fajr' => '4:46', 'sunrise' => '5:58', 'duhr' => '11:47', 'asr' => '15:51', 'maghrib' => '17:32', 'isha' => '18:46' );
		} else {
			$time_schedule = array( 'sehri' => '4:43', 'fajr' => '4:48', 'sunrise' => '6:00', 'duhr' => '11:46', 'asr' => '15:48', 'maghrib' => '17:28', 'isha' => '18:42' );
		}
	} elseif($month == 11) {
		if($day_number < 5) {
			$time_schedule = array( 'sehri' => '4:46', 'fajr' => '4:51', 'sunrise' => '6:04', 'duhr' => '11:45', 'asr' => '15:43', 'maghrib' => '17:23', 'isha' => '18:38' );
		} elseif($day_number > 4 && $day_number < 10) {
			$time_schedule = array( 'sehri' => '4:48', 'fajr' => '4:53', 'sunrise' => '6:06', 'duhr' => '11:45', 'asr' => '15:41', 'maghrib' => '17:21', 'isha' => '18:36' );
		} elseif($day_number > 9 && $day_number < 15) {
			$time_schedule = array( 'sehri' => '4:51', 'fajr' => '4:56', 'sunrise' => '6:10', 'duhr' => '11:46', 'asr' => '15:39', 'maghrib' => '17:18', 'isha' => '18:34' );
		} elseif($day_number > 14 && $day_number < 20) {
			$time_schedule = array( 'sehri' => '4:54', 'fajr' => '4:59', 'sunrise' => '6:13', 'duhr' => '11:47', 'asr' => '15:37', 'maghrib' => '17:16', 'isha' => '18:32' );
		} elseif($day_number > 19 && $day_number < 25) {
			$time_schedule = array( 'sehri' => '4:57', 'fajr' => '5:02', 'sunrise' => '6:16', 'duhr' => '11:47', 'asr' => '15:36', 'maghrib' => '17:15', 'isha' => '18:31' );
		} else {
			$time_schedule = array( 'sehri' => '5:00', 'fajr' => '5:05', 'sunrise' => '6:20', 'duhr' => '11:49', 'asr' => '15:35', 'maghrib' => '17:14', 'isha' => '18:31' );
		}
	} else {
		if($day_number < 5) {
			$time_schedule = array( 'sehri' => '5:03', 'fajr' => '5:10', 'sunrise' => '6:24', 'duhr' => '11:51', 'asr' => '15:35', 'maghrib' => '17:14', 'isha' => '18:32' );
		} elseif($day_number > 4 && $day_number < 10) {
			$time_schedule = array( 'sehri' => '5:06', 'fajr' => '5:10', 'sunrise' => '6:27', 'duhr' => '11:53', 'asr' => '15:35', 'maghrib' => '17:14', 'isha' => '18:33' );
		} elseif($day_number > 9 && $day_number < 15) {
			$time_schedule = array( 'sehri' => '5:09', 'fajr' => '5:10', 'sunrise' => '6:30', 'duhr' => '11:55', 'asr' => '15:36', 'maghrib' => '17:15', 'isha' => '18:34' );
		} elseif($day_number > 14 && $day_number < 20) {
			$time_schedule = array( 'sehri' => '5:12', 'fajr' => '5:10', 'sunrise' => '6:33', 'duhr' => '11:57', 'asr' => '15:38', 'maghrib' => '17:17', 'isha' => '18:36' );
		} elseif($day_number > 19 && $day_number < 25) {
			$time_schedule = array( 'sehri' => '5:14', 'fajr' => '5:11', 'sunrise' => '6:36', 'duhr' => '11:59', 'asr' => '15:40', 'maghrib' => '17:19', 'isha' => '18:38' );
		} else {
			$time_schedule = array( 'sehri' => '5:17', 'fajr' => '5:12', 'sunrise' => '6:38', 'duhr' => '12:02', 'asr' => '15:42', 'maghrib' => '17:22', 'isha' => '18:41' );
		}
	}

	if( $mptb_city > 0 && $mptb_city < 6 ) {$adjust_time = '-1 minutes';}
	elseif( $mptb_city == 6 ) {$adjust_time = '-2 minutes';}
	elseif( $mptb_city > 6 && $mptb_city < 10 ) { $adjust_time = '-3 minutes'; }
	elseif( $mptb_city > 9 && $mptb_city < 13 ) { $adjust_time = '-4 minutes'; }
	elseif( $mptb_city > 12 && $mptb_city < 15 ) { $adjust_time = '-5 minutes'; }
	elseif( $mptb_city > 14 && $mptb_city < 18 ) { $adjust_time = '-6 minutes'; }
	elseif( $mptb_city > 17 && $mptb_city < 20 ) { $adjust_time = '-7 minutes'; }
	elseif( $mptb_city > 19 && $mptb_city < 23 ) { $adjust_time = '+1 minutes'; }
	elseif( $mptb_city > 22 && $mptb_city < 30 ) { $adjust_time = '+2 minutes'; }
	elseif( $mptb_city > 29 && $mptb_city < 34 ) { $adjust_time = '+3 minutes'; }
	elseif( $mptb_city > 33 && $mptb_city < 40 ) { $adjust_time = '+4 minutes'; }
	elseif( $mptb_city > 39 && $mptb_city < 46 ) { $adjust_time = '+5 minutes'; }
	elseif( $mptb_city > 45 && $mptb_city < 51 ) { $adjust_time = '+6 minutes'; }
	elseif( $mptb_city > 50 && $mptb_city < 55 ) { $adjust_time = '+7 minutes'; }
	elseif( $mptb_city > 54 && $mptb_city < 57 ) { $adjust_time = '+8 minutes'; }
	else { $adjust_time = ''; } ?>
    <!-- <div id="prayertime" class="muslim_prayer_time"> -->
    <div id="<?php echo $prayerID; ?>" class="muslim_prayer_time">
        <style type="text/css" media="all">
            .muslim_prayer_time .color, .muslim_prayer_time .city_selection select option {background-color: <?php echo $dist_bg; ?>}
            .muslim_prayer_time .color select {color: <?php echo $dist_font; ?>}
            .muslim_prayer_time .prayer_name ul li.time_table {background-color: <?php echo $mptbg_one; ?>;color: <?php echo $prayer_name; ?>;font-weight: <?php echo $pname_weight; ?>;text-align: <?php echo $pname_align; ?>}
            .muslim_prayer_time .prayer_time ul li.time_table {background-color: <?php echo $mptbg_two; ?>;color: <?php echo $prayer_time; ?>;font-weight: <?php echo $ptime_weight; ?>;text-align: <?php echo $ptime_align; ?>}
            .muslim_prayer_time .sehri_time,
            .muslim_prayer_time .iftar_time {background: <?php echo $sehri_bg; ?>;color: <?php echo $sehri_font; ?>;font-weight: <?php echo $sehri_weight; ?>;text-align: <?php echo $sehri_align; ?>}
            .muslim_prayer_time .iftar_time {background: <?php echo $iftar_bg; ?>;}
        </style><?php
		if(get_option('mptb_image') == 'Enabled') {
			echo $image_output;
		} ?>
		<?php if(get_option('mptb_image') == 'Enabled') { ?>
		<div class="mptbd_timetable">
		<?php } ?>
			<div class="city_selection color semi-square">
				<form id="city_time" action="" method="post" name="city_time">
					<select id="cityname" name="cityname" onChange="prayerOnChange('<?php echo $prayerID; ?>', '<?php echo $prtime; ?>', '<?php echo $srcard; ?>', this.options[this.selectedIndex].value);">
						<option value=""><?php if($city_id != '') { echo $city_states[$city_id]; } else { echo $city_states[$mptb_city]; } ?></option>
						<?php
						foreach($city_states as $key => $city) { ?>
							<option value="<?php echo $key; ?>"<?php if($key == $city_id) { ?> selected<?php } ?>><?php echo $city; ?></option><?php
						} ?>
					</select>
				</form>
			</div>
			<div id="prayer-element"><?php
				if(get_option('mptb_option') == 'Enabled' && $srcard == 'on') { ?>
					<div class="sehri_time"><?php
						if($city_id != '') {
							if( $_POST['cityid'] > 0 && $_POST['cityid'] < 6 ) {
								echo $sehri_title . ' ' .  prayer_district_time($time_schedule['sehri'], '-1 minutes', 'sehri');
							} elseif( $_POST['cityid'] == 6 ) {
								echo $sehri_title . ' ' .  prayer_district_time($time_schedule['sehri'], '-2 minutes', 'sehri');
							} elseif( $_POST['cityid'] > 6 && $_POST['cityid'] < 10 ) {
								echo $sehri_title . ' ' .  prayer_district_time($time_schedule['sehri'], '-3 minutes', 'sehri');
							} elseif( $_POST['cityid'] > 9 && $_POST['cityid'] < 13 ) {
								echo $sehri_title . ' ' .  prayer_district_time($time_schedule['sehri'], '-4 minutes', 'sehri');
							} elseif( $_POST['cityid'] > 12 && $_POST['cityid'] < 15 ) {
								echo $sehri_title . ' ' .  prayer_district_time($time_schedule['sehri'], '-5 minutes', 'sehri');
							} elseif( $_POST['cityid'] > 14 && $_POST['cityid'] < 18 ) {
								echo $sehri_title . ' ' .  prayer_district_time($time_schedule['sehri'], '-6 minutes', 'sehri');
							} elseif( $_POST['cityid'] > 17 && $_POST['cityid'] < 20 ) {
								echo $sehri_title . ' ' .  prayer_district_time($time_schedule['sehri'], '-7 minutes', 'sehri');
							} elseif( $_POST['cityid'] > 19 && $_POST['cityid'] < 23 ) {
								echo $sehri_title . ' ' .  prayer_district_time($time_schedule['sehri'], '+1 minutes', 'sehri');
							} elseif( $_POST['cityid'] > 22 && $_POST['cityid'] < 30 ) {
								echo $sehri_title . ' ' .  prayer_district_time($time_schedule['sehri'], '+2 minutes', 'sehri');
							} elseif( $_POST['cityid'] > 29 && $_POST['cityid'] < 34 ) {
								echo $sehri_title . ' ' .  prayer_district_time($time_schedule['sehri'], '+3 minutes', 'sehri');
							} elseif( $_POST['cityid'] > 33 && $_POST['cityid'] < 40 ) {
								echo $sehri_title . ' ' .  prayer_district_time($time_schedule['sehri'], '+4 minutes', 'sehri');
							} elseif( $_POST['cityid'] > 39 && $_POST['cityid'] < 46 ) {
								echo $sehri_title . ' ' .  prayer_district_time($time_schedule['sehri'], '+5 minutes', 'sehri');
							} elseif( $_POST['cityid'] > 45 && $_POST['cityid'] < 51 ) {
								echo $sehri_title . ' ' .  prayer_district_time($time_schedule['sehri'], '+6 minutes', 'sehri');
							} elseif( $_POST['cityid'] > 50 && $_POST['cityid'] < 55 ) {
								echo $sehri_title . ' ' .  prayer_district_time($time_schedule['sehri'], '+7 minutes', 'sehri');
							} elseif( $_POST['cityid'] > 54 && $_POST['cityid'] < 57 ) {
								echo $sehri_title . ' ' .  prayer_district_time($time_schedule['sehri'], '+8 minutes', 'sehri');
							} else {
								echo $sehri_title . ' ' .  prayer_default_time($time_schedule['sehri'], $sehri_adjust);
							}
						} else {
							if($adjust_time != ''){
								echo $sehri_title . ' ' .  prayer_district_time($time_schedule['sehri'], $adjust_time, 'sehri');
							} else {
								echo $sehri_title . ' ' .  prayer_default_time($time_schedule['sehri'], $sehri_adjust);
							}
						} ?>
					</div>
					<div class="iftar_time"><?php
						if($city_id != '') {
							if( $_POST['cityid'] > 0 && $_POST['cityid'] < 6 ) {
								echo $iftar_title . ' ' .  prayer_district_time($time_schedule['maghrib'], '-1 minutes');
							} elseif( $_POST['cityid'] == 6 ) {
								echo $iftar_title . ' ' .  prayer_district_time($time_schedule['maghrib'], '-2 minutes');
							} elseif( $_POST['cityid'] > 6 && $_POST['cityid'] < 10 ) {
								echo $iftar_title . ' ' .  prayer_district_time($time_schedule['maghrib'], '-3 minutes');
							} elseif( $_POST['cityid'] > 9 && $_POST['cityid'] < 13 ) {
								echo $iftar_title . ' ' .  prayer_district_time($time_schedule['maghrib'], '-4 minutes');
							} elseif( $_POST['cityid'] > 12 && $_POST['cityid'] < 15 ) {
								echo $iftar_title . ' ' .  prayer_district_time($time_schedule['maghrib'], '-5 minutes');
							} elseif( $_POST['cityid'] > 14 && $_POST['cityid'] < 18 ) {
								echo $iftar_title . ' ' .  prayer_district_time($time_schedule['maghrib'], '-6 minutes');
							} elseif( $_POST['cityid'] > 17 && $_POST['cityid'] < 20 ) {
								echo $iftar_title . ' ' .  prayer_district_time($time_schedule['maghrib'], '-7 minutes');
							} elseif( $_POST['cityid'] > 19 && $_POST['cityid'] < 23 ) {
								echo $iftar_title . ' ' .  prayer_district_time($time_schedule['maghrib'], '+1 minutes');
							} elseif( $_POST['cityid'] > 22 && $_POST['cityid'] < 30 ) {
								echo $iftar_title . ' ' .  prayer_district_time($time_schedule['maghrib'], '+2 minutes');
							} elseif( $_POST['cityid'] > 29 && $_POST['cityid'] < 34 ) {
								echo $iftar_title . ' ' .  prayer_district_time($time_schedule['maghrib'], '+3 minutes');
							} elseif( $_POST['cityid'] > 33 && $_POST['cityid'] < 40 ) {
								echo $iftar_title . ' ' .  prayer_district_time($time_schedule['maghrib'], '+4 minutes');
							} elseif( $_POST['cityid'] > 39 && $_POST['cityid'] < 46 ) {
								echo $iftar_title . ' ' .  prayer_district_time($time_schedule['maghrib'], '+5 minutes');
							} elseif( $_POST['cityid'] > 45 && $_POST['cityid'] < 51 ) {
								echo $iftar_title . ' ' .  prayer_district_time($time_schedule['maghrib'], '+6 minutes');
							} elseif( $_POST['cityid'] > 50 && $_POST['cityid'] < 55 ) {
								echo $iftar_title . ' ' .  prayer_district_time($time_schedule['maghrib'], '+7 minutes');
							} elseif( $_POST['cityid'] > 54 && $_POST['cityid'] < 57 ) {
								echo $iftar_title . ' ' .  prayer_district_time($time_schedule['maghrib'], '+8 minutes');
							} else {
								echo $iftar_title . ' ' .  prayer_default_time($time_schedule['maghrib'], $prayer_adjust);
							}
						} else {
							if($adjust_time != ''){
								echo $iftar_title . ' ' .  prayer_district_time($time_schedule['maghrib'], $adjust_time);
							} else {
								echo $iftar_title . ' ' .  prayer_default_time($time_schedule['maghrib'], $prayer_adjust);
							}
						} ?>
					</div><?php
				}
				if($prtime == 'on') { ?>
				<div class="prayer_name">
					<ul><?php
						foreach($prayer_names as $prayer) {
							echo '<li class="time_table">'.$prayer.'</li>';
						} ?>
					</ul>
				</div>
				<div class="prayer_time">
					<ul><?php
						for($t4b = 1; $t4b < 7; $t4b++) {
							if($city_id != '') {
								if( $_POST['cityid'] > 0 && $_POST['cityid'] < 6 ) {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_district_time($time_schedule[$pr_names[$key]], '-1 minutes'); ?></li><?php }
									}
								} elseif( $_POST['cityid'] == 6 ) {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_district_time($time_schedule[$pr_names[$key]], '-2 minutes'); ?></li><?php }
									}
								} elseif( $_POST['cityid'] > 6 && $_POST['cityid'] < 10 ) {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_district_time($time_schedule[$pr_names[$key]], '-3 minutes'); ?></li><?php }
									}
								} elseif( $_POST['cityid'] > 9 && $_POST['cityid'] < 13 ) {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_district_time($time_schedule[$pr_names[$key]], '-4 minutes'); ?></li><?php }
									}
								} elseif( $_POST['cityid'] > 12 && $_POST['cityid'] < 15 ) {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_district_time($time_schedule[$pr_names[$key]], '-5 minutes'); ?></li><?php }
									}
								} elseif( $_POST['cityid'] > 14 && $_POST['cityid'] < 18 ) {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_district_time($time_schedule[$pr_names[$key]], '-6 minutes'); ?></li><?php }
									}
								} elseif( $_POST['cityid'] > 17 && $_POST['cityid'] < 20 ) {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_district_time($time_schedule[$pr_names[$key]], '-7 minutes'); ?></li><?php }
									}
								} elseif( $_POST['cityid'] > 19 && $_POST['cityid'] < 23 ) {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_district_time($time_schedule[$pr_names[$key]], '+1 minutes'); ?></li><?php }
									}
								} elseif( $_POST['cityid'] > 22 && $_POST['cityid'] < 30 ) {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_district_time($time_schedule[$pr_names[$key]], '+2 minutes'); ?></li><?php }
									}
								} elseif( $_POST['cityid'] > 29 && $_POST['cityid'] < 34 ) {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_district_time($time_schedule[$pr_names[$key]], '+3 minutes'); ?></li><?php }
									}
								} elseif( $_POST['cityid'] > 33 && $_POST['cityid'] < 40 ) {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_district_time($time_schedule[$pr_names[$key]], '+4 minutes'); ?></li><?php }
									}
								} elseif( $_POST['cityid'] > 39 && $_POST['cityid'] < 46 ) {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_district_time($time_schedule[$pr_names[$key]], '+5 minutes'); ?></li><?php }
									}
								} elseif( $_POST['cityid'] > 45 && $_POST['cityid'] < 51 ) {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_district_time($time_schedule[$pr_names[$key]], '+6 minutes'); ?></li><?php }
									}
								} elseif( $_POST['cityid'] > 50 && $_POST['cityid'] < 55 ) {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_district_time($time_schedule[$pr_names[$key]], '+7 minutes'); ?></li><?php }
									}
								} elseif( $_POST['cityid'] > 54 && $_POST['cityid'] < 57 ) {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_district_time($time_schedule[$pr_names[$key]], '+8 minutes'); ?></li><?php }
									}
								} else {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_default_time($time_schedule[$pr_names[$key]], $prayer_adjust); ?></li><?php }
									}
								}
							} else {
								if($adjust_time != '') {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_district_time($time_schedule[$pr_names[$key]], $adjust_time); ?></li><?php }
									}
								}
								else {
									foreach($period_times as $key => $period) {
										if($t4b == $key + 1) { ?><li class="time_table"><?php if($period != '') { echo $period.' ' ; } echo prayer_default_time($time_schedule[$pr_names[$key]], $prayer_adjust); ?></li><?php }
									}
								}
							}
						} ?>
					</ul>
				</div><?php
				} ?>
			</div>
		<?php if(get_option('mptb_image') == 'Enabled') { ?>
		</div>
		<?php } ?>
    </div><?php
}
add_action( 'wp_ajax_nopriv_mptb_muslim_prayer_time', 'mptb_muslim_prayer_time' );
add_action( 'wp_ajax_mptb_muslim_prayer_time', 'mptb_muslim_prayer_time' );

class widget_muslim_prayer_time extends WP_Widget {
	function __construct() {
		parent::__construct(
			'mptb',
			__('Muslim Prayer Time BD', 'mptb' ),
			array (
				'description' => __( 'Display prayer time for Bangladeshi Muslims.', 'mptb' )
			)
		);
	}
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		$prayer_time = $instance[ 'prayer_time' ] ? 'true' : 'false';
		$sehri_card = $instance[ 'sehri_card' ] ? 'true' : 'false';
		echo $before_widget;
			if ( $title )
				echo $before_title . $title . $after_title;

			if( 'on' == $instance[ 'prayer_time' ] ) :
				if( 'on' == $instance[ 'sehri_card' ] ) :
					echo do_shortcode('[prayer_time pt="on" sc="on" id="'.$this->id.'"]');
				else :
					echo do_shortcode('[prayer_time pt="on" sc="off" id="'.$this->id.'"]');
				endif;
			else :
				if( 'on' == $instance[ 'sehri_card' ] ) :
					echo do_shortcode('[prayer_time pt="off" sc="on" id="'.$this->id.'"]');
				else :
					echo do_shortcode('[prayer_time pt="off" sc="off" id="'.$this->id.'"]');
				endif;
			endif;
		echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance[ 'prayer_time' ] = $new_instance[ 'prayer_time' ];
		$instance[ 'sehri_card' ] = $new_instance[ 'sehri_card' ];
		return $instance;
	}
	function form($instance) {
		$defaults = array(
            'title' => __('Prayer Time Table'),
			'prayer_time' => 'on',
			'sehri_card' => 'on'
        );
		$instance = wp_parse_args( (array) $instance, $defaults );
		if( $instance) {
			$title = esc_attr($instance['title']);
		} ?>
		<p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Prayer Title:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
        </p>
		<p>
            <input class="checkbox" type="checkbox" <?php checked( $instance[ 'prayer_time' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'prayer_time' ); ?>" name="<?php echo $this->get_field_name( 'prayer_time' ); ?>" /> 
            <label for="<?php echo $this->get_field_id( 'prayer_time' ); ?>">Show Prayer Time</label>
        </p>
		<p>
            <input class="checkbox" type="checkbox" <?php checked( $instance[ 'sehri_card' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'sehri_card' ); ?>" name="<?php echo $this->get_field_name( 'sehri_card' ); ?>" /> 
            <label for="<?php echo $this->get_field_id( 'sehri_card' ); ?>">Show Sehri Card</label>
        </p><?php
	}
}
/* Registered Widget */
function mptb_custom_widget_init() {
	if ( !function_exists('register_widget') )
		return;
	register_widget('widget_muslim_prayer_time');
}
add_action('widgets_init', 'mptb_custom_widget_init');
add_shortcode('prayer_time', 'mptb_muslim_prayer_time');
?>