<?php
include('submodules/wcp-autoupdate/wcp-autoupdate.php');

$GLOBALS['image_map_pro_countries'] = array();
foreach (glob(plugin_dir_path(__FILE__) . 'countries/*.php') as $filename)
{
	include $filename;
}

/*
Plugin Name: Image Map Pro
Plugin URI: http://www.imagemappro.com/
Version: 5.6.9
Author: Webcraft Plugins Ltd.
Description: The most advanced image map builder for WordPress
*/

// Debugging Class
// if (class_exists('PhpConsole')) {
// 	if (!PhpConsole\Helper::isRegistered()) {
// 		PhpConsole\Helper::register();
// 	}
// }

if (!class_exists('ImageMapPro')) {
	class ImageMapPro {
		function __construct() {
			$this->version = '5.6.9';
			$this->admin_options_name = 'image-map-pro-wordpress-admin-options';
			$this->default_settings = array(
				"purchase_code" => '',
				"saves" => array(),
				"last_save_id" => "",
			);
			$this->pagename = 'image-map-pro-wordpress';
			$this->new_pagename = 'new_image-map-pro-wordpress';

			// $options = get_option($this->admin_options_name);
			// $options['purchase_code'] = '';
			// update_option($this->admin_options_name, $options);

			// Check if session has already started
			$started = false;
			if (version_compare(phpversion(), '5.4.0') != -1) {
				if (session_status() == PHP_SESSION_NONE) {
					$started = true;
				}
			} else {
				if(session_id() == '') {
					$started = true;
				}
			}

			if (!$started) {
				session_start();
			}
			
			$_SESSION['image-map-pro-shortcodes'] = array();
		}
		function get_admin_options() {
			$admin_options = array(
				"purchase_code" => '',
				"saves" => array(),
				"last_save_id" => "",
			);

			$loaded_options = get_option($this->admin_options_name);

			if (!empty($loaded_options)) {
				foreach ($loaded_options as $key => $option) {
					$admin_options[$key] = $option;
				}
			} else {
				$loaded_options = $this->default_settings;
			}

			update_option($this->admin_options_name, $admin_options);
			return $admin_options;
		}
		function init_pages() {
			add_menu_page("Image Map Pro", "Image Map Pro", "manage_options", $this->pagename, array($this, "print_options_page"));
			// add_submenu_page("plugins.php", "Image Map Pro", "Image Map Pro", "manage_options", $this->pagename, array($this, "print_options_page"));
		}

		function register_admin_includes() {
			// Defaults
			wp_register_script('image-map-pro-wordpress-defaults-js', plugins_url('/js/image-map-pro-defaults.js', __FILE__), false, $this->version, true);

			// Squares
			wp_register_style('image-map-pro-squares-css', plugins_url('/submodules/squares/css/squares.css', __FILE__), false, $this->version, false);
			wp_register_style('image-map-pro-squares-editor-css', plugins_url('/submodules/squares/css/squares-editor.css', __FILE__), false, $this->version, false);
			wp_register_style('image-map-pro-squares-controls-css', plugins_url('/submodules/squares/css/squares-controls.css', __FILE__), false, $this->version, false);
			wp_register_script('image-map-pro-squares-js', plugins_url('/submodules/squares/js/squares.js', __FILE__), false, $this->version, true);
			wp_register_script('image-map-pro-squares-renderer-js', plugins_url('/submodules/squares/js/squares-renderer.js', __FILE__), array('jquery'), $this->version, true);
			wp_register_script('image-map-pro-squares-elements-js', plugins_url('/submodules/squares/js/squares-elements-wp.js', __FILE__), false, $this->version, true);
			wp_register_script('image-map-pro-squares-controls-js', plugins_url('/submodules/squares/js/squares-controls.js', __FILE__), false, $this->version, true);

			// Compress
			wp_register_script('image-map-pro-wcp-compress-js', plugins_url('/submodules/wcp-compress/js/wcp-compress.js', __FILE__), false, $this->version, true);

			// WCP Editor
			wp_register_style('image-map-pro-wcp-editor-css', plugins_url('/submodules/wcp-editor/css/wcp-editor.css', __FILE__), false, $this->version, false);
			wp_register_script('image-map-pro-wcp-editor-js', plugins_url('/submodules/wcp-editor/js/wcp-editor.js', __FILE__), false, $this->version, true);

			// Icons
			wp_register_style('image-map-pro-wcp-fontawesome-min-css', plugins_url('/submodules/wcp-fontawesome/css/font-awesome.min.css', __FILE__), false, $this->version, false);
			wp_register_style('image-map-pro-wcp-fontawesome-css', plugins_url('/submodules/wcp-fontawesome/css/wcp-fontawesome.css', __FILE__), false, $this->version, false);
			wp_register_script('image-map-pro-wcp-fontawesome-js', plugins_url('/submodules/wcp-fontawesome/js/wcp-fontawesome.js', __FILE__), false, $this->version, true);

			// WCP Form
			wp_register_style('image-map-pro-wcp-form-css', plugins_url('/submodules/wcp-form/css/wcp-form.css', __FILE__), false, $this->version, false);
			wp_register_script('image-map-pro-wcp-form-js', plugins_url('/submodules/wcp-form/js/wcp-form.js', __FILE__), false, $this->version, true);
			wp_register_style('image-map-pro-wcp-form-controls-css', plugins_url('/submodules/wcp-form/css/wcp-form-controls.css', __FILE__), false, $this->version, false);
			wp_register_script('image-map-pro-wcp-form-controls-js', plugins_url('/submodules/wcp-form/js/wcp-form-controls.js', __FILE__), false, $this->version, true);

			// WCP Tour
			wp_register_style('image-map-pro-wcp-tour-css', plugins_url('/submodules/wcp-tour/css/wcp-tour.css', __FILE__), false, $this->version, false);
			wp_register_script('image-map-pro-wcp-tour-js', plugins_url('/submodules/wcp-tour/js/wcp-tour.js', __FILE__), false, $this->version, true);

			// WCP Validate Purchase
			wp_register_script('image-map-pro-wcp-validate-purchase-js', plugins_url('/submodules/wcp-validate-purchase/js/wcp-validate-purchase.js', __FILE__), false, $this->version, true);

			// WCP WP Media
			wp_register_script('image-map-pro-wcp-wp-media-js', plugins_url('/submodules/wcp-wp-media/js/wcp-wp-media.js', __FILE__), false, $this->version, true);
			
			// WCP WP Path Parser
			wp_register_script('image-map-pro-svg-path-parser-js', plugins_url('/submodules/svg-path-parser/svg-path-parser.js', __FILE__), false, $this->version, true);

			// Plugin
			wp_register_style('image-map-pro-css', plugins_url('/css/image-map-pro.css', __FILE__), false, $this->version, false);
			wp_register_script('image-map-pro-js', plugins_url('/js/image-map-pro.js', __FILE__), false, $this->version, true);

			// Image Map Pro Editor
			wp_register_script('image-map-pro-wordpress-editor-countries-wp', plugins_url('/js/image-map-pro-editor-countries-wordpress.js', __FILE__), false, $this->version, true);
			wp_register_style('image-map-pro-wordpress-editor-css', plugins_url('/css/image-map-pro-editor.css', __FILE__), false, $this->version, false);
			wp_register_script('image-map-pro-wordpress-editor-js', plugins_url('/js/image-map-pro-editor.js', __FILE__), false, $this->version, true);
			wp_register_script('image-map-pro-wordpress-editor-init-js', plugins_url('/js/image-map-pro-editor-init-wordpress.js', __FILE__), false, $this->version, true);
			wp_register_script('image-map-pro-wordpress-editor-content-js', plugins_url('/js/image-map-pro-editor-content.js', __FILE__), false, $this->version, true);
			wp_register_script('image-map-pro-wordpress-editor-wp-storage-js', plugins_url('/js/image-map-pro-editor-storage-wordpress.js', __FILE__), false, $this->version, true);

			// Admin Stuffs
			wp_register_style('image-map-pro-wordpress-admin-css', plugins_url('/css/admin-wordpress.css', __FILE__), false, $this->version, false);
			wp_register_script('image-map-pro-wordpress-admin-js', plugins_url('/js/admin-wordpress.js', __FILE__), false, $this->version, true);
		}
		function register_client_includes() {
			/* [dev start]
			// Defaults
			wp_register_script('image-map-pro-defaults-js', plugins_url('/js/image-map-pro-defaults.js', __FILE__), array('jquery'), false, $this->version, true);

			// Squares
			wp_register_style('image-map-pro-squares-css', plugins_url('/submodules/squares/css/squares.css', __FILE__), false, $this->version, false);
			wp_register_script('image-map-pro-squares-renderer-js', plugins_url('/submodules/squares/js/squares-renderer.js', __FILE__), array('jquery'), $this->version, true);
			wp_register_script('image-map-pro-squares-elements-js', plugins_url('/submodules/squares/js/squares-elements-wp.js', __FILE__), array('jquery'), false, $this->version, true);

			// Icons
			wp_register_style('image-map-pro-wcp-fontawesome-min-css', plugins_url('/submodules/wcp-fontawesome/css/font-awesome.min.css', __FILE__), false, $this->version, false);

			// Plugin
			wp_register_style('image-map-pro-css', plugins_url('/css/image-map-pro.css', __FILE__), false, $this->version, false);
			wp_register_script('image-map-pro-js', plugins_url('/js/image-map-pro.js', __FILE__), array('jquery'), $this->version, true);
			[dev end] */

			// /* [dist start]
			wp_register_style('image-map-pro-dist-css', plugins_url('/css/image-map-pro.min.css', __FILE__), false, $this->version, false);
			wp_register_script('image-map-pro-dist-js', plugins_url('/js/image-map-pro.min.js', __FILE__), array('jquery'), $this->version, true);
			// [dist end] */

			$this->enqueue_client_includes();
		}
		function enqueue_admin_includes() {
			wp_enqueue_script('jquery');
			wp_enqueue_media();

			// Defaults
			wp_enqueue_script('image-map-pro-wordpress-defaults-js');

			// Squares
			wp_enqueue_style('image-map-pro-squares-css');
			wp_enqueue_style('image-map-pro-squares-editor-css');
			wp_enqueue_style('image-map-pro-squares-controls-css');
			wp_enqueue_script('image-map-pro-squares-js');
			wp_enqueue_script('image-map-pro-squares-renderer-js');
			wp_enqueue_script('image-map-pro-squares-elements-js');
			wp_enqueue_script('image-map-pro-squares-controls-js');

			// Compress
			wp_enqueue_script('image-map-pro-wcp-compress-js');

			// WCP Editor
			wp_enqueue_style('image-map-pro-wcp-editor-css');
			wp_enqueue_script('image-map-pro-wcp-editor-js');

			// Icons
			wp_enqueue_style('image-map-pro-wcp-fontawesome-min-css');
			wp_enqueue_style('image-map-pro-wcp-fontawesome-css');
			wp_enqueue_script('image-map-pro-wcp-fontawesome-js');

			// WCP Form
			wp_enqueue_style('image-map-pro-wcp-form-css');
			wp_enqueue_script('image-map-pro-wcp-form-js');
			wp_enqueue_style('image-map-pro-wcp-form-controls-css');
			wp_enqueue_script('image-map-pro-wcp-form-controls-js');

			// WCP Tour
			wp_enqueue_style('image-map-pro-wcp-tour-css');
			wp_enqueue_script('image-map-pro-wcp-tour-js');

			// WCP Validate Purchase
			wp_enqueue_script('image-map-pro-wcp-validate-purchase-js');

			// WCP WP Media
			wp_enqueue_script('image-map-pro-wcp-wp-media-js');

			// WCP WP Path Parser
			wp_enqueue_script('image-map-pro-svg-path-parser-js');

			// Plugin
			wp_enqueue_style('image-map-pro-css');
			wp_enqueue_script('image-map-pro-js');

			// Image Map Pro Editor
			wp_enqueue_script('image-map-pro-wordpress-editor-countries-wp');
			wp_enqueue_style('image-map-pro-wordpress-editor-css');
			wp_enqueue_script('image-map-pro-wordpress-editor-js');
			wp_enqueue_script('image-map-pro-wordpress-editor-init-js');
			wp_enqueue_script('image-map-pro-wordpress-editor-content-js');
			wp_enqueue_script('image-map-pro-wordpress-editor-wp-storage-js');

			// Admin Stuffs
			wp_enqueue_style('image-map-pro-wordpress-admin-css');
			wp_enqueue_script('image-map-pro-wordpress-admin-js');
		}
		function enqueue_client_includes() {
			// wp_enqueue_script('jquery');

			/* [dev start]
			wp_enqueue_script('image-map-pro-defaults-js');

			wp_enqueue_style('image-map-pro-wcp-fontawesome-min-css');
			wp_enqueue_style('image-map-pro-squares-css');
			wp_enqueue_script('image-map-pro-squares-renderer-js');
			wp_enqueue_script('image-map-pro-squares-elements-js');

			wp_enqueue_style('image-map-pro-css');
			wp_enqueue_script('image-map-pro-js');
			[dev end] */

			// /* [dist start]
			wp_enqueue_style('image-map-pro-dist-css');
			wp_enqueue_script('image-map-pro-dist-js');
			// [dist end] */
		}
		function enqueue_block_editor_assets() {
			wp_enqueue_script(
				'image-map-pro-wordpress-block-js',
				plugins_url('/js/image-map-pro-wordpress-gutenberg.js', __FILE__), 
				array('wp-blocks', 'wp-element', 'wp-components')
			);
			wp_localize_script('image-map-pro-wordpress-block-js', 'image_map_pro_locals', array(
				'url' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('image_map_pro')
			));
		}
		function shortcodes() {
			$options = $this->get_admin_options();
			$saves = $options['saves'];

			foreach ($saves as $save) {
				if (isset($save['meta']['shortcode']) && strlen($save['meta']['shortcode']) > 0) {
					add_shortcode($save['meta']['shortcode'], array($this, 'print_shortcode'));
				}
			}
		}
		function print_shortcode($a, $b, $shortcode) {
			$options = $this->get_admin_options();
			$saves = $options['saves'];
			$result = false;

			foreach ($saves as $id => $save) {
				if (isset($save['meta']['shortcode']) && $save['meta']['shortcode'] == $shortcode) {
					$result = '<div id="image-map-pro-'. $id .'"></div>';

					if (isset($_SESSION['image-map-pro-shortcodes'])) {
						array_push($_SESSION['image-map-pro-shortcodes'], $shortcode);
					}
				}
			}

			if ($result) {
				add_action('wp_footer', array($this, 'call_plugin'));
			}

			return $result;
		}
		function call_plugin() {
			$this->enqueue_client_includes();
			
			$options = $this->get_admin_options();
			$saves = $options['saves'];

			foreach ($saves as $id => $save) {

				if (isset($_SESSION['image-map-pro-shortcodes'])) {
					if (array_search($save['meta']['shortcode'], $_SESSION['image-map-pro-shortcodes']) === false) {
						continue;
					}
				}
				
				?>
				<script>
				;(function ($, window, document, undefined ) {
					$(document).ready(function() {
						setTimeout(function() {
							
						<?php

						$save = $this->sanitize_json_for_save($save);

						echo 'var settings = '. $save['json'] .';' . "\n";
						echo "$('#image-map-pro-". $id . "').imageMapPro(settings);";

						?>

						}, 0);
					});
				})(jQuery, window, document);
				</script>
				<?php

				$parsed = json_decode($save['json']);

				if (isset($parsed->custom_code->custom_css) && strlen($parsed->custom_code->custom_css) > 0) {
					echo '<style type="text/css">' . $this->clean_code($parsed->custom_code->custom_css) . '</style>';
				}
				if (isset($parsed->custom_code->custom_js) && strlen($parsed->custom_code->custom_js) > 0) {
					echo '<script>' . $this->clean_code($parsed->custom_code->custom_js) .'</script>' . "\n";
				}
			}
		}
		function print_options_page() {
			$options = $this->get_admin_options();
			$this->enqueue_admin_includes();
			
			?>
			<div id="instance-options-wrap" data-purchase-code="<?php echo $options['purchase_code']; ?>" data-nonce="<?php echo wp_create_nonce('image_map_pro') ?>">
				<div id="debug" style="display: none; height: 60px; position: relative; width: 100%; z-index: 999999;"><?php echo ini_get('post_max_size'); ?></div>
				<div id="debug" style="display: none; height: 60px; position: relative; width: 100%; z-index: 999999;"><?php echo ini_get('max_execution_time'); ?></div>
				<div id="wcp-editor"></div>
			</div>
			<?php
		}
		function autoupdate() {
			// $options = get_option($this->admin_options_name);

			// $plugin_remote_path = 'https://imagemappro.com/updates/update.php?purchase_code=' . $options['purchase_code'];
			// $plugin_slug = plugin_basename(__FILE__);
			// $purchase_code = $options['purchase_code'];
			
			// new WCPAutoUpdate($this->version, $plugin_remote_path, $plugin_slug, $purchase_code);
		}
		function sanitize_json_for_save($save) {
			$json = $save['json'];

			$json = str_replace('\\\n', "", $json); // Remove new line characters inside tooltip contents
			$json = str_replace('\"', '"', $json); // Replace \" with "
			$json = str_replace("\\'", "'", $json); // Replace \' with '
			$json = str_replace('\\\"', '\"', $json); // Replace \\" with \"
			
			$decoded = json_decode($json);
			
			for ($i=0; $i<count($decoded->spots); $i++) {
				$spot = $decoded->spots[$i];

				if (isset($spot->tooltip_content->plain_text)) {
					$spot->tooltip_content->plain_text = do_shortcode($spot->tooltip_content->plain_text);

					$pattern = '/\\+"/';
					$spot->tooltip_content->plain_text = preg_replace($pattern, '\"', $spot->tooltip_content->plain_text);
					$spot->tooltip_content->plain_text = str_replace("\n", "", $spot->tooltip_content->plain_text);
				}
				
				if (isset($spot->tooltip_content->squares_settings)) {
					// Loop over containers
					for ($j=0; $j<count($spot->tooltip_content->squares_settings->containers); $j++) {
						$container = $spot->tooltip_content->squares_settings->containers[$j];
						$elements = $container->settings->elements;

						// Loop over elements
						if (is_array($elements)) {
							for ($k=0; $k<count($elements); $k++) {
								$element = $elements[$k];

								if ($element->settings->name == 'Paragraph') {
									// Replace
									if (isset($element->options->text->text)) {
										$element->options->text->text = do_shortcode($element->options->text->text);

										$pattern = '/\\+"/';
										$element->options->text->text = preg_replace($pattern, '\"', $element->options->text->text);
										$element->options->text->text = str_replace("\n", "", $element->options->text->text);
									}
								}
							}
						}
					}
				}
			}

			$save['json'] = json_encode($decoded);
			return $save;
		}
		function clean_code($code) {
			$formatted = str_replace('\n', " ", $code);
			$formatted = preg_replace("/\s+/", " ", $formatted);
			$formatted = preg_replace("/<br>/", '', $formatted);
			$formatted = preg_replace("/\\\\t/", ' ', $formatted);

			return $formatted;
		}

		// AJAX

		function ajax_get_last_save() {
			if (!wp_verify_nonce($_POST['nonce'], 'image_map_pro')) {
				die('Invalid nonce');
			}

			$options = $this->get_admin_options();

			if (isset($options['last_save_id'])) {
				echo $options['last_save_id'];
			}

			die();
		}
		function ajax_set_last_save() {
			if (!wp_verify_nonce($_POST['nonce'], 'image_map_pro')) {
				die('Invalid nonce');
			}

			$options = $this->get_admin_options();

			$options['last_save_id'] = $_POST['saveID'];
			update_option($this->admin_options_name, $options);

			die();
		}
		function ajax_store_save() {
			$json = '';
			$id = 0;
			$name = '';
			$shortcode = '';

			if (!wp_verify_nonce($_POST['nonce'], 'image_map_pro')) {
				die('Invalid nonce');
			}

			if (isset($_POST['json'])) {
				$json = $_POST['json'];
			}
			if (isset($_POST['saveID'])) {
				$id = $_POST['saveID'];
			}
			if (isset($_POST['name'])) {
				$name = $_POST['name'];
			}
			if (isset($_POST['shortcode'])) {
				$shortcode = $_POST['shortcode'];
			}

			$options = get_option($this->admin_options_name);
			$options['saves'][$id] = array(
				"json" => $json,
				"meta" => array(
					"name" => $name,
					"shortcode" => $shortcode
				)
			);
			update_option($this->admin_options_name, $options);

			// Verify
			$options = get_option($this->admin_options_name);
			$storedJSON = $options['saves'][$id]['json'];
			echo $storedJSON;

			die();
		}
		function ajax_get_save() {
			if (!wp_verify_nonce($_POST['nonce'], 'image_map_pro')) {
				die('Invalid nonce');
			}

			$id = $_POST['saveID'];

			$options = get_option($this->admin_options_name);
			$save = $options['saves'][$id];
			echo $save['json'];
			die();
		}
		function ajax_delete_save() {
			if (!wp_verify_nonce($_POST['nonce'], 'image_map_pro')) {
				die('Invalid nonce');
			}

			$id = $_POST['saveID'];

			$options = get_option($this->admin_options_name);
			unset($options['saves'][$id]);

			if ($options['last_save_id'] == $id) {
				unset($options['last_save_id']);
			}

			update_option($this->admin_options_name, $options);
		}
		function ajax_get_saves_list() {
			if (!wp_verify_nonce($_POST['nonce'], 'image_map_pro')) {
				die('Invalid nonce');
			}

			$options = get_option($this->admin_options_name);
			$list = array();

			foreach ($options['saves'] as $id => $save) {
				$listItem = array(
					"id" => $id,
					"name" => $save['meta']['name'],
					"shortcode" => $save['meta']['shortcode'],
				);

				array_push($list, $listItem);
			}

			echo json_encode($list);
			die();
		}
		function ajax_validate_purchase_code() {
			if (!wp_verify_nonce($_POST['nonce'], 'image_map_pro')) {
				die('Invalid nonce');
			}

			// Validate
			$code = $_POST['code'];

			$envato_apikey = "fyyd39viwu1ljcgt0z1lu5c1b8ebp1zt";
			$envato_username = "nickys";

			// CURL-less method

			$url = 'http://marketplace.envato.com/api/v3/' . $envato_username . '/' . $envato_apikey . '/verify-purchase:' . $code . '.json';

			// use key 'http' even if you send the request to https://...
			$options = array(
				'http' => array(
					'method'  => 'GET',
					'header'  => "Content-type: application/x-www-form-urlencoded\r\n" . "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36\r\n",
					'content' => ''
				)
			);
			
			$context = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			
			if ($result === FALSE) {
				echo "Error fetching the info: \n\n";
				echo $result;
			} else {
				$json_data = json_decode($result, true);
				if (isset($json_data['verify-purchase']) && count($json_data['verify-purchase']) > 0 && $json_data['verify-purchase']['item_id'] == '2826664') {
					// Store
					$options = get_option($this->admin_options_name);
					$options['purchase_code'] = $code;
					update_option($this->admin_options_name, $options);

					// Verify
					$options = get_option($this->admin_options_name);
					if ($options['purchase_code'] == $code) {
						echo 'success';
					}
				} else {
					print_r($json_data);
					die();
				}
			}

			die();
		}
		function ajax_get_country_svg() {
			if (!wp_verify_nonce($_POST['nonce'], 'image_map_pro')) {
				die('Invalid nonce');
			}
			
			$countryName = $_POST['countryName'];

			echo $GLOBALS['image_map_pro_countries'][$countryName];
			die();
		}
	}
}

