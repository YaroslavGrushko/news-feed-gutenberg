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
        // register news block
		add_action( 'init', array($this, 'news_feed_gutenberg_register_block') );
	}
	function news_feed_gutenberg_register_block() {
		register_block_type( __DIR__ );
	}
}

new News_Feed_Gutenberg();