<?php
add_action('init', 'yoa_create_posttype');
function yoa_create_posttype() {
    register_post_type( 'yoa_school',
        // CPT Options
        array(
            'labels' => array(
                'name' => __('YOA SCHOOLS'),
                'singular_name' => __('YOA SCHOOL')
            ),
            'public' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'yoa_school'),
        )
    );
}
add_action('save_post','yoa_save_post_callback', 10, 3);
function yoa_save_post_callback($post_id, $post, $update) {
    if ($post->post_type != 'yoa_school') return;

    $value = site_url(). '/' . YOA_PAGENAME . '/' . sanitize_title($post->post_title) . '/';
    update_post_meta($post_id, 'yoa_ticket_buyurl', $value);
}

add_filter('manage_posts_columns', 'yoa_columns_head');
add_action('manage_posts_custom_column', 'yoa_columns_content', 10, 2);
function yoa_columns_head($defaults) {
    $defaults['ticket_buy_url'] = 'Ticket Buy URL';
    return $defaults;
}

function yoa_columns_content($column_name, $post_ID) {
    if ($column_name == 'ticket_buy_url') {
        echo get_post_meta($post_ID, 'yoa_ticket_buyurl', true);
    }
}

add_action('admin_menu', 'yoa_setup_menu');
 function yoa_setup_menu(){
    add_menu_page( 'Year of Awesome Transactions', 'YOA Transactions', 'manage_options', 'yoa-plugin', 'yoa_init' );
    add_submenu_page( 'yoa-plugin', 'YOA settings', 'Settings',
    'manage_options', 'yoa-plugin-settings','yoa_settings');
}

function yoa_settings()
{
    
     if (isset($_POST['save_ddz_settings']) && $_POST['save_ddz_settings'] == 'save_ddz_settings') {

               
                $settings =get_option( 'ddz_ticket_settings' );
                if (empty($settings)) {
                   add_option( 'ddz_ticket_settings', $_POST['ddz_ticket_settings']);
                } else {
                    update_option( 'ddz_ticket_settings', $_POST['ddz_ticket_settings'] );
                }
                wp_redirect( admin_url('admin.php?page=yoa-plugin-settings'));
                exit();
            }

        ?>
                    <form action="#" method="POST" >

                <div class="row">
                    <div class="col-md-12 card" >
                      <div class="card-body">
                        <h4 class="card-title">Ticket settings</h4>
                       
                          <div class="form-group">
                            <label for="">Show video gallery</label>
                             <input type="text" class="form-control" name="ddz_ticket_settings[stripe_option]"<?php 

                                if (isset($settings["stripe_option"])) {
                                echo ($settings["stripe_option"] == 'on') ? 'checked' : '';
                            }
                              ?>>
                            
                          </div>
                            <div class="form-group">
                            <label for="">Show video gallery</label>
                             <input type="text" class="form-control" name="ddz_ticket_settings[stripe_test]"<?php 

                                if (isset($settings["stripe_test"])) {
                                echo ($settings["stripe_test"] == 'on') ? 'checked' : '';
                            }
                              ?>>
                            
                          </div>
                      </div>
                    </div>
                </div>

            </div>
                <br>
                <div class="container">
                    <div class="row">
                        <button type="submit" name="save_ddz_settings" class="btn btn-primary" value="save_ddz_settings">Submit</button>
                    </div>
                </div>
                 
            </form>

        <?php
}
function yoa_init(){ global $wpdb; ?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.15/r-2.1.1/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.15/r-2.1.1/datatables.min.js"></script>

<style>
#yoa-table th {
    font-weight: bold;
    padding-bottom: 10px;
    padding-left: 10px;
}
#yoa-table_wrapper {
    margin-top: 40px;
}
#yoa-table_length {
    margin-left: 10px;
}
#yoa-table_filter {
    margin-right: 12px;
}
</style>
<script>
jQuery(document).ready(function ($) {
    $('#yoa-table').DataTable( {
        order: [[ 8, "desc" ]],
        columnDefs: [ {
            targets: [ 0 ],
            orderData: [ 0, 1 ]
        }, {
            targets: [ 1 ],
            orderData: [ 1, 0 ]
        }, {
            targets: [ 4 ],
            orderData: [ 4, 0 ]
        } ]
    } );
} );
</script>

