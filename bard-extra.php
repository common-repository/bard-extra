<?php
/*
Plugin Name: Bard Extra
Plugin URI: http://wordpress.org/plugins/bard-extra/
Description: Adds One Click Demo Import functionality for Bard theme.
Author: WP Royal
Version: 1.2.7
License: GPLv2 or later
Author URI: https://wp-royal.com/
Text Domain: bard-extra
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Bardxtra_Options' ) ) {

	class Bardxtra_Options {

		public function __construct() {

			add_action( 'admin_init', [ $this, 'init' ] );

			add_action( 'admin_menu', [ $this, 'bardxtra_options_page' ] );

			add_action( 'wp_ajax_bardxtra_contact_from_7_activation', [ $this, 'bardxtra_contact_from_7_activation' ] );
			add_action( 'wp_ajax_bardxtra_instagram_feed_activation', [ $this, 'bardxtra_instagram_feed_activation' ] );
			add_action( 'wp_ajax_bardxtra_wysija_newsletter_activation', [ $this, 'bardxtra_wysija_newsletter_activation' ] );
			add_action( 'wp_ajax_bardxtra_recent_posts_activation', [ $this, 'bardxtra_recent_posts_activation' ] );
			// add_action( 'wp_ajax_bardxtra_elementor_activation', [ $this, 'bardxtra_elementor_activation' ] );
			// add_action( 'wp_ajax_bardxtra_royal_elementor_addons_activation', [ $this, 'bardxtra_royal_elementor_addons_activation' ] );

			// Remove Instagram
			add_action( 'wp_ajax_bardxtra_remove_instagram_widget', [ $this, 'bardxtra_remove_instagram_widget' ] );

			add_action( 'admin_enqueue_scripts', [ $this, 'bardxtra_widget_enqueue_scripts' ] );

		}

		public function init() {
			// Import XML file
			add_action( 'wp_ajax_bardxtra_import_xml', [ $this, 'bardxtra_import_xml' ] );
		}

		public function bard_extra_subpage_content() { ?>

			<div class="extra-options-page-wrap">
				<div class="wrap extra-options">
					<h1>Demo Import Completed !</h1>
					<p class="after-import-notice">
						<?php esc_html_e( 'Please visit', 'bard-extra' ); ?> <a href="<?php echo esc_url( admin_url('themes.php?page=about-bard') ); ?>" class="visit-website"><?php esc_html_e( 'About Bard Page', 'bard-extra' ); ?></a>
						&nbsp;<?php esc_html_e( 'or', 'bard-extra' ); ?>&nbsp;
						<a href="<?php echo esc_url( home_url() ); ?>" class="visit-website" target="_blank"><?php esc_html_e( 'Check out your new website.', 'bard-extra' ); ?></a>
					</p>
				</div>
			</div>

		<?php }

		// Add Admin Menu
		public function bardxtra_options_page() {
			add_menu_page(
				esc_html__( 'Bard Extra', 'bard-extra' ),
				esc_html__( 'Bard Extra', 'bard-extra' ),
				'manage_options',
				'bard-extra',
				[ $this, 'bardxtra_options_page_html' ],
				'dashicons-star-filled',
				80
			);

			add_submenu_page( 
				'bard-extra-xxx', 
				esc_html__('Bard Extra Sub Page', 'bard-extra'),
				esc_html__('Bard Extra Sub', 'bard-extra'),
				'manage_options',
				'bard-extra-sub',
				[$this, 'bard_extra_subpage_content']
			);
		}

		// Render Admin Page HTML
		public function bardxtra_options_page_html() {

			?>

			<div class="extra-options-page-wrap">

				<div class="wrap extra-options">
					<h1><?php esc_html_e( 'One Click Demo Import', 'bard-extra' ); ?></h1>
					<p>
						<?php esc_html_e( 'Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme.', 'bard-extra' ); ?>
						<br>
						<?php esc_html_e( 'It will allow you to quickly edit everything instead of creating content from scratch.', 'bard-extra' ); ?>
					</p>

					<p>
					<?php
					//  ! is_plugin_active( 'elementor/elementor.php' ) || 
						if (! is_plugin_active( 'royal-elementor-addons/wpr-addons.php' ) || ! is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) || ! is_plugin_active( 'instagram-feed/instagram-feed.php' ) || ! is_plugin_active( 'wysija-newsletters/index.php' ) || ! is_plugin_active( 'recent-posts-widget-with-thumbnails/recent-posts-widget-with-thumbnails.php' ) ) {
							esc_html_e( 'All recommended plugins need to be installed and activated for this step.', 'bard-extra' );
						}
					?>
					</p>

					<div class="bardxtra-plugin-activation">
						<?php if ( ! is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) : ?>
						<div class="plugin-box">
							<img src="<?php echo plugin_dir_url( __FILE__ ) .'assets/images/cf7.png'; ?>">
							<span><?php esc_html_e( 'Contact Form 7', 'bard-extra' ); ?></span>
							<input type="checkbox" id="contact_from_7" name="contact_from_7" value="yes" checked>
							<label for="contact_from_7"></label>
						</div>
						<?php endif; ?>

						<?php if ( ! is_plugin_active( 'instagram-feed/instagram-feed.php' ) ) : ?>
						<div class="plugin-box">
							<img src="<?php echo plugin_dir_url( __FILE__ ) .'assets/images/instagram-feed.png'; ?>">
							<span><?php esc_html_e( 'Instagram Feed', 'bard-extra' ); ?></span>
							<input type="checkbox" id="instagram_feed" name="instagram_feed" value="yes" checked>
							<label for="instagram_feed"></label>
						</div>
						<?php endif; ?>

						<?php if ( ! is_plugin_active( 'wysija-newsletters/index.php' ) ) : ?>
						<div class="plugin-box">
							<img src="<?php echo plugin_dir_url( __FILE__ ) .'assets/images/mailchimp.png'; ?>">
							<span><?php esc_html_e( 'Newsletter', 'bard-extra' ); ?></span>
							<input type="checkbox" id="wysija_newsletter" name="wysija_newsletter" value="yes" checked>
							<label for="wysija_newsletter"></label>
						</div>
						<?php endif; ?>

						<?php if ( ! is_plugin_active( 'recent-posts-widget-with-thumbnails/recent-posts-widget-with-thumbnails.php' ) ) : ?>
						<div class="plugin-box">
							<img src="<?php echo plugin_dir_url( __FILE__ ) .'assets/images/recent-posts.png'; ?>">
							<span><?php esc_html_e( 'Recent Posts', 'bard-extra' ); ?></span>
							<input type="checkbox" id="recent_posts" name="recent_posts" value="yes" checked>
							<label for="recent_posts"></label>
						</div>
						<?php endif; ?>

						<?php if ( 2 < 1 && ! is_plugin_active( 'elementor/elementor.php' ) ) : ?>
						<div class="plugin-box">
							<img src="<?php echo plugin_dir_url( __FILE__ ) .'assets/images/elementor.png'; ?>">
							<span><?php esc_html_e( 'Elementor', 'bard-extra' ); ?></span>
							<input type="checkbox" id="elementor" name="elementor" value="yes" checked>
							<label for="elementor"></label>
						</div>
						<?php endif; ?>

						<?php if ( 2 < 1 && ! is_plugin_active( 'royal-elementor-addons/wpr-addons.php' ) ) : // temporary-change ?>
						<div class="plugin-box">
							<img src="<?php echo plugin_dir_url( __FILE__ ) .'assets/images/royal-addons.png'; ?>">
							<span><?php esc_html_e( 'Royal Elementor Addons', 'bard-extra' ); ?></span>
							<input type="checkbox" id="royal_elementor_addons" name="royal_elementor_addons" value="yes" checked>
							<label for="royal_elementor_addons"></label>
						</div>
						<?php endif; ?>
					</div>
				
				<br>
				<button class="button button-primary" id="bard-demo-import"><?php esc_html_e( 'Import Demo Content', 'bard-extra' ); ?></button>
				<br><br>
				<em class="before-import-notice"><?php esc_html_e( 'Import may take 1-2 minutes, please don\'t refresh this page until it\'s done!', 'bard-extra' ); ?></em>

				</div>

			</div>

			<?php
		}

		// Install/Activate CF7 Plugin 
		public function bardxtra_contact_from_7_activation() {

            $nonce = $_POST['nonce'];

            if ( !wp_verify_nonce( $nonce, 'plugin-options-js' ) || !current_user_can('activate_plugins') ) {
                return;
            }

			// Get the list of currently active plugins (Most likely an empty array)
			$active_plugins = (array) get_option( 'active_plugins', array() );

			if ( true == $_POST['bardxtra_plugin_checked'] ) {
				array_push( $active_plugins, 'contact-form-7/wp-contact-form-7.php' );
			}

			// Set the new plugin list in WordPress
			update_option( 'active_plugins', $active_plugins );

		}

		// Install/Activate Instagram Feed Plugin 
		public function bardxtra_instagram_feed_activation() {

            $nonce = $_POST['nonce'];

            if ( !wp_verify_nonce( $nonce, 'plugin-options-js' ) || !current_user_can('activate_plugins') ) {
                return;
            }

			// Get the list of currently active plugins (Most likely an empty array)
			$active_plugins = (array) get_option( 'active_plugins', array() );

			if ( true == $_POST['bardxtra_plugin_checked'] ) {
				array_push( $active_plugins, 'instagram-feed/instagram-feed.php' );
			}

			// Set the new plugin list in WordPress
			update_option( 'active_plugins', $active_plugins );

			// Get Instagram Options
			$instagram_options = get_option( 'sb_instagram_settings' );

			// Set Instagram Options
			$instagram_options['sb_instagram_num'] = '9';
			$instagram_options['sb_instagram_cols'] = '3';
			$instagram_options['sb_instagram_image_padding'] = '0';
			$instagram_options['sb_instagram_show_header'] = false;
			$instagram_options['sb_instagram_show_btn'] = false;
			$instagram_options['sb_instagram_show_follow_btn'] = false;

			// Update Instagram Options
			update_option( 'sb_instagram_settings', $instagram_options );

		}

		// Install/Activate Mailpoet Plugin 
		public function bardxtra_wysija_newsletter_activation() {

            $nonce = $_POST['nonce'];

            if ( !wp_verify_nonce( $nonce, 'plugin-options-js' ) || !current_user_can('activate_plugins') ) {
                return;
            }

			// Get the list of currently active plugins (Most likely an empty array)
			$active_plugins = (array) get_option( 'active_plugins', array() );

			if ( true == $_POST['bardxtra_plugin_checked'] ) {
				array_push( $active_plugins, 'wysija-newsletters/index.php' );
			}

			// Set the new plugin list in WordPress
			update_option( 'active_plugins', $active_plugins );

		}

		// Install/Activate Recent Posts Widget Plugin 
		public function bardxtra_recent_posts_activation() {

            $nonce = $_POST['nonce'];

            if ( !wp_verify_nonce( $nonce, 'plugin-options-js' ) || !current_user_can('activate_plugins') ) {
                return;
            }

			// Get the list of currently active plugins (Most likely an empty array)
			$active_plugins = (array) get_option( 'active_plugins', array() );

			if ( true == $_POST['bardxtra_plugin_checked'] ) {
				array_push( $active_plugins, 'recent-posts-widget-with-thumbnails/recent-posts-widget-with-thumbnails.php' );
			}

			// Set the new plugin list in WordPress
			update_option( 'active_plugins', $active_plugins );

		}

		// Install/Activate Elementor Plugin 
		public function bardxtra_elementor_activation() {

            $nonce = $_POST['nonce'];

            if ( !wp_verify_nonce( $nonce, 'plugin-options-js' ) || !current_user_can('activate_plugins') ) {
                return;
            }

			// Get the list of currently active plugins (Most likely an empty array)
			$active_plugins = (array) get_option( 'active_plugins', array() );

			if ( true == $_POST['bardxtra_plugin_checked'] ) {
				array_push( $active_plugins, 'elementor/elementor.php' );
			}

			// Set the new plugin list in WordPress
			update_option( 'active_plugins', $active_plugins );

		}

		// Install/Activate Royal Elementor Addons Plugin 
		public function bardxtra_royal_elementor_addons_activation() {

            $nonce = $_POST['nonce'];

            if ( !wp_verify_nonce( $nonce, 'plugin-options-js' ) || !current_user_can('activate_plugins') ) {
                return;
            }

			// Get the list of currently active plugins (Most likely an empty array)
			$active_plugins = (array) get_option( 'active_plugins', array() );

			if ( true == $_POST['bardxtra_plugin_checked'] ) {
				array_push( $active_plugins, 'royal-elementor-addons/wpr-addons.php' );
			}

			// Set the new plugin list in WordPress
			update_option( 'active_plugins', $active_plugins );

		}

		// Remove Importext Instagram Widget
		public function bardxtra_remove_instagram_widget() {

            $nonce = $_POST['nonce'];

            if ( !wp_verify_nonce( $nonce, 'plugin-options-js' ) || !current_user_can('activate_plugins') ) {
                return;
            }

			// Get All Text Widgets
			$text_widget = get_option('widget_text');
			
			// Remove
			foreach (get_option('widget_text') as $key => $value) {
				if ( 'Instagram' === $value['title'] || '@instagram' === $value['title'] ) {
					unset($text_widget[$key]);
				}
			}

			// Update
			update_option( 'widget_text', $text_widget );

		}

		// Import
		public function bardxtra_import_xml() {

			$import_filepath = plugin_dir_path( __FILE__ ) . 'includes/importers/data/';

		    if ( ! defined('WP_LOAD_IMPORTERS') ) {
		        define('WP_LOAD_IMPORTERS', true);
		    }

		    // Load Importer API
		    require_once ABSPATH . 'wp-admin/includes/import.php';

		    if ( ! class_exists( 'WP_Importer' ) ) {
		        $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		        if ( file_exists( $class_wp_importer ) ) {
		            require $class_wp_importer;
		        }
		    }

		    if ( ! class_exists( 'WP_Import' ) ) {
		        $class_wp_importer = plugin_dir_path( __FILE__ ) . 'includes/importers/class-wordpress-importer.php';

		        if ( file_exists( $class_wp_importer ) ) {
		            require $class_wp_importer;
		        }
		    }

		    if ( class_exists( 'WP_Import' ) ) {

		        // Import Demo Content
		        $wp_import = new WP_Import();
		        $wp_import->fetch_attachments = true;

		        set_time_limit(0);
		        ob_start();

		            // Demo Content
		            $wp_import->import( $import_filepath . 'demo-content.xml' );

		        ob_end_clean();

		        // Import Widgets
		        $this->bardxtra_widgets_import( $import_filepath . 'demo-widgets.wie' );

				// Install Menus after Import
				$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
				$top_menu = get_term_by( 'name', 'Top Menu', 'nav_menu' );

				set_theme_mod( 'nav_menu_locations', array(
						'main' => $main_menu->term_id,
						'top'  => $top_menu->term_id,
					)
				);

			    // Set Theme Customzie Options
			    $custom_theme_options = array(
					'featured_slider_label' => true,
			        'featured_links_label' => true,
			        'featured_links_sec_title' => '',
			        'featured_links_window' => true,
			        'featured_links_gutter_horz' => true,
			        'featured_links_columns' => '3',
			        'featured_links_title_1' => 'Features',
			        'featured_links_url_1' => 'https://wp-royal.com/themes/item-bard-pro/?ref=bard-demo-import-xml#!/features',
			        'featured_links_image_1' => '97',
			        'featured_links_title_2' => 'Try Bard Pro',
			        'featured_links_url_2' => 'https://wp-royal.com/themes/bard-pro/wp-content/plugins/open-house-theme-options/redirect.php?multisite=demo',
			        'featured_links_image_2' => '96',
			        'featured_links_title_3' => 'Buy Bard Pro',
			        'featured_links_url_3' => 'https://wp-royal.com/themes/item-bard-pro/?ref=bard-demo-import-xml#!/download',
			        'featured_links_image_3' => '95',
			        'featured_links_title_4' => '',
			        'featured_links_url_4' => '',
			        'featured_links_image_4' => '',
			        'featured_links_title_5' => '',
			        'featured_links_url_5' => '',
			        'featured_links_image_5' => '',
			        'featured_links_title_6' => '',
			        'featured_links_url_6' => '',
			        'featured_links_image_6' => '',
					'social_media_icon_1' => 'facebook',
					'social_media_url_1' => '#',
					'social_media_icon_2' => 'twitter',
					'social_media_url_2' => '#',
					'social_media_icon_3' => 'instagram',
					'social_media_url_3' => '#',
					'social_media_icon_4' => 'pinterest',
					'social_media_url_4' => '#',
					'page_footer_copyright' => '© 2024 - All Rights Reserved.',
			    );
			    update_option( 'bard_options', $custom_theme_options );

			    // Set Logo
				set_theme_mod( 'custom_logo', '283' );

			    // Delete "Hello World" Post
			    $hello_world_post = get_page_by_path( 'hello-world', OBJECT, 'post' );

				if ( ! is_null( $hello_world_post ) ) {
					wp_delete_post( $hello_world_post->ID, true );
				}

		    }
		}

		// Widget Import Function
		public function bardxtra_widgets_import( $file_path ) {

		    if ( ! file_exists($file_path) ) {
		        return;
		    }

		    // get import file and convert to array
		    $widgets_wie  = file_get_contents( $file_path );
		    $widgets_json = json_decode($widgets_wie, true);

		    // get active widgets
		    $active_widgets = get_option('sidebars_widgets');
		    $active_widgets['sidebar-left'] = array();
		    $active_widgets['sidebar-right'] = array();
		    $active_widgets['sidebar-alt'] = array();
		    $active_widgets['footer-widgets'] = array();
		    $active_widgets['instagram-widget'] = array();

		    // Sidebar Right
		    $counter = 0;
		    if ( isset($widgets_json['sidebar-right']) ) {
		        foreach( $widgets_json['sidebar-right'] as $widget_id => $widget_data ) {

		            // separate widget id/number
		            $instance_id     = preg_replace( '/-[0-9]+$/', '', $widget_id );
		            $instance_number = str_replace( $instance_id .'-', '', $widget_id );

		            if ( ! get_option('widget_'. $instance_id) ) {

		                // if is a single widget
		                $update_arr = array(
		                    $instance_number => $widget_data,
		                    '_multiwidget' => 1
		                );

		            } else {

		                // if there are multiple widgets
		                $update_arr = get_option('widget_'. $instance_id);
		                $update_arr[$instance_number] = $widget_data;

		            }

		            // update widget data
		            update_option( 'widget_' . $instance_id, $update_arr );
		            $active_widgets['sidebar-right'][$counter] = $widget_id;
		            $counter++;

		        }
		    }

		    // Sidebar Alt
		    $counter = 0;
		    if ( isset($widgets_json['sidebar-alt']) ) {
		        foreach( $widgets_json['sidebar-alt'] as $widget_id => $widget_data ) {

		            // separate widget id/number
		            $instance_id     = preg_replace( '/-[0-9]+$/', '', $widget_id );
		            $instance_number = str_replace( $instance_id .'-', '', $widget_id );

		            if ( ! get_option('widget_'. $instance_id) ) {

		                // if is a single widget
		                $update_arr = array(
		                    $instance_number => $widget_data,
		                    '_multiwidget' => 1
		                );

		            } else {

		                // if there are multiple widgets
		                $update_arr = get_option('widget_'. $instance_id);
		                $update_arr[$instance_number] = $widget_data;

		            }

		            // update widget data
		            update_option( 'widget_' . $instance_id, $update_arr );
		            $active_widgets['sidebar-alt'][$counter] = $widget_id;
		            $counter++;

		        }
		    }

		    // Footer Widgets
		    $counter = 0;
		    if ( isset($widgets_json['footer-widgets']) ) {
		        foreach( $widgets_json['footer-widgets'] as $widget_id => $widget_data ) {

		            // separate widget id/number
		            $instance_id     = preg_replace( '/-[0-9]+$/', '', $widget_id );
		            $instance_number = str_replace( $instance_id .'-', '', $widget_id );

		            if ( ! get_option('widget_'. $instance_id) ) {

		                // if is a single widget
		                $update_arr = array(
		                    $instance_number => $widget_data,
		                    '_multiwidget' => 1
		                );

		            } else {

		                // if there are multiple widgets
		                $update_arr = get_option('widget_'. $instance_id);
		                $update_arr[$instance_number] = $widget_data;

		            }

		            // update widget data
		            update_option( 'widget_' . $instance_id, $update_arr );
		            $active_widgets['footer-widgets'][$counter] = $widget_id;
		            $counter++;

		        }
		    }

		    // Instagram Widget
		    $counter = 0;
		    if ( isset($widgets_json['instagram-widget']) ) {
		        foreach( $widgets_json['instagram-widget'] as $widget_id => $widget_data ) {

		            // separate widget id/number
		            $instance_id     = preg_replace( '/-[0-9]+$/', '', $widget_id );
		            $instance_number = str_replace( $instance_id .'-', '', $widget_id );

		            if ( ! get_option('widget_'. $instance_id) ) {

		                // if is a single widget
		                $update_arr = array(
		                    $instance_number => $widget_data,
		                    '_multiwidget' => 1
		                );

		            } else {

		                // if there are multiple widgets
		                $update_arr = get_option('widget_'. $instance_id);
		                $update_arr[$instance_number] = $widget_data;

		            }

		            // update widget data
		            update_option( 'widget_' . $instance_id, $update_arr );
		            $active_widgets['instagram-widget'][$counter] = $widget_id;
		            $counter++;

		        }
		    }
		    
		    update_option( 'sidebars_widgets', $active_widgets );

		}

		// Enqueue Scripts
		public function bardxtra_widget_enqueue_scripts($hook) {
			// Disable Notifications
			wp_enqueue_style( 'plugin-notices-css', plugin_dir_url( __FILE__ ) . 'assets/css/notices.css'  );
			
			if ( 'toplevel_page_bard-extra' != $hook && 'admin_page_bard-extra-sub' != $hook ) {
				return;
			}

			wp_enqueue_script( 'plugin-install' );
			wp_enqueue_script( 'updates' );
			wp_enqueue_script( 'plugin-options-js', plugin_dir_url( __FILE__ ) . 'assets/js/plugin-options.js', array(), '1.2.4' );

            wp_localize_script(
                'plugin-options-js',
                'bardPluginOptions', // This is used in the js file to group all of your scripts together
                [
                    'nonce' => wp_create_nonce( 'plugin-options-js' ),
                ]
            );
		
			// Enqueue Styles
			wp_enqueue_style( 'plugin-options-css', plugin_dir_url( __FILE__ ) . 'assets/css/plugin-options.css', array(), '1.2.4' );
		}

	} // end Bardxtra_Options

}
new Bardxtra_Options();