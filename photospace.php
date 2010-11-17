<?php
/*
Plugin Name: Photospace
Plugin URI: http://thriveweb.com.au/blog/photospace-wordpress-gallery-plugin/
Description: A image gallery for WordPress. This plugin uses a modified version of Galleriffic and Smart image resizer. 
<a href="http://www.twospy.com/galleriffic/>galleriffic</a>
<a href="http://shiftingpixel.com/2008/03/03/smart-image-resizer/>Smart Image Resizer</a>
Author: Dean Oakley
Author URI: http://deanoakley.com/
Version: 1.6.2
*/

/*  Copyright 2010  Dean Oakley  (email : contact@deanoakley.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { 
	die('Illegal Entry');  
}

//============================== Photospace options ========================//
class photospace_plugin_options {

	function PS_getOptions() {
		$options = get_option('ps_options');
		
		if (!is_array($options)) {
									
			$options['num_thumb'] = '9';
			
			$options['use_hover'] = false;
			
			$options['show_captions'] = false;
			
			$options['show_download'] = false;
			
			$options['show_controls'] = false;
			
			$options['show_bg'] = false;
			
			$options['auto_play'] = false;			
			$options['delay'] = 3500;
			$options['hide_thumbs'] = false;
			
			$options['reset_css'] = false;
			
			$options['thumbnail_margin'] = 10;
			
			$options['thumbnail_width'] = 50;
			$options['thumbnail_height'] = 50;
			$options['thumbnail_crop_ratio'] = '1:1';	
			
			$options['thumb_col_width'] = '181';	
			$options['main_col_width'] = '400';
			$options['main_col_height'] = '500';
			$options['gallery_width'] = '600';			
			
			update_option('ps_options', $options);
		}
		return $options;
	}

	function update() {
		if(isset($_POST['ps_save'])) {
			$options = photospace_plugin_options::PS_getOptions();
			
			$options['num_thumb'] = stripslashes($_POST['num_thumb']);
			$options['thumbnail_margin'] =  stripslashes($_POST['thumbnail_margin']);
			$options['thumbnail_width'] = stripslashes($_POST['thumbnail_width']);
			$options['thumbnail_height'] = stripslashes($_POST['thumbnail_height']);			
			$options['thumbnail_crop_ratio'] = stripslashes($_POST['thumbnail_crop_ratio']);
			
			$options['thumb_col_width'] = stripslashes($_POST['thumb_col_width']);
			$options['main_col_width'] = stripslashes($_POST['main_col_width']);
			$options['main_col_height'] = stripslashes($_POST['main_col_height']);
			
			$options['gallery_width'] = stripslashes($_POST['gallery_width']);
			
			$options['delay'] = stripslashes($_POST['delay']);
			
			
			if ($_POST['show_controls']) {
				$options['show_controls'] = (bool)true;
			} else {
				$options['show_controls'] = (bool)false;
			} 
			
			if ($_POST['show_download']) {
				$options['show_download'] = (bool)true;
			} else {
				$options['show_download'] = (bool)false;
			} 
			
			if ($_POST['show_captions']) {
				$options['show_captions'] = (bool)true;
			} else {
				$options['show_captions'] = (bool)false;
			}
			
			if ($_POST['show_bg']) {
				$options['show_bg'] = (bool)true;
			} else {
				$options['show_bg'] = (bool)false;
			} 
					
			if ($_POST['use_hover']) {
				$options['use_hover'] = (bool)true;
			} else {
				$options['use_hover'] = (bool)false;
			}
			
			if ($_POST['auto_play']) {
				$options['auto_play'] = (bool)true;
			} else {
				$options['auto_play'] = (bool)false;
			}
			
			if ($_POST['hide_thumbs']) {
				$options['hide_thumbs'] = (bool)true;
			} else {
				$options['hide_thumbs'] = (bool)false;
			}
			
			if ($_POST['reset_css']) {
				$options['reset_css'] = (bool)true;
			} else {
				$options['reset_css'] = (bool)false;
			}			
			
			update_option('ps_options', $options);

		} else {
			photospace_plugin_options::PS_getOptions();
		}

		add_menu_page('Photospace options', 'Photospace Gallery Options', 'edit_themes', basename(__FILE__), array('photospace_plugin_options', 'display'));
	}
	

	function display() {
		
		$options = photospace_plugin_options::PS_getOptions();
		?>
		
		<div class="wrap">
		
			<h2>Photospace Options</h2>
			
			<form method="post" action="#" enctype="multipart/form-data">				

				<!-- Too buggy			
				<h3>Change photo on hover?</h3>
				<p><input name="use_hover" type="checkbox" value="checkbox" <?php if($options['use_hover']) echo "checked='checked'"; ?> /> Yes </p>
				<br />-->
				
				<div class="wp-menu-separator" style="clear:both; padding-bottom:15px; border-bottom:solid 1px #e6e6e6" ></div>
				
				<h3><label><input name="show_download" type="checkbox" value="checkbox" <?php if($options['show_download']) echo "checked='checked'"; ?> /> Show download link</label></h3>			
				
				<h3><label><input name="show_controls" type="checkbox" value="checkbox" <?php if($options['show_controls']) echo "checked='checked'"; ?> /> Show controls (play slide show / Next Prev image links)</label></h3>			
				
				<h3><label><input name="show_captions" type="checkbox" value="checkbox" <?php if($options['show_captions']) echo "checked='checked'"; ?> /> Show Title / Caption / Desc under image</label></h3>
				
				<h3><label><input name="reset_css" type="checkbox" value="checkbox" <?php if($options['reset_css']) echo "checked='checked'"; ?> /> Try to clear current theme image css / formating</label></h3>


				<h3><label><input name="show_bg" type="checkbox" value="checkbox" <?php if($options['show_bg']) echo "checked='checked'"; ?> /> Show background colours for layout testing</label></h3>
				
				
				
				<div style="clear:both; padding-bottom:15px; border-bottom:solid 1px #e6e6e6" ></div>
				
				<div style="width:25%;float:left;">		
					<h3><label><input name="auto_play" type="checkbox" value="checkbox" <?php if($options['auto_play']) echo "checked='checked'"; ?> /> Auto play slide show</label></h3>
				</div>
				<div style="width:25%;float:left;">		
					<h3><label><input name="hide_thumbs" type="checkbox" value="checkbox" <?php if($options['hide_thumbs']) echo "checked='checked'"; ?> /> Hide thumbnails</label></h3>
				</div>
				<div style="width:25%;float:left;">		
					<h3>Slide delay in milliseconds</h3>
					<p><input type="text" name="delay" value="<?php echo($options['delay']); ?>" /></p>
				</div>				


				
				<div style="clear:both; padding-bottom:15px; border-bottom:solid 1px #e6e6e6" ></div>
				
				<div style="width:25%;float:left;">		
					<h3>Number of thumbnails</h3>
					<p><input type="text" name="num_thumb" value="<?php echo($options['num_thumb']); ?>" /></p>
				</div>				

				<div style="width:25%;float:left;">				
					<h3>Thumbnail Width</h3>
					<p><input type="text" name="thumbnail_width" value="<?php echo($options['thumbnail_width']); ?>" /></p>
				</div>
				
				<div style="width:25%; float:left;">				
					<h3>Thumbnail Height</h3>
					<p><input type="text" name="thumbnail_height" value="<?php echo($options['thumbnail_height']); ?>" /></p>
				</div>
				
				<div style="width:25%; float:left;">
					<h3>Thumbnail Crop Ratio</h3>
					<p><input type="text" name="thumbnail_crop_ratio" value="<?php echo($options['thumbnail_crop_ratio']); ?>" /></p>
				</div>
				
				
				<div style="clear:both; padding-bottom:15px; border-bottom:solid 1px #e6e6e6" ></div>
				
				
				<div style="width:25%; float:left;">				
					<h3>Thumbnail column width</h3>
					<p><input type="text" name="thumb_col_width" value="<?php echo($options['thumb_col_width']); ?>" /></p>
				</div>
				
				<div style="width:25%; float:left;">				
					<h3>Thumbnail margin</h3>
					<p><input type="text" name="thumbnail_margin" value="<?php echo($options['thumbnail_margin']); ?>" /></p>
				</div>					
				
				<div style="width:25%; float:left">
					<h3>Main image width</h3>
					<p><input type="text" name="main_col_width" value="<?php echo($options['main_col_width']); ?>" /></p>
				</div>
				
				<div style="width:25%; float:left">
					<h3>Main image height</h3>
					<p><input type="text" name="main_col_height" value="<?php echo($options['main_col_height']); ?>" /></p>
				</div>
				
				
				<div style="clear:both; padding-bottom:15px; border-bottom:solid 1px #e6e6e6" ></div>
				
				
				
				<h3>Gallery width (at least Thumbnail column + Main image width)</h3>
				<p><input type="text" name="gallery_width" value="<?php echo($options['gallery_width']); ?>" /></p>
				<br />
			
				<p><input class="button-primary" type="submit" name="ps_save" value="Save Changes" /></p>
			
			</form>
	
		</div>
		
		<?php
	} 
} 

function PS_getOption($option) {
    global $mytheme;
    return $mytheme->option[$option];
}

// register functions
add_action('admin_menu', array('photospace_plugin_options', 'update'));


//============================== insert HTML header tag ========================//

wp_enqueue_script('jquery');

$photospace_wp_plugin_path = get_option('siteurl')."/wp-content/plugins/photospace";

wp_enqueue_style( 'gallery-styles', 	$photospace_wp_plugin_path . '/gallery.css');
wp_enqueue_script( 'galleriffic', 		$photospace_wp_plugin_path . '/jquery.galleriffic.js');
wp_enqueue_script( 'opacityrollover', 	$photospace_wp_plugin_path . '/jquery.opacityrollover.js');

add_action( 'wp_head', 'photospace_wp_headers', 10 );

function photospace_wp_headers() {
	
	$options = get_option('ps_options');
	
	echo "<!--	photospace [ START ] --> \n";
	
	echo '<style type="text/css">'; 
	
	if($options['reset_css']){ 
	
		echo '
			/* reset */ 
			body .gallery img,
			body .gallery li a{
				padding:0;
				margin:0;
				border:none !important;
				background:none !important;
				height:auto !important;
				width:auto !important; 
			}			
			';
	}
	
	echo '	.gallery .thumnail_col{
				width:'. $options['thumb_col_width'] .'px;
			}
			
			.gallery .gal_content,
			.gallery .loader,
			.gallery .slideshow a.advance-link{
				width:'. $options['main_col_width'] .'px;
			}
			
			.gallery{
				width:'. $options['gallery_width'] .'px;
				height:'. $options['main_col_height'] .'px;
			}
			
			
			
			.gallery ul.thumbs li {
				margin-bottom:'. $options['thumbnail_margin'] .'px;
				margin-right:'. $options['thumbnail_margin'] .'px; 
			}
			
			.gallery .loader {
				height: '. $options['main_col_height'] / 2 . 'px;
				width: '. $options['main_col_width'] . 'px;
			}
			
			.gallery .slideshow a.advance-link,
			.gallery .slideshow span.image-wrapper {
				height:'. $options['main_col_height'] .'px;
			}
			
			.gallery .slideshow-container {
				height:'. $options['main_col_height'] .'px;
			}';
			
	if($options['show_bg']){ 
	
		echo '
			.gallery{
				background-color:#fbefd7;
			}
			
			.gallery .thumnail_col {
				background-color:#e7cf9f;
			}
			
			.gallery .gal_content,
			.gallery .loader,
			.gallery .slideshow a.advance-link {
				background-color:#e7cf9f;
			}'; 
	}
	
	if($options['hide_thumbs']){ 
		echo '
			.gallery .thumnail_col{
				display:none !important;
			}
		'; 
	}

	echo '</style>'; 
			
	echo "<!--	photospace [ END ] --> \n";
}



