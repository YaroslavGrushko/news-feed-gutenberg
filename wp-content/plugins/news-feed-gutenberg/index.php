<?php 
/**
 * Plugin Name: Gutenberg examples 01
 */
function news_feed_gutenberg_01_register_block() {
    register_block_type( __DIR__ );
}
add_action( 'init', 'news_feed_gutenberg_01_register_block' );