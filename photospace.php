<?php
/*
Plugin Name: Photospace
Plugin URI: http://thriveweb.com.au/blog/photospace-wordpress-gallery-plugin/
Description: A image gallery for WordPress. This theme uses a modified version of Galleriffic and Smart image resizer. 
<a href="http://www.twospy.com/galleriffic/>galleriffic</a>
<a href="http://shiftingpixel.com/2008/03/03/smart-image-resizer/>Smart Image Resizer</a>
Author: Dean Oakley
Author URI: http://deanoakley.com/
Version: 1.4.3
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
class photospace_options {

	function PS_getOptions() {
		$options = get_option('ps_options');
		
		if (!is_array($options)) {
									
			$options['num_thumb'] = '9';
			
			$options['use_hover'] = false;
			
			$options['show_captions'] = false;
			
			$options['show_download'] = false;
			
			$options['show_controls'] = false;
			
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
			$options = photospace_options::PS_getOptions();
			
			$options['num_thumb'] = stripslashes($_POST['num_thumb']);			
			$options['thumbnail_width'] = stripslashes($_POST['thumbnail_width']);
			$options['thumbnail_height'] = stripslashes($_POST['thumbnail_height']);			
			$options['thumbnail_crop_ratio'] = stripslashes($_POST['thumbnail_crop_ratio']);
			
			$options['thumb_col_width'] = stripslashes($_POST['thumb_col_width']);
			$options['main_col_width'] = stripslashes($_POST['main_col_width']);
			$options['main_col_height'] = stripslashes($_POST['main_col_height']);
			
			$options['gallery_width'] = stripslashes($_POST['gallery_width']);
			
			
			
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
			
			if ($_POST['use_hover']) {
				$options['use_hover'] = (bool)true;
			} else {
				$options['use_hover'] = (bool)false;
			}

			update_option('ps_options', $options);

		} else {
			photospace_options::PS_getOptions();
		}

		add_menu_page('Photospace options', 'Photospace Gallery Options', 'edit_themes', basename(__FILE__), array('photospace_options', 'display'));
	}
	

	function display() {
		$options = photospace_options::PS_getOptions();
		
		?>
		
		<div class="wrap">
		
			<h2>Photospace Options</h2>
			
			<form method="post" action="#" enctype="multipart/form-data">				
				
			
					
				<!-- Too buggy			
				<h3>Change photo on hover?</h3>
				<p><input name="use_hover" type="checkbox" value="checkbox" <?php if($options['use_hover']) echo "checked='checked'"; ?> /> Yes </p>
				<br />-->
				
				<div class="wp-menu-separator" style="clear:both; padding-bottom:15px; border-bottom:solid 1px #e6e6e6" ></div>
				
				<h3><input name="show_download" type="checkbox" value="checkbox" <?php if($options['show_download']) echo "checked='checked'"; ?> /> Show download link</h3>
				
				
				<h3><input name="show_controls" type="checkbox" value="checkbox" <?php if($options['show_controls']) echo "checked='checked'"; ?> /> Show controls (play slide show / Next Prev image links)</h3>
				
				
				<h3><input name="show_captions" type="checkbox" value="checkbox" <?php if($options['show_captions']) echo "checked='checked'"; ?> /> Show Title / Caption / Desc under image</h3>
				
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
add_action('admin_menu', array('photospace_options', 'update'));


//============================== insert HTML header tag ========================//
wp_enqueue_script('jquery'); 

add_action( 'wp_head', 'photospace_wp_headers', 10 );

function photospace_wp_headers() {
	
	$options = photospace_options::PS_getOptions();
	
	$photospace_wp_plugin_path = 
	get_option('siteurl')."/wp-content/plugins/photospace";
	
	$photospace_wp_style_path .= 
		"<link rel=\"stylesheet\" type=\"text/css\" " . 
		"href=\"$photospace_wp_plugin_path/gallery.css\" media=\"screen\" />\n";
	
	$photospace_wp_script_path .= 
		"<script type='text/javascript' ".
		"src='$photospace_wp_plugin_path/jquery.galleriffic.js'></script>\n";

	$photospace_wp_script_path .= 
		"<script type='text/javascript' ".
		"src='$photospace_wp_plugin_path/jquery.opacityrollover.js'></script>\n";


	echo "<!--	photospace [ BEGIN ] --> \n";
	echo $photospace_wp_style_path;
	echo $photospace_wp_script_path;
	
	$options = get_option('ps_options');
	echo '
		<style type="text/css">
			.gallery .navigation{
				width:'. $options['thumb_col_width'] .'px !important;
			}
			
			.gallery .content,
			.gallery .loader,
			.gallery .slideshow a.advance-link {
				width:'. $options['main_col_width'] .'px !important;
			}
			
			.gallery{
				width:'. $options['gallery_width'] .'px !important;
				height:'. $options['main_col_height'] .'px !important;
			}
			
			div.loader {
				height: '. $options['main_col_height'] / 2 . 'px !important;
			}
			
			div.slideshow a.advance-link {
				height:'. $options['main_col_height'] .'px !important;
			}
			
			div.slideshow-container {
				height:'. $options['main_col_height'] .'px !important;
			}

		</style>
	'; 
	
	
	echo "<!--	photospace [ END ] --> \n";
}


add_shortcode( 'photospace', 'photospace_shortcode' );
function photospace_shortcode( $attr ) {
	
	global $post;
	$id = intval($post->ID);
	
	$options = get_option('ps_options');
	
	$photospace_wp_plugin_path = get_option('siteurl')."/wp-content/plugins/photospace";
	
	$output_buffer .='
	
		<div class="gallery_clear"></div> 
		<div class="gallery"> 
										
			<!-- Start Advanced Gallery Html Containers -->
			<div id="gallery" class="content">
				';
				
				if($options['show_controls']){ 
					$output_buffer .='<div id="controls_'.$post->ID.'" class="controls"></div>';
				}
				
				$output_buffer .='
				<div class="slideshow-container">
					<div id="loading_'.$post->ID.'" class="loader"></div>
					<div id="slideshow_'.$post->ID.'" class="slideshow"></div>
					<div id="caption_'.$post->ID.'" class="caption-container"></div>
				</div>
				
			</div>
											
			
			<!-- Start Advanced Gallery Html Containers -->				
			<div id="thumbs_'.$post->ID.'" class="navigation">
				<ul class="thumbs noscript">
				
				';
					
				$attachments = get_children("post_parent=$id&post_type=attachment&post_mime_type=image&orderby=menu_order"); 
			
				if ( !empty($attachments) ) {
					foreach ( $attachments as $id => $attachment ) {
						$img = _wp_get_attachment_image_src( $id , ''); 
						$_post = & get_post( intval($id) ); 

						$image_title = attribute_escape($_post->post_title);
						$image_caption = attribute_escape($_post->post_excerpt);
						$image_description = attribute_escape($_post->post_content);
													
						$output_buffer .='
							<li><a class="thumb" href="' . $photospace_wp_plugin_path . '/image.php?width=' . $options['main_col_width'] . '&amp;height=' . $options['main_col_height'] . '&amp;image=' . $img[0] . '" >
								<img src="' . $photospace_wp_plugin_path . '/image.php?width=' . $options['thumbnail_width'] . '&amp;height=' . $options['thumbnail_height'] . '&amp;cropratio=' . $options['thumbnail_crop_ratio'] . '&amp;image=' . $img[0] . '" alt="' . $image_description . '" title="' . $image_title . '"/>
								</a>
								';

								$output_buffer .='
								<div class="caption">
									';
									if($options['show_captions']){ 	
										
										$output_buffer .='
										<div class="image-title_">' . $image_title . '</div>
										<div class="image-caption">' .  $image_caption . '</div>
										<div class="image-desc">' .  $image_description . '</div>
										';
									}
									
									if($options['show_download']){ 		
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
				</ul>
					
				<div style="clear: both;"></div>
				<a class="pageLink prev" style="display: none;" href="#" title="Previous Page"></a>
				<a class="pageLink next" style="display: none;" href="#" title="Next Page"></a>
			</div>
	
	</div>
	
	<div class="gallery_clear"></div>
	
	';
	
	$output_buffer .= "
	
	<script type='text/javascript'>
			
			jQuery(document).ready(function($) {
				
				// We only want these styles applied when javascript is enabled
				$('div.content').css('display', 'block');
		
				// Initially set opacity on thumbs and add
				// additional styling for hover effect on thumbs
				var onMouseOutOpacity = 0.67;
				$('#thumbs_".$post->ID." ul.thumbs li, div.navigation a.pageLink').opacityrollover({
					mouseOutOpacity:   onMouseOutOpacity,
					mouseOverOpacity:  1.0,
					fadeSpeed:         'fast',
					exemptionSelector: '.selected'
				});	
				
				// Initialize Advanced Galleriffic Gallery
				var gallery = $('#thumbs_".$post->ID."').galleriffic({ 
					delay:                     3500,
					numThumbs:                 " . $options['num_thumb'] . ",
					preloadAhead:              " . $options['num_thumb'] . ",
					enableTopPager:            false,
					enableBottomPager:         false,
					imageContainerSel:         '#slideshow_".$post->ID."',
					controlsContainerSel:      '#controls_".$post->ID."',
					captionContainerSel:       '#caption_".$post->ID."',  
					loadingContainerSel:       '#loading_".$post->ID."',
					renderSSControls:          true,
					renderNavControls:         true,
					playLinkText:              'Play Slideshow',
					pauseLinkText:             'Pause Slideshow',
					prevLinkText:              '&lsaquo; Previous Photo',
					nextLinkText:              'Next Photo &rsaquo;',
					nextPageLinkText:          'Next &rsaquo;',
					prevPageLinkText:          '&lsaquo; Prev',
					enableHistory:             	false,  
					autoStart:                 	false,
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
						var prevPageLink = this.find('a.prev').css('display', 'none');
						var nextPageLink = this.find('a.next').css('display', 'none');
						
						// Show appropriate next / prev page links
						if (this.displayedPage > 0)
							prevPageLink.css('display', 'block');
		
						var lastPage = this.getNumPages() - 1;
						if (this.displayedPage < lastPage)
							nextPageLink.css('display', 'block');
		
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
				
			if($options['use_hover']){ 		
		 
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

