<?php 
/**
 * @package news-feed-gutenberg
 */

for($i = 0; $i <= 2; $i++){
    $article = $articles[$i];
    ?>
    <p>
        <strong>
            <a href="<?php echo esc_url($article['url']);?>"> 
                <?php echo esc_html($article['title']);?>
            </a>
        </strong>
    </p>
    <p>
        <img 
            src="<?php echo esc_url($article['urlToImage']);?>" 
            alt="<?php echo esc_attr($article['title']);?>" 
            style="max-width: 100%"/>
    </p>
    <p>     
        <?php echo esc_html($article['description']);?>   
    </p>
    <?php
}
?>
