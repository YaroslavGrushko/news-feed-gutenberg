<?php 
/**
 * Plugin Name: News Feed Gutenberg
 * Plugin URI: https://yvg.com.ua/
 * Description: News feed (Gutenberg block) using data from the API and optimized for server rendering (SSR).
 * Version: 1.0.0
 * Author: Yaroslav Grushko
 * Author URI: https://yvg.com.ua/
 * Text Domain: news-feed-gutenberg
 * Domain Path: /languages/
 */

if( !defined('NEWS_FEED_GUTENBERG_VERSION') ){
	define('NEWS_FEED_GUTENBERG_VERSION', '1.0.0');
}

if( !defined('NEWS_FEED_GUTENBERG_VERSION') ){
	define('NEWS_FEED_GUTENBERG_VERSION', plugin_dir_path( __FILE__ ));
}

class News_Feed_Gutenberg{
    function __construct(){
        // css and js
		add_action( 'wp_enqueue_scripts', array($this, 'news_feed_gutenberg_register_scripts') );
	}

    // register css and js files
	function news_feed_gutenberg_register_scripts(){
		$css_folder = plugin_dir_url( __FILE__ ) . 'css';
		$js_folder = plugin_dir_url( __FILE__ ) . 'js';
		$plugin_version = NEWS_FEED_GUTENBERG_VERSION;

		// main styles file
		wp_enqueue_style( 'tp-style', $css_folder . '/news_feed_gutenberg.css', array(), $plugin_version );
		// main js file
		wp_enqueue_script( 'tp-script', $js_folder . '/news_feed_gutenberg.js', array( 'jquery' ), $plugin_version,  true);	
	}
}

new News_Feed_Gutenberg();