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
 *
 * @package news-feed-gutenberg
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
		add_action( 'wp_enqueue_scripts', array($this, 'news_feed_gutenberg_register_scripts') );
	}
	// register css 
	function news_feed_gutenberg_register_scripts(){
		$css_folder = plugin_dir_url( __FILE__ ) . 'css';
		$plugin_version = NEWS_FEED_GUTENBERG_VERSION;

		// main styles file
		wp_enqueue_style( 'news-feed-gutenberg-style', $css_folder . '/news_feed_gutenberg.css', array(), $plugin_version );
	
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
				'apikey' => [
					'type' => 'string',
					'default' => '4794618f58b44a2e98159af1978784a7',
				],
				'pageSize' => [
					'type' => 'integer',
					'default' => 3,
				],
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
	// render block
	function news_feed_gutenberg_render_block($block_attributes, $content) {
		$api_key = $block_attributes['apikey'];
		$default_page_size = $block_attributes['pageSize'];
		$page_size = $this->get_page_size($default_page_size);
		$country = $block_attributes['country'];
		$category = $block_attributes['category'];
		$countries = [
			'us' => 'USA',
			'ua' => 'Ukraine',
		];
		$categories = [
			'business' => 'Business',
			'science' => 'Science',
			'sports' => 'Sports',
			'general' => 'General',
		];

		$submit_result = $this->news_feed_gutenberg_form_check_submit($country, $category);
		$country = $submit_result["country"];
		$category = $submit_result["category"];
		$is_more = $submit_result["is_more"];
		if($is_more){
			$page_size = $this->increment_page_size($page_size);
		}
		$api_url = "https://newsapi.org/v2/top-headlines?country=$country&category=$category&apiKey=$api_key&pageSize=$page_size";
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
			$status = $response_array['status'];
			if($status !== 'ok'){
				// error
				$message = $response_array['message'];
				return $message;
			}
			$articles = $response_array['articles'];

			ob_start();
			require plugin_dir_path( __FILE__ ) . 'includes/news-template.php';
			return ob_get_clean();
		}
	
		return [];
	}
	function get_page_size($default_page_size) {
		if (!session_id()) {
			session_start();
		}

		$page_size = isset($_SESSION['page_size']) ? $_SESSION['page_size'] : $default_page_size;
	
		return $page_size; 
	}
	function increment_page_size($page_size) {
		$page_size = $this->get_page_size($page_size);
	
		$_SESSION['page_size'] = $page_size + 5;
		return $_SESSION['page_size'];
	}
	
	// form submit handler 
	function news_feed_gutenberg_form_check_submit($country, $category) {
		$verified = isset( $_POST['news_feed_gutenberg_nonce_field'] ) && wp_verify_nonce( $_POST['news_feed_gutenberg_nonce_field'], 'news_feed_gutenberg_nonce_action' ); 
		$is_more = false;
		if ( $verified && (isset($_POST['news_feed_gutenberg_form_submit'])||isset($_POST['news_feed_gutenberg_form_more'])) ) {
			$country = $_POST["news_feed_gutenberg_country"]; 
			$category = $_POST["news_feed_gutenberg_category"]; 
			$is_more = isset($_POST['news_feed_gutenberg_form_more']);
		}

		return ['country' => $country, 'category' => $category, 'is_more' => $is_more];
	}
}

new News_Feed_Gutenberg();