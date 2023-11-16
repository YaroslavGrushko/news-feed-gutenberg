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
			'attributes' => [
				'country' => [
					'type' => 'string',
					'default' => 'us',
				],
				'category' => [
					'type' => 'string',
					'default' => 'general',
				],
			],
		]);
	}
	function news_feed_gutenberg_render_block($block_attributes, $content) {
		$country = $block_attributes['country'];
		// $category = $block_attributes['category'];
	
		$api_key = 'd77f778d6d4643ebb53fc72ce08513c1';
		$api_url = "https://newsapi.org/v2/top-headlines?country=$country&apiKey=$api_key";
		$user_agent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36";
		$request_args = array(
			'method'      => 'GET',
			'headers'     => array(
				'Content-Type' => 'application/json',
				'User-Agent' => $user_agent,
			),
		);

		// request to api
		$response = wp_remote_get($api_url, $request_args);
	
		if (is_array($response) && !is_wp_error($response)) {
			$body = wp_remote_retrieve_body($response);
			$response_array = json_decode($body, true);
			$articles = $response_array['articles'];
			for($i = 0; $i <= 3; $i++){
				$item = $articles[$i];
				$result_html = $result_html . '<p><strong><a href="' . $item['url'] . '">' .  $item['title'] . '</a></strong></p>';
				$result_html = $result_html . '<p><img src="' . $item['urlToImage'] . '" alt="' .  $item['title'] . '" style="max-width: 100%"/></p>';
				$result_html = $result_html . '<p>' .  $item['description'] . '</p><br>';
			}
			return $result_html;
		}
	
		return [];
	}
}

new News_Feed_Gutenberg();