<center>
    <h2>Year Of Awesome</h2>
    <h3>Ticket Transactions</h3>
</center>

<table id="yoa-table" class="display widefat fixed" cellspacing="0" style="margin-top: 20px;width: 98%;">
    <thead>
        <tr style="background-color: ghostwhite;">
         <th class="manage-column column-cb check-column" scope="col">Users</th>
         <th class="manage-column column-cb check-column" scope="col">School</th>
         <th class="manage-column column-cb check-column num" scope="col">Each</th>
         <th class="manage-column column-cb check-column num" scope="col">Value</th>
         <th class="manage-column column-cb check-column num" scope="col">Purchased</th>     
         <th class="manage-column column-cb check-column num" scope="col">Free Tickets</th>
         <th class="manage-column column-cb check-column num" scope="col">Total Tickets</th>     
         <th class="manage-column column-cb check-column num" scope="col">Total Cost</th>
         <th class="manage-column column-cb check-column" scope="col">Transaction Date</th>
         <th class="manage-column column-cb check-column" scope="col">Tickets</th>
         <th class="manage-column column-cb check-column" scope="col">Subscribe to Intrepid</th>
        </tr>
    </thead>    
    <tbody><?php
    $yoa_records = $wpdb->get_results ( "SELECT * FROM yoa_tickets ORDER BY 'date' DESC" );

    foreach ($yoa_records as $yoa_record) {
        $school_name = '';
        $yoa_school = $yoa_record->school;
        if ($yoa_school != -1) {
            $sql = "SELECT * FROM ".$wpdb->prefix."posts where ID=$yoa_school";
            $schoolname_result = $wpdb->get_results ($sql);

            $school_name = $schoolname_result[0]->post_title;
        }
        $user_info = get_userdata($yoa_record->user_id);
        $user_email =   $user_info->user_email; ?>
        <tr>
            <td><?php echo $user_email; ?></td>
            <td><?php echo $school_name; ?></td>
            <td class="num" style="color: darkorange;"><?php echo $yoa_record->ticket; ?></td>
            <td class="num" style="color: darkgreen;border-right: 1px dotted gray;"><?php echo "$".$yoa_record->value; ?></td>
            <td class="num" style="color: darkorange;"><?php echo ($yoa_record->ticket*$yoa_record->count); ?></td>
            <td class="num"style="color: darkblue;border-right: 1px dotted gray;"><?php echo "+".$yoa_record->free; ?></td>
            <td class="num" style="color: darkorange;"><?php echo (($yoa_record->ticket*$yoa_record->count)+$yoa_record->free); ?></td>
            <td class="num" style="color: darkgreen;"><?php echo "$".($yoa_record->value*$yoa_record->count); ?></td>
            <td><?php echo date("d-m-Y h:i :s", strtotime($yoa_record->date)); ?></td>
            <td><?php  global $wpdb; $tickets_table = $wpdb->prefix . 'yoa_ticket_number'; 
            $transactiondate = date("Y-m-d h:i :s", strtotime($yoa_record->date));
            //echo $transactiondate; 
            $ticket_numbers = $wpdb->get_results( "SELECT id FROM $tickets_table WHERE yoa_id = $yoa_record->id " );
                   //print_r($ticket_numbers);
               foreach ($ticket_numbers as $key ) {
                echo $key->id.'<br>';
               
                }
             
              ?></td>
            <td class="num" style="color: darkgreen;"><?php echo ($yoa_record->intrepid_checkbox == true) ? "Yes" : "No" ; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>    
<?php } ?>