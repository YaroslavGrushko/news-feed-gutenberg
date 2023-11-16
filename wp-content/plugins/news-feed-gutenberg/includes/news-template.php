<?php 
/**
 * @package news-feed-gutenberg
 */

$selected_country = $country;
$selected_category = $category;
?>
<div class="news_feed_gutenberg-container">
    <h3 class="filter-title"><?php echo esc_html__( 'Filters:', 'news_feed_gutenberg');?></h3>
    <form id="news_feed_gutenberg-form" class="news-feed-gutenberg-form" method="post" enctype="multipart/form-data">
        <div>
            <label for="news_feed_gutenberg_country"><?php echo esc_html__( 'Choose Country', 'news_feed_gutenberg');?></label>
            <div class="field">
                <select name="news_feed_gutenberg_country" id="news_feed_gutenberg_country">
                    <?php
                    foreach( $countries as $key => $value ){?>
                        <option 
                            value="<?php echo esc_attr($key); ?>" 
                            <?php echo esc_attr(selected($key, $selected_country, false)); ?>>
                                <?php echo esc_html($value); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div>
            <label for="news_feed_gutenberg_category"><?php echo esc_html__( 'Choose Category', 'news_feed_gutenberg');?></label>
            <div class="field">
                <select name="news_feed_gutenberg_category" id="news_feed_gutenberg_category">
                    <?php
                    foreach( $categories as $key => $value ){?>
                        <option 
                            value="<?php echo esc_attr($key); ?>" 
                            <?php echo esc_attr(selected($key, $selected_category, false)); ?>>
                                <?php echo esc_html($value); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <?php wp_nonce_field('news_feed_gutenberg_nonce_action', 'news_feed_gutenberg_nonce_field'); ?>
        <input 
            type="submit"
            name="news_feed_gutenberg_form_submit" 
            id="news_feed_gutenberg_form_submit"
            value=" <?php echo esc_html__( 'Apply Filter', 'news_feed_gutenberg'); ?>"
        />
    </form>


    <?php
        foreach( $articles as $article ){
            ?>
            <div class="news-feed-gutenberg-article">
                <p>
                    <strong class="news-feed-gutenberg-article-title">
                        <a href="<?php echo esc_url($article['url']);?>"> 
                            <?php echo esc_html($article['title']);?>
                        </a>
                    </strong>
                </p>
                <p>
                    <img 
                        src="<?php echo esc_url($article['urlToImage']);?>" 
                        class="news-feed-gutenberg-image"
                        alt="<?php echo esc_attr($article['title']);?>" 
                    />
                </p>
                <p>     
                    <?php echo esc_html($article['description']);?>   
                </p>
            </div>
            <?php
        }
    ?>
</div>

