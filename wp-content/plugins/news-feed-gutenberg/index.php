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
		add_action( 'init', array($this, 'news_feed_gutenberg_register_block') );
	}
	function news_feed_gutenberg_register_block() {
		// automatically load dependencies and version
		$asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php');

		wp_register_script(
			'news-feed-gutenberg-block',
			plugins_url( 'build/index.js', __FILE__ ),
			$asset_file['dependencies'],
			$asset_file['version']
		);

		register_block_type('news-feed-gutenberg/news-block', [
			'editor_script' => 'news-feed-gutenberg-block',
			'render_callback' => array($this, 'news_feed_gutenberg_render_block'),
		]);
	}
	function news_feed_gutenberg_render_block($attributes) {
		// $country = $attributes['country'];
		// $category = $attributes['category'];
	
		// $api_key = 'd77f778d6d4643ebb53fc72ce08513c1';
		// $url = "https://newsapi.org/v2/top-headlines?country=$country&category=$category&apiKey=$api_key";
	
		$url = "https://wpml.org/wp-json/wp/v2/posts/";
		
		$response = wp_remote_get($url);
	
		if (is_array($response) && !is_wp_error($response)) {
			$body = wp_remote_retrieve_body($response);
			$response_array = json_decode($body, true);
			return $response_array;
		}
	
		return [];
	}
}

new News_Feed_Gutenberg();