add_shortcode( 'photospace', 'photospace_shortcode' );
function photospace_shortcode( $atts ) {
	
	global $post;
	$options = get_option('ps_options');
	
	extract(shortcode_atts(array(
		'id' 				=> intval($post->ID),
		'num_thumb' 		=> $options['num_thumb'],
		'num_preload' 		=> $options['num_thumb'],
		'show_captions' 	=> $options['show_captions'],
		'show_download' 	=> $options['show_download'],
		'show_controls' 	=> $options['show_controls'],
		'auto_play' 		=> $options['auto_play'],
		'delay' 			=> $options['delay'],
		'hide_thumbs' 		=> $options['hide_thumbs'],
		
		'thumbnail_width' 	=> $options['thumbnail_width'],
		'thumbnail_height' 	=> $options['thumbnail_height'],
		'thumbnail_crop_ratio' => $options['thumbnail_crop_ratio'],
		'main_col_width' 	=> $options['main_col_width'],
		'main_col_height' 	=> $options['main_col_height'],
		'horizontal_thumb' 	=> 0		
	), $atts));
	
	$post_id = intval($post->ID);

	if($hide_thumbs){
		$hide_thumb_style = 'display:none !important';
	}
	
	if($horizontal_thumb){
		$thumb_style_init = 'visibility:hidden';
		$thumb_style_on  = "'visibility', 'visible'";
		$thumb_style_off  = "'visibility', 'hidden'";
	}
	else{
		$thumb_style_init = 'display:none';
		$thumb_style_on  = "'display', 'block'";
		$thumb_style_off  = "'display', 'none'";
	}
	
	$photospace_wp_plugin_path = get_option('siteurl')."/wp-content/plugins/photospace";
	
	$output_buffer ='
	
		<div class="gallery_clear"></div> 
		<div id="gallery_'.$post_id.'" class="gallery"> 
										
			<!-- Start Advanced Gallery Html Containers -->
			<div class="gal_content">
				';
				
				if($show_controls){ 
					$output_buffer .='<div id="controls_'.$post_id.'" class="controls"></div>';
				}
				
				$output_buffer .='
				<div class="slideshow-container">
					<div id="loading_'.$post_id.'" class="loader"></div>
					<div id="slideshow_'.$post_id.'" class="slideshow"></div>
					<div id="caption_'.$post_id.'" class="caption-container"></div>
				</div>
				
			</div>
											
			
			<!-- Start Advanced Gallery Html Containers -->
			<div class="thumbs_wrap">
			<div id="thumbs_'.$post_id.'" class="thumnail_col" style="'. $hide_thumb_style . '" >
				';
				
				if($horizontal_thumb){ 		
						$output_buffer .='<a class="pageLink prev" style="'. $thumb_style_init . '" href="#" title="Previous Page"></a>';
				}
				
				$output_buffer .=' 
				<ul class="thumbs noscript">				
				';
					
				$attachments = get_children("post_parent=$id&post_type=attachment&post_mime_type=image&orderby=menu_order&order=asc"); 
			
				if ( !empty($attachments) ) {
					foreach ( $attachments as $aid => $attachment ) {
						$img = _wp_get_attachment_image_src( $aid , '');
						$thumb = wp_get_attachment_thumb_url ( $aid );
						$_post = & get_post($aid); 

						$image_title = attribute_escape($_post->post_title);
						$image_alttext = get_post_meta($aid, '_wp_attachment_image_alt', true);
						$image_caption = attribute_escape($_post->post_excerpt);
						$image_description = attribute_escape($_post->post_content);						
													
						$output_buffer .='
							<li><a class="thumb" href="' . $photospace_wp_plugin_path . '/image.php?width=' . $main_col_width . '&amp;height=' . $main_col_height . '&amp;image=' . $img[0] . '" >								
								<img src="' . $photospace_wp_plugin_path . '/image.php?width=' . $thumbnail_width . '&amp;height=' . $thumbnail_height . '&amp;cropratio=' . $thumbnail_crop_ratio . '&amp;image=' . $thumb . '" alt="' . $image_alttext . '" title="' . $image_title . '"/>
								</a>
								';

								$output_buffer .='
								<div class="caption">
									';
									if($show_captions){ 	
										
										$output_buffer .='
										<div class="image-caption">' .  $image_caption . '</div>
										<div class="image-desc">' .  $image_description . '</div>
										';
									}
									
									if($show_download){ 		
										$output_buffer .='
										<div class="download"><a href="'.$img[0].'">Download Original</a></div>
										';
									}
									
								$output_buffer .='
								</div>
								';
								
								
							$output_buffer .='
							</li>
						';
						} 
					} 
					
				$output_buffer .='
				</ul>';

				
				if(!$horizontal_thumb){ 		
						$output_buffer .='
						<div class="gallery_clear"></div>
						<a class="pageLink prev" style="'.$thumb_style_init.'" href="#" title="Previous Page"></a>';
				}
				
				$output_buffer .='
				<a class="pageLink next" style="'.$thumb_style_init.'" href="#" title="Next Page"></a>
			</div>
			</div>
	
	</div>
	
	<div class="gallery_clear"></div>
	
	';
	
	$output_buffer .= "
	
	<script type='text/javascript'>
			
			jQuery(document).ready(function($) {
				
				// We only want these styles applied when javascript is enabled
				$('.gal_content').css('display', 'block');
		
				// Initially set opacity on thumbs and add
				// additional styling for hover effect on thumbs
				var onMouseOutOpacity = 0.67;
				$('#thumbs_".$post_id." ul.thumbs li, .thumnail_col a.pageLink').opacityrollover({
					mouseOutOpacity:   onMouseOutOpacity,
					mouseOverOpacity:  1.0,
					fadeSpeed:         'fast',
					exemptionSelector: '.selected'
				});	
				
				// Initialize Advanced Galleriffic Gallery 
				var gallery = $('#thumbs_".$post_id."').galleriffic({ 
					delay:                     " . intval($delay) . ",
					numThumbs:                 " . intval($num_thumb) . ",
					preloadAhead:              " . intval($num_preload) . ",
					enableTopPager:            false,
					enableBottomPager:         false,
					imageContainerSel:         '#slideshow_".$post_id."',
					controlsContainerSel:      '#controls_".$post_id."',
					captionContainerSel:       '#caption_".$post_id."',  
					loadingContainerSel:       '#loading_".$post_id."',
					renderSSControls:          true,
					renderNavControls:         true,
					playLinkText:              'Play Slideshow',
					pauseLinkText:             'Pause Slideshow',
					prevLinkText:              '&lsaquo; Previous Photo',
					nextLinkText:              'Next Photo &rsaquo;',
					nextPageLinkText:          'Next &rsaquo;',
					prevPageLinkText:          '&lsaquo; Prev',
					enableHistory:             	false,  
					autoStart:                 	'" . $auto_play . "',
					enableKeyboardNavigation:	true,
					syncTransitions:           	true,
					defaultTransitionDuration: 	300,
						
					onSlideChange:             function(prevIndex, nextIndex) {
						// 'this' refers to the gallery, which is an extension of $('#thumbs')
						this.find('ul.thumbs').children()
							.eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
							.eq(nextIndex).fadeTo('fast', 1.0);
					},
					onTransitionOut:           function(slide, caption, isSync, callback) {
						slide.fadeTo(this.getDefaultTransitionDuration(isSync), 0.0, callback);
						caption.fadeTo(this.getDefaultTransitionDuration(isSync), 0.0);
					},
					onTransitionIn:            function(slide, caption, isSync) {
						var duration = this.getDefaultTransitionDuration(isSync);
						slide.fadeTo(duration, 1.0);
	
						// Position the caption at the bottom of the image and set its opacity
						var slideImage = slide.find('img');
						caption.width(slideImage.width())
							.css({
								//'bottom' : Math.floor((slide.height() - slideImage.outerHeight()) / 2 - 40),
								'top' : slideImage.outerHeight(),
								'left' : Math.floor((slide.width() - slideImage.width()) / 2) + slideImage.outerWidth() - slideImage.width()
							})
							.fadeTo(1000, 1.0);
						
					},
					onPageTransitionOut:       function(callback) {
						this.hide();
						setTimeout(callback, 100); // wait a bit
					},
					onPageTransitionIn:        function() {
						var prevPageLink = this.find('a.prev').css(".$thumb_style_off.");
						var nextPageLink = this.find('a.next').css(".$thumb_style_off.");
						
						// Show appropriate next / prev page links
						if (this.displayedPage > 0)
							prevPageLink.css(".$thumb_style_on.");
		
						var lastPage = this.getNumPages() - 1;
						if (this.displayedPage < lastPage)
							nextPageLink.css(".$thumb_style_on.");
		
						this.fadeTo('fast', 1.0);
					},
					onImageAdded: function(imageData, li) {
						_li.opacityrollover({
							mouseOutOpacity:   onMouseOutOpacity,
							mouseOverOpacity:  1.0,
							fadeSpeed:         'fast',
							exemptionSelector: '.selected'
						});
					}
					
				}); ";
				
			if($use_hover){ 		
		 
				$output_buffer .= "
					gallery.find('a.thumb').hover(function(e) {
						gallery.clickHandler(e, this);
					});
				";
		
			} 
					
				
			$output_buffer .= "
				
				/**************** Event handlers for custom next / prev page links **********************/
		
				gallery.find('a.prev').click(function(e) {
					gallery.previousPage();
					e.preventDefault();
				});
		
				gallery.find('a.next').click(function(e) {
					gallery.nextPage(); 
					e.preventDefault();
				});
		
			});
		</script>
		
		";
		
		return $output_buffer;
} 


