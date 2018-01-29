
    /*// check if like button clicked
    FB.Event.subscribe('edge.create', function (href, widget) {
        setcookie("yaol", "liked");
        fbchange();
    });
    //check if like button unclicked
    FB.Event.subscribe('edge.remove', function (response) {
        setcookie("yaol", "none");
        fbchange();
    });*/
    
    // check if shared or share closed
    $( document ).ready(function() {
        setcookie('yaos',null);
    // if (getCookie("yaos") === "shared") {
    //       jQuery('#strp-free').val(0);
    // }
    var mailText = 'mailto:?subject=Year of Awesome&body=Hey,%20%0D%0A%20%0D%0Acheck out the year of awesome prizes. Absolutely amazing!%20%0D%0A%20%0D%0AAnd it all raises funds to get kids playing around the world to improve their development%20%0D%0A%20%0D%0AI just bought a ticket, check it out here : http://www.myyearofawesome.org%20%0D%0A%20%0D%0ASee you soon';
    jQuery('#share-mail').attr('href', mailText);
  
    });

     // Email Area show/hide
    $(document).ready(function(){
        
        $("#share-mail").click(function(){
            $("#show-email").toggle();
        });

    });
    // Top nav message Hide
    function close_message() {

        jQuery(".closebtn").css('display', 'none');
          if(window.location.href.indexOf("?") > -1) {
             location.href=location.href.replace("?success=1", "");
            }
    }

    function share() {
        var share_link = jQuery("#yoa_mainjs").data("yoapage-link");

        FB.ui({
            method: 'feed',
            name: 'https://www.facebook.com/playgroundideas',
            link: share_link,
            caption: 'An example caption'
        }, function (response) {
            if (response && !response.error_message) {
                jQuery(".tkt-free-case").html('<span class="free-ticket-footer">+ '+tktFree+'</span> <span class="free-ticket-price">FREE</span> ');
                setcookie("yaos", "shared");
                fbchange();
            } else {
                setcookie("yaos", "none");
                fbchange();
            }
        });
    }

    // UI Alteration
    var wsize = jQuery(window).width();
    if (wsize < 601) {
        $item = jQuery('.col-sm-4'),
            visible = 1, //Set the number of items that will be visible
            index = 0, //Starting index
            endIndex = ( $item.length / visible ) - 1; //End index
        w = jQuery(".col-sm-4").css("width");
        w = (parseInt(w, 10) + 10) + "px";
        jQuery('#arrowR').click(function () {
            if (index < endIndex) {
                index++;
                $item.animate({'left': '-=' + w});
            }
        });

        jQuery('#arrowL').click(function () {
            if (index > 0) {
                index--;
                $item.animate({'left': '+=' + w});
            }
        });
    }
    if ((wsize >= 601) && (wsize < 767)) {
        $item = jQuery('.col-sm-4'),
            visible = 2, //Set the number of items that will be visible
            index = 0, //Starting index
            endIndex = ( $item.length / visible ) - 1; //End index
        w = jQuery(".col-sm-4").css("width");
        w = ((parseInt(w, 10) * 2) + 20) + "px";

        jQuery('#arrowR').click(function () {
            if (index < endIndex) {
                index++;
                $item.animate({'left': '-=' + w});
            }
        });

        jQuery('#arrowL').click(function () {
            if (index > 0) {
                index--;
                $item.animate({'left': '+=' + w});
            }
        });
    }

    //check ticket amount user selects
    jQuery('#ticket-amount').on('change', function () {
        selectv = jQuery(this).val();
        tktid = jQuery("#tkt-id").html();
        jQuery("#total-tkts").html(tktid * selectv);
        jQuery("#total-tkts-label").html((tktid * selectv>1)?"tickets":"ticket");
        totalv = jQuery(".tkt-price").html();
        totalv = totalv.replace(/\D/g, '');
        selectv = selectv * totalv;
        jQuery(".tkt-total").html(selectv);
        fbchange();
    })
    // compare ticket banner to ticket popup and translate data
    jQuery(".tkt-button").click(function () {

        tktCount = jQuery(this).attr("tktb-count");
        tktValue = jQuery(this).attr("tktb-value");
        tktFree = jQuery(this).attr("tktb-free");
        if (tktFree ==1 ) {
            jQuery('.free-ticket-text').html('ticket');
        } else {
             jQuery('.free-ticket-text').html('tickets');
        }
        jQuery('#ticket-amount').val("1");
        jQuery('.free-ticket-count').html(tktFree);
        jQuery(".tkt-sub").html('save $' + tktFree * tktValue / tktCount);
        jQuery(".tkt-total").html(tktValue);
        jQuery("#total-tkts").html(tktCount);
        jQuery("#total-tkts-label").html((tktCount>1)?"tickets":"ticket");
        var ticketText;
        if (tktCount == 1) {
            ticketText = "Ticket";
        } else {
            ticketText = "Tickets";
        }
        jQuery(".tkt-price-value").html('<div><span id="tkt-id">' + tktCount + '</span> '+ ticketText +' for <span class="tkt-price">$' + tktValue + '</span></div>');
        jQuery("#strp-free").attr("value", tktFree);
        if (getCookie("yaos") == "shared") {
            jQuery(".tkt-free-case").html('<span class="free-ticket-footer">+ '+tktFree+'</span> <span class="free-ticket-price">FREE</span> ');

        }
        
    });

    // scroll prize button
    jQuery(".PrizeButton").click(function () {
        jQuery('html, body').animate({
            scrollTop: parseInt(jQuery(".yoa-space").offset().top - 20)
        }, 1000);
    });

    jQuery(".tkt-scroll").click(function () {
        jQuery('html, body').animate({
            scrollTop: parseInt(jQuery(".tickets-row").offset().top - 20)
        }, 1000);
    });

    jQuery(".prize-button").click(function () {
        var id = jQuery(this).attr('class').split(/\s+/)[1];
        jQuery('html, body').animate({
            scrollTop: parseInt(jQuery("#prize-wrapper-" + id).offset().top - 20)
        }, 1000);
    });

    jQuery("#WhyButton").click(function () {
        jQuery('html, body').animate({
            scrollTop: parseInt(jQuery("#WhyButton-wrapper").offset().top - 20)
        }, 1000);
    });

    // handles like and share changes
    function fbchange() {
        if (getCookie("yaos") === "shared") {
            if (getCookie("yaos") == "shared") {
                    jQuery(".fb-share-b a").addClass("disable-fb-link");
                    jQuery('#strp-free').val(0);
                }
            var freeTicketCount = jQuery('.free-ticket-count').html();
            jQuery(".fb-share-b a").css("background-color", "#4267b2");
            jQuery(".share-check").addClass("tc-check-off");
            jQuery(".tkt-free-case").html('<span class="free-ticket-footer">+ '+freeTicketCount+'</span> <span class="free-ticket-price">FREE</span> ');
            jQuery("#strp-free").attr("value", freeTicketCount);
        }
        else {
            jQuery(".fb-share-b a").css("background-color", "#4267b2");
            jQuery(".share-check").removeClass("tc-check-on").addClass("tc-check-off");
            jQuery(".tkt-free-case").html('');
        }
    }

    // cookies funtions
    function setcookie(cookieName, cookieValue) {
        var today = new Date();
        var expire = new Date();
        expire.setTime(today.getTime() + 3600000 * 24 * 99999);
        document.cookie = cookieName + "=" + escape(cookieValue) + ";expires=" + expire.toGMTString() + "; path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    /* Header Slider */
    jQuery('#header-slider').slick({
        prevArrow: "<div class='slider-button-prev'><button class='slick-prev slick-arrow' type='button' style=''></button></div>",
        nextArrow: "<div class='slider-button-next'><button class='slick-next slick-arrow' type='button' style=''></button></div>",
        //slidesToShow: 1,
        arrows: true,
        //centerPadding: '280px',
        //centerMode: true,
        autoplay: false,
        infinity: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        centerPadding: '30%',
        centerMode: true,
        responsive: [
            {
                breakpoint: 1400,
                settings: { slidesToShow: 1, slidesToScroll: 1, centerPadding: '280px', infinite: true, centerMode: true }
            },
            {
                breakpoint: 1293,
                settings: { slidesToShow: 1, slidesToScroll: 1, centerPadding: '15%', infinite: true, centerMode: true }
            },
            {
                breakpoint: 992,
                settings: { slidesToShow: 1, slidesToScroll: 1, centerPadding: '60px', infinite: true, centerMode: true }
            },
            {
                breakpoint: 574,
                settings: { slidesToShow: 1, slidesToScroll: 1, centerPadding: '0px', centerMode: true }
            }
        ]
    });
