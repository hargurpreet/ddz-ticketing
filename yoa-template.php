<?php
function isIphone($user_agent=NULL) {
    if(!isset($user_agent)) {
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    }  
    if ((strpos($user_agent, 'Chrome') || strpos($_SERVER['HTTP_USER_AGENT'], 'CriOS')) && (strpos($user_agent, 'iPad') || strpos($user_agent, 'iPhone'))) {
        return true;
    } 
}

if (isIphone() == true) {
    ?>
    <style type="text/css">
        html, body{
            background: #fff;
        }
    </style>
    <div class="container awesome-navbar">
        <a href="<?php //echo get_site_url() ?>">
            <img src="<?php echo YOA_URL; ?>assets/images/playground-ideas-logo.png" class="nav-left"></a>
        <p class="major-sponsor">
            <span>Major Sponsor</span>
            <img src="<?php echo YOA_URL; ?>assets/images/intrepid-logo.png" class="nav-right">
        </p>
    </div>
    <div class="first-header-row">
        <div class="container">
            <img src="<?php echo YOA_URL; ?>assets/images/year-of-awesome-special-font.png" class="awesome-header-font">
        </div>
    </div>

    <div class="container text-center">
        <div class="row">
            <h2>Looking for the Year Of Awesome website?</h2>
            <p>Please open <span style="font-size: 23px; font-weight: bold; color: #DF287D;" >Safari</span> and go to <span style="font-size: 23px; font-weight: bold; color: #DF287D;" >myyearofawesome.org</span></p>
        <p>(Unfortunately Chrome isn't awesome enough for our website).</p>
        </div>
    </div>

    <?php
    die();
}
global $TICKET_PRICE_DATA;
$yoa_school = get_query_var('yoa_school_name');
$yoa_school_id = -1;
$current_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


if (isset($_POST) && $_POST['send'] == 'yoa_send') {
    $user_email = $_POST['user_email'];
    $user_message = sanitize_text_field($_POST['user_message']);
     $header = array(
        "From: info@playgroundideas.org",
        "MIME-Version: 1.0",
        "Content-Type: text/html;charset=utf-8"
    );
    $subject = "Year of Awesome";
    $message = "<p>Hey,</p> 
    <p>check out the year of awesome prizes. Absolutely amazing!</p> <p>And it all raises funds to get kids playing around the world to improve their development</p><p>I just bought a ticket, check it out here : http://www.myyearofawesome.org </p><p>".$user_message."</p><p> See you soon</p>";
    wp_mail( $user_email, $subject, $message, $header );
    wp_redirect( home_url().'/year-of-awesome/?success=1' );
    exit();
}
$yoa_sucess = $_GET['success'];
if ($yoa_sucess ) {
   ?>
   <style type="text/css">
       .alert {
            padding: 20px;
            background-color: #df287d;
            color: white;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }
   </style>
   <div class="alert">
      <span class="closebtn" onclick="close_message()" >&times;</span> 
      <strong>Email </strong>sent sucessfully.
    </div>
   <?php
}



$args = array(
    'post_type'      => 'yoa_school',
    'meta_query' => array(
        array(
            'key' => 'yoa_ticket_buyurl',
            'value' => $current_url,
            'compare' => '='
        ),
    ),
    'posts_per_page' => 1,
);
$res = new WP_Query($args);
if ($res->have_posts()) {
    $res->the_post();
    $yoa_school_id = get_the_ID();
    $yoa_school_title = get_the_title( );
    wp_reset_postdata();
}

if ($yoa_school != "" && $yoa_school_id == -1) {
    global $wp_query;
    $wp_query->set_404();
    status_header( 404 );
    get_template_part( 404 );
    exit();
}

?>
<header class="menu"></header>
<div class="container awesome-navbar">
    <a href="<?php echo get_site_url() ?>">
        <img src="<?php echo YOA_URL; ?>assets/images/playground-ideas-logo.png" class="nav-left"></a>
    <p class="major-sponsor">
        <span>Major Sponsor</span>
        <img src="<?php echo YOA_URL; ?>assets/images/intrepid-logo.png" class="nav-right">
    </p>
</div>

<div class="first-header-row">
    <div class="container">
        <img src="<?php echo YOA_URL; ?>assets/images/year-of-awesome-special-font.png" class="awesome-header-font">
    </div>
    <?php 
    if ($yoa_school_title) {
      ?>
    <div class="school-name">
        <h3><?php echo $yoa_school_title; ?>'s Page</h3>
    </div>
      <?php
    }
    ?>
    
    <div class="container button-row">
        <button type="button" class="btn btn-lg btn-success tkt-scroll"><strong>ENTER NOW</strong></button>
        <button id="PrizeButton" type="button" class="PrizeButton btn btn-lg btn-default sini"><strong>VIEW PRIZES</strong></button>
        <button id="WhyButton" type="button" class="btn btn-lg btn-default"><strong>WHY?</strong></button>
    </div>
</div>

<div class="header-slider-wrapper">
    <div class="slider-tag">#experiences<span class="strike-text">not</span>stuff</div>
    <div id="header-slider">
        <div class="slider-item">
            <div class="slider-ticket">
                <img src="<?php echo YOA_URL; ?>assets/images/slider-image-ticket-2.png" alt="Interepid">
            </div>
            <img src="<?php echo YOA_URL; ?>assets/images/slider-image-2.jpg">
            <p class="slider-text">1st Prize: Intrepid Travel Family Adventure to Vietnam</p>
        </div>
        <div class="slider-item">
            <div class="slider-ticket">
                <img src="<?php echo YOA_URL; ?>assets/images/slider-image-ticket-2.png" alt="Interepid">
            </div>
            <img src="<?php echo YOA_URL; ?>assets/images/slider-image-3.jpg">
            <p class="slider-text">2nd Prize: Intrepid Travel Victorian Family Adventure Loop</p>
        </div>
        <div class="slider-item">
            <div class="slider-ticket">
                <img src="<?php echo YOA_URL; ?>assets/images/lakeshore-logo.png" alt="Lakeshore house">
            </div>
            <img src="<?php echo YOA_URL; ?>assets/images/slider-image-4.jpg">
            <p class="slider-text">3rd Prize: Lakeshore House, Daylesford</p>
        </div>
        <div class="slider-item">
            <div class="slider-ticket">
                <img src="<?php echo YOA_URL; ?>assets/images/wander-logo.png" alt="Wanderlings">
                <img src="<?php echo YOA_URL; ?>assets/images/slider-image-ticket-4.png" alt="Peninsula Hot Springs">
            </div>
            <img src="<?php echo YOA_URL; ?>assets/images/slider-image-5.jpg">
            <p class="slider-text">4th Prize: Wanderlings Airstream and Peninsula Hot Springs Family weekend</p>
        </div>
        <div class="slider-item">
            <div class="slider-ticket">
                <img src="<?php echo YOA_URL; ?>assets/images/gorci-logo.png"
                     alt="Great ocean road and chocolaterie">
                <img src="<?php echo YOA_URL; ?>assets/images/big4-logo.png" alt="Big4">
            </div>
            <img src="<?php echo YOA_URL; ?>assets/images/slider-image-6.jpg">
            <p class="slider-text">5th Prize: Great Ocean Road Chocolaterie & Ice creamery and Big 4 Anglesea Holiday Park</p>
        </div>
        <div class="slider-item">
            <div class="slider-ticket">
                <img src="<?php echo YOA_URL; ?>assets/images/slow-logo.png" alt="Slow clay centre">
            </div>
            <img src="<?php echo YOA_URL; ?>assets/images/slider-image-7.jpg">
            <p class="slider-text">6th Prize: Slow Clay</p>
        </div>
        <div class="slider-item">
            <div class="slider-ticket">
                <img src="<?php echo YOA_URL; ?>assets/images/ArtCentreMelbourne-white.png" width="80" alt="Arts Centre ‘The Unbelievables’">
            </div>
            <img src="<?php echo YOA_URL; ?>assets/images/slider-image-8.jpg">
            <p class="slider-text">7th Prize: Arts Centre ‘The Unbelievables’ show</p>
        </div>
        <div class="slider-item">
            <div class="slider-ticket">
                <img src="<?php echo YOA_URL; ?>assets/images/zoos-logo.png" alt="Zoos VICTORIA">
            </div>
            <img src="<?php echo YOA_URL; ?>assets/images/slider-image-9.jpg">
            <p class="slider-text">8th Prize: Zoos Victoria Family Membership</p>
        </div>
        <div class="slider-item">
            <div class="slider-ticket">
                <img src="<?php echo YOA_URL; ?>assets/images/circus-logo.png" alt="Circus OZ">
            </div>
            <img src="<?php echo YOA_URL; ?>assets/images/slider-image-10.jpg">
            <p class="slider-text">9th Prize: Circus Oz</p>
        </div>
        <div class="slider-item">
            <div class="slider-ticket">
                <img src="<?php echo YOA_URL; ?>assets/images/enchanted-logo.png" alt="Enchanted Adventure Garden">
            </div>
            <img src="<?php echo YOA_URL; ?>assets/images/slider-image-11.jpg">
            <p class="slider-text">10th Prize: Enchanted Adventure Garden</p>
        </div>
        <div class="slider-item">
            <div class="slider-ticket">
                <img src="<?php echo YOA_URL; ?>assets/images/nica-logo.png" alt="National Institute of Circus Arts">
            </div>
            <img src="<?php echo YOA_URL; ?>assets/images/slider-image-12.jpg">
            <p class="slider-text">11th Prize: National Institute of Circus Arts (NICA)</p>
        </div>
        <div class="slider-item">
            <div class="slider-ticket">
                <img class="victoria-logo" src="<?php echo YOA_URL; ?>assets/images/victoria-logo.png" alt="Museums Victoria Family Membership">
            </div>
            <img src="<?php echo YOA_URL; ?>assets/images/slider-image-13.jpg">
            <p class="slider-text">12th Prize: Museums Victoria Family Membership</p>
        </div>
        <div class="slider-item">
            <div class="slider-ticket">
                <img src="<?php echo YOA_URL; ?>assets/images/mariner-logo.png" alt="Marriner Theatre’s Priscilla Queen of the Desert">
            </div>
            <img src="<?php echo YOA_URL; ?>assets/images/slider-image-14.jpg">
            <p class="slider-text">Plus Bonus Prize: Marriner Theatre’s Priscilla Queen of the Desert</p>
        </div>
        <div class="slider-item">
            <div class="slider-ticket">
                <img src="<?php echo YOA_URL; ?>assets/images/chunky-logo.png" alt="Chunky Move">
            </div>
            <img src="<?php echo YOA_URL; ?>assets/images/slider-image-15.jpg">
            <p class="slider-text">Plus Bonus Prize: Chunky Move</p>
        </div>
        <div class="slider-item">
            <div class="slider-ticket">
                <img src="<?php echo YOA_URL; ?>assets/images/slider-image-ticket-1.png">
            </div>
            <img src="<?php echo YOA_URL; ?>assets/images/slider-image-1.jpg" alt="Slide 1">
            <p class="slider-text">Plus Bonus Prize: Melbourne Street Art Tours</p>
        </div>
    </div>
</div>

<div class="tickets-row open-sans">
    <div class="container">
       
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="green-well">
                            <h3>1 Ticket for <span class="ticket-price">$<?php echo $TICKET_PRICE_DATA[YOA_TICKET_PLAN1]; ?></span></h3>
                            <div class="blue-ticket-bar"><p class="blue-ticket-p">+ up to 1 more ticket FREE</p></div>
                            <div class="sub-ticket-p">Save $5</div>
                            <div class="ticket-button">
                                <button type="button" class="btn btn-lg btn-success tkt-button"
                                        data-toggle="modal" data-target="#myModal" tktb-free="<?php echo YOA_FREE_ONE; ?>" tktb-count="<?php echo YOA_TICKET_PLAN1; ?>" tktb-value="<?php echo $TICKET_PRICE_DATA[YOA_TICKET_PLAN1]; ?>">
                                    <strong>BUY TICKET</strong>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="green-well">
                            <h3>5 Tickets for <span class="ticket-price">$<?php echo $TICKET_PRICE_DATA[YOA_TICKET_PLAN2]; ?></span></h3>
                            <div class="blue-ticket-bar"><p class="blue-ticket-p">+ up to 3 more tickets FREE</p></div>
                            <div class="sub-ticket-p">Save $15</div>
                            <div class="ticket-button">
                                <button type="button" class="btn btn-lg btn-success tkt-button"
                                        data-toggle="modal" data-target="#myModal" tktb-free="<?php echo YOA_FREE_THREE; ?>" tktb-count="<?php echo YOA_TICKET_PLAN2; ?>" tktb-value="<?php echo $TICKET_PRICE_DATA[YOA_TICKET_PLAN2]; ?>">
                                    <strong>BUY TICKETS</strong>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="pink-well">
                            <div style="position: absolute; left: 50%; top:0px;">
                                <div style="position: relative; left: -50%;"><div class="top-flag sini">GOOD DEAL!</div></div>
                            </div>
                            <h3>8 Tickets for <span class="ticket-price">$<?php echo $TICKET_PRICE_DATA[YOA_TICKET_PLAN3]; ?></span></h3>
                            <div class="pink-ticket-bar"><p class="blue-ticket-p">+ up to 5 more tickets FREE</p></div>
                            <div class="sub-ticket-p">Save $25</div>
                            <div class="ticket-button">
                                <button type="button" class="btn btn-lg btn-success tkt-button"
                                        data-toggle="modal" data-target="#myModal" tktb-free="<?php echo YOA_FREE_FIVE; ?>" tktb-count="<?php echo YOA_TICKET_PLAN3; ?>" tktb-value="<?php echo $TICKET_PRICE_DATA[YOA_TICKET_PLAN3]; ?>">
                                    <strong>BUY TICKETS</strong>
                                </button>
                            </div>
                        </div>
                    </div>

            
            <!-- <div id="arrowL"></div>
            <div id="arrowR"></div> -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="share-buttons-block text-center">
                        <a class="yoa-shares-fb" onclick="share();" style="margin-right:4px;"><i class="fa fa-facebook" aria-hidden="true"></i>Share</a>
                       <a class="yoa-shares-tw" target="_blank" href="https://twitter.com/share/?text=Amazing%20prizes%20and%20awesome%20cause.%20Check%20it%20out%20here"
                           onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=480,width=600');return false;">
                            <i class="fa fa-twitter" aria-hidden="true"></i>Tweet
                        </a>
                         <!--  <a target="_blank" id="share-mail" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=480,width=600');return false;" class="yoa-shares-email" href=""><i class="fa fa-envelope" aria-hidden="true"></i>Email</a> -->
                       <a id="share-mail" class="yoa-shares-email" href="#"><i class="fa fa-envelope" aria-hidden="true"></i>Email</a>
                    </div>
                </div>
            </div>
            <!-- Email Area -->
             <div class="row" id="show-email" >
                <div class="">
                    <form action="#" method="POST">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" name="user_email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Your Message</label>
                        <textarea placeholder="Your message" name="user_message" class="form-control" rows="3"></textarea>
                      </div>
                      <button type="submit" name="send" class="btn btn-primary" value="yoa_send" >Send Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="timeline-row open-sans competition-prizes-wrapper">
        <div class="container yoa-space">
            <div class="row">
                <div class="col-md-12">
                    <h2>Competition Prizes</h2>
                    <p>Life is about experiences, not stuff and we’ve got 12 awesome prizes designed to bring families
                        together to have PLAYful adventures they won’t forget - one for every month of the year! As the
                        pace of life spins faster, we want to provide a way for families to reconnect, slow down and
                        make space to just be. The Year of Awesome is our little way of prompting us all to remember
                        that we only have one life and we need to get out and experience it before our kids start doing
                        it without us :) Buy tickets for a chance to win one of these amazing experiences. Share on
                        Facebook and get free tickets. And click here to find out more about how Playground Ideas
                        creates awesome experiences for kids.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="competition-prize-item">
                        <div class="competition-lable">1st PRIZE</div>
                        <img src="<?php echo YOA_URL; ?>assets/images/competition-1.jpg" alt="Intrepid Travel Family Adventure to Vietnam">
                        <h3>Intrepid Travel Family Adventure to Vietnam</h3>
                        <p>Experience the wonders of Vietnam on a 9 day family adventure (2 adults &amp; 2 children) with Intrepid Travel, valued at $10,441.</p>
                        <a href="#" class="prize-button 1">View experience</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="competition-prize-item">
                        <div class="competition-lable">2nd PRIZE</div>
                        <img src="<?php echo YOA_URL; ?>assets/images/competition-2.jpg" alt="Intrepid Travel Victorian Family Adventure Loop">
                        <h3>Intrepid Travel Victorian Family Adventure Loop</h3>
                        <p>Experience a 3 day Melbourne to Melbourne family Adventure Loop for 2 adults &amp; 2 children, via the Great Ocean Road and the Grampians, valued at $2,176.</p>
                        <a href="#" class="prize-button 2">View experience</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="competition-prize-item">
                        <div class="competition-lable">3rd PRIZE</div>
                        <img src="<?php echo YOA_URL; ?>assets/images/competition-3.jpg" alt="Lakeshore House, Daylesford">
                        <h3>Lakeshore House, Daylesford</h3>
                        <p>Enjoy a luxury lakeside weekend getaway for up to 8 people in Lakeshore House, valued at $1700.</p>
                        <a href="#" class="prize-button 3">View experience</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="competition-prize-item">
                        <div class="competition-lable">4th PRIZE</div>
                        <img src="<?php echo YOA_URL; ?>assets/images/competition-4.jpg" alt="Wanderlings Airstream and Peninsula Hot Springs Family weekend">
                        <h3>Wanderlings Airstream and Peninsula Hot Springs Family weekend</h3>
                        <p>Experience a unique getaway in a Wanderlings Airstream &amp; relax together in the Peninsula Hot Springs, valued at $650.</p>
                        <a href="#" class="prize-button 4">View experience</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="competition-prize-item">
                        <div class="competition-lable">5th PRIZE</div>
                        <img src="<?php echo YOA_URL; ?>assets/images/competition-5.jpg" alt="Great Ocean Road Chocolaterie &amp; Ice creamery and Big 4 Anglesea Holiday Park">
                        <h3>Great Ocean Road Chocolaterie &amp; Ice creamery and Big 4 Anglesea Holiday Park</h3>
                        <p>Enjoy a beach holiday at Anglesea Big 4 Holiday Park and visit the Chocolaterie for a kids chocolate making course, valued at $580.</p>
                        <a href="#" class="prize-button 5">View experience</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="competition-prize-item">
                        <div class="competition-lable">6th PRIZE</div>
                        <img src="<?php echo YOA_URL; ?>assets/images/competition-6.jpg" alt="Slow Clay">
                        <h3>Slow Clay</h3>
                        <p>Learn together in a private family ceramics class with Slow Clay, valued at $450.</p>
                        <a href="#" class="prize-button 6">View experience</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="competition-prize-item">
                        <div class="competition-lable">7th PRIZE</div>
                        <img src="<?php echo YOA_URL; ?>assets/images/competition-7.jpg" alt="Arts Centre">
                        <h3>Arts Centre</h3>
                        <p>Win family tickets to see ‘The Unbelievables’ show at Hamer Hall, valued at $276.</p>
                        <a href="#" class="prize-button 7">View experience</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="competition-prize-item">
                        <div class="competition-lable">8th PRIZE</div>
                        <img src="<?php echo YOA_URL; ?>assets/images/competition-8.jpg" alt="Zoos Victoria Family Membership">
                        <h3>Zoos Victoria Family Membership</h3>
                        <p>Annual family membership to the Melbourne Zoo, Healesville Sanctuary and Werribee Open Range zoo, valued at $216.</p>
                        <a href="#" class="prize-button 8">View experience</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="competition-prize-item">
                        <div class="competition-lable">9th PRIZE</div>
                        <img src="<?php echo YOA_URL; ?>assets/images/competition-9.jpg" alt="Circus Oz">
                        <h3>Circus Oz</h3>
                        <p>Learn, laugh and leap in a family circus experience with Circus Oz, valued at $120.</p>
                        <a href="#" class="prize-button 9">View experience</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="competition-prize-item">
                        <div class="competition-lable">10th PRIZE</div>
                        <img src="<?php echo YOA_URL; ?>assets/images/competition-10.jpg" alt="Enchanted Adventure Garden">
                        <h3>Enchanted Adventure Garden</h3>
                        <p>Family day out to explore the wonders of the Mornington Peninsula’s Enchanted Adventure Garden, valued at $100.</p>
                        <a href="#" class="prize-button 10">View experience</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="competition-prize-item">
                        <div class="competition-lable">11th PRIZE</div>
                        <img src="<?php echo YOA_URL; ?>assets/images/competition-11.jpg" alt="National Institute of Circus Arts (NICA)">
                        <h3>National Institute of Circus Arts (NICA)</h3>
                        <p>Family tickets to see the final year NICA students ensemble show, valued at $83.</p>
                        <a href="#" class="prize-button 11">View experience</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="competition-prize-item">
                        <div class="competition-lable">12th PRIZE</div>
                        <img src="<?php echo YOA_URL; ?>assets/images/competition-12.jpg" alt="Museums Victoria Family Membership">
                        <h3>Museums Victoria Family Membership</h3>
                        <p>Annual family membership to the Melbourne Museum, Scienceworks and the Immigration Museum, valued at $79.</p>
                        <a href="#" class="prize-button 12">View experience</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="bonus-prizes">Plus Bonus Prizes (without the kids!)</h2>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="competition-prize-item competition-bonus-item">
                        <h3>Marriner Theatre’s Priscilla Queen of the Desert</h3>
                        <p>Take your date nights up a notch with 2 VIP passes to Priscilla Queen of the Desert, Regent Theatre, valued at $410.</p>
                        <a href="#" class="prize-button 13">View experience</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="competition-prize-item competition-bonus-item">
                        <h3>Chunky Move</h3>
                        <p>Learn to dance with Chunky Move’s Beginner Dance four week course for two, valued at $176.</p>
                        <a href="#" class="prize-button 14">View experience</a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="competition-prize-item competition-bonus-item">
                        <h3>Melbourne Street Art Tours</h3>
                        <p>Take a friend and be led on a tour of Melbourne’s Street Art, valued at $138.</p>
                        <a href="#" class="prize-button 15">View experience</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="why-row open-sans">
        <div class="container" id="WhyButton-wrapper">
            <h2>Why are we doing this?</h2>
            <!-- <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Donec sed odio dui. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Donec sed odio dui. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.</p> -->
            <p><a href="<?php echo site_url(); ?>" target="_blank">Playground Ideas</a> is an Australian non-profit committed to seeing the world’s children
                thrive. Right now, 250 million children under 5 lack the adequate stimulation needed to reach their full
                development potential and we are here to change that. Play based stimulation in early childhood is the
                most powerful tool to build children’s brains which dramatically increases educational and long term
                life outcomes. It also has the side effect of making children much happier :) So far, we have supported
                1885 communities in 143 countries to build stimulating play spaces, using locally sourced and recycled
                materials.</p>
        </div>
    </div>
    <div class="sponsor-row open-sans">
        <div class="container">
            <h2>Major Sponsor</h2>
            <a target="_blank" href="https://www.intrepidtravel.com/?utm_campaign=playground-ideas&utm_medium=inclusion&utm_source=playground-ideas&utm_content=logo"><img src="<?php echo YOA_URL; ?>assets/images/intrepid-white.png" class="sponsor-main"></a>
            <h4>Supported By</h4>
            <div class="container">
                <div class="row seven-cols">
                    <div class="col-md-12">
                        <div class="brand-wrapper">
                            <a target="_blank" href="https://www.lakeshorehouse.com.au/"><img src="<?php echo YOA_URL; ?>assets/images/lakeshore-logo.png"></a>
                            <a target="_blank" href="http://wanderlings.com.au/"><img src="<?php echo YOA_URL; ?>assets/images/wander-logo.png"></a>
                            <a target="_blank" href="https://www.peninsulahotsprings.com/"><img src="<?php echo YOA_URL; ?>assets/images/hot-springs-white.png" style="width: 50px"></a>
                            <a target="_blank" href="https://www.gorci.com.au/"><img src="<?php echo YOA_URL; ?>assets/images/gorci-logo.png"></a>
                            <a target="_blank" href="https://www.big4.com.au/"><img src="<?php echo YOA_URL; ?>assets/images/big4-logo.png"></a>
                            <a target="_blank" href="https://www.slowclay.com/"><img src="<?php echo YOA_URL; ?>assets/images/slow-logo.png"></a>
                            <a target="_blank" href="https://www.artscentremelbourne.com.au/"><img src="<?php echo YOA_URL; ?>assets/images/ArtCentreMelbourne-white.png" style="width: 100px"></a>
                            <a target="_blank" href="https://www.zoo.org.au/"><img src="<?php echo YOA_URL; ?>assets/images/zoos-logo.png"></a>
                            <a target="_blank" href="http://www.circusoz.com/"><img src="<?php echo YOA_URL; ?>assets/images/circus-logo.png"></a>
                            <a target="_blank" href="http://www.enchantedmaze.com.au/"><img src="<?php echo YOA_URL; ?>assets/images/enchanted-logo.png"></a>
                            <a target="_blank" href="http://www.nica.com.au/"><img src="<?php echo YOA_URL; ?>assets/images/nica-logo.png"></a>
                            <a target="_blank" href="https://museumsvictoria.com.au/"><img class="victoria-logo" src="<?php echo YOA_URL; ?>assets/images/victoria-logo.png"></a>
                            <a target="_blank" href="https://marrinergroup.com.au/shows/priscilla-queen-of-the-desert"><img src="<?php echo YOA_URL; ?>assets/images/mariner-logo.png"></a>
                            <a target="_blank" href="http://chunkymove.com.au/"><img src="<?php echo YOA_URL; ?>assets/images/chunky-logo.png"></a>
                            <a target="_blank" href="https://melbournestreettours.com/"><img src="<?php echo YOA_URL; ?>assets/images/mst-logo.png"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="prize-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="open-sans prize-text">
                        <h2>Competition Prize Details</h2>
                    </div>
                </div>
                <div class="col-md-12" id="prize-wrapper-1">
                    <div class="prize-details-item">
                        <p class="title"><a target="_blank" href="https://www.intrepidtravel.com/vietnam/vietnam-active-family-holiday-101888/?utm_campaign=playground-ideas&utm_medium=inclusion&utm_source=playground-ideas&utm_content=trip" style="color: #df287d;">1st Prize: Intrepid Travel Vietnam Family Adventure for two adults and two
                                children.<span class="prize-price"> Valued at $10,441.</span></a></p>
                        <p>With so much to share and do together, you’ll experience the culture, flavours and highlights
                            of a Vietnamese adventure your family will always remember. Starting in Hanoi, uncover
                            Vietnam’s landmark attractions on a city cycling tour and sit down to lunch at an initiative
                            geared towards helping street children. Savour the picturesque countryside of rural Vietnam
                            during a two-day ride from Luong Song to stunning Ninh Binh, cruise the waters of Halong Bay
                            by junk boat and kayak, and explore charming Hoi An and its surrounds by bike and foot.
                            Experience this once in a lifetime 9 day trip for your family, including flights and
                            accommodation.</p>
                        <p>Intrepid Travel’s small group style of travel means you’ll stay under the radar, and travel,
                            eat and sleep the local way. You’ll have the unsurpassed knowledge of a local leader, taking
                            you out of the guidebooks and into a world you’re waiting to discover.</p>
                        <p>Intrepid Travel is a proud member of the Intrepid Group, the global leader in delivering
                            sustainable, experience rich travel.</p>
                    </div>
                </div>
                <div class="col-md-12" id="prize-wrapper-2">
                    <div class="prize-details-item">
                        <p class="title"><a target="_blank" href="https://www.intrepidtravel.com/australia/melbourne-melbourne-adventure-loop-original-103384/?utm_campaign=playground-ideas&utm_medium=inclusion&utm_source=playground-ideas&utm_content=melbourne-trip" style="color: #df287d;">2nd Prize: Intrepid Travel Melbourne to Melbourne Adventure Loop for two adults
                                and two children.<span class="prize-price"> Valued at $2,176.</span></a></p>
                        <p>Enjoy a three day family adventure down the Great Ocean Road, see the Twelve Apostles, Loch
                            Ard Gorge and wind through the Otways to hike the Mackenzie Falls, the Pinnacles, The
                            Balconies and Reeds Lookout. Learn about the history and customs of the Grampians
                            traditional owners at the Brambuk Aboriginal Cultural Centre before returning back to
                            Melbourne.</p>
                        <p>Intrepid Travel’s small group style of travel means you’ll stay under the radar, and travel,
                            eat and sleep the local way. You’ll have the unsurpassed knowledge of a local leader, taking
                            you out of the guidebooks and into a world you’re waiting to discover.</p>
                        <p>Intrepid Travel is a proud member of the Intrepid Group, the global leader in delivering
                            sustainable, experience rich travel.</p>
                    </div>
                </div>
                <div class="col-md-12" id="prize-wrapper-3">
                    <div class="prize-details-item">
                        <p class="title"><a target="_blank" href="https://www.lakeshorehouse.com.au/" style="color: #df287d;">3rd Prize: Lakeshore House, Daylesford - luxury lakeside getaway for 8
                                people.<span class="prize-price"> Valued at $1,700.</span></a></p>
                        <p>Spend a luxurious two night stay in the beautifully appointed Lakeshore House with up to 8
                            friends and family. Sitting at the edge of Lake Daylesford, this post war home on a large
                            block lends itself to families enjoying time together, playing, relaxing and experiencing
                            all that the area has to offer. Step out through the back fence and explore the Great Divide
                            Trekking Trail and Peace Mile walking tracks or enjoy the benefits of the area’s Mineral
                            Springs.</p>
                        <p>Lakeshore House is beautifully appointed and set in extensive landscaped gardens. Split over
                            three floors, the house provides all you need for a getaway with friends and family,
                            furnished with an eye for stylish and livable country comfort. Views through large picture
                            windows take in the lake, bushland and Wombat Hill. Lakeshore House provides a serene oasis
                            in the heart of the main tourist precinct.</p>
                    </div>
                </div>
                <div class="col-md-12" id="prize-wrapper-4">
                    <div class="prize-details-item">
                        <p class="title"><a target="_blank" href="http://wanderlings.com.au/" style="color: #df287d;">4th Prize: Wanderlings Airstream Trailer and Peninsula Hot Springs Family
                                weekend away.<span class="prize-price"> Valued at $650.</span></a></p>
                        <p>Enjoy two nights staying in the cosy comforts of ‘Peggy Sue’, a 1966 Airstream with an open,
                            eclectic design. Wanderlings will set her up for you on the Mornington Peninsula and leave
                            you to enjoy your unique adventure! Use your airstream as a base to explore the local
                            coastline and your family experience of bathing at the local Peninsula Hot Springs.</p>
                        <p><span class="strong-prize-details">Wanderlings:</span><br>Are you a wanderling? You love slow
                            nights by a campfire. You follow loads of #vanlife accounts and pounce one every cabin book
                            you find… but you don’t own a camper and living like a nomad full-time really isn’t for you.
                        </p>
                        <p>We hear you and we’d love to help quench your wanderlust!</p>
                        <p>Wanderlings<sup>&trade;</sup> offers hires and sales of vintage Airstreams, caravans + unique
                            campers. Wanderlings is owned by Jessie and Scott Curtis-Griffiths who are obsessed with
                            vintage Airstreams, unique campers, coffee and chasing inspiration! We live on the stunning
                            Mornington Peninsula.</p>
                        <p><span class="strong-prize-details">Peninsula Hot Springs:</span><br>The Peninsula Hot Springs
                            provides the space and gorgeous facilities for families to relax together in nature, to
                            escape routine and enjoy the beautiful surrounds while looking after your body and your
                            well-being. A commitment to geothermal health and to the well-being of visitors, The
                            Peninsula Hot Springs is a unique natural experience.</p>
                    </div>
                </div>
                <div class="col-md-12" id="prize-wrapper-5">
                    <div class="prize-details-item">
                        <p class="title"><a target="_blank" href="https://www.big4.com.au/" style="color: #df287d;">5th Prize: Great Ocean Road Chocolaterie & ice creamery and Big 4 Anglesea
                                Holiday Park.<span class="prize-price"> Valued at $580.</span></a></p>
                        <p>Taste, watch, indulge & discover the world of chocolate at the new Chocolaterie on the Great
                            Ocean Road – an experience the whole family can enjoy. Kids can immerse themselves in
                            chocolate traditions and learn the craft of chocolate making while parents can treat
                            themselves to some of the delights of the spectacular showroom.</p>
                        <p>Down the road from your chocolate experience, stay for the weekend in a two bedroom unit at
                            Anglesea’s Big4 Holiday Park. </p>
                        <p><span class="strong-prize-details">Great Ocean Road Chocolaterie and Ice Creamery:</span><br>Come
                            visit us at our stunning new Chocolaterie on the Great Ocean Road - an experience the whole
                            family can enjoy. Created by passionate foodies Ian & Leanne Neeland, share in their love of
                            chocolate and the creation of memorable experiences.</p>
                        <p>Delight in free chocolate and ice cream tastings, watch the art of chocolate making and say
                            hello to our European chocolatiers. When tastings are done, discover our tranquil landscaped
                            coastal settings. Kids are encouraged to explore the lawns, native garden and emerging
                            orchard or play in the lavender field and sand play area.</p>
                        <p><span class="strong-prize-details">Big 4 Anglesea:</span><br>Enjoy the gorgeous beach and
                            grazing kangaroos of the ocean side accommodation and the play experiences within the
                            complex including an awesome indoor water complex, jumping pillow, indoor toddler playroom,
                            adventure playground and much more!</p>
                    </div>
                </div>
                <div class="col-md-12" id="prize-wrapper-6">
                    <div class="prize-details-item">
                        <p class="title"><a target="_blank" href="https://www.slowclay.com/" style="color: #df287d;">6th Prize: Slow Clay, Private family ceramic classes. <span
                                        class="prize-price"> Valued at $450.</span></a></p>
                        <p>Spend time learning ceramics together as a family in an exclusive private workshop. Your
                            family will be guided by award-winning ceramic artists that will share their expertise on
                            either the potter’s wheel or hand building. Your creations will be glazed and fired for you
                            to collect a few weeks later.</p>
                        <p>Slow Clay Centre specialises in ceramic art and pottery education and offers an extensive
                            variety of ceramics and pottery classes throughout the year.</p>
                    </div>
                </div>
                <div class="col-md-12" id="prize-wrapper-7">
                    <div class="prize-details-item">
                        <p class="title"><a target="_blank" href="https://www.artscentremelbourne.com.au" style="color: #df287d;">7th Prize: Arts Centre Family tickets for The Unbelievables show.<span
                                        class="prize-price"> Valued at $276.</span></a></p>
                        <p>From the internationally acclaimed producers of The Illusionists and Circus 1903 comes an
                            entertainment blockbuster set to dazzle Melbourne audiences this summer. Featuring the
                            greatest acts from around the globe, The Unbelievables has it all - jaw-dropping magic,
                            breathtaking circus and the world's most spectacular ballroom dancers. Win a family pass - 2
                            adults and 2 children - to see this fabulous show at Hamer Hall.</p>
                        <p><span class="strong-prize-details">Arts Centre:</span><br>The Arts Centre Melbourne is both a
                            defining Melbourne landmark and Australia’s largest and busiest performing arts centre. Last
                            year, they staged more than 4,000 performances and events to more than 2.7 million people.
                            For nearly 30 years, the Arts Centre Melbourne has played a leading role in showcasing the
                            best local and international performing arts.</p>
                    </div>
                </div>
                <div class="col-md-12" id="prize-wrapper-8">
                    <div class="prize-details-item">
                        <p class="title"><a target="_blank" href="https://www.zoo.org.au/" style="color: #df287d;">8th Prize: Zoos Victoria Family Membership for 2018.<span class="prize-price"> Valued at $216.</span></a>
                        </p>
                        <p>Visit your family’s favourite animals all year round with a Family Zoo Membership. Enjoy
                            unlimited entry into Melbourne Zoo, Werribee Open Range Zoo and Healesville Sanctuary and
                            learn, discover and imagine. Be updated on Zoo happenings with the quarterly Magazine and
                            get exclusive access to member events and exhibit previews. You will also receive free
                            reciprocal entry to select interstate zoos.</p>
                        <p>Zoos Victoria is a not-for-profit conservation organisation dedicated to fighting wildlife
                            extinction. This is done through breeding and recovery programs for threatened species and
                            by working with visitors and supporters to reduce threats facing endangered wildlife.</p>
                    </div>
                </div>
                <div class="col-md-12" id="prize-wrapper-9">
                    <div class="prize-details-item">
                        <p class="title"><a target="_blank" href="http://www.circusoz.com/" style="color: #df287d;">9th Prize: Circus Oz, Family Circus Experience.<span class="prize-price"> Valued at $110.</span></a>
                        </p>
                        <p>Experience the dazzling expertise of Melbourne’s beloved Circus Oz artists and share in the
                            delights of this magical, jaw dropping physical artistry with a circus experience for the
                            whole family.</p>
                        <p><span class="strong-prize-details">Circus Oz:</span><br>Breathtaking feats, serious fun, and
                            Australian Humour for audiences of all ages…</p>
                        <p>For three and a half decades, Circus Oz has delighted itself into the hearts of generations
                            of audiences embracing its role as Australia’s National Circus. We also believe that
                            everyone is capable of discovering their strengths, reaching their goals and contributing to
                            something extraordinary. Through our workshops and classes we connect with kids and adults
                            from all walks of life and invite them to experience the power of circus through our social
                            enterprise programs.</p>
                        <p>Circus Oz was born in Melbourne, Australia in 1978. For nearly 40 years the company has been
                            putting up extraordinary shows and successfully touring them both nationally and
                            internationally. From New York to South American rainforests, Madrid to outback
                            Australia,Circus Oz has taken its self-crafted performances of wit, grace and spectacle to
                            27 countries across five continents, to critical acclaim. The Circus Oz show is a
                            rock-n-roll, animal free circus that adults and children can enjoy together. Celebrating
                            breathtaking stunts, irreverent humour, cracking live music and an all human ensemble,
                            Circus Oz promotes the best of the Australian spirit: generosity, diversity, death-defying
                            bravery, and a fair go for all.</p>
                    </div>
                </div>
                <div class="col-md-12" id="prize-wrapper-10">
                    <div class="prize-details-item">
                        <p class="title"><a target="_blank" href="http://www.enchantedmaze.com.au/" style="color: #df287d;">10th Prize: Enchanted Adventure Garden family pass.<span class="prize-price"> Valued at $100.</span></a>
                        </p>
                        <p>The Enchanted Adventure Garden is a multi-award winning natural attraction nestled in the
                            beautiful hinterland of Arthur’s Seat. From humble beginnings, the Enchanted Adventure
                            Garden has grown into a wonderland of mazes, gardens, art and adventure that is designed to
                            enliven the senses and challenge the mind. Enjoy your day pass for the family and get
                            tangled in a wonderland of Hedge Mazes, go Tube Sliding or book a Tree Surfing
                            adventure!</p>
                    </div>
                </div>
                <div class="col-md-12" id="prize-wrapper-11">
                    <div class="prize-details-item">
                        <p class="title"><a target="_blank" href="http://www.nica.com.au/" style="color: #df287d;">11th Prize: National Institute of Circus Arts (NICA) Family pass for two adults
                                and two children.<span class="prize-price"> Valued at $83.</span></a></p>
                        <p>Engage with students from Australia’s only Bachelor of Circus Arts Degree in their third year
                            winter showcase experience.</p>
                        <p>The National Institute of Circus Arts (NICA) has been developing professional circus artists
                            and producing innovative new circus works since 2001. It is a national organisation with a
                            strong international reputation for training multi-talented artists. Enjoy these talented
                            circus students destined for wonderful, playful inspiring careers.</p>
                    </div>
                </div>
                <div class="col-md-12" id="prize-wrapper-12">
                    <div class="prize-details-item">
                        <p class="title"><a target="_blank" href="https://museumsvictoria.com.au/" style="color: #df287d;">12th Prize: Museums Victoria Household Membership (2 adults and up to 4
                                children for a year).<span class="prize-price"> Valued at $79.</span></a></p>
                        <p class="strong-prize-details">Museums Victoria</p>
                        <p><span class="strong-prize-details">Three great museums, one membership:</span><br>A Museums
                            Victoria membership will give you unlimited free general entry to our three museums - the
                            Melbourne Museum, Scienceworks and the Immigration Museum - and access to an infinite world
                            of discovery.</p>
                        <p><span class="strong-prize-details">Enriching experiences:</span><br>We love our museums, and
                            we know you do too. They’re vital contributors to Australian history, culture and scientific
                            research, but one of their most important roles is to involve and inspire. We’ve designed
                            Museum Members with discovery in mind – to make wonder a part of every visit.</p>
                        <p><span class="strong-prize-details">Supporting our museums:</span><br>Your museum membership
                            helps us preserve Victoria’s State Collection of more than 17 million objects for future
                            generations to enjoy. It also supports research activities of a team of scientists and
                            historians and contributes to the development of new exhibitions and projects.</p>
                    </div>
                </div>
                <div class="col-md-12" id="prize-wrapper-13">
                    <div class="prize-details-item">
                        <p class="title"><a target="_blank" href="https://marrinergroup.com.au/shows/priscilla-queen-of-the-desert" style="color: #df287d;">Bonus Prize: Marriner Theatre’s 2 x VIP passes to Priscilla Queen of the
                                Desert.<span class="prize-price"> Valued at $410.</span></a></p>
                        <p>Marriner Group’s prized heritage theatres have played host to many of the biggest shows and
                            stars of the entertainment world. Be pampered on a date night to the Regent Theatre as a VIP
                            to the award winning hit musical Priscilla Queen of the Desert. Based on the Oscar-winning
                            film, PRISCILLA is the hilarious adventure of three friends who hop aboard a battered old
                            bus bound for Alice Springs to put on the show of a lifetime.</p>
                        <p>Winners will receive the red carpet experience including great seats, a souvenir program and
                            their choice of beverage and snack.</p>
                    </div>
                </div>
                <div class="col-md-12" id="prize-wrapper-14">
                    <div class="prize-details-item">
                        <p class="title"><a target="_blank" href="http://chunkymove.com.au/" style="color: #df287d;">Bonus Prize: Chunky Move Complete Beginner Dance classes for two. <span
                                        class="prize-price"> Valued at $176.</span></a></p>
                        <p>If you have little to no previous dance experience, join one of Chunky Move’s Complete
                            Beginner Series. Over the four-week series, they will take you and a friend through the
                            basics of contemporary dance in a fun and non-judgemental environment. Contemporary dance is
                            energetic and varied, so it’s perfect for fitness, toning and strengthening muscles. Each
                            class starts with a gentle warm-up and builds to simple and energetic dance moves. If you've
                            always thought you were too uncoordinated to ever step into a dance studio, this is your
                            chance to give it a go! </p>
                        <p>If you have little to no previous dance experience, join one of Chunky Move’s Complete
                            Beginner Series. Over the four-week series, they will take you and a friend through the
                            basics of contemporary dance in a fun and non-judgemental environment. Contemporary dance is
                            energetic and varied, so it’s perfect for fitness, toning and strengthening muscles. Each
                            class starts with a gentle warm-up and builds to simple and energetic dance moves. If you've
                            always thought you were too uncoordinated to ever step into a dance studio, this is your
                            chance to give it a go! </p>
                    </div>
                </div>
                <div class="col-md-12" id="prize-wrapper-15">
                    <div class="prize-details-item">
                        <p class="title"><a target="_blank" href="https://melbournestreettours.com/" style="color: #df287d;">Bonus Prize: Melbourne Street Art Tours.<span class="prize-price"> Valued at $138.</span></a>
                        </p>
                        <p>Journey through Melbourne’s famous street art laneways and see hidden treasures, learn about
                            the artists and hear stories from street artists directly involved in the scene. The tour
                            finishes at the famous Blender Studios (now located in Docklands) where you will be treated
                            to an exclusive studio tour. Meet the artists and see them at work in our huge art
                            studio.</p>
                        <p>A gourmet selection of market fresh produce, beer, wine and soft drinks are provided as you
                            wander through this incredible space.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="awesome-footerbar yoa-page-footer">
        <div class="container">
            <div class="col-md-4">
                <a href="<?php echo get_site_url() ?>">
                    <img src="<?php echo YOA_URL; ?>assets/images/playground-ideas-logo-white.png" class="nav-left">
                </a>
            </div>

            <div class="col-md-3 privacy-footer">
                <p>Permit number:10586/17</p>
                <a href="<?php echo get_site_url() ?>/raffle-terms-and-conditions/" target="_blank">Terms &amp; Conditions</a>
            </div>

            <div class="col-md-5 open-sans">
                <p class="footer-text">&copy;2017 Playground Ideas is an Australian Non-Profit Organization </p>
            </div>
        </div>
    </div>

    <?php include YOA_DIR . "yoa-model.php"; ?>

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
    <link rel='stylesheet' href='<?php echo YOA_URL; ?>assets/css/main.css' type='text/css'/>

    <script src="<?php echo YOA_URL; ?>assets/js/jquery.min.js"></script>
    <script>window.jQuery || document.write("<script src='<?php echo YOA_URL; ?>assets/js/jquery.min.js'><\x3C/script>")</script>
    <script src="<?php echo YOA_URL; ?>assets/js/jquery-cookie-master/src/jquery.cookie.js"></script>
    <script src="<?php echo YOA_URL; ?>assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
    <script src="<?php echo YOA_URL; ?>assets/js/main.js" id="yoa_mainjs" data-yoapage-link="<?php echo site_url(YOA_PAGENAME);?>"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo YOA_URL; ?>assets/js/ie10-viewport-bug-workaround.js"></script>
    <?php
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
      
        if (strpos($user_agent, 'iPhone')) {

            ?>
            <style type="text/css">
                .modal {
                position: absolute !important;
                top: 40px;
                }
            </style>
            <script type="text/javascript">
                jQuery(".ticket-button button").click(function () {

                jQuery('html, body').animate({

                    scrollTop: parseInt(jQuery("header.menu").offset().top - 20)

                }, 1000);

            });
            </script>
            <?php
        } 
        ?>
</div>
