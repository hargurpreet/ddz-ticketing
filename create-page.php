<?php
$page_name = basename($_SERVER[REQUEST_URI]);

if (strpos($_SERVER[REQUEST_URI], YOA_PAGENAME) !== FALSE) {
    remove_filter('the_content', 'wpautop');
    remove_filter('the_excerpt', 'wpautop');

    add_action('wp_head', 'tc_head_script');
    // add stuff to head tag
    function tc_head_script()
    { ?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- facebook share -->
        <meta property="og:image" content="<?php echo YOA_URL; ?>assets/images/yoa.jpg">
        <meta property="og:image:type" content="image/jpeg">
        <meta property="og:image:width" content="550">
        <meta property="og:image:height" content="400">
        <meta property="og:title" content="Year Of Awesome | Playground Ideas">
        <meta property="og:description" content="Life is about experiences, not stuff and we’ve got 12 awesome prizes designed to bring families together to have PLAYful adventures they won’t forget - one for every month of the year! As the pace of life spins faster, we want to provide a way for families to reconnect,…">
        <meta property="fb:app_id" content="276719169501679">
        <link rel="canonical" href="https://playgroundideas.org/year-of-awesome/" />
        <meta property="og:url" content="https://playgroundideas.org/year-of-awesome/" />
        
        <link rel="icon" href="../favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Gudea:700" rel="stylesheet">

        <link href="<?php echo YOA_URL; ?>assets/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo YOA_URL; ?>assets/css/timeline.css" rel="stylesheet">
        <link href="<?php echo YOA_URL; ?>assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
        <link href="<?php echo YOA_URL; ?>assets/css/starter-template.css" rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script src="https://connect.facebook.net/en_US/all.js"></script>
        <script>
            window.fbAsyncInit = function () {
                FB.init({
                    appId: '276719169501679',
                    xfbml: true,
                    version: 'v2.10'
                });

                (function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) {
                        return;
                    }
                    js = d.createElement(s);
                    js.id = id;
                    js.src = "//connect.facebook.net/en_US/sdk.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            };
        </script>
    <?php }

    // use footer hook to inject template
    add_action('wp_footer', function () {
        include YOA_DIR . "yoa-template.php";
    });
}

//add_action('admin_head', 'yoa_admin_head');
function yoa_admin_head() {
    global $wpdb;
    echo '<div style="position:absolute; left: 200px; top:60px;z-index:1;"><pre>';
    $installed_ver = get_option("YOA_VERSION");
    echo $installed_ver;
    $res = $wpdb->get_var("SELECT COUNT(1) FROM information_schema.tables WHERE table_schema='liveplay_wpnew' AND table_name='yoa_tickets';");
    var_dump($res);
    foreach ( $wpdb->get_col( "DESC " . yoa_tickets, 0 ) as $column_name ) {
        echo $column_name.", ";
    }
    echo '<br/>';
    $rows = $wpdb->get_results( "SELECT * FROM yoa_tickets");
    foreach( $rows as $row )
        var_dump($row);
    echo '</pre></div>';
}
add_action('init', 'create_ticket_page');
function create_ticket_page()
{
    global $wpdb;

    // check if Year of Awesome Page is exist
    if ($wpdb->get_row("SELECT post_name FROM wp_posts WHERE post_name = '" . YOA_PAGENAME . "'", 'ARRAY_A')) {
        return YOA_PAGENAME;
    } else {
        // creates the Year of Awesome Page
        wp_insert_post(array('post_title' => 'Year Of Awesome', 'post_type' => 'page', 'post_content' => '', 'post_status' => 'publish', 'page_template' => 'empty_template.php'));
    }
}



add_filter('rewrite_rules_array', 'yoa_rewrite_rules');
function yoa_rewrite_rules($orules){
    $rules = array ();
    $rules[YOA_PAGENAME.'/([^/]*)/?$'] = 'index.php?pagename='.YOA_PAGENAME.'&yoa_school_name=$matches[1]';
    return array_merge($rules, $orules);
}

add_filter( 'query_vars', 'yoa_rewrite_vars' );
function yoa_rewrite_vars( $vars ) {
    $vars[] = 'yoa_school_name';
    return $vars;
}

add_action('wp_ajax_store_transaction', 'store_transaction');
add_action('wp_ajax_nopriv_store_transaction', 'store_transaction');
function store_transaction()
{
    global $wpdb, $TICKET_PRICE_DATA;
    // f_name, l_name, email_user, phone_user, school_id, token_id, token_email, ticket_plan, ticket_amount, ticket_free ,intrepid_check
    $intrepid_check = $_POST['intrepid_check'];
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $email_user = $_POST['email_user'];
    $phone_num = $_POST['phone_user'];
    $school_id = intval($_POST['school_id']);
    $token_id = $_POST['token_id'];
    $token_email = $_POST['token_email'];
    $ticket_plan = intval($_POST['ticket_plan']);
    $ticket_plan_value = intval($TICKET_PRICE_DATA[$_POST['ticket_plan']]);
    $ticket_free_value = intval($_POST['ticket_free']);
    $ticket_amount = intval($_POST['ticket_amount']);

    $response = array();
    ///////////////////////////////////////////////////////////////////////////////
    require_once('assets/stripe-php-5.1.2/init.php');

    \Stripe\Stripe::setApiKey('sk_live_H9tz8Pkk8aNjO8AP8Jie07vY'); 
    // sk_test_f4OwaXbTy3l2c3A3mZFWPqo9, 
    // old live key -- sk_live_e57dDoyD6KhTa7lpN9vJBsSq
    // new live key -- sk_live_H9tz8Pkk8aNjO8AP8Jie07vY

    $customer = \Stripe\Customer::create(array(
            'card' => $token_id,
            'email' => $email_user
        )
    );
    if (!empty($customer) && $customer->id != "") {
        try {
            $charge = \Stripe\Charge::create(array(
                "customer" => $customer->id,
                "amount" => intval($ticket_amount * $ticket_plan_value * 100),
                "currency" => "AUD",
                "receipt_email" => $email_user
            ));
            if ($charge['status'] == 'succeeded')
                $response['charge_status'] = 'success';
            else
                $response['charge_status'] = 'failed';
        } catch (Exception $e) {
            $response['charge_status'] = $e->getMessage();
        }
    }
    else
        $response['charge_status'] = 'customer create failed';

    ///////////////////////////////////////////////////////////////////////////////
    if (email_exists($email_user)) { }
    else {
        // Create a user
        $userdata = array(
            'user_login' => $email_user,
            'user_pass' => MD5('doifd'),
            'user_nicename' => $f_name . " " . $l_name,
            'user_email' => $email_user,
        );
        $user_id = wp_insert_user($userdata);
        if (!is_wp_error($user_id)) {
            update_user_meta($user_id, "phone_num", $phone_num);
        }
    }

    $user = get_user_by('email', $email_user);
    $user_id = -1;
    if ($user) $user_id = $user->ID;
    // store transaction
    $wpdb->insert(
        'yoa_tickets',
        array(
            'user_id' => $user_id,
            'ticket' => $ticket_plan,
            'value' => $ticket_plan_value,
            'count' => $ticket_amount,
            'free' => $ticket_free_value,
            'school' => $school_id,
            'date' => date('Y-m-d H:i:s'),
            'intrepid_checkbox' => $intrepid_check
        )
    );
    $response['insert_id'] = $wpdb->insert_id;
    //////////////////////////////////////////////////////////////////////////////////////////////
     // ticket generating system starts
    global $wpdb;

    $tickets_table = $wpdb->prefix . 'yoa_ticket_number';
    $last_insert = $wpdb->insert_id;
    $current_year = date('Y');
    $total_tickets = $ticket_amount*($ticket_plan + $ticket_free_value);

    $tickets_table = $wpdb->prefix . 'yoa_ticket_number';
    $last_id = $wpdb->get_row( "SELECT MAX(id) FROM $tickets_table",ARRAY_N   );
    $last_ticket = $wpdb->get_row( "SELECT * FROM $tickets_table WHERE id = $last_id[0]");
    $result =   explode('-', $last_ticket->ticket_no);
    if (empty($result[1])) {
        $start = 0;
    } else {
        $start = $result[2];
    }
       
    for ($i=1; $i <= $total_tickets ; $i++) { 
        $generate_ticket = $current_year.'-'.$last_insert.'-'.($start+$i);

          $wpdb->insert(
             $tickets_table,
            array( 
                'yoa_id' => $last_insert,
                'user_id' => $user_id,
                'ticket_no' => $generate_ticket,
                'date' => date('Y-m-d H:i:s')

            )

        );
    }
    
    $ticket_numbers = $wpdb->get_results( "SELECT id FROM $tickets_table WHERE yoa_id = $last_insert" );
       foreach ($ticket_numbers as $key ) {
        //$tickets[] = $key->ticket_no;
        if ($key->id < 10) {
        	$zeros = "00000";
    	} else if ($key->id < 100) {
        	$zeros = "0000";
        } else if ($key->id < 1000) {
        	$zeros = "000";
        } else if ($key->id < 10000) {
        	$zeros = "00";
        } else if ($key->id < 100000) {
        	$zeros = "0";
        };
        
        $tickets[] = $zeros . $key->id;
    }

    $tickets_list = implode(", ", $tickets);
    // tickets generating system ends
    // old tickets count $ticket_amount*($ticket_plan + $ticket_free_value) placed in $tickets_list
    yoa_sendemail_forticketbuy($email_user, $f_name." ".$l_name, $phone_num, $tickets_list, $school_id, yoa_getpagelink_by_slug(YOA_PAGENAME));

    echo json_encode($response);
    die();
}

function yoa_getpagelink_by_slug($slug, $post_type = "page"){
    $permalink = '';

    $args = array(
        'post_type' => $post_type,
        'name'          => $slug,
        'max_num_posts' => 1
    );

    $query = new WP_Query( $args );
    if($query->have_posts()) {
        $query->the_post();
        $permalink = get_permalink( get_the_ID() );
        wp_reset_postdata();
    }
    return $permalink;
}

function yoa_sendemail_forticketbuy($user_email, $user_name, $user_phone, $user_tickets, $school_id, $yoa_page_url) {
    $header = array(
        "From: info@playgroundideas.org",
        "MIME-Version: 1.0",
        "Content-Type: text/html;charset=utf-8"
    );
    $subject = "Your Year of Awesome ticket/s";
    
    if ($school_id > -1) {
    	$email_text = "By buying a ticket, not only are you going into the draw to win one of 15 amazing prizes, but you are also raising money to go towards play resources in your own school or pre-school, whilst supporting communities all over the world to create awesome play spaces for children.";
    } else {
    	$email_text = "By buying a ticket, not only are you going into the draw to win one of 15 amazing prizes, but you are also raising money to support communities all over the world to create awesome play spaces for children.";
	};
	
    $email_content = file_get_contents(YOA_DIR . 'email-ticketbuy.html');
    $email_content_args = array(
        '{{logo_img_url}}' => YOA_URL.'assets/images/playground-ideas-logo.png',
        '{{user_name}}' => $user_name,
        '{{user_phone}}' => $user_phone,
        '{{user_tickets}}' => $user_tickets,
        '{{yoa_page_url}}' => $yoa_page_url,
        '{{email_text}}' => $email_text,
    );

    $message = str_replace(array_keys($email_content_args), array_values($email_content_args), $email_content);

    wp_mail($user_email, $subject, $message, $header);
}