<?php
use Royl\WpThemeBase\Util;
use Royl\WpThemeBase\Ajax;
?>
<div class="alert alert-info">POST FILTER FORM</div>
<?php royl_render_filter_form( 'test-filter-form' ); ?>
<hr>
<div class="alert alert-info">FILTERED POSTS<br>
This is not the main loop. It is the <code>test-filter-form</code> Filter Query</div>
<?php

// Get filtered query object:
$query = royl_get_filter_query( 'test-filter-form' );

// WordPress pagination is based on the Main query.
// We have to kinda trick WP when we use a custom query object in the main loop.. 
$temp_query = $wp_query;
$wp_query = $query;
?>
<?php
// the loop
if ( $query->have_posts() ) :
    ?>
    <ul class="listing">
    <?php
    while ( $query->have_posts() ) : $query->the_post();
        ?><li class="listing__item"><?php
        get_template_part( 'template-parts/post/content', get_post_format() );
        ?></li><?php
    endwhile;
    ?>
    </ul>
    <?php
    the_posts_pagination( array(
        'prev_text' => '<span class="previous" aria-label="previous">' . Util\Text::translate( 'Previous page' ) . '</span>',
        'next_text' => '<span class="next" aria-label="next">' . Util\Text::translate( 'Next page' ) . '</span>',
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . Util\Text::translate( 'Page' ) . ' </span>',
    ) );
else :
    get_template_part( 'template-parts/post/content', 'none' );
endif;
$wp_query = $temp_query;
?>

<hr>