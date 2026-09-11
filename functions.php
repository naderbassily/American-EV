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

/**
 * The shop grid cards are wider than WooCommerce's 300px catalog thumbnail, so
 * serve the larger single-product size and let CSS scale it down.
 */
add_filter( 'single_product_archive_thumbnail_size', function () {
	return 'woocommerce_single';
} );

/**
 * Catalog cards send people to the product page to order rather than adding to
 * the cart inline, so every card carries the same "Order now" link.
 */
function aev_loop_order_now_button( $link, $product ) {
	return sprintf(
		'<a href="%1$s" class="button aev-order-now">%2$s</a>',
		esc_url( $product->get_permalink() ),
		esc_html__( 'Order now', 'american-ev' )
	);
}
add_filter( 'woocommerce_loop_add_to_cart_link', 'aev_loop_order_now_button', 10, 2 );

/**
 * Product pages run without breadcrumbs, and without the meta block - the only
 * thing it currently renders is an "Uncategorized" category link. Re-add either
 * line to bring them back.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

/**
 * Product benefit row - the four callouts from the product flyer, rendered as
 * text plus inline SVG rather than a flattened image so they stay legible,
 * selectable and translatable.
 */
function aev_product_benefit_icon( $name ) {
	$open  = '<svg class="product-benefits__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">';
	$paths = array(
		'airflow' => '<path d="M3 8h9a3 3 0 1 0-3-3"/><path d="M3 12h12.5a3 3 0 1 1-3 3"/><path d="M3 16h6"/>',
		'shield'  => '<path d="M12 3 4.5 6v5.4c0 4.3 3.1 7.7 7.5 9.1 4.4-1.4 7.5-4.8 7.5-9.1V6L12 3Z"/><path d="m8.9 11.9 2.3 2.3 4-4.4"/>',
		'wrench'  => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.8-3.8a6 6 0 0 1-8 8l-6.9 6.9a2.1 2.1 0 0 1-3-3l6.9-6.9a6 6 0 0 1 8-8l-3.8 3.8Z"/>',
		'charger' => '<rect x="4" y="3" width="10" height="18" rx="2.5"/><path d="M10.2 7.2 7.8 11.4h2.4l-.6 3.6 2.7-4.4h-2.4l.3-3.4Z" fill="currentColor" stroke="none"/><path d="M17.5 10H19a2 2 0 0 1 2 2v3.8a1.6 1.6 0 0 1-3.2 0V13h-1.3"/>',
	);
	return isset( $paths[ $name ] ) ? $open . $paths[ $name ] . '</svg>' : '';
}

function aev_product_benefits() {
	$benefits = array(
		array( 'airflow', __( 'Supports proper airflow', 'american-ev' ), __( 'Helps maintain cooling efficiency', 'american-ev' ) ),
		array( 'shield', __( 'Preventive maintenance', 'american-ev' ), __( 'Helps reduce dust build-up', 'american-ev' ) ),
		array( 'wrench', __( 'Easy to replace', 'american-ev' ), __( 'Designed for quick and simple installation', 'american-ev' ) ),
		array( 'charger', __( 'Supports charger reliability', 'american-ev' ), __( 'Helps keep your station operating at its best', 'american-ev' ) ),
	);

	echo '<ul class="product-benefits">';
	foreach ( $benefits as $benefit ) {
		list( $icon, $title, $copy ) = $benefit;
		printf(
			'<li class="product-benefits__item">%1$s<span class="product-benefits__title">%2$s</span><span class="product-benefits__copy">%3$s</span></li>',
			aev_product_benefit_icon( $icon ), // phpcs:ignore WordPress.Security.EscapeOutput -- fixed inline SVG.
			esc_html( $title ),
			esc_html( $copy )
		);
	}
	echo '</ul>';
}
add_action( 'woocommerce_single_product_summary', 'aev_product_benefits', 24 );

/**
 * srcset for a bundled theme image that ships in more than one width.
 *
 * Returns an empty string when $current_url is not the bundled file - an ACF
 * upload will have replaced it, and those carry their own sizes.
 *
 * @param string $base        File name without extension, e.g. 'hero'.
 * @param string $current_url URL actually being rendered (already escaped).
 * @param array  $sources     width => filename, e.g. array( 900 => 'hero-900.webp' ).
 */
