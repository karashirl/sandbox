<?php
/**
 * Plugin Name: SBG Utils
 * Description: Important fields for reusable information throught a web build
 * Version: 0.0.1
 * Author: Joseph Hritz
 * Tested with: 4.0.1
 */
 
 ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


// SBG class
class SBG {
	private $coName = 'Sinclair Digital Solutions';
	private $coURL = 'http://sinclairdigital.com';
	private $coSlogan = 'Solutions at your fingertips';
	
	public function getCompanyName() {
		return 	$this->coName;
	}
	
	public function printComapanyName() {
		echo $this->coName;
	}
	
	public function getCompanyURL() {
		return $this->coURL;	
	}
	
	public function printCompanyURL() {
		echo $this->coURL;	
	}
	
	public function getCompanySlogan() {
		return $this->coSlogan;	
	}
	
	public function printCompanySlogan() {
		echo $this->coSlogan;	
	}
	
}

$GLOBALS['sbg'] = new SBG();

// register settings
function resister_sbp_settings() {
	register_setting('sbp-config', 'sbp-company-name');
	register_setting('sbp-config', 'sbp-company-address');
	register_setting('sbp-config', 'sbp-company-city');
	register_setting('sbp-config', 'sbp-company-state');
	register_setting('sbp-config', 'sbp-company-zip');
	register_setting('sbp-config', 'sbp-company-fax');
	register_setting('sbp-config', 'sbp-company-phone2');
	register_setting('sbp-config', 'sbp-company-year');
}

add_action('admin_init', 'resister_sbp_settings');

//// SHORT CODES ////
// add shortcode method to retrieve sbp options
function shortcode_sbp_config($atts) {
	$setting = shortcode_atts( array(
		'setting' => FALSE,
	), $atts );

	$setting = $setting['setting'];

	if ($setting) {
		ob_start();
		try {
			switch ($setting) {
				case 'phone':
					echo et_get_option( 'phone_number' );
				break;
				case 'email':
					echo et_get_option( 'header_email' );
				break;
				default:
					echo get_option('sbp-' . $setting);
				break;
			}
		} catch (Exception $e) {
			// do nothing this is a failsafe just in case Divi decides to change up their code
		}
		
		return ob_get_clean();
	}

}
add_shortcode( 'sbp_config', 'shortcode_sbp_config' );

// quick shortcode for address block 
function shortcode_sbp_address_block() {
	$getDirections = 'https://maps.google.com?daddr=' . get_option('sbp-company-address') .'+'. get_option('sbp-company-address') .'+'. get_option('sbp-company-address') .'+'. get_option('sbp-company-address');
	ob_start();
	?>	
		<address class="sbp-address-block">
			<div class="sbp-company-name"><?php echo get_option('sbp-company-name') ?></div>
			<div class="sbp-address-line1"><a href="<?php echo $getDirections ?>"><?php echo get_option('sbp-company-address') ?></a></div>
			<div class="sbp-address-line2"><a href="<?php echo $getDirections ?>"><?php echo get_option('sbp-company-city') ?>, <?php echo get_option('sbp-company-state') ?> <?php echo get_option('sbp-company-zip') ?></a></div>
		</address>
	<?php
	return ob_get_clean();
}
add_shortcode( 'sbp_address_block', 'shortcode_sbp_address_block' );

// code for getting address in an anchor that links to google to get directions
function shortcode_sbp_get_directions() {
	$getDirections = 'https://maps.google.com?daddr=' . get_option('sbp-company-address') .'+'. get_option('sbp-company-address') .'+'. get_option('sbp-company-address') .'+'. get_option('sbp-company-address');
	ob_start(); ?>
		<a class="sbp-get-dir" href="<?php echo $getDirections ?>"><?php echo get_option('sbp-company-address') ?><br><?php echo get_option('sbp-company-city') ?>, <?php echo get_option('sbp-company-state') ?> <?php echo get_option('sbp-company-zip') ?></a>
	<?php return ob_get_clean();
}
add_shortcode( 'sbp_getdir', 'shortcode_sbp_get_directions' );


