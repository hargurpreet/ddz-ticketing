<?php
if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    $user_auth = 'email: "' . $current_user->user_email . '",';
} else {
    $user_auth = "";
}
global $TICKET_PRICE_DATA;
?>

<script src="https://checkout.stripe.com/checkout.js" method="POST"></script>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select Tickets</h4>
            </div>
            <div class="modal-body">
                <div class="well-green-modal">
                   
                    <div class="ticket-modal tkt-price-value"></div>
                     <!-- Small button group -->
                    <div class="ticket-select">
                        <select id="ticket-amount">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    
                </div>
                <div class="well-blue-modal">
                    <div class="ticket-modal" style="margin-bottom: 10px;">
                        <div class="fb-share-m">To get your <span class="free-ticket-count">1</span> <span class="free-ticket-text"></span> <span class="free-ticket-price">FREE</span> , Just CLICK >></div>
                         <div class="fb-share-b">
                            <a onclick="share();" style="margin-left: 0px!important;">
                                <img src="<?php echo YOA_URL; ?>assets/images/fb-icon.png"/>
                                <span>Share</span>
                            </a>
                        </div>
                        <div id="wrapper" class="share-check tktcount tc-check-off"><p class="text">Simply click the blue share button on the left and tell your friends about the year of awesome in a post and you will instantly earn extra free tickets. The more tickets you buy the more free tickets you get</p></div>
                    </div>
                    <div class="ticket-sub" style="display: inline-block;width: 100%;">
                        <div class="tcfb-share">Share this competition on Facebook with all your friends and <span class="ticket-sub tkt-sub"></span>.</div>
                       
                      
                    </div>
                </div>
                <div class="modal-terms">
                    <p style="float:left;text-align:left;padding-left:20px;color:grey;">
                        <input id="intrepid-check" type="checkbox" name="intrepid_check" value="0">
                        <span>I would like to hear more from Intrepid Travel</span>
                        <a target="_blank" href="https://www.intrepidtravel.com/?utm_campaign=playground-ideas&utm_medium=inclusion&utm_source=playground-ideas&utm_content=logo">
                            <img src="<?php echo YOA_URL; ?>assets/images/intrepid-logo.png" style="width:36px; float:right !important; text-align:right !important; position: absolute; right: 20px; bottom: 24px;">
                        </a>
                    </p>
                </div>
            </div><!-- modal-body -->
            <div class="modal-footer">
                <div class="footer-modal-text">
                    <span>QTY: <span id="total-tkts">1</span><span class="tkt-free-case"></span><span id="total-tkts-label"></span>
                </div>
                <div class="modal-ticket-button">
                    <span class="footer-total-price">Total = A$<span class="tkt-total"></span>.00</span>
                    <button id="next-button" type="button" class="btn btn-lg btn-success"><strong>NEXT</strong></button>
                    <div id="yoa-user-info-form">
                        <div id="step-fields">
                            <div class="row">
                                <div class="col-sm-6"><input class="step-fields" id="step-fname" type="text" name="step-fname" placeholder="First name"/></div>
                                <div class="col-sm-6"><input class="step-fields" id="step-lname" type="text" name="step-lname" placeholder="Last name"/></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6"><input class="step-fields" id="step-email" type="email" name="step-email" placeholder="Email address"/></div>
                                <div class="col-sm-6"><input class="step-fields" id="step-number" type="tel" name="step-number" placeholder="Phone number"/></div>
                            </div>
                            <div class="pay-div">
                                <button id="step-back" type="button" class="btn btn-lg pull-left"><strong>BACK</strong></button>
                                <button id="stripe-button" type="button" class="btn btn-lg btn-success pull-right"><strong>PROCEED TO CHECKOUT</strong></button>
                                <div style="clear:both;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- modal-footer -->
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>
<script>
jQuery(document).ready(function ($) {

    hideMyModal();

    function hideMyModal() {
        $("#myModal").removeClass("in in_pay");
        $(".modal-backdrop").remove();
        $('body').removeClass('modal-open');
        $('body').css('padding-right', '');
        $("#myModal").hide();

        $('#yoa-user-info-form').hide();
        $('#next-button').show();
        $('.modal-body').css({
            'overflow': 'auto',
            'padding': '15px',
            'height': 'initial'
        });
    }

    function isValidEmailAddress(emailAddress) {
        if (emailAddress == '')
            return false;
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    }

    // close by overlay
    $("#myModal").click(function (event) {
        if (!$(event.target).closest('.modal-dialog').length) {
            event.stopImmediatePropagation();
        }
    });

    // close by X
    $(".modal-header .close").click(function () {
        hideMyModal();
    });

    //interpid checkbox 
     $('#intrepid-check').on('click', function () {
        $(this).val(this.checked ? 1 : 0);          
    });

    // show step form
    $('#next-button').on('click', function (e) {
        $("#myModal").addClass("in_pay");
        $('#yoa-user-info-form').show();
        $("#next-button").hide();
        $('.modal-body').css({
            'overflow': 'hidden',
            'padding': '0px 15px'
        }).animate({height: '0px'});
    });

    // back step form
    $('#step-back').on('click', function (e) {
        $("#myModal").removeClass("in_pay");
        $('#yoa-user-info-form').hide();
        $('#next-button').show();
        $('.modal-body').css({
            'overflow': 'auto',
            'padding': '15px',
            'height': 'initial'
        });
    });

    $('#stripe-button').on('click', function (e) {
        var isFormValid = true;

        if ($("#step-fname").val() === ""){
            isFormValid = false;
            $("#step-fname").attr('style', "border: 1px solid red!important");
        }
        if ($("#step-lname").val() === ""){
            isFormValid = false;
            $("#step-lname").attr('style', "border: 1px solid red!important");
        }
        if ($("#step-number").val() === ""){
            isFormValid = false;
            $("#step-number").attr('style', "border: 1px solid red!important");
        }

        var email = $("#step-email").val();
        if (!isValidEmailAddress(email)) {
            isFormValid = false;
            $("#step-email").attr('style', "border: 1px solid red!important");
        }

        if (!isFormValid) {
            setTimeout(function () {
                $("#step-fname, #step-lname, #step-number, #step-email ").removeAttr('style');
            }, 1000);
            return;
        }
        /////////////////////////////////////////////////////////////////////////////////
        hideMyModal();

        // {"1": "5", "5": "25", "8": "40"}
        var TICKET_PRICE_DATA = JSON.parse('<?php echo json_encode($TICKET_PRICE_DATA); ?>');

        var ticket_plan = jQuery("#tkt-id").html(); // 1, 5, 8
        var amount = $("#ticket-amount").val(); // from select box 1~9
        var price = TICKET_PRICE_DATA[ticket_plan];

        $("#strp-plan").attr("value", ticket_plan);
        $("#strp-amount").attr("value", amount);
        var freetkt = $("#strp-free").attr("value");
        

        // Open Checkout with further options:
        handler.open({
            <?php echo $user_auth; ?>
            name: "Secure Payment by Stripe",
            description: amount + " x " + ticket_plan + " Ticket" + ((ticket_plan > 1)?"s":"") + " for $" + price + ".00 Each" + ' +' + freetkt + ' Free',
            amount: parseInt(amount * price + "00"),
            currency: "AUD"
        });
        e.preventDefault();
    });

    // Ajax Stripes Core
    // Close Checkout on page navigation:
    window.addEventListener('popstate', function () {
        handler.close();
    });

    var handler = StripeCheckout.configure({
        //key: 'pk_test_oi8zQmvNxD3fK4Pv6s3OOHR5',
        key: 'pk_live_cPUrnS9qUhWL5V2yaBtzpHyX',
        image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
        locale: 'auto',
        token: function (token) {
            //console.log(token);

            var ticket_plan = $("#strp-plan").val();
            var ticket_amount = $("#strp-amount").val();
            var ticket_free = $("#strp-free").val();

            var fname = $("#step-fname").val();
            var lname = $("#step-lname").val();
            var email = $("#step-email").val();
            var phone = $("#step-number").val();
            var intrepid = $("#intrepid-check").attr("value");
            jQuery.ajax({
                method: "POST",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {
                    action: 'store_transaction',
                    f_name: fname,
                    l_name: lname,
                    email_user: email,
                    phone_user: phone,
                    school_id: '<?php echo $yoa_school_id; ?>',
                    token_id: token.id,
                    token_email: token.email,
                    ticket_plan: ticket_plan,
                    ticket_amount: ticket_amount,
                    ticket_free: ticket_free,
                    intrepid_check : intrepid
                },
                success: function (data) {
                    //console.log(data);
                    data = JSON.parse(data);
                    if (data.charge_status == 'success')
                        setcookie('yaos',null);
                        window.location.href = '<?php echo get_site_url(); ?>/thank-you-for-your-payment/';
                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });
        },
        closed: function () {
            hideMyModal();
        }
    });
});
</script>
<input id="strp-plan" type="hidden" name="count-e" value="1">
<input id="strp-amount" type="hidden" name="value-e" value="5">
<input id="strp-free" type="hidden" name="free" value="0">