if (class_exists('ImageMapPro')) {
	$instance = new ImageMapPro();
	$instance->shortcodes();
}



add_action('admin_menu', array($instance, 'init_pages'));

add_action('admin_enqueue_scripts', array($instance, 'register_admin_includes'));
add_action('wp_enqueue_scripts', array($instance, 'register_client_includes'));
add_action('enqueue_block_editor_assets', array($instance, 'enqueue_block_editor_assets'));

// Reworked
add_action('wp_ajax_image_map_pro_get_saves_list', array($instance, 'ajax_get_saves_list'));
add_action('wp_ajax_image_map_pro_store_save', array($instance, 'ajax_store_save'));
add_action('wp_ajax_image_map_pro_get_save', array($instance, 'ajax_get_save'));
add_action('wp_ajax_image_map_pro_delete_save', array($instance, 'ajax_delete_save'));
add_action('wp_ajax_image_map_pro_set_last_save', array($instance, 'ajax_set_last_save'));
add_action('wp_ajax_image_map_pro_get_last_save', array($instance, 'ajax_get_last_save'));
add_action('wp_ajax_image_map_pro_get_country_svg', array($instance, 'ajax_get_country_svg'));
add_action('wp_ajax_wcp_validate_purchase_code', array($instance, 'ajax_validate_purchase_code'));

// add_action('init', array($instance, 'autoupdate'));

add_filter('http_request_host_is_external', 'allow_my_custom_host_imp_wp', 10, 3);
function allow_my_custom_host_imp_wp($allow, $host, $url) {
	if ($host == 'imagemappro.com')
		$allow = true;
	return $allow;
}

// add_shortcode('test-shortcode', 'print_test_shortcode');

// function print_test_shortcode() {
// 	return "test\ntest";
// }