// shortcode for getting all comany info in a nice list
function shortcode_sbp_company_info() {
	$info = '';
	$name = get_option('sbp-company-name');
	$address = get_option('sbp-company-address');
	$city = get_option('sbp-company-city');
	$state = get_option('sbp-company-state');
	$zip = get_option('sbp-company-zip');
	$email = FALSE;
	$phone = FALSE;
	$phone2 = get_option('sbp-company-phone2');
	$fax = get_option('sbp-company-fax');

	try {
		$email = et_get_option( 'header_email' );
		$phone = et_get_option( 'phone_number' );
	} catch (Exception $e) {}


	if ($name) {
		$info .= "<strong>$name</strong><br />";
	}

	if ($address && $city && $state && $zip) {
		$info .= "<strong>Address:</strong><br />$address<br />$city, $state $zip<br />";
	}

	if ($email) {
		$info .= "<strong>Email:</strong><br /><a href=\"mailto:$email\">$email</a><br />";
	}

	if ($phone) {
		$info .= "<strong>Phone:</strong><br />$phone<br />";
	}

	if ($phone2) {
		$info .= "<strong>Phone2:</strong><br />$phone2<br />";
	}

	if ($fax) {
		$info .= "<strong>Fax:</strong><br />$fax<br />";
	}

	ob_start();
	echo $info;
	return ob_get_clean();

}
add_shortcode( 'sbp_company_info', 'shortcode_sbp_company_info' );

// super short code for page name
function shortcode_sbp_page_title () {
	ob_start();
	echo get_the_title();
	return ob_get_clean();
}
add_shortcode( 'sbp_title', 'shortcode_sbp_page_title' );


//// END SHORT CODES ////




//// OPTIONS PAGE MENU UI ////
// Add Options Page to Menu
add_action( 'admin_menu', 'sbg_sbp_config' );

function sbg_sbp_config() {
	add_options_page( 'SBP Config', 'SBP Config', 'manage_options', 'sbg-sbp-config', 'sbg_write_sbg_config_form' );
}

function sbg_sbp_config_show_form() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} else { 
		sbg_write_sbg_config_form();
	}
}

// util function to get year span from start
function sbg_get_years() {
	$copyYear = get_option('sbp-company-year'); 
	$curYear = date('Y'); 
	echo ($copyYear ? $copyYear : $curYear) . (($copyYear && $copyYear != $curYear) ? ' - ' . $curYear : '');
}


function sbg_write_sbg_config_form() { ?>
	<div class="wrap">
        <h2>SBP Config</h2>
        <form method="post" action="options.php">
            <?php 
            settings_fields( 'sbp-config' ); 
            do_settings_fields( 'sbp-config', '' );
            ?>
            <style>
				label {
					width: 20%;
					display: inline-block;
					text-align: right;
				}
			</style>

            <label for="sbp-comany-name">*Company Name</label>
            <input type="text" id="sbp-company-name" name="sbp-company-name" value="<?php echo get_option('sbp-company-name'); ?>" placeholder="Type Company Name" />
            <br />

            <label for="sbp-comany-address">*Address</label>
            <input type="text" id="sbp-company-address" name="sbp-company-address" value="<?php echo get_option('sbp-company-address'); ?>" placeholder="Type Company Address" />
            <br />

            <label for="sbp-comany-city">*City</label>
            <input type="text" id="sbp-company-city" name="sbp-company-city" value="<?php echo get_option('sbp-company-city'); ?>" placeholder="Type Company City" />
            <br />

            <label for="sbp-comany-state">*State</label>
            <input type="text" id="sbp-company-state" name="sbp-company-state" value="<?php echo get_option('sbp-company-state'); ?>" maxlength="2" placeholder="Type Company State" />
            <br />

            <label for="sbp-comany-zip">*ZIP</label>
            <input type="text" id="sbp-company-zip" name="sbp-company-zip" value="<?php echo get_option('sbp-company-zip'); ?>" max-length="11" placeholder="Type Company ZIP" />
            <br />

            <label for="sbp-comany-fax">FAX</label>
            <input type="text" id="sbp-company-fax" name="sbp-company-fax" value="<?php echo get_option('sbp-company-fax'); ?>" max-length="11" placeholder="Type Company FAX" />
            <br />

            <label for="sbp-comany-phone2">Phone 2 <small>Make sure primary phone is placed in Themes &gt; Customize</small></label>
            <input type="text" id="sbp-company-phone2" name="sbp-company-phone2" value="<?php echo get_option('sbp-company-phone2'); ?>" max-length="11" placeholder="Type Company Phone 2" />
            <br />
            
            <label for="sbp-comany-year">Year </label>
            <input type="text" id="sbp-company-year" name="sbp-company-year" value="<?php echo get_option('sbp-company-year'); ?>" max-length="4" placeholder="20##" />
            <br />


            <?php
            submit_button();
            ?>
        </form>
    </div>
<?php }

?>