//==========================================================================//
//  following three functions are minor modification version of             //
//  the "/wp-include/media.php"                                             //
//==========================================================================//
function _wp_get_attachment_image( $attachment_id, 
								   $size='thumbnail', 
								   $icon = false ) {
	$html = '';
	$image = _wp_get_attachment_image_src($attachment_id, $size, $icon);
	if ( $image ) {
		list($src, $width, $height) = $image;
		$hwstring = image_hwstring($width, $height);
		if ( is_array($size) )
			$size = join('x', $size);
		$html = '<img src="'.attribute_escape($src).'" 
				'.$hwstring.'class="attachment-'.attribute_escape($size).'" alt="" />';
	}
	return $html;
}

function _wp_get_attachment_image_src( $attachment_id, 
									   $size='thumbnail', 
									   $icon = false ) {
	// get a thumbnail or intermediate image if there is one
	if ( $image = _image_downsize($attachment_id, $size) )
		return $image;
	if ( $icon && $src = wp_mime_type_icon($attachment_id) ) {
		$icon_dir = 
			apply_filters( 'icon_dir', ABSPATH . WPINC . '/images/crystal' );
		$src_file = $icon_dir . '/' . basename($src);
		@list($width, $height) = getimagesize($src_file);
	}
	if ( $src && $width && $height )
		return array( $src, $width, $height );
	return false;
}

