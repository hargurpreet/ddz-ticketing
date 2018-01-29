<?php
/*
   Plugin Name: DDZ- Tickets
   Description: A plugin that provides playground-ideas with all functionality to the Year of Awesome Ticket system
   Author: Hargurpreet
   Author URI: www.linkedin.com/in/hargurpreet-singh-b28b4246
    Version: 1.1
*/
ob_start();
define('YOA_DIR', plugin_dir_path(__FILE__));
define('YOA_URL', plugin_dir_url(__FILE__));
define('YOA_PAGENAME', 'year-of-awesome');
define('YOA_VERSION', 18);
define('YOA_FREE_ONE', 1);
define('YOA_FREE_TWO', 2);
define('YOA_FREE_THREE', 3);
define('YOA_FREE_FOUR', 4);
define('YOA_FREE_FIVE', 5);

define("YOA_TICKET_PLAN1", '1');
define("YOA_TICKET_PLAN2", '5');
define("YOA_TICKET_PLAN3", '8');

$TICKET_PRICE_DATA = array(
    YOA_TICKET_PLAN1 => '5',
    YOA_TICKET_PLAN2 => '25',
    YOA_TICKET_PLAN3 => '40',
);

include_once('create-page.php');
include_once('admin/admin-page.php');

register_activation_hook(__FILE__, 'yoa_table_create_activation');

function yoa_table_create_activation() {
	global $wpdb;

	global $jal_db_version;
	$charset_collate = $wpdb->get_charset_collate();
	$tickets = $wpdb->prefix . 'yoa_ticket_number';
	$sql = "CREATE TABLE yoa_tickets (
			  id mediumint(9) NOT NULL AUTO_INCREMENT,
			  user_id int NOT NULL,
			  ticket int NOT NULL,
			  value int NOT NULL,
			  count int NOT NULL,
			  free int NOT NULL,
			  school INT NULL,
			  `date` VARCHAR(30),
			  `intrepid_checkbox` tinyint(1) DEFAULT NULL,	  
			  PRIMARY KEY  (id)
			) $charset_collate;";
	$sql_tickets = "CREATE TABLE $tickets (
			  id mediumint(9) NOT NULL AUTO_INCREMENT,
			  yoa_id int NOT NULL,
			  user_id int NOT NULL,
			  ticket_no VARCHAR(50),
			  `date` VARCHAR(30),	  
			  PRIMARY KEY  (id)
			) $charset_collate;";
    require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
    dbDelta($sql);
    dbDelta($sql_tickets);
	$page = $wpdb->get_row("SELECT * FROM wp_posts WHERE post_name = 'thank-you-for-your-payment'");
	wp_delete_post($page->ID);
	 
		// creates the Year of Awesome Page
	    wp_insert_post(array('post_title' => 'Thank You For Your Payment', 'post_type' => 'page', 'post_content' => '&nbsp; &nbsp; &nbsp;<h2 style="text-align: center;">You\'re awesome!</h2><p style="text-align: center;">We\'ve emailed your <strong>tickets</strong> to you.Thanks for supporting the idea that play can change the world Please feel free to bombard your friends with this link &nbsp;<a href="http://Www.myyearofawesome.org">http://Www.myyearofawesome.org</a></p> <p style="text-align: center;">Did we mention you were awesome?</p><p style="text-align: center;">Big love from the<strong> PI crew</strong>.</p> &nbsp;', 'post_status' => 'publish'));
	   
	
	
    
   
 }
?>