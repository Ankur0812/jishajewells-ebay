<?php
/*
Plugin Name: JJ Ebay Template
Description: A plugin to copy data from Woocommerce and Paste to ebay template.
Version: 1.0
Requires at least: 5.0
Requires PHP: 8.0
Text Domain: jj-ebay-template
Author: Mehul Gohil
Author URI: https://mehulgohil.com/
*/

class Ebay_Plugin {
    public function __construct() {
        
        // Enqueue JavaScript
        // add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
        if( is_admin() ) {
            
            add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );

            add_filter('manage_edit-product_columns', [ $this,'add_custom_columns_to_products' ] );        
            
            add_action('manage_product_posts_custom_column', [ $this, 'custom_product_column_content' ], 10, 2);

            add_action( 'wp_ajax_jj_copy_data', [ $this, 'handle_jj_copy_data' ] );
        }
    }

    /* public function register_scripts() {
        $ajaxurl = admin_url('admin-ajax.php');

        wp_enqueue_script( 'jj-pdf-download-script', plugin_dir_url(__FILE__) . 'script.js', array(), '1.0', true);
        wp_add_inline_script('jj-pdf-download-script', 'var ajaxurl = "' . $ajaxurl . '";', 'before');
    } */

    public function register_assets() {
		wp_enqueue_script( 'jj-ebay-template-script',  plugin_dir_url(__FILE__) . 'assets/src/js/admin/jj-ebay-admin.js', array(), '1.0', true );
	}
    public function add_custom_columns_to_products($columns) {
        $columns['ebay_template_column'] = __('Ebay Template', 'jj-ebay-template');
        return $columns;
    }

    public function custom_product_column_content($column, $post_id) {
        if ($column === 'ebay_template_column') {
            
            $link = get_the_permalink();
            printf(
                '<button
                        type="button"
                        id="jjbutton"
                        class="button jj-copy-button"
                        aria-label="%1$s"
                        data-default-text="Copy"
                        data-copied-text="Copied!"
                        data-product-id="%2$s">
                    <span class="dashicons dashicons-admin-page"></span> <span class="jj-button-text"> %3$s </span> 
                </button>',
                esc_attr( $link ),
                esc_attr( $post_id ),
                esc_html__( 'Copy', 'jj-ebay-template' )
            );
        }
    }

    public function handle_jj_copy_data() {
        
        ob_start();
        
        if (isset($_POST['product_id'])) {
            
            $product_id = intval($_POST['product_id']);
            // Perform your custom action with the product ID
            $product = wc_get_product( $product_id );
            
            $product_name = $product->get_name();

            $product_main_img = wp_get_attachment_url( $product->get_image_id() );

            $attachment_ids = $product->get_gallery_image_ids();
            $image_urls = [];
    
            foreach ( $attachment_ids as $attachment_id ) {
                $image_urls[] = wp_get_attachment_url( $attachment_id );
            }

            $product_desc = $product->get_description();
            
            $string_to_remove = ".st0{display:none;}.st1{display:inline;}.st2{fill:none;stroke:#000000;stroke-width:0.1;stroke-miterlimit:10;}.st3{fill:none;}.st4{fill:none;stroke:#FFFFFF;stroke-width:0;stroke-linecap:round;stroke-linejoin:round;}.st5{fill:none;stroke:#000000;stroke-width:0;stroke-linecap:round;stroke-linejoin:round;}Created by SBTSfrom the Noun Project";
            
            $product_desc = str_replace($string_to_remove, "", $product_desc);
            
            $custom_html = "<!DOCTYPE html>
            <html lang=en>
            <head>
            <meta charset='utf-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <title>Tani-Logics Uk eBay Listing Template</title>
            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
            <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet'>
            <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet'>
            <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
            <style>@charset 'utf-8';
            body{margin:0;padding:0;font-family:'Open Sans',sans-serif;font-size:14px;display:inline-block;width:100%;color:#333;overflow-x:hidden;font-weight:400}
            input,button,select,textarea{outline:none;font-family:'Open Sans',sans-serif}
            #Body,#Body *,font{font-family:'Open Sans',sans-serif;}
            a,p,strong,ul,h1,h2,h3,h4,h5,h6{margin:0;padding:0}
            h1{font-size:24px}
            h3{font-size:28px}
            h4{font-size:22px}
            a:focus,input:focus{outline:none!important;text-decoration:none}
            a:hover{text-decoration:none}
            @media (min-width: 768px) {
            .main-bg,.container{width:768px}
            }
            @media (min-width: 939px) {
            .main-bg,.container{width:919px}
            }
            @media (min-width: 1200px) {
            .main-bg,.container{width:1000px}
            }
            .main-bg{max-width:1000px;background:#fff;margin:0 auto;    -webkit-box-shadow: 0 0 6px 2px rgba(179,173,179,1);
                -moz-box-shadow: 0 0 6px 2px rgba(179,173,179,1);
                box-shadow: 0 0 6px 2px rgba(179,173,179,1);}
            .container{padding:0 10px}
            .pagewidth{float:left;width:100%}
            .wrappage{width:100%}
            input[type=text]::-ms-clear{display:none!important;width:0!important;height:0!important}
            input[type=text]::-ms-reveal{display:none!important;width:0!important;height:0!important}
            .input-text,.sub_search{outline:0!important}
            .sub_search{border:0!important}
            #Body .tab-content-m{float:left;width:100%}
            select:focus,button:focus,option:focus,select::-moz-focus-inner,option::-moz-focus-inner{outline:none!important;border:none!important}
            code{padding:2px;background:#ddd}
            img{max-width:100%}
            #gh-logo{max-width:500%}
            .content-text a.text{cursor:text}
            a.text:hover{text-decoration:none}
            *,:before,:after{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin:0;padding:0}
            .header{min-height:125px}
            .headercontent{margin-top:30px}
            .promo .content .footer{display:inline-block;width:100%}
            .content .panel-default > .panel-heading{border-color:#252525!important;color:#fff;border-radius:0;font-size:18px;text-transform:uppercase;font-weight:400}
            .header-container{display:inline-block;width:100%;border:0;position:relative;display:inline-block;width:100%;border:0;position:relative}
            .header-container .header-top{display:inline-block;width:100%;text-align:center;`}
            .header-container .header-top p{color:#171717;font-size:14px;font-weight:600;font-family:'Open Sans',sans-serif;background:#f5f5f5;padding:5px;}
            .icon-menu-mb,.header-container .header-content .nav-trigger{display:none}
            .header-container .header-content .logo-content{float:left;text-align:center;margin:2em 0}
            .header-content{display:inline-block;width:100%;background:#FFF;text-align:center}
            .header-container{display:inline-block;width:100%}
            .menu-header{display:inline-block;width:100%;left:0;text-align:center}
            .menu-header-mobile{display:none}
            .menu-header .container{position:relative}
            .menu-header .menu-container{width:100%;background: #252525;}
            .menu-header ul li{display:inline-block}
            .menu-header ul li a{padding:15px 10px;font-family:'Open Sans',sans-serif;font-size:16px;color:#fff;display:inline-block;text-transform:uppercase;font-weight:400}
            .menu-header ul li a:hover{background:#f5f5f5;color:#666}
            .hidden-nav{display:none}
            .support{text-align:center;font-size:18px;text-transform:capitalize;margin-top:3em;float:right;color:#444;font-family:'Open Sans',sans-serif}
            .support .callus > span{font-size:16px;color:#279431;font-weight:600}
            .support i{font-size:40px;font-weight:400;color:#279431;padding:5px}
            .support span{color:#279431 !Important;}
            .content{margin-top:0}
            @media (max-width: 768px) {
            .promo{display:none}
            }
            .promo,.promo .promo-content{display:inline-block;width:100%}
            .promo .promo-content{text-align:center;}
            .promo .promo-content a{display:inline-block;color:#fff;font-size:14px;font-weight:600;font-family:'Open Sans',sans-serif}
            .promo .promo-content a span{text-transform:uppercase;font-size:14px;font-family:'Open Sans',sans-serif}
            .promo .promo-content a.box-promotion{border-right:1px solid #fff;line-height:12px;padding-right:15px;padding-left:15px}
            .promo .promo-content .fa{font-size:15x;padding-right:.5em}
            .promo .promo-content a.box-promotion:last-child{border-right:0}
            .banner{margin-top:1em}
            .left-content{padding-left:0}
            .left-content h2{margin:0;font-size:17px;font-family:'Open Sans',sans-serif;color:#fff;width:100%;padding:12px 15px;background: #252525;}
            .left-content ul{border:1px solid #dbdee1;border-top:0}
            .left-content ul li a{color:#111;background:none;font-family:'Open Sans',sans-serif;font-size:14px;line-height:18px;display:inline-block;font-weight:400;padding:12px 10px}
            .left-content ul li a:hover{color:#252525}
            .widget_box{margin-bottom:15px}
            .widget_box_text{background:#0a0a0a;border-radius:10px;padding:15px;color:#fff;text-align:justify;font-family:'Open Sans',sans-serif}
            .widget_box_text .heading{color:#fdf234;font-size:16px;font-weight:700;text-align:center}
            .widget_box_text p{padding:10px 0}
            .tani-text{padding:15px;text-align:center}
            .content{border-color:#252525!important;border-radius:0;margin-top:1em}
            .product-name{background:#252525!important;border-color:#252525!important;color:#fff;border-radius:0;font-size:18px;text-transform:uppercase;font-weight:400;padding:12px 10px}
            .subscribe{background: #252525;;border:0;text-transform:uppercase;border-radius:0;margin-top:1em;padding:10px}
            .widget_content{border:1px solid #e8e8e8;border-top:none!important}
            .subscribe i{font-size:22px;padding:0 5px 0 0}
            .content .panel-default{border-color:#e2e2e2!important;border-radius:0;font-family:'Open Sans',sans-serif}
            .right-content{padding:0}
            .desc-box{border:none !important;}
            .text-section{border: 1px solid #e2e2e2;}
            .image-gallery{position:relative;width:95%;margin:2em auto auto}
            .image-gallery img{margin:0 auto}
            .slider{width:100%;display:inline-block;padding-top:480px;text-align:center;}
            .slider .img-details{width:100%;position:absolute;left:0;top:0;transition:all .5s;text-align:center;max-height:570px;transition:all .5s;z-index:22;height:445px;background:#fff}
            .slider .img-details img{max-width:100%;max-height:443px;}
            .slider input[name='slide_switch']{display:none}
            .slider label{margin-right:11px;display:inline-block;cursor:pointer;transition:all .5s;opacity:1;margin-bottom:1em}
            .slider span{display:inline-table;width:80px;height:80px;text-align:center;border:1px solid #cdcdce}
            .slider span:has(img[src*='Liquid']){display:none}
            .slider label img{max-width:100%;width:auto;padding:1px;max-height:78px}
            .slider img[src*='Liquid']{display:none}
            .slider input[name='slide_switch']:checked+label{opacity:1}
            .slider input ~ .img-details{margin-bottom:0}
            .slider input[name='slide_switch'] ~ .img-details{opacity:0;display:none}
            .slider input[name='slide_switch']:checked + label + .img-details{opacity:1;display:block;transform:scale(1)}
            .slider #id1 + label + .img-details{opacity:1;display:block;transform:scale(1)}
            .tabPanel-widget{position:relative;background:#252525;border:1px solid #252525;border-top:0}
            .content .panel-default > .panel-heading{background: #252525;;border:0!important;color:#fff;border-radius:0;font-size:16px;text-transform:uppercase;font-weight:700;font-family:'Open Sans',sans-serif;padding:12px 15px}
            .title-heading{width:100%;font-size:16px;font-family:'Open Sans',sans-serif;color:#fff;text-align:center;border:0!important;padding:12px 10px;background: #252525;}
            .text-section img{display:block;max-width:100%;height:auto;margin:0 auto}
            .text-section,.text-section a,.text-section li,.text-section p,.text-section tr,.text-section td{margin-bottom:0;line-height:22px;font-size:15px;color:#000;font-family:'Open Sans',sans-serif}
            .text-section{padding:10px 10px 20px}
            .text-section a{color:#111;font-family:'Open Sans',sans-serif}
            .text-section a:hover{text-decoration:underline}
            .text-section ul{margin-bottom:10px;padding-left:20px}
            .text-section li{margin:0 0 5px;position:relative;list-style-type:disc}
            .text-section ul li:last-child{margin-bottom:0}
            .text-section h1{font-size:20px;color:#252525;text-transform:uppercase;font-weight:600;line-height:32px;margin-top:10px}
            .text-section h2{font-size:18px;color:#252525;text-transform:uppercase;font-weight:600;line-height:25px;margin-top:10px}
            .text-section h3,.text-section h4,.text-section h5,.text-section h6{font-size:14px;color:#000;font-weight:700;line-height:20px;margin-top:10px}
            /*Tabs Fonts Start*/
            .tabarea{padding:15px}
            .tabs{float:none;list-style:none;padding:0;margin:0 auto}
            .tabs:after{content:'';display:table;clear:both}
            .tabs input[type=radio]{display:none}
            .tabs label{display:inline-block;color:#333;text-transform:uppercase;font-size:18px;font-weight:500;font-family:'Open Sans',sans-serif;padding:12px 20px 11px;float:left;cursor:pointer;background:#e1e1e1;position:relative;z-index:2;margin:0 3px 0 0}
            .tabs label span{display:inline-block;font-size:16px;font-family:'Open Sans',sans-serif;}
            .tabs label i{padding:5px;margin-right:0}
            .tabs label:hover{color:#fff;background:#252525}
            .tab-content{display:none;font-size:16px;font-family:'Open Sans',sans-serif;width:100%;float:left;padding:15px;box-sizing:border-box;background-color:#fff;margin:-1px 0 0;padding:25px 20px 35px;border:1px solid #ccc}
            .tab-content,.tab-content a,.tab-content li,.tab-content p,.tab-content tr,.tab-content td{margin-bottom:0;line-height:22px;font-size:15px;color:#000;font-family:'Open Sans',sans-serif}
            .tab-content{margin:0;padding:25px 20px 35px;}
            .tab-content a{color:#111;font-family: 'Open Sans',sans-serif;}
            .tab-content a:hover{text-decoration:underline}
            .tab-content ul,.tab-content ol{margin-bottom:10px;padding-left:1em;}
            .tab-content ul li,.tab-content ol li{margin:0 0 5px;position:relative}
            .tab-content ul li:last-child,.tab-content ol li:last-child{margin-bottom:0}
            .tab-content h1{font-size:20px;color:#252525;text-transform:uppercase;font-weight:600;line-height:32px;margin-top:10px}
            .tab-content h2{font-size:18px;color:#252525;text-transform:uppercase;font-weight:600;line-height:25px;margin-top:10px}
            .tab-content h3,.tabarea section h4,.tabarea section h5,.tabarea section h6{font-size:14px;color:#000;font-weight:700;line-height:20px;margin-top:10px}
            .tab-content *{-webkit-animation:scale .7s ease-in-out;-moz-animation:scale .7s ease-in-out;animation:scale .7s ease-in-out}
            @keyframes scale {
            0%{transform:scale(0.9);opacity:0}
            50%{transform:scale(1.01);opacity:.5}
            100%{transform:scale(1);opacity:1}
            }
            .tabs [id^='tab']:checked + label{color:#fff;background:#252525;}
            #tab1:checked ~ #tab-content1,#tab2:checked ~ #tab-content2,#tab3:checked ~ #tab-content3,#tab4:checked ~ #tab-content4,#tab5:checked ~ #tab-content5,#tab6:checked ~ #tab-content6,#tab7:checked ~ #tab-content7,#tab8:checked ~ #tab-content8{display:block}
            .footer{color:#d1d1d1;margin-top:2em}
            .footer p{margin:0;font-family:'Open Sans',sans-serif;font-size:15px;color:#fff;}
            .copyrights{padding:10px;background: #252525;}
            @media (max-width: 1210px) and (min-width: 1140px) {
            .slider{padding-top:495px}
            .slider .img-details,.slider .img-details img{max-height:475px}
            }
            @media (min-width:769px) and (max-width:992px) {
            #LeftPanel{width:210px}
            }
            @media(min-width:992px) and (max-width:1140px) {
            .slider #id1 + label + .img-details:hover,.slider input[name='slide_switch']:checked+label+ .img-details:hover{transform:scale(1.1);border:1px solid #252525}
            }
            @media (max-width: 992px) {
            .slider{padding-top:495px}
            .slider .img-details,.slider .img-details img{max-height:450px}
            }
            @media(max-width: 940px) {
            .footer .footer-promo{display:none}
            .footer-signup{float:right}
            .contact-us{width:33%}
            }
            @media (max-width: 939px) {
            .slider{padding-top:475px}
            .slider .img-details,.slider .img-details img{max-height:455px}
            }
            @media(width: 768px) {
            header-container .header-content .logo-content{width:200px;margin-right:10px}
            #LeftPanel{width:210px}
            .slider{padding-top:390px}
            .slider .img-details,.slider .img-details img{max-height:370px}
            .slider label{margin-right:14px}
            .slider span{width:81px;height:81px}
            .slider label img{max-height:79px}
            }
            @media(max-width: 767px) {
            .header-container{border:0}
            .header-container .header-content .logo-content{padding-bottom:13px;float:none;display:inline-block}
            .header-content{padding:20px 0 15px;position:relative;text-align:center}
            .header-right{width:100%;display:inline-block}
            .search-container{width:100%;float:none}
            .search-content{position:relative;width:100%;margin-top:9px}
            .wrappage .search-content{margin-top:0!important}
            .navigation{background:#111}
            .nav-item{width:100%;border-top:1px solid #ddd;border-bottom:1px solid #000}
            .nav-trigger{position:absolute;clip:rect(0,0,0,0)}
            .nav-trigger + label{display:block;background: #252525;;cursor:pointer;color:#fff;line-height:45px;font-size:18px;font-family:'Open Sans',sans-serif;margin:0}
            .nav-trigger + label::before{display:inline-block;width:24px;height:16px;right:10px;top:15px;content:'\f0c9';font-family:'FontAwesome';font-size:1.5em;padding-left:10px;vertical-align:middle;float:left;font-weight:400}
            .header-content .menu-header{-webkit-transition:opacity .5s ease-in-out;-moz-transition:opacity .5s ease-in-out;-ms-transition:opacity .5s ease-in-out;-o-transition:opacity .5s ease-in-out;transition:opacity .5s ease-in-out;display:none}
            .nav-trigger:checked ~ .menu-header{filter:alpha(opacity=50);opacity:1;display:inline-block}
            .menu-header{display:none;z-index:19;width:100%;position:relative;top:1px;left:0;text-align:left}
            .menu-header-mobile{display:inline-block;width:100%}
            .menu-header-mobile .container{padding:0}
            .menu-header ul.menu{box-shadow:0 4px 4px #e6e6e6}
            .menu-header ul{float:right;text-align:left;width:100%}
            .menu-header ul li{float:left;width:100%;position:relative;border-bottom:1px solid #f5f5f5}
            .menu-header ul li a{background: #252525;;color:#111;line-height:22px;font-size:16px;font-family:'Open Sans',sans-serif;padding:10px;display:inline-block;width:100%;color:#fff}
            .menu-header ul li a:hover{background:#f5f5f5;color:#252525}
            .menu-header ul li input{display:none}
            .contact-us{display:none!important}
            .footer-signup{float:left;width:100%;margin-top:2em}
            .slider{padding-top:320px;width:100%;position:relative}
            .slider .img-details,.slider .img-details img{max-height:300px}
            .slider label{margin-right:12px}
            .slider span{width:66px;height:66px}
            .slider label img{max-height:64px}
            .tabs label {width: 100%;border-bottom: 1px solid #ccc;}
            }
            @media(max-width:568px) {
            .header-container .header-top{display:none}
            .header-container .header-content .logo-content{float:none}
            }
            @media(max-width:414px) {
            .slider .img-details img{height:auto}
            }.cnt{display:none !important;}</style>
            </head>
            <body>
            <div class='main-bg'>
            <div class='header-container'>
            <div class='header-content'>
            <div class='container'>
            <a class='logo-content' href='http://stores.ebay.com/jishajewel/' target='_blank'><img src='https://www.tanilogics.com/clients/jishajewel/logo.png' class='img-responsive'></a><!--Logo Link-->
            <div class='header-right'>
            <input type='checkbox' id='nav-trigger' class='nav-trigger'>
            <label for='nav-trigger' class='hidden-nav'>MENU</label>
            <div class='menu-header menu-header-mobile'>
            <div class='container'>
            <div class='menu-container'>
            <ul class='menu'>
            <li><a href='http://stores.ebay.com/jishajewel/' target='_blank'>Home</a></li><!--Main Menu Links/Max 8 Links/Bettet Usage for Featured Categories-->
            <li><a href='http://stores.ebay.com/jishajewel/_i.html?rt=nc&_sid=1243149011&_sticky=1&_trksid=p4634.c0.m14&_sop=10&_sc=1' target='_blank'>New Arrivals</a></li>
            <li><a href='http://stores.ebay.com/jishajewel/_i.html?rt=nc&_sc=1&_sid=1243149011&_sticky=1&_trksid=p4634.c0.m14&_sop=1&_sc=1' target='_blank'>Ending Soon</a></li>
            <li><a href='http://feedback.ebay.com/ws/eBayISAPI.dll?ViewFeedback&userid=jishajewel' target='_blank'>Feedback</a></li>
            <li><a href='http://contact.ebay.com/ws/eBayISAPI.dll?FindAnswers&requested=jishajewel&_trksid=p2050430.m2531.l4583&rt=nc&iid=142206348110' target='_blank'>Contact Us</a></li>
            </ul>
            </div>
            </div>
            </div>
            </div>
            </div>
            <div class='menu-header'>
            <div class='container'>
            <div class='menu-container'>
            <ul class='menu'>
            <li><a href='http://stores.ebay.com/jishajewel/' target='_blank'>Home</a></li><!--Main Menu Links/Max 8 Links/Bettet Usage for Featured Categories-->
            <li><a href='http://stores.ebay.com/jishajewel/_i.html?rt=nc&_sid=1243149011&_sticky=1&_trksid=p4634.c0.m14&_sop=10&_sc=1' target='_blank'>New Arrivals</a></li>
            <li><a href='http://stores.ebay.com/jishajewel/_i.html?rt=nc&_sc=1&_sid=1243149011&_sticky=1&_trksid=p4634.c0.m14&_sop=1&_sc=1' target='_blank'>Ending Soon</a></li>
            <li><a href='http://feedback.ebay.com/ws/eBayISAPI.dll?ViewFeedback&userid=jishajewel' target='_blank'>Feedback</a></li>
            <li><a href='http://contact.ebay.com/ws/eBayISAPI.dll?FindAnswers&requested=jishajewel&_trksid=p2050430.m2531.l4583&rt=nc&iid=142206348110' target='_blank'>Contact Us</a></li>
            </ul>
            </div>
            </div>
            </div>
            </div>
            </div>
            <div class='promo hidden-sm hidden-xs'>
            <div class='container'>
            <div class='promo-content'>
            <img src='https://www.tanilogics.com/clients/jishajewel/banner.png'>
            </div>
            </div>
            </div>
            <!--Header End-->
            <div class='content'>
            <div class='container'>
            <div class='inner-row'>
            <div class='col-sm-3 col-md-3 hidden-xs hidden-sm left-content'>
            <div class='hidden-xs hidden-sm'>
            <div class='widget_box'>
            <div class='list-group'>
            <h2>Safe & Secure </h2>
            <div class='widget_content'><img src='https://www.tanilogics.com/clients/jishajewel/left-promo.png' class='img-responsive'></div>
            </div>
            </div>
            </div>
            </div>
            <div class='col-md-9 right-content'>
            <h1 class='title-heading'>$product_name</h1><!--Item Title-->
            <div class='panel panel-default'>
            <div class='image-gallery'>
            <div class='slider'><!--Image Gallery Start-->
            <TagBot Optional section=true>
            <input type='radio' name='slide_switch' id='id1' checked value='[TagBot?Image1?Image1=][TagBot?Image1]'>
            <label for='id1'>
            <span><img src='$product_main_img' width='100'></span>
            </label>
            <div class='img-details'><img src='$product_main_img'></div>
            </TagBot>";

            foreach ($image_urls as $index => $image_url) {
                $index_plus_two = $index + 2;
                $custom_html .= "<TagBot Optional section=true>
                <input type='radio' name='slide_switch' id='id{$index_plus_two}' value='[TagBot?Image{$index_plus_two}?Image{$index_plus_two}=][TagBot?Image{$index_plus_two}]'>
                <label for='id{$index_plus_two}'>
                <span><img src='$image_url' width='100'></span>
                </label>
                <div class='img-details'><img src='$image_url'></div>
                </TagBot>";
            }
            
            $custom_html .= "</div>
            </div>
            </div>
            
            <div class='panel panel-default desc-box'>
            <div class='panel-heading'>DESCRIPTION</div><!--DESCRIPTION Start-->
            <div class='text-section'>
            <div class='panel-body'>
            $product_desc
            </div>
            </div>
            </div>
            <div class='tabs'>
            <input type='radio' name='tabs' id='tab1' checked=''>
            <label for='tab1'>
            <span>Why JISHA Jewels?</span><!--------- Tab 1 Name --------->
            </label>
            <input type='radio' name='tabs' id='tab2'>
            <label for='tab2'>
            <span>Payment</span><!--------- Tab 2 Name --------->
            </label>
            <input type='radio' name='tabs' id='tab3'>
            <label for='tab3'>
            <span>Returns</span><!--------- Tab 3 Name --------->
            </label>
            <input type='radio' name='tabs' id='tab4'>
            <label for='tab4'>
            <span>About Us</span><!--------- Tab 4 Name --------->
            </label>
            <div id='tab-content1' class='tab-content'>
            <!---------Tab 1 Content--------->
            <p>
            Our company is different from the rest. We are a major manufacturer, retailer, wholesaler and exporter of Diamonds Jewelery &amp; Gold Jewelery. Our 45 years in the business allows us to offer the Best Prices, Knowledge, and Service you could ask for. Here are just a few more reasons why we should be the only place for you purchase your Jewelery From US:<br><br>
            • <strong>100% Genuine Products -</strong> We only sell 100% natural diamonds mined from the earth &amp; 100% Solid Gold.<br>
            • <strong> 30 Day Return Policy -</strong> One of the very few online sellers offering 30 full days to make this very important decision. Returns or exchanges can be done stress free.<br>
            • <strong>Lifetime Warranty - </strong>We guarantee all clarity and color enhancements for life, and include a lifetime warranty with each purchase.<br>
            •<strong> Certified Appraisal - </strong>Every Product we sell will include an independent certificate from a respected gem lab, valid for insurance purposes.<br>
            • <strong>Free Shipping -</strong> Every Product is sent directly to you fully insured with signature required, free of charge (customs fees may apply).<br>
            • <strong>Buyer Protection-</strong> Pay with Paypal and your full Purchase Price is Covered with Ebay Buyer Protection.<br>
            • <strong>Unbeatable Prices- </strong>We manufacture Jewelery at our OWN Factory -we are the REAL source.<br>
            • <strong>100% Satisfaction Guarantee- </strong>From start to finish, your purchase with us will be 100% smooth. Customer service, shipping, merchandise will all be PERFECT.<br>
            • <strong>Custom Jewelery Designing -</strong> We Can Manufacture Your Jewelery Design. Please Contact US through eBay Messages if you want us to manufacture your own Jewelery Design. We will make same Design &amp; List it on eBay for you to Purchase. <br>
            • <b>Gold Purity, Gold Color, Diamond Color &amp; Clarity Can Be Changed Depending Upon Your Requirement. Price May Vary.<b>
            </b></b></p>
            </div>
            <div id='tab-content2' class='tab-content'>
            <!---------Tab 2 Content--------->
            <p>Payment is expected within 48 hours of your purchase, by Paypal only please.</p>
            </div>
            <div id='tab-content3' class='tab-content'>
            <!---------Tab 3 Content--------->
            <p class='txt_14px_grey'> Returns are gladly accepted, item must be in same condition as received. Buyer is responsible for all return shipping charges. Please contact me prior to returning an item.</p>
            </div>
            <div id='tab-content4' class='tab-content'>
            <!---------Tab 4 Content--------->
            <p class='txt_14px_grey'>
            JISHA Jewels offers huge variety of IGI &amp; GIA Certified DIAMOND Studded Jewellery and BIS Hallmark GOLD Jewellery.<br>
            We offer designs at PRICES that you can afford. Our QUALITY can't be beat !!<br><br>
            Our Promise
            <br>
            • Top Quality Customer Service<br>
            • Free &amp; Fully Insured Shipping<br>
            • 30 Day Money Back - No Hassle<br>
            • Lifetime Enhancements<br>
            • 100% Customer Satisfaction<br>
            • Authentic Diamond Certificates
            <br><br>
            </p>
            </div>
            </div>
            </div>
            </div>
            </div>
            <!--Footer Start-->
            <div class='footer'>
            <div class='container'>
            <div class='inner-row'>
            <div class='clearfix'></div>
            <div class='copyrights'>
            <p class='text-center'>Tani Logics UK Copyright &copy; 2016. All rights reserved.</p>
            </div>
            </div>
            </div>
            </div>
            </div>
            </body>
            </html>";

            $custom_html .= ob_get_clean();
                
                // Respond with some data
                wp_send_json_success( $custom_html );
            } else {
                wp_send_json_error('Invalid product ID');
            }
        
            wp_die();
        }

}

// Load the plugin on `plugins_loaded` hook.
add_action(
    'plugins_loaded',
    function() {
        new Ebay_Plugin();
    }
);