function _image_downsize($id, $size = 'medium') {
	if ( !wp_attachment_is_image($id) )
		return false;
	$img_url = wp_get_attachment_url($id);
	$meta = wp_get_attachment_metadata($id);
	$width = $height = 0;
	// plugins can use this to provide resize services
	if ( $out = apply_filters('_image_downsize', false, $id, $size) )
		return $out;
	// try for a new style intermediate size
	if ( $intermediate = image_get_intermediate_size($id, $size) ) {
		$img_url = str_replace(basename($img_url), $intermediate['file'], $img_url);
		$width = $intermediate['width'];
		$height = $intermediate['height'];
	}
	elseif ( $size == 'thumbnail' ) {
		// fall back to the old thumbnail
		$thumb_file = wp_get_attachment_thumb_file( $id ); // modified by Y2
		if ( $info = getimagesize($thumb_file) ) {		   // 
			$img_url = str_replace(basename($img_url), basename($thumb_file), $img_url);
			$width = $info[0];
			$height = $info[1];
		}
	}
	if ( !$width && !$height && isset($meta['width'], $meta['height']) ) {
		// any other type: use the real image and constrain it
		list( $width, $height ) = 
			 image_constrain_size_for_editor( $meta['width'], 
											  $meta['height'], $size );
	}
	if ( $img_url)
		return array( $img_url, $width, $height );
	return false;
}

