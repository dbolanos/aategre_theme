<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage SAVEO
 * @since SAVEO 1.0.14
 */
$saveo_header_video = saveo_get_header_video();
$saveo_embed_video = '';
if (!empty($saveo_header_video) && !saveo_is_from_uploads($saveo_header_video)) {
	if (saveo_is_youtube_url($saveo_header_video) && preg_match('/[=\/]([^=\/]*)$/', $saveo_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$saveo_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($saveo_header_video) . '[/embed]' ));
			$saveo_embed_video = saveo_make_video_autoplay($saveo_embed_video);
		} else {
			$saveo_header_video = str_replace('/watch?v=', '/embed/', $saveo_header_video);
			$saveo_header_video = saveo_add_to_url($saveo_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => home_url(),
				'widgetid' => 1
			));
			$saveo_embed_video = '<iframe src="' . esc_url($saveo_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php saveo_show_layout($saveo_embed_video); ?></div><?php
	}
}
?>