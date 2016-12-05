<?php
/**
 * Created by JetBrains PhpStorm.
 * Date: 7/30/13
 * Time: 10:20 AM
 * Plugin Name: Wordpress Slim framework
 * Description: Slim framework integration with Wordpress
 * Version: 1.0
 * Author: Constantin Botnari
 * License: GPLv2
 */
require_once 'Slim/Slim.php';
require_once 'SlimWpOptions.php';


\Slim\Slim::registerAutoloader();
new \Slim\SlimWpOptions();

add_filter('rewrite_rules_array', function ($rules) {
    $new_rules = array(
        '('.get_option('slim_base_path','slim/api/').')' => 'index.php',
    );
    $rules = $new_rules + $rules;
    return $rules;
});

add_action('init', function () {
    // initialize shortcode
    
    function market_share_shortcode($atts = [], $content = null)
    {
        $content .= <<<EOT
<div ng-app="plunker" ng-controller="MainCtrl">
    
    <nvd3 options="options" data="data"></nvd3>
    
    <br><a href="http://krispo.github.io/angular-nvd3/" target="_blank" style="float: right;">See more</a>
  </div>
EOT;
        return $content;
    }
    add_shortcode('market-share-plugin', 'market_share_shortcode');

    
    
    
    if (strstr($_SERVER['REQUEST_URI'], get_option('slim_base_path','slim/api/'))) {
        $slim = new \Slim\Slim();
        do_action('slim_mapping',$slim);
        $slim->get('/slim/api/user/:u',function($user){
            printf("User is %s",$user);            
        });
        $slim->get('/slim/api/test', function(){
            global $wpdb, $table_prefix;
            echo json_encode($wpdb->get_results( $wpdb->prepare("SELECT * FROM " . $table_prefix . "test", null) ));
        });
        $slim->get('/slim/api/market_share', function(){
            global $wpdb, $table_prefix;
            echo json_encode($wpdb->get_results( $wpdb->prepare("SELECT * FROM " . $table_prefix . "market_share", null) ));
        });
        $slim->run();
        exit;
    }
});

// bring in external css resources
wp_register_style('your_css_and_js', "https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.1/nv.d3.min.css");
wp_enqueue_style('your_css_and_js');
// bring in external javascript resources
wp_register_script( 'your_css_and_js1', "https://ajax.googleapis.com/ajax/libs/angularjs/1.3.9/angular.min.js");
wp_enqueue_script('your_css_and_js1');
wp_register_script( 'your_css_and_js2', "https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js");
wp_enqueue_script('your_css_and_js2');
wp_register_script( 'your_css_and_js3', "https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.1/nv.d3.min.js");
wp_enqueue_script('your_css_and_js3');
wp_register_script( 'your_css_and_js4', "https://cdnjs.cloudflare.com/ajax/libs/angular-nvd3/1.0.5/angular-nvd3.min.js");
wp_enqueue_script('your_css_and_js4');
wp_register_script( 'your_css_and_js5', plugins_url('js/firebase.js',__FILE__ ));
wp_enqueue_script('your_css_and_js5');
wp_register_script( 'your_css_and_js6', plugins_url('js/angularfire.min.js',__FILE__ ));
wp_enqueue_script('your_css_and_js6');
wp_register_script( 'your_css_and_js7', plugins_url('js/main.js',__FILE__ ));
wp_enqueue_script('your_css_and_js7');