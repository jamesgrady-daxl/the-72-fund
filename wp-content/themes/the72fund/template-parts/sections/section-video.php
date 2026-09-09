<?php

include locate_template('template-parts/modules/module-section_toolkit.php');

$video = get_sub_field('video');
$video_url = ! empty($video['url']) ? $video['url'] : '';
$video_type = ! empty($video['mime_type']) ? $video['mime_type'] : '';
$video_filetype = $video_url ? wp_check_filetype($video_url) : array();
$video_path = $video_url ? wp_parse_url($video_url, PHP_URL_PATH) : '';
$video_extension = ! empty($video_filetype['ext']) ? $video_filetype['ext'] : pathinfo($video_path, PATHINFO_EXTENSION);

$video_type = $video_type ?: ( ! empty($video_filetype['type']) ? $video_filetype['type'] : '' );
$video_type = $video_type ?: ( $video_extension ? 'video/' . $video_extension : '' );
$video_is_video = ( $video_type && 0 === strpos($video_type, 'video/') ) || in_array($video_extension, array('webm', 'mp4', 'ogg', 'ogv', 'mov', 'm4v'), true);

?>

<?php if ( $video_url && $video_is_video ) : ?>
    <section class="video mobile600"
            <?php if( !empty($section_anchor) ) : ?>id="<?php echo esc_attr($section_anchor); ?>"<?php endif; ?>
            <?php echo $section_data_attrs; ?>
            <?php echo $section_style_attr; ?>>
        <div class="container <?php echo esc_attr($container_width); ?> <?php echo esc_attr($container_padding); ?>"
            <?php echo $container_data_attrs; ?>
            <?php echo $container_style_attr; ?>>

            <video autoplay muted playsinline preload="metadata">
                <source src="<?php echo esc_url($video_url); ?>" type="<?php echo esc_attr($video_type); ?>" />
            </video>
            
        </div>
    </section>
<?php endif; ?>