function aev_theme_image_srcset( $base, $current_url, $sources ) {
	$dir = get_template_directory_uri() . '/assets/images/';
	if ( $current_url !== esc_url( $dir . $base . '.webp' ) ) {
		return '';
	}
	$set = array();
	foreach ( $sources as $width => $file ) {
		$set[] = esc_url( $dir . $file ) . ' ' . (int) $width . 'w';
	}
	return ' srcset="' . esc_attr( implode( ', ', $set ) ) . '"';
}

/**
 * Per-product "kit contents" panel fields.
 */
function aev_product_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	acf_add_local_field_group( array(
		'key'    => 'group_aev_product_kit',
		'title'  => 'Kit Contents Panel',
		'fields' => array(
			array(
				'key'          => 'field_aev_kit_quantity',
				'label'        => 'Quantity',
				'name'         => 'kit_quantity',
				'type'         => 'number',
				'min'          => 1,
				'instructions' => 'Number shown in the navy panel, e.g. 7. Leave empty to hide the panel entirely.',
			),
			array(
				'key'           => 'field_aev_kit_quantity_label',
				'label'         => 'Quantity Label',
				'name'          => 'kit_quantity_label',
				'type'          => 'text',
				'default_value' => 'Filters included',
				'instructions'  => 'Sits under the number, e.g. "Filters included".',
			),
			array(
				'key'          => 'field_aev_product_specs',
				'label'        => 'Spec Tables',
				'name'         => 'product_specs',
				'type'         => 'textarea',
				'rows'         => 14,
				'instructions' => 'One card per block, blank line between cards. First line is the heading, with an optional (Type). Then one "Label: Value" per line.',
			),
			array(
				'key'           => 'field_aev_kit_highlights',
				'label'         => 'Highlights',
				'name'          => 'kit_highlights',
				'type'          => 'textarea',
				'rows'          => 4,
				'default_value' => "Supports proper airflow\nHelps maintain performance\nPreventive maintenance kit",
				'instructions'  => 'One checkmark line per row.',
			),
		),
		'location'        => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'product' ) ) ),
		'position'        => 'normal',
		'label_placement' => 'top',
		'active'          => true,
	) );
}
add_action( 'acf/init', 'aev_product_acf_fields' );

/**
 * Navy kit panel: quantity beside a checklist. Renders only when the product
 * carries a quantity, so products without kit data simply skip it.
 */
function aev_product_kit_panel() {
	$quantity = aev_field( 'kit_quantity' );
	if ( '' === $quantity || null === $quantity || ! is_numeric( $quantity ) ) {
		return;
	}
	$label      = aev_field( 'kit_quantity_label', __( 'Filters included', 'american-ev' ) );
	// ACF only applies default_value in the admin form for new posts, so the
	// theme carries its own fallbacks - same pattern as the homepage fields.
	$highlights = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) aev_field( 'kit_highlights', "Supports proper airflow\nHelps maintain performance\nPreventive maintenance kit" ) ) ) );
	?>
	<div class="kit-panel">
		<div class="kit-panel__count">
			<span class="kit-panel__number"><?php echo esc_html( $quantity ); ?></span>
			<span class="kit-panel__label"><?php echo esc_html( $label ); ?></span>
		</div>
		<?php if ( $highlights ) : ?>
			<ul class="kit-panel__list">
				<?php foreach ( $highlights as $highlight ) : ?>
					<li><svg class="kit-panel__check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m4 12.5 5.2 5.2L20 6.8"/></svg><span><?php echo esc_html( $highlight ); ?></span></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
	<?php
}
add_action( 'woocommerce_before_single_product_summary', 'aev_product_kit_panel', 25 );

/**
 * "Proudly made in the USA" badge, rendered directly under the product gallery.
 *
 * Sits between the gallery and the summary in the DOM; CSS places it in the
 * left column, second row, so it reads as part of the gallery block.
 */
