<?php 

/*-----------------------------------------------------------------------------------*/
/*  - Enable/Disable Header, Footer or Both
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'az_header_footer_show_display' ) ) {
    function az_header_footer_show_display($postid) {

        global $options_panda, $az_options_show_header, $az_options_show_footer, $post;
        
        $check_header_display_settings = get_post_meta($postid, 'az_header_display', true);
        $check_footer_display_settings = get_post_meta($postid, 'az_footer_display', true);

        // Header Display Settings
        if ( $check_header_display_settings == 'hide') { 
            $az_options_show_header = false;
        } else {
            $az_options_show_header = true;
        }

        // Footer Display Settings
        if ( $check_footer_display_settings == 'hide') { 
            $az_options_show_footer = false;
        } else {
            $az_options_show_footer = true;
        }
    }
}


/*-----------------------------------------------------------------------------------*/
/*  - Page Header Settings
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'az_page_header' ) ) {
    function az_page_header($postid) {

        global $options_panda, $post;
        
        $options_az = redux_post_meta( 'panda' , $postid );

        $title_header_layout_class = $title_header_height_output = $fill_bg_h = $fill_hide_bg = $text_color = $heading_format = null;
        
        $check_title_header_settings = $options_az['az_title_header_display'];
        $check_title_header_hide_settings = $options_az['az_title_header_hide_display'];

        $check_title_header_layout = $options_az['az_title_header_layout'];

        $check_title_header_module = $options_az['az_title_header_module'];

        $check_title_header_slider = $options_az['az_title_header_slider_mode'];

        $check_title_header_mask = $options_az['az_title_header_mask_mode'];
        $check_title_header_video = $options_az['az_title_header_video_mode'];

        $check_title_header_text_display = $options_az['az_title_header_text_display'];

        $title_header_height = $options_az['az_title_header_height'];

        $title_animated_background_color = $options_az['az_animated_pattern_background_color'];
        $title_animated_background = $options_az['az_animated_pattern_background_image'];
        $title_animated_duration = $options_az['az_animated_pattern_animation_duration'];
        $title_animated_moveset = $options_az['az_animated_pattern_animation_moveset'];

        $title_header_background_color = $options_az['az_title_header_normal_bg_color'];
        $title_header_hide_background_color = $options_az['az_title_header_hide_color'];

        $title_header_background_image = $options_az['az_title_header_image'];
        $title_header_background_position = $options_az['az_title_header_image_position'];
        $title_header_background_repeat = $options_az['az_title_header_image_repeat'];

        $title_header_background_image_parallax = $options_az['az_title_header_image_parallax'];

        $az_slider_alias = $options_az['az_title_header_az_slider_alias'];
        $az_slider_text_format = $options_az['az_title_header_az_slider_text_format'];
        $az_slider_animation_type = $options_az['az_title_header_az_slider_animation_type'];
        $az_slider_autoplay = $options_az['az_title_header_az_slider_autoplay'];
        $az_slider_loop = $options_az['az_title_header_az_slider_loop'];
        $az_slider_slide_speed = $options_az['az_title_header_az_slider_slide_speed'];
        $az_slider_slideshow_speed = $options_az['az_title_header_az_slider_slideshow_speed'];
        $az_slider_parallax_slide = $options_az['az_title_header_az_slider_parallax'];

        $rev_slider_alias = $options_az['az_title_header_revolution_slider_alias'];

        $title_header_video_mobile_settings = $options_az['az_title_header_video_mobile_settings'];
        $title_header_video_image = $options_az['az_title_header_video_image'];

        $title_header_video_self_image = $options_az['az_title_header_video_self_image'];
        $title_header_video_webm = $options_az['az_title_header_video_webm'];
        $title_header_video_mp4 = $options_az['az_title_header_video_mp4'];
        $title_header_video_volume = $options_az['az_title_header_video_volume'];
        $title_header_video_autoplay = $options_az['az_title_header_video_autoplay'];
        $title_header_video_loop = $options_az['az_title_header_video_loop'];
        
        $title_header_video_youtube_image = $options_az['az_title_header_video_youtube_image'];
        $title_header_video_youtube_url = $options_az['az_title_header_video_youtube_url'];
        $title_header_video_youtube_vol = $options_az['az_title_header_video_youtube_volume'];
        $title_header_video_youtube_autoplay = $options_az['az_title_header_video_youtube_autoplay'];
        $title_header_video_youtube_loop = $options_az['az_title_header_video_youtube_loop'];

        $title_header_video_vimeo_id = $options_az['az_title_header_video_vimeo_id'];
        $title_header_video_vimeo_vol = $options_az['az_title_header_video_vimeo_volume'];
        $title_header_video_vimeo_autoplay = $options_az['az_title_header_video_vimeo_autoplay'];
        $title_header_video_vimeo_loop = $options_az['az_title_header_video_vimeo_loop'];

        $title_header_mask_pattern = $options_az['az_title_header_mask_pattern'];
        $title_header_mask_pattern_opacity = $options_az['az_title_header_mask_pattern_opacity'];
        $title_header_mask_color = $options_az['az_title_header_mask_background'];

        $title_heading = $options_az['az_title_header_text_heading'];
        $title_subheading = $options_az['az_title_header_text_subheading'];

        $title_heading_format = $options_az['az_title_header_text_format'];

        $title_text_color = $options_az['az_title_header_text_color'];

        $scrollBtn = $options_az['az_scroll_to_section'];

        // Allowed Tags
        $allowed_tags = array(
            'br' => array(),
            'strong' => array()
        );

        // Mobile Detect
        $detect = new Mobile_Detect;
        $device_version = '';
        if ( $detect->isMobile() ) {
            $device_version = 'mobile-version';
        } else {
            $device_version = 'desktop-version';
        }
        
        // FullScreen/Normal Class
        $mode_height = null;
        if ( $check_title_header_layout == 'fullscreen') { 
            $title_header_layout_class = ' full-container';
            $mode_height = ' full-height';
        } else {
            $title_header_layout_class = ' normal-container';
            $mode_height = ' normal-height';
        }

        // Check Height Value
        if ( !empty($title_header_height) ) {
            $title_header_height_output = ' style="height: '.esc_attr($title_header_height).'px;"';
        }

        // Check Custom Background Color
        if ( !empty($title_header_background_color) && !empty($title_header_height) ) { 
            $fill_bg_h = ' style="background-color: '.$title_header_background_color.'; height: '.esc_attr($title_header_height).'px;"'; 
        }
        else if ( empty($title_header_background_color) && !empty($title_header_height) ) {
            $fill_bg_h = ' style="height: '.esc_attr($title_header_height).'px;"'; 
        }
        else if ( !empty($title_header_background_color) && empty($title_header_height) ) {
            $fill_bg_h = ' style="background-color: '.$title_header_background_color.';"';
        }

        // Check Custom Text Color
        if (!empty($title_text_color)) { 
            $text_color = ' style="color: '.$title_text_color.';"'; 
        }

        // Check Custom Background Color Hide Title Header
        if (!empty($title_header_hide_background_color)) { 
            $fill_hide_bg = ' style="background-color: '.$title_header_hide_background_color.';"';
        }

        // Check Title Heading Format
        if ( $title_heading_format == 'big_format') {
            $heading_format = ' big-format-heading';
        } else {
            $heading_format = ' normal-format-heading';
        }

        // Check Background Color, Height Value & Animated Pattern Background & Time Animation and Moveset
        $height_bg_animate = $bg_url_animate = $output_css_animation = $duration_animation = $animation_moveset = null;
        if ( !empty($title_animated_background['url']) ) {
            $bg_url_animate = ' style="background-image: url('.$title_animated_background['url'].');"';

            // Check Custom Background Color
            if (!empty($title_animated_background_color)) { 
                $height_bg_animate = ' style="background-color: '.$title_animated_background_color.';"'; 
            }

            // Check Duration, Moveset and Animation CSS
            if ( !empty($title_animated_duration) ) {
                $duration_animation = '.title-header-container.animate-bg-scroll { -webkit-animation-duration: '.esc_attr($title_animated_duration).'s; animation-duration: '.esc_attr($title_animated_duration).'s; }';
            }
            
            if ( $title_animated_moveset == 'leftright' ) { 
                $animation_moveset = '
                    @-webkit-keyframes bgscroll { from {background-position:0 0;} to {background-position:'.$title_animated_background['width'].'px 0;} }
                    @keyframes bgscroll { from {background-position:0 0;} to {background-position:'.$title_animated_background['width'].'px 0;} }';
            } else if ( $title_animated_moveset == 'rightleft' ) {
                $animation_moveset = '
                    @-webkit-keyframes bgscroll { from {background-position:0 0;} to {background-position:-'.$title_animated_background['width'].'px 0;} }
                    @keyframes bgscroll { from {background-position:0 0;} to {background-position:-'.$title_animated_background['width'].'px 0;} }';
            } else if ( $title_animated_moveset == 'topbottom' ) {
                $animation_moveset = '
                    @-webkit-keyframes bgscroll { from {background-position:0 0;} to {background-position:0 '.$title_animated_background['height'].'px;} }
                    @keyframes bgscroll { from {background-position:0 0;} to {background-position:0 '.$title_animated_background['height'].'px;} }';
            } else {
                $animation_moveset = '
                    @-webkit-keyframes bgscroll { from {background-position:0 0;} to {background-position:0 -'.$title_animated_background['height'].'px;} }
                    @keyframes bgscroll { from {background-position:0 0;} to {background-position:0 -'.$title_animated_background['height'].'px;} }';
            }

            $output_css_animation = '
                <style type="text/css">
                    '.$duration_animation.$animation_moveset.'
                </style>
            ';
        }
        if ( !empty($title_header_height) && !empty($title_animated_background['url']) ) {
            $bg_url_animate = ' style="height: '.esc_attr($title_header_height).'px; background-image: url('.$title_animated_background['url'].');"';

            // Check Custom Background Color
            if (!empty($title_animated_background_color)) { 
                $height_bg_animate = ' style="background-color: '.$title_animated_background_color.'; height: '.esc_attr($title_header_height).'px;"'; 
            } else {
                $height_bg_animate = ' style="height: '.esc_attr($title_header_height).'px;"';
            }
            
            // Check Duration, Moveset and Animation CSS
            if ( !empty($title_animated_duration) ) {
                $duration_animation = '.title-header-container.animate-bg-scroll { -webkit-animation-duration: '.esc_attr($title_animated_duration).'s; animation-duration: '.esc_attr($title_animated_duration).'s; }';
            }

            if ( $title_animated_moveset == 'leftright' ) { 
                $animation_moveset = '
                    @-webkit-keyframes bgscroll { from {background-position:0 0;} to {background-position:'.$title_animated_background['width'].'px 0;} }
                    @keyframes bgscroll { from {background-position:0 0;} to {background-position:'.$title_animated_background['width'].'px 0;} }';
            } else if ( $title_animated_moveset == 'rightleft' ) {
                $animation_moveset = '
                    @-webkit-keyframes bgscroll { from {background-position:0 0;} to {background-position:-'.$title_animated_background['width'].'px 0;} }
                    @keyframes bgscroll { from {background-position:0 0;} to {background-position:-'.$title_animated_background['width'].'px 0;} }';
            } else if ( $title_animated_moveset == 'topbottom' ) {
                $animation_moveset = '
                    @-webkit-keyframes bgscroll { from {background-position:0 0;} to {background-position:0 '.$title_animated_background['height'].'px;} }
                    @keyframes bgscroll { from {background-position:0 0;} to {background-position:0 '.$title_animated_background['height'].'px;} }';
            } else {
                $animation_moveset = '
                    @-webkit-keyframes bgscroll { from {background-position:0 0;} to {background-position:0 -'.$title_animated_background['height'].'px;} }
                    @keyframes bgscroll { from {background-position:0 0;} to {background-position:0 -'.$title_animated_background['height'].'px;} }';
            }

            $output_css_animation = '
                <style type="text/css">
                    '.$duration_animation.$animation_moveset.'
                </style>
            ';
        }

        // Check Title Header Image / Background Position / Repeat
        $bg_mode_output = $bg_mode_position = $bg_mode_repeat = $bg_mode_parallax = null;

        // Background Position
        if ( $title_header_background_position == 'left_top') {
            $bg_mode_position = 'left top';
        } else if ( $title_header_background_position == 'left_center') {
            $bg_mode_position = 'left center';
        } else if ( $title_header_background_position == 'left_bottom') {
            $bg_mode_position = 'left bottom';
        } else if ( $title_header_background_position == 'right_top') {
            $bg_mode_position = 'right top';
        } else if ( $title_header_background_position == 'right_center') {
            $bg_mode_position = 'right center';
        } else if ( $title_header_background_position == 'right_bottom') {
            $bg_mode_position = 'right bottom';
        } else if ( $title_header_background_position == 'center_top') {
            $bg_mode_position = 'center top';
        } else if ( $title_header_background_position == 'center_bottom') {
            $bg_mode_position = 'center bottom';
        } else {
            $bg_mode_position = 'center center';
        }

        // Background Repeat
        if ( $title_header_background_repeat == 'no_repeat') {
            $bg_mode_repeat = 'background-repeat: no-repeat;';
        } else if ( $title_header_background_repeat == 'repeat') {
            $bg_mode_repeat = 'background-repeat: repeat;';
        } else if ( $title_header_background_repeat == 'repeat_x') {
            $bg_mode_repeat = 'background-repeat: repeat-x;';
        } else if ( $title_header_background_repeat == 'repeat_y') {
            $bg_mode_repeat = 'background-repeat: repeat-y;';
        } else {
            $bg_mode_repeat = 'background-repeat: no-repeat; background-size: cover;';
        }

        // Output Title Header Image Output
        if ( !empty($title_header_background_image['url']) ) {
            $bg_mode_output = ' style="background-image: url('.$title_header_background_image['url'].'); background-position:'.$bg_mode_position.'; '.$bg_mode_repeat.'"';
        }
        if ( !empty($title_header_height) && !empty($title_header_background_image['url']) ) {
            $bg_mode_output = ' style="background-image: url('.$title_header_background_image['url'].'); background-position:'.$bg_mode_position.'; '.$bg_mode_repeat.' height: '.esc_attr($title_header_height).'px;"';
        }

        // Output Title Header Image Parallax
        if ( !empty($title_header_background_image_parallax['url']) ) {
            $bg_mode_parallax = ' style="background-image: url('.$title_header_background_image_parallax['url'].');"';
        }
        if ( !empty($title_header_height) && !empty($title_header_background_image_parallax['url']) ) {
            $bg_mode_parallax = ' style="background-image: url('.$title_header_background_image_parallax['url'].'); height: '.esc_attr($title_header_height).'px;"';
        }

        // Check Mask Module
        $mask_output = $mask_rgba_value = null;

        if ( $check_title_header_mask == 'mask_color' || $check_title_header_mask == 'mask_pattern_color' ) {
            $mask_rgba_value = Redux_Helpers::hex2rgba(''.$title_header_mask_color['color'].'', ''.$title_header_mask_color['alpha'].'');
        }

        if ( $check_title_header_mask == 'mask_color') {
            $mask_output = '<span class="overlay-bg" style="background-color: '.$mask_rgba_value.';"></span>';
        } else if ( $check_title_header_mask == 'mask_pattern') {
            $mask_output = '<span class="overlay-pattern" style="background-image: url('.$title_header_mask_pattern['url'].'); opacity: '.$title_header_mask_pattern_opacity.';"></span>';
        } else if ( $check_title_header_mask == 'mask_pattern_color') {
            $mask_output = '<span class="overlay-pattern" style="background-image: url('.$title_header_mask_pattern['url'].'); opacity: '.$title_header_mask_pattern_opacity.';"></span><span class="overlay-bg" style="background-color: '.$mask_rgba_value.';"></span>';
        } else {
            $mask_output = '';
        }

        // Check Video Module
        $wrap_video_check = $video_mobile_out = $bg_self_image_visibility = $alternative_button_self = $alternative_button_yt = $alternative_button_vimeo = $video_output = $video_loop = $video_autoplay = $video_vol = $self_button_play_output = $vimeo_video_id = $vimeo_player_id = $vimeo_vol = $vimeo_autoplay = $vimeo_loop = $vimeo_button_play_output = $escape_url_yt = $youtube_video_url = $youtube_container = $youtube_vol = $youtube_autoplay = $youtube_loop = null;

        // Start Video Vimeo
        if ( $check_title_header_video == 'vimeo_embed_code') {

            // Check Video Mobile/Tablets Settings
            if ( $title_header_video_mobile_settings == 'lightbox' ) {
                $video_mobile_out = 'fancybox-media fancybox-video-popup';
            } else {
                $video_mobile_out = 'new-window-video';
            }
            
            $vimeo_video_id = esc_attr( $title_header_video_vimeo_id );
            $vimeo_player_id = uniqid();

            // Mobile Image
            $bg_video_image = ( !empty($title_header_video_image['url']) ) ? 'background-image: url('.$title_header_video_image['url'].');' : '';

            // Mute Audio
            if( $title_header_video_vimeo_vol == 'off') {
                $vimeo_vol = '1';
            } else {
                $vimeo_vol = '0';
            }

            // AutoPlay
            if( $title_header_video_vimeo_autoplay == 'off') {
                $vimeo_autoplay = 'false';
            } else {
                $vimeo_autoplay = 'true';
            }

            // Loop
            if( $title_header_video_vimeo_loop == 'off') {
                $vimeo_loop = '0';
            } else {
                $vimeo_loop = '1';
            }

            // Conditionals
            // Autoplay OFF - LOOP OFF
            if( $title_header_video_vimeo_autoplay == 'off' && $title_header_video_vimeo_loop == 'off' ) {

                if ( $check_title_header_text_display == 'show' && $title_heading_format == 'big_format') {

                    $vimeo_button_play_output = '
                    <div class="video-header-status-vimeo pause" data-videovimeocheck="player_'.$vimeo_player_id.'"></div>';

                    $alternative_button_vimeo = '
                    <a href="#" class="vimeo_player_button inside" data-videoid="player_'.$vimeo_player_id.'"><i class="font-icon-play"></i></a>';

                } else if ( $check_title_header_text_display == 'show' && $title_heading_format == 'normal_format') {

                    $vimeo_button_play_output = '
                    <div class="video-header-status-vimeo pause" data-videovimeocheck="player_'.$vimeo_player_id.'"></div>';

                    $alternative_button_vimeo = '
                    <a href="#" class="vimeo_player_button normal-inside" data-videoid="player_'.$vimeo_player_id.'"><i class="font-icon-play"></i></a>';

                } else {

                    $vimeo_button_play_output = '
                    <div class="video-header-status-vimeo pause" data-videovimeocheck="player_'.$vimeo_player_id.'">
                        <a href="#" class="vimeo_player_button" data-videoid="player_'.$vimeo_player_id.'"><i class="font-icon-play"></i></a>
                    </div>';

                    $alternative_button_vimeo = '';
                }

            }
            // Autoplay ON - LOOP OFF
            else if ( !$title_header_video_vimeo_autoplay == 'off' && $title_header_video_vimeo_loop == 'off' ) {

                if ( $check_title_header_text_display == 'show' && $title_heading_format == 'big_format') {

                    $vimeo_button_play_output = '
                    <div class="video-header-status-vimeo play" data-videovimeocheck="player_'.$vimeo_player_id.'"></div>';

                    $alternative_button_vimeo = '
                    <a href="#" class="vimeo_player_button inside hided" data-videoid="player_'.$vimeo_player_id.'" style="visibility:hidden;"><i class="font-icon-play"></i></a>';

                    $wrap_video_check = ' not-visible';

                } if ( $check_title_header_text_display == 'show' && $title_heading_format == 'normal_format') {

                    $vimeo_button_play_output = '
                    <div class="video-header-status-vimeo play" data-videovimeocheck="player_'.$vimeo_player_id.'"></div>';

                    $alternative_button_vimeo = '
                    <a href="#" class="vimeo_player_button normal-inside hided" data-videoid="player_'.$vimeo_player_id.'" style="visibility:hidden;"><i class="font-icon-play"></i></a>';

                    $wrap_video_check = ' not-visible';

                } else {

                    $vimeo_button_play_output = '
                    <div class="video-header-status-vimeo play" data-videovimeocheck="player_'.$vimeo_player_id.'">
                        <a href="#" class="vimeo_player_button hided" data-videoid="player_'.$vimeo_player_id.'" style="visibility:hidden;"><i class="font-icon-play"></i></a>
                    </div>';

                    $wrap_video_check = ' not-visible';

                    $alternative_button_vimeo = '';

                }

            }
            // Autoplay ON - LOOP ON
            else if ( !$title_header_video_vimeo_autoplay == 'off' && !$title_header_video_vimeo_loop == 'off' ) {

                if ( $check_title_header_text_display == 'show' && $title_heading_format == 'big_format') {

                    $vimeo_button_play_output = '
                    <div class="video-header-status-vimeo play" data-videovimeocheck="player_'.$vimeo_player_id.'"></div>';

                    $alternative_button_vimeo = '
                    <a href="#" class="vimeo_player_button inside hided" data-videoid="player_'.$vimeo_player_id.'" style="visibility:hidden;"><i class="font-icon-play"></i></a>';

                    $wrap_video_check = ' not-visible';

                } else if ( $check_title_header_text_display == 'show' && $title_heading_format == 'normal_format') {

                    $vimeo_button_play_output = '
                    <div class="video-header-status-vimeo play" data-videovimeocheck="player_'.$vimeo_player_id.'"></div>';

                    $alternative_button_vimeo = '
                    <a href="#" class="vimeo_player_button normal-inside hided" data-videoid="player_'.$vimeo_player_id.'" style="visibility:hidden;"><i class="font-icon-play"></i></a>';

                    $wrap_video_check = ' not-visible';

                } else {

                    $vimeo_button_play_output = '
                    <div class="video-header-status-vimeo play" data-videovimeocheck="player_'.$vimeo_player_id.'">
                        <a href="#" class="vimeo_player_button hided" data-videoid="player_'.$vimeo_player_id.'" style="visibility:hidden;"><i class="font-icon-play"></i></a>
                    </div>';

                    $wrap_video_check = ' not-visible';

                    $alternative_button_vimeo = '';
                }

            }
            // Autoplay OFF - LOOP ON
            else if ( $title_header_video_vimeo_autoplay == 'off' && !$title_header_video_vimeo_loop == 'off' ) {

                if ( $check_title_header_text_display == 'show' && $title_heading_format == 'big_format') {

                    $vimeo_button_play_output = '
                    <div class="video-header-status-vimeo pause" data-videovimeocheck="player_'.$vimeo_player_id.'"></div>';

                    $alternative_button_vimeo = '
                    <a href="#" class="vimeo_player_button inside" data-videoid="player_'.$vimeo_player_id.'"><i class="font-icon-play"></i></a>';

                } else if ( $check_title_header_text_display == 'show' && $title_heading_format == 'normal_format') {

                    $vimeo_button_play_output = '
                    <div class="video-header-status-vimeo pause" data-videovimeocheck="player_'.$vimeo_player_id.'"></div>';

                    $alternative_button_vimeo = '
                    <a href="#" class="vimeo_player_button normal-inside" data-videoid="player_'.$vimeo_player_id.'"><i class="font-icon-play"></i></a>';

                } else {

                    $vimeo_button_play_output = '
                    <div class="video-header-status-vimeo pause" data-videovimeocheck="player_'.$vimeo_player_id.'">
                        <a href="#" class="vimeo_player_button" data-videoid="player_'.$vimeo_player_id.'"><i class="font-icon-play"></i></a>
                    </div>';

                    $alternative_button_vimeo = '';

                }

            }

            // if Mobile/Tablet
            if ( $detect->isMobile() ) {

                $vimeo_button_play_output = $wrap_video_check = '';

                if ( $check_title_header_text_display == 'show' && $title_heading_format == 'big_format') {

                    $video_output = '
                    <div class="video-section-container vimeo-video">
                        <div class="mobile-video-fallback-image" style="'.$bg_video_image.'"></div>
                    </div>';

                    $alternative_button_vimeo = '
                    <a href="https://vimeo.com/'.$vimeo_video_id.'" target="_blank" class="mobile_video_button inside '.$video_mobile_out.'"><i class="font-icon-play"></i></a>';

                } else if ( $check_title_header_text_display == 'show' && $title_heading_format == 'normal_format') {

                    $video_output = '
                    <div class="video-section-container vimeo-video">
                        <div class="mobile-video-fallback-image" style="'.$bg_video_image.'"></div>
                    </div>';

                    $alternative_button_vimeo = '
                    <a href="https://vimeo.com/'.$vimeo_video_id.'" target="_blank" class="mobile_video_button normal-inside '.$video_mobile_out.'"><i class="font-icon-play"></i></a>';

                } else {

                    $alternative_button_vimeo = '';

                    $video_output = '
                    <div class="video-section-container vimeo-video">
                        <a href="https://vimeo.com/'.$vimeo_video_id.'" target="_blank" class="mobile_video_button '.$video_mobile_out.'"><i class="font-icon-play"></i></a>
                        <div class="mobile-video-fallback-image" style="'.$bg_video_image.'"></div>
                    </div>';
                }

            } else {

                $video_output = '
                '.$vimeo_button_play_output.'
                <div class="video-section-container vimeo-video">
                    <div class="video-embed-wrap">
                        <iframe class="vimeo video-header" data-volume="'.$vimeo_vol.'" data-autoplay="'.$vimeo_autoplay.'" data-loop="'.$vimeo_loop.'" id="player_'.$vimeo_player_id.'" src="http://player.vimeo.com/video/'.$vimeo_video_id.'?api=1&player_id=player_'.$vimeo_player_id.'" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>
                </div>';

            }

        }
        // Start Video Youtube
        else if ( $check_title_header_video == 'youtube_url') {

            // Check Video Mobile/Tablets Settings
            if ( $title_header_video_mobile_settings == 'lightbox' ) {
                $video_mobile_out = 'fancybox-media fancybox-video-popup';
            } else {
                $video_mobile_out = 'new-window-video';
            }
            
            $escape_url_yt = esc_attr( $title_header_video_youtube_url );
            $youtube_video_url = "videoURL:'https://www.youtube.com/watch?v=$escape_url_yt'";
            $youtube_container = "containment:'.title-header-container'";

            // Mobile Image
            $bg_video_image = ( !empty($title_header_video_image['url']) ) ? 'background-image: url('.$title_header_video_image['url'].');' : '';

            // Youtube Image
            $bg_video_image_yt = ( !empty($title_header_video_youtube_image['url']) ) ? '<div class="no-autoplay-video-fallback-image" style="background-image: url('.$title_header_video_youtube_image['url'].');"></div>' : '';
            
            // Mute Audio
            if( $title_header_video_youtube_vol == 'off') {
                $youtube_vol = 'false';
            } else {
                $youtube_vol = 'true';
            }

            // AutoPlay
            if( $title_header_video_youtube_autoplay == 'off') {
                $youtube_autoplay = 'false';
            } else {
                $youtube_autoplay = 'true';
            }

            // Loop
            if( $title_header_video_youtube_loop == 'off') {
                $youtube_loop = 'false';
            } else {
                $youtube_loop = 'true';
            }

            // Conditionals
            // Autoplay OFF - LOOP OFF
            if( $title_header_video_youtube_autoplay == 'off' && $title_header_video_youtube_loop == 'off' ) {

                if ( $check_title_header_text_display == 'show' && $title_heading_format == 'big_format') {

                    $youtube_button_play_output = '
                    <div class="video-header-status-youtube pause"></div>';

                    $alternative_button_yt = '
                    <a href="#" class="player_YT_Mod_button inside"><i class="font-icon-play"></i></a>';

                } else if ( $check_title_header_text_display == 'show' && $title_heading_format == 'normal_format') {

                    $youtube_button_play_output = '
                    <div class="video-header-status-youtube pause"></div>';

                    $alternative_button_yt = '
                    <a href="#" class="player_YT_Mod_button normal-inside"><i class="font-icon-play"></i></a>';

                } else {

                    $youtube_button_play_output = '
                    <div class="video-header-status-youtube pause">
                        <a href="#" class="player_YT_Mod_button"><i class="font-icon-play"></i></a>
                    </div>';

                    $alternative_button_yt = '';

                }

            }
            // Autoplay ON - LOOP OFF
            else if ( !$title_header_video_youtube_autoplay == 'off' && $title_header_video_youtube_loop == 'off' ) {
                
                if ( $check_title_header_text_display == 'show' && $title_heading_format == 'big_format') {

                    $youtube_button_play_output = '
                    <div class="video-header-status-youtube play"></div>';

                    $alternative_button_yt = '
                    <a href="#" class="player_YT_Mod_button inside" style="visibility:hidden;"><i class="font-icon-play"></i></a>';

                    $wrap_video_check = ' not-visible';

                } else if ( $check_title_header_text_display == 'show' && $title_heading_format == 'normal_format') {

                    $youtube_button_play_output = '
                    <div class="video-header-status-youtube play"></div>';

                    $alternative_button_yt = '
                    <a href="#" class="player_YT_Mod_button normal-inside" style="visibility:hidden;"><i class="font-icon-play"></i></a>';

                    $wrap_video_check = ' not-visible';

                } else {
                    
                    $youtube_button_play_output = '
                    <div class="video-header-status-youtube play">
                        <a href="#" class="player_YT_Mod_button" style="visibility:hidden;"><i class="font-icon-play"></i></a>
                    </div>';

                    $alternative_button_yt = '';

                    $wrap_video_check = ' not-visible';

                }

            }
            // Autoplay ON - LOOP ON
            else if ( !$title_header_video_youtube_autoplay == 'off' && !$title_header_video_youtube_loop == 'off' ) {

                if ( $check_title_header_text_display == 'show' && $title_heading_format == 'big_format') {

                    $youtube_button_play_output = '
                    <div class="video-header-status-youtube play"></div>';

                    $alternative_button_yt = '
                    <a href="#" class="player_YT_Mod_button inside" style="visibility:hidden;"><i class="font-icon-play"></i></a>';

                    $wrap_video_check = ' not-visible';


                } else if ( $check_title_header_text_display == 'show' && $title_heading_format == 'normal_format') {

                    $youtube_button_play_output = '
                    <div class="video-header-status-youtube play"></div>';

                    $alternative_button_yt = '
                    <a href="#" class="player_YT_Mod_button normal-inside" style="visibility:hidden;"><i class="font-icon-play"></i></a>';

                    $wrap_video_check = ' not-visible';


                } else {
                    
                    $youtube_button_play_output = '
                    <div class="video-header-status-youtube play">
                        <a href="#" class="player_YT_Mod_button" style="visibility:hidden;"><i class="font-icon-play"></i></a>
                    </div>';

                    $wrap_video_check = ' not-visible';

                    $alternative_button_yt = '';

                }

            }
            // Autoplay OFF - LOOP ON
            else if ( $title_header_video_youtube_autoplay == 'off' && !$title_header_video_youtube_loop == 'off' ) {

                if ( $check_title_header_text_display == 'show' && $title_heading_format == 'big_format') {

                    $youtube_button_play_output = '
                    <div class="video-header-status-youtube pause"></div>';

                    $alternative_button_yt = '
                    <a href="#" class="player_YT_Mod_button inside"><i class="font-icon-play"></i></a>';

                } else if ( $check_title_header_text_display == 'show' && $title_heading_format == 'normal_format') {

                    $youtube_button_play_output = '
                    <div class="video-header-status-youtube pause"></div>';

                    $alternative_button_yt = '
                    <a href="#" class="player_YT_Mod_button normal-inside"><i class="font-icon-play"></i></a>';

                } else {
                    
                    $youtube_button_play_output = '
                    <div class="video-header-status-youtube pause">
                        <a href="#" class="player_YT_Mod_button"><i class="font-icon-play"></i></a>
                    </div>';

                    $alternative_button_yt = '';

                }

            }

            // if Mobile/Tablet
            if ( $detect->isMobile() ) {

                $youtube_button_play_output = $wrap_video_check = '';

                if ( $check_title_header_text_display == 'show' && $title_heading_format == 'big_format') {

                    $video_output = '
                    <div class="video-section-container youtube-video">
                        <div class="mobile-video-fallback-image" style="'.$bg_video_image.'"></div>
                    </div>';

                    $alternative_button_yt = '
                    <a href="https://www.youtube.com/watch?v='.$escape_url_yt.'" target="_blank" class="mobile_video_button inside '.$video_mobile_out.'"><i class="font-icon-play"></i></a>';

                } else if ( $check_title_header_text_display == 'show' && $title_heading_format == 'big_format') {

                    $video_output = '
                    <div class="video-section-container youtube-video">
                        <div class="mobile-video-fallback-image" style="'.$bg_video_image.'"></div>
                    </div>';

                    $alternative_button_yt = '
                    <a href="https://www.youtube.com/watch?v='.$escape_url_yt.'" target="_blank" class="mobile_video_button normal-inside '.$video_mobile_out.'"><i class="font-icon-play"></i></a>';

                } else {

                    $alternative_button_yt = '';

                    $video_output = '
                    <div class="video-section-container youtube-video">
                        <a href="https://www.youtube.com/watch?v='.$escape_url_yt.'" target="_blank" class="mobile_video_button '.$video_mobile_out.'"><i class="font-icon-play"></i></a>
                        <div class="mobile-video-fallback-image" style="'.$bg_video_image.'"></div>
                    </div>';

                }


            } else {

                $video_output = '
                '.$youtube_button_play_output.'
                '.$bg_video_image_yt.'
                <a class="player_YT_Mod" data-autoplay="'.$youtube_autoplay.'" data-property="{'.$youtube_video_url.','.$youtube_container.',startAt:0,mute:'.$youtube_vol.',autoPlay:'.$youtube_autoplay.',loop:'.$youtube_loop.',opacity:1,printUrl:false,showControls:false,stopMovieOnBlur:false}"></a>';

            }

        } 
        // Start Video Self-Hosted
        else if ( $check_title_header_video == 'self_hosted') {

            // Check Video Mobile/Tablets Settings
            if ( $title_header_video_mobile_settings == 'lightbox' ) {
                $video_mobile_out = 'fancybox-media fancybox-video-popup-self-hosted';
            } else {
                $video_mobile_out = 'new-window-video';
            }

            $uniq_video = uniqid();
            $player_video_id = 'player_'.$uniq_video;

            // Mute Audio
            if( $title_header_video_volume == 'off') {
                $video_vol = 'unmute';
            } else {
                $video_vol = 'mute';
            }

            // AutoPlay
            if( $title_header_video_autoplay == 'off') {
                $video_autoplay = 'false';
            } else {
                $video_autoplay = 'true';
            }

            // Loop
            if ( $title_header_video_loop == 'off') { 
                $video_loop = '';
            } else {
                $video_loop = 'loop';
            }

            $bg_video_image = ( !empty($title_header_video_image['url']) ) ? 'background-image: url('.$title_header_video_image['url'].');' : '';

            $url_video_webm = ( !empty($title_header_video_webm['url']) ) ? $title_header_video_webm['url'] : '';
            $url_video_mp4  = ( !empty($title_header_video_mp4['url']) ) ? $title_header_video_mp4['url'] : '';

            // Conditionals
            // Autoplay OFF - LOOP OFF
            if( $title_header_video_autoplay == 'off' && $title_header_video_loop == 'off' ) {
                
                if ( $check_title_header_text_display == 'show' && $title_heading_format == 'big_format') {
                    
                    $self_button_play_output = '
                    <div class="video-header-status-self pause"></div>';

                    $alternative_button_self = '
                    <a href="#" class="self_player_button inside"><i class="font-icon-play"></i></a>';

                } else if ( $check_title_header_text_display == 'show' && $title_heading_format == 'normal_format') {

                    $self_button_play_output = '
                    <div class="video-header-status-self pause"></div>';

                    $alternative_button_self = '
                    <a href="#" class="self_player_button normal-inside"><i class="font-icon-play"></i></a>';

                } else {

                    $self_button_play_output = '
                    <div class="video-header-status-self pause">
                        <a href="#" class="self_player_button"><i class="font-icon-play"></i></a>
                    </div>';

                    $alternative_button_self = '';
                }
            }
            // Autoplay ON - LOOP OFF
            else if ( !$title_header_video_autoplay == 'off' && $title_header_video_loop == 'off' ) {

                if ( $check_title_header_text_display == 'show' && $title_heading_format == 'big_format') {

                    $self_button_play_output = '
                    <div class="video-header-status-self play"></div>';

                    $alternative_button_self = '
                    <a href="#" class="self_player_button inside" style="visibility:hidden;"><i class="font-icon-play"></i></a>';

                    $wrap_video_check = ' not-visible';

                    $bg_self_image_visibility = ' played';

                } else if ( $check_title_header_text_display == 'show' && $title_heading_format == 'normal_format') {

                    $self_button_play_output = '
                    <div class="video-header-status-self play"></div>';

                    $alternative_button_self = '
                    <a href="#" class="self_player_button normal-inside" style="visibility:hidden;"><i class="font-icon-play"></i></a>';

                    $wrap_video_check = ' not-visible';

                    $bg_self_image_visibility = ' played';

                } else {

                    $self_button_play_output = '
                    <div class="video-header-status-self play">
                        <a href="#" class="self_player_button" style="visibility:hidden;"><i class="font-icon-play"></i></a>
                    </div>';

                    $wrap_video_check = ' not-visible';

                    $bg_self_image_visibility = ' played';

                    $alternative_button_self = '';

                }
            }
            // Autoplay ON - LOOP ON
            else if ( !$title_header_video_autoplay == 'off' && !$title_header_video_loop == 'off' ) {
                
                if ( $check_title_header_text_display == 'show' && $title_heading_format == 'big_format') {

                    $self_button_play_output = '
                    <div class="video-header-status-self play"></div>';

                    $alternative_button_self = '
                    <a href="#" class="self_player_button inside" style="visibility:hidden;"><i class="font-icon-play"></i></a>';

                    $wrap_video_check = ' not-visible';

                    $bg_self_image_visibility = ' played';

                } else if ( $check_title_header_text_display == 'show' && $title_heading_format == 'normal_format') {

                    $self_button_play_output = '
                    <div class="video-header-status-self play"></div>';

                    $alternative_button_self = '
                    <a href="#" class="self_player_button normal-inside" style="visibility:hidden;"><i class="font-icon-play"></i></a>';

                    $wrap_video_check = ' not-visible';

                    $bg_self_image_visibility = ' played';

                } else {

                    $self_button_play_output = '
                    <div class="video-header-status-self play">
                        <a href="#" class="self_player_button" style="visibility:hidden;"><i class="font-icon-play"></i></a>
                    </div>';

                    $wrap_video_check = ' not-visible';

                    $bg_self_image_visibility = ' played';
                    
                    $alternative_button_self = '';

                }
            }
            // Autoplay OFF - LOOP ON
            else if ( $title_header_video_autoplay == 'off' && !$title_header_video_loop == 'off' ) {
                
                if ( $check_title_header_text_display == 'show' && $title_heading_format == 'big_format') {

                    $self_button_play_output = '
                    <div class="video-header-status-self pause"></div>';

                    $alternative_button_self = '
                    <a href="#" class="self_player_button inside"><i class="font-icon-play"></i></a>';

                } else if ( $check_title_header_text_display == 'show' && $title_heading_format == 'normal_format') {

                    $self_button_play_output = '
                    <div class="video-header-status-self pause"></div>';

                    $alternative_button_self = '
                    <a href="#" class="self_player_button normal-inside"><i class="font-icon-play"></i></a>';

                } else {

                    $self_button_play_output = '
                    <div class="video-header-status-self pause">
                        <a href="#" class="self_player_button"><i class="font-icon-play"></i></a>
                    </div>';

                    $alternative_button_self = '';
                }
            }

            // if Mobile/Tablet
            if ( $detect->isMobile() ) {

                $self_player_button = $wrap_video_check = $bg_self_image_visibility = '';

                if ( $check_title_header_text_display == 'show' && $title_heading_format == 'big_format') {

                    $video_output = '
                    <div class="video-section-container self-hosted-video">
                        <div class="mobile-video-fallback-image" style="'.$bg_video_image.'"></div>
                    </div>';

                    $alternative_button_self = '
                    <a href="'.$url_video_mp4.'" target="_blank" class="mobile_video_button inside '.$video_mobile_out.'" data-poster="'.$title_header_video_self_image['url'].'"><i class="font-icon-play"></i></a>';

                } else if ( $check_title_header_text_display == 'show' && $title_heading_format == 'normal_format') {

                    $video_output = '
                    <div class="video-section-container self-hosted-video">
                        <div class="mobile-video-fallback-image" style="'.$bg_video_image.'"></div>
                    </div>';

                    $alternative_button_self = '
                    <a href="'.$url_video_mp4.'" target="_blank" class="mobile_video_button normal-inside '.$video_mobile_out.'" data-poster="'.$title_header_video_self_image['url'].'"><i class="font-icon-play"></i></a>';

                } else {

                    $alternative_button_self = '';

                    $video_output = '
                    <div class="video-section-container self-hosted-video">
                        <a href="'.$url_video_mp4.'" target="_blank" class="mobile_video_button '.$video_mobile_out.'" data-poster="'.$title_header_video_self_image['url'].'"><i class="font-icon-play"></i></a>
                        <div class="mobile-video-fallback-image" style="'.$bg_video_image.'"></div>
                    </div>';
                }

            } else {

                $bg_video_image_self = ( !empty($title_header_video_self_image['url']) ) ? '<div class="no-autoplay-video-fallback-image-self'.$bg_self_image_visibility.'" style="background-image: url('.$title_header_video_self_image['url'].');"></div>' : '';

                $video_output = '
                <div class="video-section-container self-hosted-video">
                '.$self_button_play_output.'
                '.$bg_video_image_self.'
                    <div class="video-wrap">
                        <video id="'.$player_video_id.'" class="video-header" preloader="auto" '.$video_loop.' width="1920" height="800" data-volume="'.$video_vol.'" data-autoplay="'.$video_autoplay.'" data-loop="'.$video_loop.'">
                            <source type="video/webm" src="'.$url_video_webm.'">
                            <source type="video/mp4" src="'.$url_video_mp4.'">
                        </video>
                    </div>
                </div>';

            }

        }

        // Check Slider Output
        $slider_output = $slider_autoplay = $slider_loop = $slide_speed = $slideshow_speed = $animation_slide = $parallax_slide = $parallax_css = $scroll_btn_output = null;

        if ( $check_title_header_slider == 'rev_slider') {
            $slider_output = do_shortcode('[rev_slider '.$rev_slider_alias.']');
        }

        else if ( $check_title_header_slider == 'az_slider') { 
            
            // Animation Type
            if ( $az_slider_animation_type == 'slide') {
                $animation_slide = 'slide';
            }
            else {
                $animation_slide = 'fade';
            }

            // Autoplay
            if ( $az_slider_autoplay == 'off' ) {

                $slider_autoplay = 'false';

                // Loop
                if ( $az_slider_loop == 'off' ) {
                    $slider_loop = 'false';
                } else {
                    $slider_loop = 'false';
                }

            } else {

                $slider_autoplay = 'true';

                // Loop
                if ( $az_slider_loop == 'off' ) {
                    $slider_loop = 'false';
                } else {
                    $slider_loop = 'true';
                }

            }

            // Slide Speed
            $slide_speed = $az_slider_slide_speed;

            // SlideShow Speed
            $slideshow_speed = $az_slider_slideshow_speed;

            // Parallax
            if ( $az_slider_parallax_slide == 'off' ) {
                $parallax_slide = 'false';
                $parallax_css = '';
            } else {
                $parallax_slide = 'true';
                $parallax_css = ' background-position: center top;';
            }

            $slider_output .= '
                <div id="title-header-flexslider" class="flexslider" data-parallax="'.$parallax_slide.'" data-slide-type="'.$animation_slide.'" data-slide-easing="swing" data-slide-speed="'.esc_attr($slide_speed).'" data-slide-loop="'.$slider_loop.'" data-slideshow="'.$slider_autoplay.'" data-slideshow-speed="'.esc_attr($slideshow_speed).'">
                    <ul class="slides">';

            // Output Slides
            if ( $az_slider_text_format == 'big_format') {
                $slider_text_format = ' big-format-heading';
            } else {
                $slider_text_format = ' normal-format-heading';
            }

            $values = $options_az['az_title_header_az_slider_alias'];
                if(is_array($values)) {

                    foreach ($values as $value) :

                        $slider_output .= '
                            <li class="slide" style="background-image: url('.$value['image'].');'.$parallax_css.'">
                                '.$mask_output.'';


                        if (!empty($value['title']) || !empty($value['description']) || !empty($value['url']) ) {
                            $slider_output .='
                            <div class="slider-content'.$slider_text_format.'">';
                        }

                        if (!empty($value['url'])) {
                            $slider_output .= '
                            <a href="'.esc_url($value['url']).'">';
                        }

                        if (!empty($value['title'])) {
                            $slider_output .= '
                            <h1 class="slide-title">'.wp_kses($value['title'], $allowed_tags).'</h1>';
                        }

                        if (!empty($value['description'])) {
                            $slider_output .= '
                            <h2 class="slide-subtitle">'.wp_kses($value['description'], $allowed_tags).'</h2>';
                        }
                        
                        if (!empty($value['url'])) {
                            $slider_output .= '
                            </a>';
                        }

                        if (!empty($value['title']) || !empty($value['description']) || !empty($value['url']) ) {
                            $slider_output .='
                            </div>';
                        }
                        

                        $slider_output .= '
                            </li>';
                    endforeach;

                }

            $slider_output .= '
                    </ul>';

            // Output Pagination Slide
            $slider_output .= '
                <ol class="flex-control-nav flex-control-paging">';

            $elements = $options_az['az_title_header_az_slider_alias'];
                if(is_array($elements)) {

                    foreach ($elements as $element) :

                        $slider_output .= '
                            <li><a>'.strip_tags($element['title']).'</a></li>';
                    endforeach;

                }
            $slider_output .= '
                </ol>';

            $slider_output .= '
                </div>';

        }
?>

<div class="wrap-title-header <?php echo esc_attr($device_version); ?>">
<?php if ( $check_title_header_settings == 'show' ){ ?>
    
    <div class="fake-layer-spacer<?php echo esc_attr($mode_height); ?>"<?php echo !empty( $title_header_height_output ) ? $title_header_height_output : ''; ?>></div>

    <?php if ( $check_title_header_module == 'image') { ?>
    
    <div id="image-header" class="title-header-spacer">
        <div class="title-header-container imagize<?php echo esc_attr($mode_height); ?><?php echo esc_attr($title_header_layout_class); ?>"<?php echo !empty( $bg_mode_output ) ? $bg_mode_output : ''; ?>>
            <?php echo !empty( $mask_output ) ? $mask_output : ''; ?>
            <?php if ( $check_title_header_text_display == 'show' ){ ?>
            <div class="box-content<?php echo esc_attr($heading_format); ?>">
                <div class="box-content-titles">
                    <?php if( !empty($title_heading) ) { ?>
                    <h1 class="title"<?php echo !empty( $text_color ) ? $text_color : ''; ?>><?php echo wp_kses($title_heading, $allowed_tags); ?></h1>
                    <?php } else { ?>
                    <h1 class="title"<?php echo !empty( $text_color ) ? $text_color : ''; ?>><?php echo the_title(); ?></h1>
                    <?php } ?>
                    <?php if( !empty($title_subheading) ) { ?>
                    <h2 class="subheading"<?php echo !empty( $text_color ) ? $text_color : ''; ?>><?php echo wp_kses($title_subheading, $allowed_tags); ?></h2>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php if($check_title_header_layout == 'fullscreen' && $scrollBtn == 'enable') { echo '<a class="scroll-btn-full-area-title-header"><i class="font-icon-arrow-down-simple-thin-round animated-opacity"></i></a>'; } ?>
    </div>

    <?php } else if ( $check_title_header_module == 'image_parallax') { ?>

    <div id="image-parallax-header" class="title-header-spacer">
        <div class="title-header-container imagize-parallax<?php echo esc_attr($mode_height); ?><?php echo esc_attr($title_header_layout_class); ?>"<?php echo !empty( $bg_mode_parallax ) ? $bg_mode_parallax : ''; ?>>
            <?php echo !empty( $mask_output ) ? $mask_output : ''; ?>
            <?php if ( $check_title_header_text_display == 'show' ){ ?>
            <div class="box-content<?php echo esc_attr($heading_format); ?>">
                <div class="box-content-titles">
                    <?php if( !empty($title_heading) ) { ?>
                    <h1 class="title"<?php echo !empty( $text_color ) ? $text_color : ''; ?>><?php echo wp_kses($title_heading, $allowed_tags); ?></h1>
                    <?php } else { ?>
                    <h1 class="title"<?php echo !empty( $text_color ) ? $text_color : ''; ?>><?php echo the_title(); ?></h1>
                    <?php } ?>
                    <?php if( !empty($title_subheading) ) { ?>
                    <h2 class="subheading"<?php echo !empty( $text_color ) ? $text_color : ''; ?>><?php echo wp_kses($title_subheading, $allowed_tags); ?></h2>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php if($check_title_header_layout == 'fullscreen' && $scrollBtn == 'enable') { echo '<a class="scroll-btn-full-area-title-header"><i class="font-icon-arrow-down-simple-thin-round animated-opacity"></i></a>'; } ?>
    </div>

    <?php } else if ( $check_title_header_module == 'video') { ?>

    <div id="video-header" class="<?php echo esc_attr($check_title_header_video); ?> title-header-spacer">          
        <div class="title-header-container<?php echo esc_attr($mode_height); ?><?php echo esc_attr($title_header_layout_class); ?>"<?php echo !empty( $title_header_height_output ) ? $title_header_height_output : ''; ?>>
            <?php echo !empty( $mask_output ) ? $mask_output : ''; ?>
            <?php echo !empty( $video_output ) ? $video_output : ''; ?>
            <?php if ( $check_title_header_text_display == 'show' ){ ?>
            <div class="box-content<?php echo esc_attr($heading_format); ?><?php echo esc_attr($wrap_video_check); ?>">
                <div class="box-content-titles">
                    <?php if( !empty($title_heading) ) { ?>
                    <h1 class="title"<?php echo !empty( $text_color ) ? $text_color : ''; ?>><?php echo wp_kses($title_heading, $allowed_tags); ?></h1>
                    <?php } else { ?>
                    <h1 class="title"<?php echo !empty( $text_color ) ? $text_color : ''; ?>><?php echo the_title(); ?></h1>
                    <?php } ?>
                    <?php if( !empty($title_subheading) ) { ?>
                    <h2 class="subheading"<?php echo !empty( $text_color ) ? $text_color : ''; ?>><?php echo wp_kses($title_subheading, $allowed_tags); ?></h2>
                    <?php } ?>
                    <?php echo !empty( $alternative_button_self ) ? $alternative_button_self : ''; ?>
                    <?php echo !empty( $alternative_button_yt ) ? $alternative_button_yt : ''; ?>
                    <?php echo !empty( $alternative_button_vimeo ) ? $alternative_button_vimeo : ''; ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php if($check_title_header_layout == 'fullscreen' && $scrollBtn == 'enable') { echo '<a class="scroll-btn-full-area-title-header"><i class="font-icon-arrow-down-simple-thin-round animated-opacity"></i></a>'; } ?>
    </div>

    <?php } else if ( $check_title_header_module == 'slider') { ?>
    
    <div id="slider-header-revolution" class="title-header-spacer <?php echo esc_attr($check_title_header_slider); ?>">   
        <div class="title-header-container<?php echo esc_attr($mode_height); ?><?php echo esc_attr($title_header_layout_class); ?>"<?php echo !empty( $title_header_height_output ) ? $title_header_height_output : ''; ?>>
            <?php echo !empty( $slider_output ) ? $slider_output : ''; ?>
        </div>
        <?php if($check_title_header_layout == 'fullscreen' && $scrollBtn == 'enable' && $check_title_header_slider == 'az_slider' ) { echo '<a class="scroll-btn-full-area-title-header"><i class="font-icon-arrow-down-simple-thin-round animated-opacity"></i></a>'; } ?>
    </div>

    <?php } else if ( $check_title_header_module == 'animate') { ?>

    <div id="animated-pattern-header" class="title-header-spacer">                
        <div class="title-header-container animate-bg-scroll<?php echo esc_attr($mode_height); ?><?php echo esc_attr($title_header_layout_class); ?>"<?php echo !empty( $bg_url_animate ) ? $bg_url_animate : ''; ?>>
            <?php echo !empty( $output_css_animation ) ? $output_css_animation : ''; ?>
            <?php if ( $check_title_header_text_display == 'show' ){ ?>
            <div class="box-content<?php echo esc_attr($heading_format); ?>">
                <div class="box-content-titles">
                    <?php if( !empty($title_heading) ) { ?>
                    <h1 class="title"<?php echo !empty( $text_color ) ? $text_color : ''; ?>><?php echo wp_kses($title_heading, $allowed_tags); ?></h1>
                    <?php } else { ?>
                    <h1 class="title"<?php echo !empty( $text_color ) ? $text_color : ''; ?>><?php echo the_title(); ?></h1>
                    <?php } ?>
                    <?php if( !empty($title_subheading) ) { ?>
                    <h2 class="subheading"<?php echo !empty( $text_color ) ? $text_color : ''; ?>><?php echo wp_kses($title_subheading, $allowed_tags); ?></h2>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php if($check_title_header_layout == 'fullscreen' && $scrollBtn == 'enable') { echo '<a class="scroll-btn-full-area-title-header"><i class="font-icon-arrow-down-simple-thin-round animated-opacity"></i></a>'; } ?>
    </div>
    <?php } else { ?>

    <div id="text-header" class="title-header-spacer">
        <div class="title-header-container<?php echo esc_attr($mode_height); ?><?php echo esc_attr($title_header_layout_class); ?>"<?php echo !empty( $fill_bg_h ) ? $fill_bg_h : ''; ?>>
            <?php if ( $check_title_header_text_display == 'show' ){ ?>
            <div class="box-content<?php echo esc_attr($heading_format); ?>">
                <div class="box-content-titles">
                    <?php if( !empty($title_heading) ) { ?>
                    <h1 class="title"<?php echo !empty( $text_color ) ? $text_color : ''; ?>><?php echo wp_kses($title_heading, $allowed_tags); ?></h1>
                    <?php } else { ?>
                    <h1 class="title"<?php echo !empty( $text_color ) ? $text_color : ''; ?>><?php echo the_title(); ?></h1>
                    <?php } ?>
                    <?php if( !empty($title_subheading) ) { ?>
                    <h2 class="subheading"<?php echo !empty( $text_color ) ? $text_color : ''; ?>><?php echo wp_kses($title_subheading, $allowed_tags); ?></h2>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php if($check_title_header_layout == 'fullscreen' && $scrollBtn == 'enable') { echo '<a class="scroll-btn-full-area-title-header"><i class="font-icon-arrow-down-simple-thin-round animated-opacity"></i></a>'; } ?>
    </div>

    <?php } ?>

<?php } else { ?>

    <?php if ( $check_title_header_settings == 'hide' && $check_title_header_hide_settings == 'colorful'){ ?>
    <div class="no-page-header colorful-version"<?php echo !empty( $fill_hide_bg ) ? $fill_hide_bg : ''; ?>></div>
    <?php } else { ?>
    <div class="no-page-header transparent-version"></div>
    <?php } ?>

<?php } ?>

</div>
<?php }
} 

/*-----------------------------------------------------------------------------------*/
/*  - Preloader Page/Post Settings
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'az_preloader' ) ) {
    function az_preloader($postid) {
        global $options_panda, $post;

        $check_preloader_design = (!empty($options_panda['preloader_design_mode'])) ? $options_panda['preloader_design_mode'] : '1';

        $output_preloader = '';
        $output_preloader .= '
        <div id="preloader-container">';

        if( $check_preloader_design == '1' ) { 
            
            $output_preloader .= '
            <div class="preloader-page">
                <div class="pre-progress-bar"></div>
                <div class="pre-background-bar"></div>
            </div>';

        } else if( $check_preloader_design == '2' ) {

            $preloader_image = $options_panda['preloader_media_image'];
            $preloader_image_width = $options_panda['preloader_media_image']['width'];
            $preloader_image_height = $options_panda['preloader_media_image']['height'];
            $preloader_image_width_content = $preloader_image_width/2;
            $preloader_image_height_content = $preloader_image_height/2;

            $output_preloader .= '
            <div class="preloader-page" style="width: '.$preloader_image_width.'px; height: '.$preloader_image_height.'px; margin-left: -'.$preloader_image_width_content.'px; margin-top: -'.$preloader_image_height_content.'px;">
                <div class="preloader-loading-image" style="background-image: url('.$preloader_image['url'].'); width: '.$preloader_image_width.'px; height: '.$preloader_image_height.'px;"></div>
            </div>
            ';

        }

        $output_preloader .= '
        </div>';

        // If Search
        if ( is_search() ) {

            $check_search_preloader_settings = $options_panda['search_preloader_visibility'];

            if ( $check_search_preloader_settings == 'show' ) {
                echo !empty( $output_preloader ) ? $output_preloader : '';
            }

        } else if ( is_archive() ) {

            $check_archive_preloader_settings = $options_panda['archive_preloader_visibility'];

            if ( $check_archive_preloader_settings == 'show' ) {
                echo !empty( $output_preloader ) ? $output_preloader : '';
            }

        } else if ( is_404() ) {

            $check_error_preloader_settings = $options_panda['error_preloader_visibility'];

            if ( $check_error_preloader_settings == 'show' ) {
                echo !empty( $output_preloader ) ? $output_preloader : '';
            }

        } else {

            $options_az = redux_post_meta( 'panda' , $postid );
            $check_preloader_settings = $options_az['az_preloader_display'];

            if ( $check_preloader_settings == 'show' ) {
                echo !empty( $output_preloader ) ? $output_preloader : '';
            }
        
        }
    }
} 

/*-----------------------------------------------------------------------------------*/
/*  - Footer Widgets Area Page/Post Settings
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'az_footer_widget' ) ) {
    function az_footer_widget($postid) {
        global $options_panda, $post;

        $footer_widget_color_area = (!empty($options_panda['footer_widget_area_color_type'])) ? $options_panda['footer_widget_area_color_type'] : 'dark-type';
        $footer_widget_cols = (!empty($options_panda['footer_widget_columns'])) ? $options_panda['footer_widget_columns'] : '3';
        $footer_data_cols = ' data-cols="'.$footer_widget_cols.'"';

        $output_footer_widgets = '';

        if(!function_exists('get_dynamic_sidebar')){
            function get_dynamic_sidebar($index = 1){
                $sidebar_contents = "";
                ob_start();
                dynamic_sidebar($index);
                $sidebar_contents = ob_get_clean();
                return $sidebar_contents;
            }
        }

        $output_footer_widgets .= '
        <div class="footer-widget-area '.$footer_widget_color_area.'"'.$footer_data_cols.'>';

        $output_footer_widgets .= '
        <div class="item-footer-widget-area">'.get_dynamic_sidebar('footer-area-one').'</div>
        <div class="item-footer-widget-area">'.get_dynamic_sidebar('footer-area-two').'</div>';

        if($footer_widget_cols == '3' || $footer_widget_cols == '4'){
            $output_footer_widgets .= '
            <div class="item-footer-widget-area">'.get_dynamic_sidebar('footer-area-three').'</div>';
        }

        if($footer_widget_cols == '4'){
            $output_footer_widgets .= '
            <div class="item-footer-widget-area">'.get_dynamic_sidebar('footer-area-four').'</div>';
        }

        $output_footer_widgets .= '
        </div>';

        // If Search
        if ( is_search() ) {

            $check_search_footer_widgets_settings = $options_panda['search_footer_widget_visibility'];
            
            if ( $check_search_footer_widgets_settings == 'show' ) {
                echo !empty( $output_footer_widgets ) ? $output_footer_widgets : '';
            }

        } else if ( is_archive() ) {

            $check_archive_footer_widgets_settings = $options_panda['archive_footer_widget_visibility'];
            
            if ( $check_archive_footer_widgets_settings == 'show' ) {
                echo !empty( $output_footer_widgets ) ? $output_footer_widgets : '';
            }

        } else {

            $options_az = redux_post_meta( 'panda' , $postid );
            $check_footer_widgets_settings = $options_az['az_footer_widget_display'];

            if ( $check_footer_widgets_settings == 'show' ) {
                echo !empty( $output_footer_widgets ) ? $output_footer_widgets : '';
            }
        
        }
    }
} 

/*-----------------------------------------------------------------------------------*/
/*  - Dots Menu
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'az_dots_menu_navigation' ) ) {
    function az_dots_menu_navigation($postid) {
        global $options_panda, $post;

        $options_az = redux_post_meta( 'panda' , $postid );

        $check_display_dots_menu = $options_az['az_dots_menu_display'];
        $section_ids_dots_menu = $options_az['az_dots_menu_id_sections'];
        $section_label_dots_menu = $options_az['az_dots_menu_label_sections'];

        $output_dots_menu = '';
        if ( $check_display_dots_menu == 'show' ){

            // Explde Section ID
            $sections_ids_array = explode(',', esc_attr($section_ids_dots_menu));
            $sections_ids_array = array_map('trim', $sections_ids_array);

            // Explode Section Label
            $sections_label_array = explode(',', esc_attr($section_label_dots_menu));
            $sections_label_array = array_map('trim', $sections_label_array);

            $i = 1;
            if ( !empty($section_label_dots_menu) ) {

                foreach ( array_combine($sections_ids_array, $sections_label_array) as $item => $name ) :

                    $output_dots_menu = '<li><a href="#'.strtolower($item).'" class="dots-menu-anchor" data-number="'.$i.'"><span class="dots-menu-dot"></span><span class="dots-menu-label">'.$name.'</span></a></li>';
                    echo !empty( $output_dots_menu ) ? $output_dots_menu : '';

                    $i++;
                endforeach;

            } else {
                
                foreach ( $sections_ids_array as $item ) :

                    $output_dots_menu = '<li><a href="#'.strtolower($item).'" class="dots-menu-anchor" data-number="'.$i.'"><span class="dots-menu-dot"></span></a></li>';
                    echo !empty( $output_dots_menu ) ? $output_dots_menu : '';

                    $i++;
                endforeach;

            }

        }
    }
}


