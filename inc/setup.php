<?php
if( ! class_exists('Wsetup') ) :
Class Wsetup {
	 /**
	 * __construct
	 *
	 * a dummy construct prepare for extend
	 *
	 * @date	5/4/2022
	 * @since	1.0
	 *
	 * @param	void
	 * @return	void
	 */	
	function __construct() {
		
	}

 	/**
	 * initialize
	 *
	 * Sets up the gutenUser plugin.
	 *
	 * @date	5/4/2022
	 * @since	1.0
	 *
	 * @param	void
	 * @return	void
	 */
	function initialize() {
		add_action( 'init', [__CLASS__,'create_user_post_type'], 20 );
		add_action( 'init', [__CLASS__,'create_block_gutenuser_block_init'], 10 );
	}

	function gutenuser_callback($block_attributes, $content) {
		$content_post = get_post($block_attributes['curUser']);
		$post_content = $content_post->post_content;
		$blocks = (parse_blocks($post_content));
		/// update some validate function here for making sure the important layout class not be removed by user. Example: c-gutenuser__heading ...
		/// end validate
		
		foreach ($blocks as $block) {
			$output .= render_block($block);
		}
		return '<div class="c-gutenuser">'.$output.'</div>';
	}
	 
	 /**
	 * register Block
	 *
	 * Set up block and block's library
	 *
	 * @date	5/4/2022
	 * @since	1.0
	 *
	 * @param	void
	 * @return	void
	 */
	function create_block_gutenuser_block_init() {
		global $pagenow;
		global $post_type;
		$typenow = '';
		register_block_type(
			GUTENUSER_PATH . 'build/components/gutenSocial/block.json'
		);

		if ( 'post-new.php' === $pagenow ) {
			if ( isset( $_REQUEST['post_type'] ) && post_type_exists( $_REQUEST['post_type'] ) ) {
			  $typenow = $_REQUEST['post_type'];
			};
		} 
		elseif ( 'post.php' === $pagenow ) {
			if ( isset( $_GET['post'] ) && isset( $_POST['post_ID'] ) && (int) $_GET['post'] !== (int) $_POST['post_ID'] ) {
			  // Do nothing
			} 
			elseif ( isset( $_GET['post'] ) ) {
			  $post_id = (int) $_GET['post'];
			} 
			elseif ( isset( $_POST['post_ID'] ) ) {
			  $post_id = (int) $_POST['post_ID'];
			}
			
			if ( $post_id ) {
			  $post = get_post( $post_id );
			  $typenow = $post->post_type;
			}
		}

		// show on post_type page only
		if ($typenow !== 'page' && is_admin()) {
			return;
		}

		register_block_type(
			GUTENUSER_PATH . 'build/components/gutenuser/block.json',
			array(
				'render_callback' => [__CLASS__,'gutenuser_callback'],
			)
		);
	}

	/**
	 * allow block types
	 *
	 * Allow gutenuser for post type Page only
	 *
	 * @date	10/4/2022
	 * @since	1.0
	 *
	 * @param	void
	 * @return	allow_block_types [array]
	 */	
	function gutenuser_allowed_block_types( $allowed_block_types, $post ) {
		if ( $post->post_type !== 'page' ) {
		  unset($allowed_block_types['gutenuser']);
		}

		return $allowed_block_types;
	  }

	/**
	 * create gutenuser
	 *
	 * Create gutenuser post type
	 *
	 * @date	5/4/2022
	 * @since	1.0
	 *
	 * @param	void
	 * @return	void
	 */	
	function create_user_post_type() {
		register_post_type( 'gutenuser',
		// CPT Options
			array(
				'labels' => array(
					'name' => __( 'Guten Users' ),
					'singular_name' => __( 'Guten User' )
				),
				'public' => true,
				// 'publicly_queryable'  => false,
				'show_in_rest' => true,
				'template' => array(
					array( "core/image", array(
						 "align" => "left",
						 "sizeSlug" => "thumbnail",
						 "className" => "c-gutenuser__thumbnail is-style-rounded",
						 "supports" => [
							"align" => false,
							"styles" => false,
							"sizeSlug" => false,
							"width" => false,
							"height" => false,
							"caption" => false,
						 ]
					 ) ),
		
					array('core/group',["className" => "c-gutenuser__group js-has-popup"], array(
						array( 'core/heading', array(
							'placeholder' => __('First/Lastname'),
							'typography' => ['textTransform' => 'uppercase'],
							'className' => 'c-gutenuser__heading popup--hybird',
							'supports' => [
								'typography' => [
									"fontSize" => false,
									"lineHeight" =>  false,
									"__experimentalFontStyle" => false,
									"__experimentalFontWeight" => false,
									"__experimentalLetterSpacing" => false,
									"__experimentalTextTransform" => false,
									"__experimentaDefaultControls" => [
										"fontSize" => false,
										"fontAppearance" => false,
										"textTransform" => false
									]
								],
								
							]
						) ),
						array( 'core/paragraph', array(
							'placeholder' => 'Short description',
							'className' => 'c-gutenuser__description popup--show'
						)),
						array( 'core/paragraph', array(
							'placeholder' => 'Position',
							'className' => 'c-gutenuser__position'
						)),
						array('core/social-links',['className' => 'c-gutenuser__social-links popup--show'],array(
							array('core/social-link',array(
								"service"=>"github"
							)),
							array('core/social-link',array(
								"service"=>"linkedIn"
							)),
							// array('gutenuser/social-link',array(
							// )),
							array('core/social-link',array(
								"service"=>"facebook"
							))
						))
						
					) ),
				),
				'template_lock' => 'all'
			)
		);
	}
	// Hooking up our function to theme setup
}
endif;