function aev_made_in_usa_badge() {
	$stripes = '';
	for ( $i = 0; $i < 7; $i++ ) {
		$stripes .= sprintf( '<rect y="%s" width="26" height="1.385"/>', round( $i * 2.769, 3 ) );
	}
	$stars = '';
	for ( $row = 0; $row < 4; $row++ ) {
		for ( $col = 0; $col < 5; $col++ ) {
			$stars .= sprintf( '<circle cx="%s" cy="%s" r=".4"/>', round( 1.3 + $col * 1.95, 3 ), round( 1.35 + $row * 2.35, 3 ) );
		}
	}
	?>
	<p class="usa-badge">
		<svg class="usa-badge__flag" viewBox="0 0 26 18" role="img" aria-label="<?php esc_attr_e( 'Flag of the United States', 'american-ev' ); ?>">
			<rect width="26" height="18" fill="#fff"/>
			<g fill="#b22234"><?php echo $stripes; // phpcs:ignore WordPress.Security.EscapeOutput -- generated markup. ?></g>
			<rect width="10.4" height="9.692" fill="#3c3b6e"/>
			<g fill="#fff"><?php echo $stars; // phpcs:ignore WordPress.Security.EscapeOutput -- generated markup. ?></g>
		</svg>
		<span><?php esc_html_e( 'Proudly made in the USA', 'american-ev' ); ?></span>
	</p>
	<?php
}
add_action( 'woocommerce_single_product_summary', 'aev_made_in_usa_badge', 4 );

/**
 * Wrap the gallery and the kit panel in one element so they occupy a single
 * grid cell in the left column.
 *
 * 19 opens before woocommerce_show_product_images (20); 26 closes after the
 * kit panel (25). The sale flash (10) stays outside, positioned off div.product.
 */
add_action( 'woocommerce_before_single_product_summary', function () {
	echo '<div class="product-gallery-col">';
}, 19 );
add_action( 'woocommerce_before_single_product_summary', function () {
	echo '</div>';
}, 26 );

/**
 * Drop the Reviews tab from product pages, leaving Description on its own.
 */
add_filter( 'woocommerce_product_tabs', function ( $tabs ) {
	unset( $tabs['reviews'] );
	return $tabs;
}, 98 );

/**
 * Spec tables beside the description.
 *
 * ACF free has no Repeater field, so the data lives in one textarea with a
 * plain-text shape the client can edit without markup:
 *
 *   Outlet Filter (Rectangular)
 *   Dimensions: 20" x 8"
 *   Quantity: 3 filters
 *
 *   Inlet Filter (Rectangular)
 *   Dimensions: 20" x 14"
 *
 * A blank line starts a new card. The first line is the card heading, with an
 * optional parenthetical shown alongside it. Every later "Label: Value" line
 * becomes a row; anything without a colon is skipped.
 */
function aev_parse_spec_tables( $raw ) {
	$cards = array();
	foreach ( preg_split( '/\R\s*\R/', trim( (string) $raw ) ) as $block ) {
		$lines = array_values( array_filter( array_map( 'trim', preg_split( '/\R/', $block ) ) ) );
		if ( ! $lines ) {
			continue;
		}
		$heading = array_shift( $lines );
		$type    = '';
		if ( preg_match( '/^(.*?)\s*\(([^)]*)\)$/', $heading, $matches ) ) {
			$heading = trim( $matches[1] );
			$type    = trim( $matches[2] );
		}
		$rows = array();
		foreach ( $lines as $line ) {
			$parts = explode( ':', $line, 2 );
			if ( 2 === count( $parts ) && '' !== trim( $parts[0] ) ) {
				$rows[] = array( trim( $parts[0] ), trim( $parts[1] ) );
			}
		}
		if ( $rows ) {
			$cards[] = array( 'heading' => $heading, 'type' => $type, 'rows' => $rows );
		}
	}
	return $cards;
}

function aev_product_spec_tables() {
	$cards = aev_parse_spec_tables( aev_field( 'product_specs', '' ) );
	if ( ! $cards ) {
		return;
	}
	echo '<div class="product-specs">';
	foreach ( $cards as $card ) {
		?>
		<table class="spec-card">
			<caption class="spec-card__head">
				<span class="spec-card__head-inner">
					<span class="spec-card__title"><?php echo esc_html( $card['heading'] ); ?></span>
					<?php if ( $card['type'] ) : ?><span class="spec-card__type"><?php echo esc_html( $card['type'] ); ?></span><?php endif; ?>
				</span>
			</caption>
			<tbody>
				<?php foreach ( $card['rows'] as $row ) : ?>
					<tr><th scope="row"><?php echo esc_html( $row[0] ); ?></th><td><?php echo esc_html( $row[1] ); ?></td></tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php
	}
	echo '</div>';
}
add_filter( 'woocommerce_product_tabs', function ( $tabs ) {
	if ( aev_parse_spec_tables( aev_field( 'product_specs', '' ) ) ) {
		$tabs['specs'] = array(
			'title'    => __( 'Specs', 'american-ev' ),
			'priority' => 15,
			'callback' => 'aev_product_spec_tables',
		);
	}
	return $tabs;
}, 97 );
