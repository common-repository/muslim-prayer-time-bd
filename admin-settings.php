<?php
/**
 * Adding a submenu page in Settings menu for prayer timetable plugin.
 *
 * @uses  add_options_page() - Add sub menu page to the Settings menu.
 *
 * @uses  register_setting() - Register a setting and its data.
 *
 * Muslim Prayer Time BD - v2.4 - 28th March, 2023
 * by @realwebcare - https://www.realwebcare.com/
 */
add_action('admin_menu', 'register_mptb_menu_page');
function register_mptb_menu_page() {
	add_options_page('Muslim Prayer Time BD', __('Prayer Settings', 'mptb'), 'manage_options', __FILE__, 'mptb_plugin_menu');
	add_action( 'admin_init', 'register_mptb_settings' );
}
function register_mptb_settings() {
	//register our settings
	register_setting( 'mptb-settings-group', 'mptb_option' );
	register_setting( 'mptb-settings-group', 'mptb_image' );
	register_setting( 'mptb-settings-group', 'ampm_option' );
}
function mptb_plugin_menu() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
?>
	<div class="wrap">
		<h1><?php _e('Muslim Prayer Time BD Settings', 'mptb'); ?></h1>
		<hr>
		<div class="postbox-container prayer-time-settings">
			<form method="post" action="options.php"><?php
				settings_fields( 'mptb-settings-group' );
				$city_states = district_lists();
				$prayer_ln = get_option('prayer_ln') != '' ? get_option('prayer_ln') : 'bn';
				$prayer_image = (get_option('prayer_image')) ? get_option('prayer_image') : ''; ?>
				<div class="prayer-options start-options">
					<label class="input-title"><?php _e('Select the Default District', 'mptb'); ?>:</label>
					<select name="default_city" id="default_city">
						<option value="" selected="selected"><?php
							if(isset($_POST['default_city'])) {
								echo $_POST['default_city'];
							} else {
								if($prayer_ln == 'bn') { echo 'ঢাকা'; }
								else { echo 'Dhaka'; }
							} ?>
						</option><?php
						foreach($city_states as $key => $city) { ?>
							<option value="<?php echo $key; ?>" <?php if(get_option('default_city') == $key) {echo "selected=selected";} ?>><?php echo $city; ?></option><?php
						} ?>
					</select>
				</div>
                <div class="prayer-options">
                    <label class="input-title"><?php _e('Adjust Prayer Time (+/-)', 'mptb'); ?>:<a href="#" class="mptbd_tooltip" rel="<?php _e('To adjust the current prayer time of the district, you can modify the time by adding or subtracting minutes. Adding a positive number, such as 10, will increase the time, while subtracting a negative number, such as -10, will decrease the time.', 'mptb'); ?>"><span class="dashicons dashicons-editor-help"></span></a></label>
                    <input type="number" name="adj_prayer_time" id="adj_prayer_time" value="<?php echo get_option('prayer_adjust'); ?>" min="-1440" max="1440" step="any" placeholder="<?php _e('5', 'mptb'); ?>" />
                </div>
                <div class="prayer-options">
                    <label class="input-title"><?php _e('Enter Prayer Name', 'mptb'); ?>:<a href="#" class="mptbd_tooltip" rel="<?php _e('To customize the display of prayer name in your schedule, enter the names of the prayer separated by commas in the designated field. Ensure that the names are entered accurately and in the desired order to generate an accurate schedule. For example, entering \'Fajr, Dhuhr, Asr, Maghrib, Isha\' will display the prayer times in that particular order.', 'mptb'); ?>"><span class="dashicons dashicons-editor-help"></span></a></label>
                    <span id="prayer-name" class="prayer_note">e.g. Fajr, Duhr, Asr, Maghrib, Isha, Sunrise</span>
                    <span id="name-clear" class="prayer_note">Click to Clear</span>
                    <textarea name="prayer_names" id="prayer_names" cols="50" rows="2" placeholder="<?php _e('Enter Prayer Name', 'mptb'); ?>"><?php echo get_option('pr_names'); ?></textarea>
                </div>
                <div class="prayer-options">
                    <label class="input-title"><?php _e('Enter Prayer Time of Day', 'mptb'); ?>:<a href="#" class="mptbd_tooltip" rel="<?php _e('To add the time of day next to each prayer name, such as \'Morning\' or \'Evening\', simply enter the time of day for each prayer in the designated field, separated by commas. For example, if you enter \'Morning, Noon, Afternoon, Evening, Night\' along with the prayer names, the schedule will display the time of day next to each prayer name in the order entered. Make sure to enter the time of day accurately for each prayer to ensure an accurate schedule.', 'mptb'); ?>"><span class="dashicons dashicons-editor-help"></span></a></label>
                    <span id="prayer-time" class="prayer_note">e.g. Dawn, Noon, Afternoon, Evening, Night, Dawn</span>
                    <span id="time-clear" class="prayer_note">Click to Clear</span>
                    <textarea name="period_times" id="period_times" cols="50" rows="2" placeholder="<?php _e('Enter Period of Time Name', 'mptb'); ?>"><?php echo get_option('pr_times'); ?></textarea>
                </div>
				<div class="prayer-options">
					<label class="input-title"><?php _e('Show Prayer Time in', 'mptb'); ?>:</label>
					<select name="prayer_time_ln" id="prayer_time_ln">
						<?php if(get_option('prayer_ln') == 'en') { ?>
						<option value="bn"><?php _e('Bangla', 'mptb'); ?></option>
						<option value="en" selected="selected"><?php _e('English', 'mptb'); ?></option>
						<?php } else { ?>
						<option value="bn" selected="selected"><?php _e('Bangla', 'mptb'); ?></option>
						<option value="en"><?php _e('English', 'mptb'); ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="prayer-options">
					<label class="input-title"><?php _e('Time Format', 'mptb'); ?>:</label>
					<select name="time_format" id="time_format">
						<?php if(get_option('time_fm') == '24') { ?>
						<option value="12"><?php _e('12 Hours', 'mptb'); ?></option>
						<option value="24" selected="selected"><?php _e('24 Hours', 'mptb'); ?></option>
						<?php } else { ?>
						<option value="12" selected="selected"><?php _e('12 Hours', 'mptb'); ?></option>
						<option value="24"><?php _e('24 Hours', 'mptb'); ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="prayer-options">
					<label class="input-check" id="am-pm"><?php _e('Display AM/PM', 'mptb'); ?>:</label>
					<label for="am-pm" class="enable_check">
						<input type="checkbox" name="ampm_option" class="tickbox" id="ampm_option" value="Yes" <?php if(get_option('ampm_option')=="Yes") echo('checked="checked"'); ?>/>
					</label>
				</div>
				<div class="prayer-color">
					<label class="input-title" style="color:#bd7b02"><?php _e('District List Box Color', 'mptb'); ?>:</label>
					<input type="text" name="district_bg_color" class="district_bg_color" id="district_bg_color" value="<?php echo get_option('dist_bg'); ?>" />
				</div>
				<div class="prayer-color">
					<label class="input-title" style="color:#bd7b02"><?php _e('District List Font Color', 'mptb'); ?>:</label>
					<input type="text" name="district_font_color" class="district_font_color" id="district_bg_color" value="<?php echo get_option('dist_font'); ?>" />
				</div>
				<div class="prayer-color">
					<label class="input-title" style="color:#28a918"><?php _e('Prayer Name Background Color', 'mptb'); ?>:</label>
					<input type="text" name="prayer_name_bg" class="prayer_name_bg" id="prayer_name_bg" value="<?php echo get_option('mptbg_one'); ?>" />
				</div>
				<div class="prayer-color">
					<label class="input-title" style="color:#28a918"><?php _e('Prayer Name Font Color', 'mptb'); ?>:</label>
					<input type="text" name="prayer_name_font" class="prayer_name_font" id="prayer_name_font" value="<?php echo get_option('prayer_name'); ?>" />
				</div>
				<div class="prayer-options">
					<label class="input-title" style="color:#28a918"><?php _e('Prayer Name Font Weight', 'mptb'); ?>:</label>
					<select name="prayer_name_weight" id="prayer_name_weight">
						<?php if(get_option('pname_weight') == 'normal') { ?>
						<option value="bold"><?php _e('Bold', 'mptb'); ?></option>
						<option value="normal" selected="selected"><?php _e('Normal', 'mptb'); ?></option>
						<?php } else { ?>
						<option value="bold" selected="selected"><?php _e('Bold', 'mptb'); ?></option>
						<option value="normal"><?php _e('Normal', 'mptb'); ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="prayer-options">
					<label class="input-title" style="color:#28a918"><?php _e('Prayer Name Text Align', 'mptb'); ?>:</label>
					<select name="prayer_name_align" id="prayer_name_align">
						<?php if(get_option('pname_align') == 'left') { ?>
						<option value="left" selected="selected"><?php _e('Left', 'mptb'); ?></option>
						<option value="right"><?php _e('Right', 'mptb'); ?></option>
						<option value="center"><?php _e('Center', 'mptb'); ?></option>
						<?php } elseif(get_option('pname_align') == 'right') { ?>
						<option value="left"><?php _e('Left', 'mptb'); ?></option>
						<option value="right" selected="selected"><?php _e('Right', 'mptb'); ?></option>
						<option value="center"><?php _e('Center', 'mptb'); ?></option>
						<?php } else { ?>
						<option value="left"><?php _e('Left', 'mptb'); ?></option>
						<option value="right"><?php _e('Right', 'mptb'); ?></option>
						<option value="center" selected="selected"><?php _e('Center', 'mptb'); ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="prayer-color">
					<label class="input-title" style="color:#2574a9"><?php _e('Prayer Time Background Color', 'mptb'); ?>:</label>
					<input type="text" name="prayer_time_bg" class="prayer_time_bg" id="prayer_time_bg" value="<?php echo get_option('mptbg_two'); ?>" />
				</div>
				<div class="prayer-color">
					<label class="input-title" style="color:#2574a9"><?php _e('Prayer Time Font Color', 'mptb'); ?>:</label>
					<input type="text" name="prayer_time_font" class="prayer_time_font" id="prayer_time_font" value="<?php echo get_option('prayer_time'); ?>" />
				</div>
				<div class="prayer-options">
					<label class="input-title" style="color:#2574a9"><?php _e('Prayer Time Font Weight', 'mptb'); ?>:</label>
					<select name="prayer_time_weight" id="prayer_time_weight">
						<?php if(get_option('ptime_weight') == 'bold') { ?>
						<option value="normal"><?php _e('Normal', 'mptb'); ?></option>
						<option value="bold" selected="selected"><?php _e('Bold', 'mptb'); ?></option>
						<?php } else { ?>
						<option value="normal" selected="selected"><?php _e('Normal', 'mptb'); ?></option>
						<option value="bold"><?php _e('Bold', 'mptb'); ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="prayer-options">
					<label class="input-title" style="color:#2574a9"><?php _e('Prayer Time Text Align', 'mptb'); ?>:</label>
					<select name="prayer_time_align" id="prayer_time_align">
						<?php if(get_option('ptime_align') == 'left') { ?>
						<option value="left" selected="selected"><?php _e('Left', 'mptb'); ?></option>
						<option value="right"><?php _e('Right', 'mptb'); ?></option>
						<option value="center"><?php _e('Center', 'mptb'); ?></option>
						<?php } elseif(get_option('ptime_align') == 'right') { ?>
						<option value="left"><?php _e('Left', 'mptb'); ?></option>
						<option value="right" selected="selected"><?php _e('Right', 'mptb'); ?></option>
						<option value="center"><?php _e('Center', 'mptb'); ?></option>
						<?php } else { ?>
						<option value="left"><?php _e('Left', 'mptb'); ?></option>
						<option value="right"><?php _e('Right', 'mptb'); ?></option>
						<option value="center" selected="selected"><?php _e('Center', 'mptb'); ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="prayer-options image-end">
					<label class="input-check" id="enable-sehri"><?php _e('Display Background Image', 'mptb'); ?>:<a href="#" class="mptbd_tooltip" rel="<?php _e('You can easily set an image for your prayer timetable by selecting it from the WordPress media library or by uploading an image from your computer. Simply click the \'Upload Image\' button to begin the process. Alternatively, you can also set the image by directly entering the image link. This flexible feature allows you to easily add an image to your prayer timetable and customize it according to your preferences.', 'mptb'); ?>"><span class="dashicons dashicons-editor-help"></span></a></label>
					<label for="enable-sehri" class="enable_check">
						<input type="checkbox" name="mptb_image" class="tickbox" id="mptb_image" value="Enabled" <?php if(get_option('mptb_image')=="Enabled") echo('checked="checked"'); ?>/>
					</label>
				</div>
				<div id="image_enable">
					<div class="prayer-options start-image">
						<label for="upload image" class="input-title"><?php _e('Upload Image', 'mptb'); ?><a href="#" class="mptbd_tooltip" rel="<?php _e('You can either enter the image location directly, upload an image from your computer, or select an image from the WordPress media library.', 'mptb'); ?>"><span class="dashicons dashicons-editor-help"></span></a></label>
						<input type="text" name="prayer_image" id="prayer_image" value="<?php echo $prayer_image; ?>" size="40" placeholder="<?php _e('Enter a URL / upload an image', 'mptb'); ?>">
					</div>
					<input type="hidden" name="hidden_path" value="<?php echo $prayer_image; ?>" />
					<div id="show_upload_preview" class="prayer-options end-image">
						<?php if(!empty($prayer_image)) { ?>
							<label class="input-title"><?php _e('Preview', 'mptb'); ?></label>
							<img src="<?php echo $prayer_image ; ?>" alt="package image" class="preview_image">
							<span id="remove_image"></span>
						<?php } ?>
					</div>
				</div>
				<div class="prayer-options prayer-end">
					<label class="input-check" id="enable-sehri"><?php _e('Enable to Show Sehri &amp; Iftar Time', 'mptb'); ?>:</label>
					<label for="enable-sehri" class="enable_check">
						<input type="checkbox" name="mptb_option" class="tickbox" id="mptb_option" value="Enabled" <?php if(get_option('mptb_option')=="Enabled") echo('checked="checked"'); ?>/>
					</label>
				</div>
				<div id="sehri_enable">
					<div class="prayer-options start-sehri">
						<label class="input-title"><?php _e('Adjust Sehri Time (+/-)', 'mptb'); ?>:<a href="#" class="mptbd_tooltip" rel="<?php _e('To adjust the current sehri time of the district, you can modify the time by adding or subtracting minutes. Adding a positive number, such as 10, will increase the time, while subtracting a negative number, such as -10, will decrease the time.', 'mptb'); ?>"><span class="dashicons dashicons-editor-help"></span></a></label>
						<input type="number" name="adj_sehri_time" id="adj_sehri_time" value="<?php echo get_option('sehri_adjust'); ?>" min="-1440" max="1440" step="any" placeholder="<?php _e('5', 'mptb'); ?>" />
					</div>
					<div class="prayer-options">
						<label class="input-title"><?php _e('Sehri Card Title', 'mptb'); ?>:</label>
						<input type="text" name="sehri_title" id="sehri_title" value="<?php echo get_option('sehri_title'); ?>" size="40" placeholder="<?php _e('Last Time of Sehri at:', 'mptb'); ?>" />
					</div>
					<div class="prayer-options">
						<label class="input-title"><?php _e('Iftar Card Title', 'mptb'); ?>:</label>
						<input type="text" name="iftar_title" id="iftar_title" value="<?php echo get_option('iftar_title'); ?>" size="40" placeholder="<?php _e('Iftar Start at:', 'mptb'); ?>" />
					</div>
					<div class="prayer-color">
						<label class="input-title"><?php _e('Sehri Time Background Color', 'mptb'); ?>:</label>
						<input type="text" name="sehri_time_bg" class="sehri_time_bg" id="sehri_time_bg" value="<?php echo get_option('sehri_bg'); ?>" />
					</div>
					<div class="prayer-color">
						<label class="input-title"><?php _e('Iftar Time Background Color', 'mptb'); ?>:</label>
						<input type="text" name="iftar_time_bg" class="iftar_time_bg" id="iftar_time_bg" value="<?php echo get_option('iftar_bg'); ?>" />
					</div>
					<div class="prayer-color">
						<label class="input-title"><?php _e('Sehri &amp; Iftar Font Color', 'mptb'); ?>:</label>
						<input type="text" name="sehri_time_font" class="sehri_time_font" id="sehri_time_font" value="<?php echo get_option('sehri_font'); ?>" />
					</div>
					<div class="prayer-options">
						<label class="input-title"><?php _e('Sehri &amp; Iftar Font Weight', 'mptb'); ?>:</label>
						<select name="sehri_time_weight" id="sehri_time_weight">
							<?php if(get_option('sehri_weight') == 'bold') { ?>
							<option value="normal"><?php _e('Normal', 'mptb'); ?></option>
							<option value="bold" selected="selected"><?php _e('Bold', 'mptb'); ?></option>
							<?php } else { ?>
							<option value="normal" selected="selected"><?php _e('Normal', 'mptb'); ?></option>
							<option value="bold"><?php _e('Bold', 'mptb'); ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="prayer-options end-sehri">
						<label class="input-title"><?php _e('Sehri &amp; Iftar Text Align', 'mptb'); ?>:</label>
						<select name="sehri_time_align" id="sehri_time_align">
							<?php if(get_option('sehri_align') == 'left') { ?>
							<option value="left" selected="selected"><?php _e('Left', 'mptb'); ?></option>
							<option value="right"><?php _e('Right', 'mptb'); ?></option>
							<option value="center"><?php _e('Center', 'mptb'); ?></option>
							<?php } elseif(get_option('sehri_align') == 'right') { ?>
							<option value="left"><?php _e('Left', 'mptb'); ?></option>
							<option value="right" selected="selected"><?php _e('Right', 'mptb'); ?></option>
							<option value="center"><?php _e('Center', 'mptb'); ?></option>
							<?php } else { ?>
							<option value="left"><?php _e('Left', 'mptb'); ?></option>
							<option value="right"><?php _e('Right', 'mptb'); ?></option>
							<option value="center" selected="selected"><?php _e('Center', 'mptb'); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<?php submit_button(); ?>
                <input type="submit" class="button button-secondary right" name="clear_all" id="clear_all" value="Reset">
			</form>
		</div>
		<div class="mptb-sidebar">
			<div class="postbox-container">
				<div class="card">
					<h2 class="mpt-title"><?php _e('Prayer Time Using Widget', 'mptb'); ?></h2>
					<p><?php _e('To display the prayer time and/or sehri time using a WordPress widget, follow these steps:', 'mptb'); ?></p>
					<ol>
						<li><?php _e('Log in to your WordPress account and go to the <b>Appearance >> Widgets</b> section.', 'mptb'); ?></li>
						<li><?php _e('Look for the <b>Muslim Prayer Time BD</b> widget and drag and drop it to the sidebar where you want to display the prayer time and/or sehri time.', 'mptb'); ?></li>
						<li><?php _e('From the widget, you will have the option to show both Prayer and Sehri time, or you can display them individually.', 'mptb'); ?></li>
					</ol>
					<p><?php _e('By following these simple steps, you can easily display the prayer time and/or sehri time on your WordPress website using a widget.', 'mptb'); ?></p>
				</div>
			</div>
			<div class="postbox-container">
				<div class="card">
					<h2 class="mpt-title"><?php _e('Prayer Time Using Shortcode', 'mptb'); ?></h2>
					<p><?php _e('You can display the prayer time and/or sehri time using the WordPress SHORTCODE in your page or post.', 'mptb'); ?></p>
					<p><?php _e('Copy &amp; paste the below shortcode into the posts/pages you want to show prayer time and/or sehri time.', 'mptb'); ?></p>
					<input type="text" class="mptb-shortcode" value="[prayer_time]" size="10">
					<p><?php _e('In the shortcode, you will have the option to show both Prayer and Sehri time, or you can display them individually. To do this follow the below procedure in the shortcode:', 'mptb'); ?></p>
					<input type='text' class='mptb-shortcode' value='[prayer_time pt="on" sc="off"]' size="30">
					<p><?php _e('<strong>pt</strong> means Prayer Time and <strong>sc</strong> means Sehri card. Using <strong>ON/OFF</strong>, you can decide which to display and/or which not to display.', 'mptb'); ?></p>
				</div>
			</div>
			<div class="postbox-container">
				<div class="card">
					<h2 class="mpt-title"><?php _e('Plugin Info', 'mptb'); ?></h2>
					<p>
						<?php _e('Version: 2.4', 'mptb'); ?><br/>
						<?php _e('Scripts: PHP + CSS + JS', 'mptb'); ?><br/>
						<?php _e('Requires: Wordpress 3.0', 'mptb'); ?>+<br/>
						<?php _e('First release: 23 January, 2014', 'mptb'); ?><br/>
						<?php _e('Last update: 28 March, 2023', 'mptb'); ?><br/>
						<?php _e('By', 'mptb'); ?>: <a href="https://www.realwebcare.com/" target="_blank"><?php _e('Realwebcare', 'mptb'); ?></a><br/>
						<?php _e('Author', 'mptb'); ?>: <a href="https://facebook.com/IKIAlam" target="_blank"><?php _e('Iftekhar', 'mptb'); ?></a><br/>
						<?php _e('Need Help', 'mptb'); ?>? <a href="https://wordpress.org/support/plugin/muslim-prayer-time-bd/" target="_blank">Support</a><br/>
						<?php _e('Like it? Please leave us a', 'mptb'); ?> <a target="_blank" href="https://wordpress.org/support/plugin/muslim-prayer-time-bd/reviews/?filter=5/#new-post">&#9733;&#9733;&#9733;&#9733;&#9733;</a> <?php _e('rating. We highly appreciate your support!', 'mptb'); ?><br/>
						<?php _e('Published under', 'mptb'); ?>: <a href="http://www.gnu.org/licenses/gpl.txt"><?php _e('GNU General Public License', 'mptb'); ?></a>
					</p>
				</div>
			</div>
			<div class="postbox-container">
				<a href="https://www.realwebcare.com/" target="_blank"><div class="card rwc-ads"></div></a>
			</div>
		</div>
	</div>
	<?php
}
$prayer_time_options = array( 'dist_bg' => 'district_bg_color', 'prayer_adjust' => 'adj_prayer_time', 'pr_names' => 'prayer_names', 'pr_times' => 'period_times', 'prayer_ln' => 'prayer_time_ln', 'time_fm' => 'time_format', 'dist_font' => 'district_font_color', 'sehri_weight' => 'sehri_time_weight', 'sehri_align' => 'sehri_time_align', 'sehri_adjust' => 'adj_sehri_time', 'sehri_title' => 'sehri_title', 'iftar_title' => 'iftar_title', 'sehri_bg' => 'sehri_time_bg', 'iftar_bg' => 'iftar_time_bg', 'sehri_font' => 'sehri_time_font', 'default_city' => 'default_city', 'mptbg_one' => 'prayer_name_bg', 'mptbg_two' => 'prayer_time_bg', 'prayer_name' => 'prayer_name_font', 'prayer_time' => 'prayer_time_font', 'pname_weight' => 'prayer_name_weight', 'ptime_weight' => 'prayer_time_weight', 'pname_align' => 'prayer_name_align', 'ptime_align' => 'prayer_time_align', 'prayer_image' => 'prayer_image' );
foreach($prayer_time_options as $key => $option) {
	if( isset( $_POST[$option] ) ) {
		update_option( $key, sanitize_text_field( $_POST[$option] ) );
	}
}
if( isset( $_POST['clear_all'] ) ) { clear_muslim_prayer_time_bd($prayer_time_options); }

function clear_muslim_prayer_time_bd($prayer_options) {
	foreach($prayer_options as $option => $value) {
		delete_option($option);
	}
}
?>