<?php
/**
 * Theme functionality.
 *
 * @package AmericanEV
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AEV_THEME_VERSION', '1.1.0' );

function aev_setup() {
	load_theme_textdomain( 'american-ev', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 100, 'width' => 280, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	register_nav_menus( array( 'primary' => __( 'Primary Navigation', 'american-ev' ), 'footer' => __( 'Footer Navigation', 'american-ev' ) ) );
}
add_action( 'after_setup_theme', 'aev_setup' );

function aev_assets() {
	wp_enqueue_style( 'aev-fonts', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700&display=swap', array(), null );
	wp_enqueue_style( 'aev-style', get_stylesheet_uri(), array(), AEV_THEME_VERSION );
	wp_enqueue_script( 'aev-theme', get_template_directory_uri() . '/assets/js/theme.js', array(), AEV_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'aev_assets' );

function aev_field( $name, $default = '' ) {
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $name );
		if ( false !== $value && null !== $value && '' !== $value ) {
			return $value;
		}
	}
	return $default;
}

function aev_image_url( $field_name, $fallback ) {
	$image = aev_field( $field_name );
	if ( is_array( $image ) && ! empty( $image['url'] ) ) {
		return esc_url( $image['url'] );
	}
	if ( is_numeric( $image ) ) {
		return esc_url( wp_get_attachment_image_url( (int) $image, 'full' ) );
	}
	return esc_url( get_template_directory_uri() . $fallback );
}

function aev_home_anchor( $anchor ) {
	return is_front_page() ? '#' . ltrim( $anchor, '#' ) : home_url( '/#' . ltrim( $anchor, '#' ) );
}

function aev_fallback_menu() {
	$links = array(
		'services'    => __( 'Services', 'american-ev' ),
		'parts'       => __( 'Parts', 'american-ev' ),
		'maintenance' => __( 'Maintenance', 'american-ev' ),
		'process'     => __( 'About', 'american-ev' ),
	);
	foreach ( $links as $anchor => $label ) {
		$is_current = is_page( 'services' ) && 'services' === $anchor;
		$url        = 'services' === $anchor ? home_url( '/services/' ) : aev_home_anchor( $anchor );
		printf( '<a href="%1$s"%2$s%3$s>%4$s</a>', esc_url( $url ), $is_current ? ' class="is-current"' : '', $is_current ? ' aria-current="page"' : '', esc_html( $label ) );
	}
}

function aev_register_enquiry_type() {
	register_post_type( 'aev_enquiry', array(
		'labels' => array( 'name' => __( 'Quote Requests', 'american-ev' ), 'singular_name' => __( 'Quote Request', 'american-ev' ) ),
		'public' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_icon' => 'dashicons-email-alt',
		'supports' => array( 'title', 'editor', 'custom-fields' ),
	) );
}
add_action( 'init', 'aev_register_enquiry_type' );

function aev_handle_quote_request() {
	$requested_redirect = isset( $_POST['redirect_to'] ) ? esc_url_raw( wp_unslash( $_POST['redirect_to'] ) ) : '';
	$redirect           = wp_validate_redirect( $requested_redirect, home_url( '/#contact' ) );
	if ( ! isset( $_POST['aev_quote_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['aev_quote_nonce'] ) ), 'aev_quote_request' ) ) {
		wp_safe_redirect( add_query_arg( 'quote', 'invalid', $redirect ) );
		exit;
	}
	if ( ! empty( $_POST['company_url'] ) ) {
		wp_safe_redirect( add_query_arg( 'quote', 'success', $redirect ) );
		exit;
	}
	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$company = isset( $_POST['company'] ) ? sanitize_text_field( wp_unslash( $_POST['company'] ) ) : '';
	$service = isset( $_POST['service'] ) ? sanitize_text_field( wp_unslash( $_POST['service'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	$charger_manufacturer = isset( $_POST['charger_manufacturer'] ) ? sanitize_text_field( wp_unslash( $_POST['charger_manufacturer'] ) ) : '';
	$charger_model        = isset( $_POST['charger_model'] ) ? sanitize_text_field( wp_unslash( $_POST['charger_model'] ) ) : '';
	$part_number          = isset( $_POST['part_number'] ) ? sanitize_text_field( wp_unslash( $_POST['part_number'] ) ) : '';
	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_safe_redirect( add_query_arg( 'quote', 'required', $redirect ) );
		exit;
	}
	$body = sprintf( "Name: %s\nEmail: %s\nPhone: %s\nCompany: %s\nRequest: %s\nCharger manufacturer: %s\nCharger model: %s\nPart number: %s\n\n%s", $name, $email, $phone, $company, $service, $charger_manufacturer, $charger_model, $part_number, $message );
	$post_id = wp_insert_post( array(
		'post_type' => 'aev_enquiry',
		'post_status' => 'private',
		'post_title' => sprintf( '%s — %s', $name, current_time( 'M j, Y g:i a' ) ),
		'post_content' => $body,
	) );
	if ( ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, '_aev_email', $email );
		update_post_meta( $post_id, '_aev_phone', $phone );
		update_post_meta( $post_id, '_aev_company', $company );
		update_post_meta( $post_id, '_aev_service', $service );
		update_post_meta( $post_id, '_aev_charger_manufacturer', $charger_manufacturer );
		update_post_meta( $post_id, '_aev_charger_model', $charger_model );
		update_post_meta( $post_id, '_aev_part_number', $part_number );
	}
	$attachments = array();
	if ( ! is_wp_error( $post_id ) && ! empty( $_FILES['attachment']['name'] ) && empty( $_FILES['attachment']['error'] ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
		$attachment_id = media_handle_upload( 'attachment', $post_id, array(), array( 'test_form' => false, 'mimes' => array( 'jpg|jpeg|jpe' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp', 'pdf' => 'application/pdf' ) ) );
		if ( ! is_wp_error( $attachment_id ) ) {
			update_post_meta( $post_id, '_aev_attachment_id', $attachment_id );
			$attachment_path = get_attached_file( $attachment_id );
			if ( $attachment_path ) {
				$attachments[] = $attachment_path;
			}
		}
	}
	$recipient = sanitize_email( aev_field( 'contact_email', get_option( 'admin_email' ) ) );
	wp_mail( $recipient, sprintf( __( 'New quote request from %s', 'american-ev' ), $name ), $body, array( 'Reply-To: ' . $name . ' <' . $email . '>' ), $attachments );
	wp_safe_redirect( add_query_arg( 'quote', 'success', $redirect ) );
	exit;
}
add_action( 'admin_post_nopriv_aev_quote_request', 'aev_handle_quote_request' );
add_action( 'admin_post_aev_quote_request', 'aev_handle_quote_request' );

function aev_plugin_notice() {
	$missing = array();
	if ( ! class_exists( 'WooCommerce' ) ) {
		$missing[] = 'WooCommerce';
	}
	if ( ! function_exists( 'get_field' ) ) {
		$missing[] = 'Advanced Custom Fields';
	}
	if ( $missing ) {
		printf( '<div class="notice notice-warning"><p>%s</p></div>', esc_html( sprintf( __( 'American EV Solutions recommends activating: %s.', 'american-ev' ), implode( ', ', $missing ) ) ) );
	}
}
add_action( 'admin_notices', 'aev_plugin_notice' );

function aev_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	$fields = array(
		array( 'key' => 'field_aev_hero_eyebrow', 'label' => 'Hero Eyebrow', 'name' => 'hero_eyebrow', 'type' => 'text', 'default_value' => 'Commercial EV Charging Support' ),
		array( 'key' => 'field_aev_hero_title', 'label' => 'Hero Title', 'name' => 'hero_title', 'type' => 'text', 'default_value' => 'Built for uptime.' ),
		array( 'key' => 'field_aev_hero_body', 'label' => 'Hero Description', 'name' => 'hero_body', 'type' => 'textarea', 'rows' => 3 ),
		array( 'key' => 'field_aev_hero_image', 'label' => 'Hero Image', 'name' => 'hero_image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ),
		array( 'key' => 'field_aev_intro_title', 'label' => 'Intro Title', 'name' => 'intro_title', 'type' => 'text' ),
		array( 'key' => 'field_aev_intro_body', 'label' => 'Intro Description', 'name' => 'intro_body', 'type' => 'textarea', 'rows' => 4 ),
		array( 'key' => 'field_aev_parts_title', 'label' => 'Parts Title', 'name' => 'parts_title', 'type' => 'text' ),
		array( 'key' => 'field_aev_parts_body', 'label' => 'Parts Description', 'name' => 'parts_body', 'type' => 'textarea', 'rows' => 4 ),
		array( 'key' => 'field_aev_parts_image', 'label' => 'Parts Image', 'name' => 'parts_image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ),
		array( 'key' => 'field_aev_maintenance_title', 'label' => 'Maintenance Title', 'name' => 'maintenance_title', 'type' => 'text' ),
		array( 'key' => 'field_aev_maintenance_body', 'label' => 'Maintenance Description', 'name' => 'maintenance_body', 'type' => 'textarea', 'rows' => 4 ),
		array( 'key' => 'field_aev_contact_title', 'label' => 'Contact Title', 'name' => 'contact_title', 'type' => 'text' ),
		array( 'key' => 'field_aev_contact_body', 'label' => 'Contact Description', 'name' => 'contact_body', 'type' => 'textarea', 'rows' => 4 ),
		array( 'key' => 'field_aev_contact_email', 'label' => 'Contact Email', 'name' => 'contact_email', 'type' => 'email', 'default_value' => 'info@americanevsolutions.com' ),
		array( 'key' => 'field_aev_contact_phone', 'label' => 'Contact Phone', 'name' => 'contact_phone', 'type' => 'text', 'default_value' => '404-309-4880' ),
	);
	acf_add_local_field_group( array(
		'key' => 'group_aev_homepage',
		'title' => 'American EV Homepage',
		'fields' => $fields,
		'location' => array( array( array( 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ) ) ),
		'menu_order' => 0,
		'position' => 'acf_after_title',
		'style' => 'default',
		'label_placement' => 'top',
		'active' => true,
	) );
}
add_action( 'acf/init', 'aev_acf_fields' );

function aev_services_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	acf_add_local_field_group( array(
		'key' => 'group_aev_services',
		'title' => 'American EV Services Page',
		'fields' => array(
			array( 'key' => 'field_aev_services_hero_title', 'label' => 'Hero Title', 'name' => 'services_hero_title', 'type' => 'textarea', 'rows' => 2, 'new_lines' => '' ),
			array( 'key' => 'field_aev_services_hero_body', 'label' => 'Hero Description', 'name' => 'services_hero_body', 'type' => 'textarea', 'rows' => 3, 'new_lines' => '' ),
			array( 'key' => 'field_aev_services_hero_image', 'label' => 'Hero Image', 'name' => 'services_hero_image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ),
			array( 'key' => 'field_aev_services_overview_title', 'label' => 'Overview Title', 'name' => 'services_overview_title', 'type' => 'textarea', 'rows' => 2, 'new_lines' => '' ),
			array( 'key' => 'field_aev_services_parts_title', 'label' => 'Replacement Parts Title', 'name' => 'services_parts_title', 'type' => 'textarea', 'rows' => 2, 'new_lines' => '' ),
			array( 'key' => 'field_aev_services_parts_body', 'label' => 'Replacement Parts Description', 'name' => 'services_parts_body', 'type' => 'textarea', 'rows' => 3, 'new_lines' => '' ),
			array( 'key' => 'field_aev_services_sourcing_title', 'label' => 'Part Sourcing Title', 'name' => 'services_sourcing_title', 'type' => 'textarea', 'rows' => 2, 'new_lines' => '' ),
			array( 'key' => 'field_aev_services_sourcing_body', 'label' => 'Part Sourcing Description', 'name' => 'services_sourcing_body', 'type' => 'textarea', 'rows' => 3, 'new_lines' => '' ),
			array( 'key' => 'field_aev_services_featured_title', 'label' => 'Featured Component Title', 'name' => 'services_featured_title', 'type' => 'textarea', 'rows' => 2, 'new_lines' => '' ),
			array( 'key' => 'field_aev_services_featured_body', 'label' => 'Featured Component Description', 'name' => 'services_featured_body', 'type' => 'textarea', 'rows' => 3, 'new_lines' => '' ),
			array( 'key' => 'field_aev_services_maintenance_title', 'label' => 'Maintenance Title', 'name' => 'services_maintenance_title', 'type' => 'textarea', 'rows' => 2, 'new_lines' => '' ),
			array( 'key' => 'field_aev_services_maintenance_body', 'label' => 'Maintenance Description', 'name' => 'services_maintenance_body', 'type' => 'textarea', 'rows' => 3, 'new_lines' => '' ),
			array( 'key' => 'field_aev_services_request_title', 'label' => 'Request Section Title', 'name' => 'services_request_title', 'type' => 'textarea', 'rows' => 2, 'new_lines' => '' ),
			array( 'key' => 'field_aev_services_request_body', 'label' => 'Request Section Description', 'name' => 'services_request_body', 'type' => 'textarea', 'rows' => 3, 'new_lines' => '' ),
		),
		'location' => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-services.php' ) ) ),
		'position' => 'acf_after_title',
		'label_placement' => 'top',
		'active' => true,
	) );
}
add_action( 'acf/init', 'aev_services_acf_fields' );

function aev_wc_wrapper_start() {
	echo '<main class="site-main site-main--inner"><div class="container">';
}
function aev_wc_wrapper_end() {
	echo '</div></main>';
}
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 'aev_wc_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'aev_wc_wrapper_end', 10 );
add_filter( 'woocommerce_show_page_title', '__return_true' );

function aev_redirect_legacy_shop() {
	$path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
	if ( is_404() && 'shop' === $path && class_exists( 'WooCommerce' ) ) {
		wp_safe_redirect( wc_get_page_permalink( 'shop' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'aev_redirect_legacy_shop', 1 );

/**
 * WordPress rewrite rules are case-sensitive, so /FILTERS/ misses the product
 * archive rule and falls back to the shop page object with no products in the
 * loop. Send mis-cased shop URLs to the canonical permalink instead.
 */
function aev_redirect_miscased_shop() {
	if ( ! class_exists( 'WooCommerce' ) || is_front_page() ) {
		return;
	}
	$shop_id = wc_get_page_id( 'shop' );
	if ( $shop_id <= 0 || ! is_page( $shop_id ) ) {
		return;
	}
	$shop_url  = wc_get_page_permalink( 'shop' );
	$requested = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
	$canonical = trim( (string) wp_parse_url( $shop_url, PHP_URL_PATH ), '/' );
	if ( '' !== $canonical && $requested !== $canonical && strtolower( $requested ) === strtolower( $canonical ) ) {
		wp_safe_redirect( $shop_url, 301 );
		exit;
	}
}
add_action( 'template_redirect', 'aev_redirect_miscased_shop', 1 );
