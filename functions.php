<?php
/**
 * Theme functionality.
 *
 * @package AmericanEV
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AEV_THEME_VERSION', '1.3.1' );
define( 'AEV_NOTIFICATION_EMAIL', 'info@americanevsolutions.com' );
define( 'AEV_FROM_EMAIL', 'info@americanevsolutions.com' );

/**
 * Receive theme updates from the stable GitHub branch through WordPress.
 */
function aev_init_github_theme_updater() {
	$loader = get_template_directory() . '/inc/plugin-update-checker/plugin-update-checker.php';
	if ( ! file_exists( $loader ) ) {
		return;
	}

	require_once $loader;

	$update_checker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
		'https://github.com/naderbassily/American-EV/',
		__FILE__,
		get_template()
	);
	$update_checker->setBranch( 'main' );
}
aev_init_github_theme_updater();

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

function aev_ensure_theme_pages() {
	if ( AEV_THEME_VERSION === get_option( 'aev_required_pages_version' ) ) {
		return;
	}

	$required_pages = array(
		'contact' => array(
			'title'    => __( 'Contact Us', 'american-ev' ),
			'template' => 'page-contact.php',
		),
		'thank-you' => array(
			'title'    => __( 'Thank You', 'american-ev' ),
			'template' => 'page-thank-you.php',
		),
	);
	$all_ready = true;

	foreach ( $required_pages as $slug => $settings ) {
		$page = get_page_by_path( $slug );
		if ( ! $page ) {
			$page_id = wp_insert_post( array(
				'post_type'   => 'page',
				'post_status' => 'publish',
				'post_title'  => $settings['title'],
				'post_name'   => $slug,
			) );
			if ( is_wp_error( $page_id ) || ! $page_id ) {
				$all_ready = false;
				continue;
			}
		} else {
			$page_id = $page->ID;
		}
		update_post_meta( $page_id, '_wp_page_template', $settings['template'] );
	}

	if ( $all_ready ) {
		update_option( 'aev_required_pages_version', AEV_THEME_VERSION, false );
	}
}
add_action( 'init', 'aev_ensure_theme_pages', 20 );

function aev_assets() {
	wp_enqueue_style( 'aev-fonts', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700&display=swap', array(), null );
	wp_enqueue_style( 'aev-style', get_stylesheet_uri(), array(), AEV_THEME_VERSION );
	wp_enqueue_script( 'aev-theme', get_template_directory_uri() . '/assets/js/theme.js', array(), AEV_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'aev_assets' );

function aev_clean_document_head() {
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_site_icon', 99 );
	remove_action( 'wp_head', 'rel_canonical' );
}
add_action( 'after_setup_theme', 'aev_clean_document_head', 20 );

function aev_favicon_tags() {
	$icon_url = get_template_directory_uri() . '/assets/favicon/';
	?>
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url( $icon_url . 'favicon-32.png' ); ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo esc_url( $icon_url . 'favicon-16.png' ); ?>">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( $icon_url . 'apple-touch-icon.png' ); ?>">
	<link rel="icon" type="image/png" sizes="512x512" href="<?php echo esc_url( $icon_url . 'site-icon-512.png' ); ?>">
	<meta name="theme-color" content="#071522">
	<?php
}
add_action( 'wp_head', 'aev_favicon_tags', 2 );

function aev_uses_seo_plugin() {
	return defined( 'WPSEO_VERSION' )
		|| defined( 'RANK_MATH_VERSION' )
		|| defined( 'AIOSEO_VERSION' )
		|| defined( 'SEOPRESS_VERSION' );
}

function aev_meta_description() {
	$descriptions = array(
		'services' => 'Replacement parts, component sourcing, and preventive maintenance support for commercial EV charging equipment.',
		'filters'  => 'Replacement filters for commercial EV charging equipment, with practical support identifying the right component for your charger.',
		'about'    => 'Learn how American EV Solutions supports commercial EV charging operators with practical parts sourcing and preventive maintenance.',
		'contact'  => 'Contact American EV Solutions about commercial EV charging replacement parts, hard-to-source components, and preventive maintenance support.',
	);

	if ( is_front_page() ) {
		return 'Commercial EV charging replacement parts, hard-to-source components, and preventive maintenance support from American EV Solutions.';
	}
	foreach ( $descriptions as $page => $description ) {
		if ( is_page( $page ) || ( 'filters' === $page && function_exists( 'is_shop' ) && is_shop() ) ) {
			return $description;
		}
	}
	if ( is_singular() && has_excerpt() ) {
		return wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 28, '' );
	}
	return get_bloginfo( 'description' );
}

function aev_meta_image_url() {
	if ( is_singular() && has_post_thumbnail() ) {
		$image = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' );
		if ( $image ) {
			return $image;
		}
	}
	if ( is_page( array( 'services', 'about' ) ) ) {
		return get_template_directory_uri() . '/assets/images/services-hero-maintenance.webp';
	}
	if ( is_page( 'filters' ) || ( function_exists( 'is_shop' ) && is_shop() ) ) {
		return get_template_directory_uri() . '/assets/images/filters-hero.webp';
	}
	return get_template_directory_uri() . '/assets/images/commercial-charging-hero.webp';
}

function aev_meta_tags() {
	if ( aev_uses_seo_plugin() || is_admin() || is_feed() || is_search() || is_404() || is_page( 'thank-you' ) ) {
		return;
	}
	$description = aev_meta_description();
	$title       = wp_get_document_title();
	$canonical   = is_singular() ? get_permalink() : home_url( wp_parse_url( $_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH ) );
	$image       = aev_meta_image_url();
	$type        = is_singular( array( 'post', 'product' ) ) ? 'article' : 'website';
	?>
	<meta name="description" content="<?php echo esc_attr( $description ); ?>">
	<link rel="canonical" href="<?php echo esc_url( $canonical ); ?>">
	<meta property="og:locale" content="<?php echo esc_attr( get_locale() ); ?>">
	<meta property="og:type" content="<?php echo esc_attr( $type ); ?>">
	<meta property="og:title" content="<?php echo esc_attr( $title ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( $description ); ?>">
	<meta property="og:url" content="<?php echo esc_url( $canonical ); ?>">
	<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
	<meta property="og:image" content="<?php echo esc_url( $image ); ?>">
	<meta property="og:image:alt" content="American EV Solutions commercial EV charging support">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?php echo esc_attr( $title ); ?>">
	<meta name="twitter:description" content="<?php echo esc_attr( $description ); ?>">
	<meta name="twitter:image" content="<?php echo esc_url( $image ); ?>">
	<?php
}
add_action( 'wp_head', 'aev_meta_tags', 3 );

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

function aev_contact_url( $anchor = '' ) {
	$contact = get_page_by_path( 'contact' );
	$url     = $contact ? get_permalink( $contact ) : home_url( '/contact/' );
	return $anchor ? $url . '#' . ltrim( $anchor, '#' ) : $url;
}

function aev_fallback_menu() {
	$about = get_page_by_path( 'about' );
	$links = array(
		array(
			'label'   => __( 'Services', 'american-ev' ),
			'url'     => home_url( '/services/' ),
			'current' => is_page( 'services' ),
		),
		array(
			'label'   => __( 'Filters', 'american-ev' ),
			'url'     => home_url( '/filters/' ),
			'current' => is_page( 'filters' ) || ( function_exists( 'is_shop' ) && is_shop() ),
		),
		array(
			// Falls back to the homepage anchor until the About page exists.
			'label'   => __( 'About', 'american-ev' ),
			'url'     => $about ? get_permalink( $about ) : aev_home_anchor( 'process' ),
			'current' => $about && is_page( $about->ID ),
		),
	);
	foreach ( $links as $link ) {
		printf(
			'<a href="%1$s"%2$s%3$s>%4$s</a>',
			esc_url( $link['url'] ),
			$link['current'] ? ' class="is-current"' : '',
			$link['current'] ? ' aria-current="page"' : '',
			esc_html( $link['label'] )
		);
	}
}

function aev_register_enquiry_type() {
	register_post_type( 'aev_enquiry', array(
		'labels' => array( 'name' => __( 'Website Requests', 'american-ev' ), 'singular_name' => __( 'Website Request', 'american-ev' ) ),
		'public' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_icon' => 'dashicons-email-alt',
		'supports' => array( 'title', 'editor', 'custom-fields' ),
	) );
}
add_action( 'init', 'aev_register_enquiry_type' );

function aev_email_detail_row( $label, $value ) {
	if ( '' === trim( (string) $value ) ) {
		return '';
	}
	return sprintf(
		'<tr><td style="width:38%%;padding:11px 16px 11px 0;border-bottom:1px solid #e2e7eb;color:#65717d;font-size:13px;line-height:1.5;vertical-align:top;">%1$s</td><td style="padding:11px 0;border-bottom:1px solid #e2e7eb;color:#102337;font-size:14px;font-weight:600;line-height:1.5;vertical-align:top;">%2$s</td></tr>',
		esc_html( $label ),
		esc_html( $value )
	);
}

function aev_handle_quote_request() {
	$requested_redirect = isset( $_POST['redirect_to'] ) ? esc_url_raw( wp_unslash( $_POST['redirect_to'] ) ) : '';
	$redirect           = wp_validate_redirect( $requested_redirect, home_url( '/#contact' ) );
	$success_redirect   = home_url( '/thank-you/' );
	$nonce_is_valid = isset( $_POST['aev_quote_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['aev_quote_nonce'] ) ), 'aev_quote_request' );
	// Logged-out forms may be served from a full-page cache after a WordPress nonce expires.
	// The public form is protected by its honeypot below; logged-in submissions still require a valid nonce.
	if ( is_user_logged_in() && ! $nonce_is_valid ) {
		wp_safe_redirect( add_query_arg( 'quote', 'invalid', $redirect ) );
		exit;
	}
	if ( ! empty( $_POST['company_url'] ) ) {
		wp_safe_redirect( $success_redirect );
		exit;
	}
	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$company = isset( $_POST['company'] ) ? sanitize_text_field( wp_unslash( $_POST['company'] ) ) : '';
	$service = isset( $_POST['service'] ) ? sanitize_text_field( wp_unslash( $_POST['service'] ) ) : '';
	$form_type = isset( $_POST['form_type'] ) && 'general' === sanitize_key( wp_unslash( $_POST['form_type'] ) ) ? 'general' : 'service';
	$form_url_raw = isset( $_POST['form_url'] ) ? esc_url_raw( wp_unslash( $_POST['form_url'] ) ) : '';
	$form_url     = wp_validate_redirect( $form_url_raw, home_url( '/' ) );
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	$charger_manufacturer = isset( $_POST['charger_manufacturer'] ) ? sanitize_text_field( wp_unslash( $_POST['charger_manufacturer'] ) ) : '';
	$charger_model        = isset( $_POST['charger_model'] ) ? sanitize_text_field( wp_unslash( $_POST['charger_model'] ) ) : '';
	$part_number          = isset( $_POST['part_number'] ) ? sanitize_text_field( wp_unslash( $_POST['part_number'] ) ) : '';
	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_safe_redirect( add_query_arg( 'quote', 'required', $redirect ) );
		exit;
	}
	$request_label = 'general' === $form_type ? 'General inquiry' : 'Parts or service request';
	$body = sprintf( "Form: %s\nName: %s\nEmail: %s\nPhone: %s\nCompany: %s\nRequest: %s\nCharger manufacturer: %s\nCharger model: %s\nPart number: %s\n\nMessage:\n%s", $request_label, $name, $email, $phone, $company, $service, $charger_manufacturer, $charger_model, $part_number, $message );
	$post_id = wp_insert_post( array(
		'post_type' => 'aev_enquiry',
		'post_status' => 'private',
		'post_title' => sprintf( '%s: %s — %s', $request_label, $name, current_time( 'M j, Y g:i a' ) ),
		'post_content' => $body,
	) );
	if ( ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, '_aev_email', $email );
		update_post_meta( $post_id, '_aev_phone', $phone );
		update_post_meta( $post_id, '_aev_company', $company );
		update_post_meta( $post_id, '_aev_service', $service );
		update_post_meta( $post_id, '_aev_form_type', $form_type );
		update_post_meta( $post_id, '_aev_form_url', $form_url );
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
	$recipient = sanitize_email( AEV_NOTIFICATION_EMAIL );
	$headers   = array(
		'From: American EV Solutions <' . sanitize_email( AEV_FROM_EMAIL ) . '>',
		'Reply-To: ' . $name . ' <' . $email . '>',
		'Content-Type: text/html; charset=UTF-8',
	);
	$logo_url = get_template_directory_uri() . '/assets/images/email-logo.png';
	$details  = aev_email_detail_row( 'Name', $name );
	$details .= aev_email_detail_row( 'Email', $email );
	$details .= aev_email_detail_row( 'Phone', $phone );
	$details .= aev_email_detail_row( 'Company', $company );
	$details .= aev_email_detail_row( 'Inquiry type', $service );
	$details .= aev_email_detail_row( 'Charger manufacturer', $charger_manufacturer );
	$details .= aev_email_detail_row( 'Charger model', $charger_model );
	$details .= aev_email_detail_row( 'Part number', $part_number );
	$email_body = sprintf(
		'<!doctype html><html><body style="margin:0;padding:0;background:#f1f3f5;font-family:Arial,Helvetica,sans-serif;color:#102337;"><table role="presentation" width="100%%" cellspacing="0" cellpadding="0" border="0" style="width:100%%;background:#f1f3f5;"><tr><td align="center" style="padding:34px 16px;"><table role="presentation" width="640" cellspacing="0" cellpadding="0" border="0" style="width:100%%;max-width:640px;background:#ffffff;border-radius:18px;overflow:hidden;box-shadow:0 14px 40px rgba(0,31,63,.12);"><tr><td style="height:6px;background:#4ba271;font-size:0;line-height:0;">&nbsp;</td></tr><tr><td style="padding:24px 34px;background:#ffffff;border-bottom:1px solid #e7ebee;"><img src="%1$s" width="190" alt="American EV Solutions" style="display:block;width:190px;max-width:100%%;height:auto;border:0;"></td></tr><tr><td style="padding:34px;background:#071522;"><p style="margin:0 0 12px;color:#61b985;font-size:12px;font-weight:700;letter-spacing:1.8px;text-transform:uppercase;">New website inquiry</p><h1 style="margin:0;color:#ffffff;font-size:30px;line-height:1.2;letter-spacing:-.5px;">A new message from %2$s</h1><p style="margin:14px 0 0;color:#adbac5;font-size:15px;line-height:1.6;">Submitted through the American EV Solutions website.</p></td></tr><tr><td style="padding:30px 34px 8px;"><h2 style="margin:0 0 10px;color:#102337;font-size:19px;line-height:1.3;">Inquiry details</h2><table role="presentation" width="100%%" cellspacing="0" cellpadding="0" border="0">%3$s</table></td></tr><tr><td style="padding:22px 34px 8px;"><h2 style="margin:0 0 12px;color:#102337;font-size:19px;line-height:1.3;">Message</h2><div style="padding:18px 20px;border-left:4px solid #4ba271;border-radius:8px;background:#f5f7f8;color:#33475b;font-size:15px;line-height:1.7;">%4$s</div></td></tr><tr><td style="padding:26px 34px 34px;"><a href="mailto:%5$s" style="display:inline-block;padding:13px 24px;border-radius:999px;background:#4ba271;color:#ffffff;font-size:14px;font-weight:700;text-decoration:none;">Reply to %2$s</a></td></tr><tr><td style="padding:20px 34px;background:#f7f8f9;border-top:1px solid #e4e8eb;color:#65717d;font-size:12px;line-height:1.6;">Submitted from: <a href="%6$s" style="color:#2d66c3;text-decoration:none;word-break:break-all;">%6$s</a><br>This notification was sent by the American EV Solutions website.</td></tr></table></td></tr></table></body></html>',
		esc_url( $logo_url ),
		esc_html( $name ),
		$details,
		nl2br( esc_html( $message ) ),
		esc_attr( $email ),
		esc_url( $form_url )
	);
	$mail_sent = wp_mail(
		$recipient,
		'American EV solution inquiry',
		$email_body,
		$headers,
		$attachments
	);
	if ( ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, '_aev_mail_sent', $mail_sent ? 'yes' : 'no' );
	}
	wp_safe_redirect( $success_redirect );
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

/**
 * Echo each non-empty line of a block of copy as its own paragraph.
 * Lets a plain ACF textarea drive multi-paragraph sections.
 */
function aev_paragraphs( $text, $class = '' ) {
	$lines = array_filter( array_map( 'trim', preg_split( '/\R/', (string) $text ) ) );
	foreach ( $lines as $line ) {
		printf( '<p%1$s>%2$s</p>', $class ? ' class="' . esc_attr( $class ) . '"' : '', esc_html( $line ) );
	}
}

function aev_about_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	$text     = function ( $key, $label, $name, $rows = 2 ) {
		return array( 'key' => $key, 'label' => $label, 'name' => $name, 'type' => 'textarea', 'rows' => $rows, 'new_lines' => '' );
	};
	$image    = function ( $key, $label, $name ) {
		return array( 'key' => $key, 'label' => $label, 'name' => $name, 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' );
	};
	acf_add_local_field_group( array(
		'key'    => 'group_aev_about',
		'title'  => 'American EV About Page',
		'fields' => array(
			$text( 'field_aev_about_hero_title', 'Hero Title', 'about_hero_title' ),
			$text( 'field_aev_about_hero_body', 'Hero Description', 'about_hero_body', 3 ),
			$image( 'field_aev_about_hero_image', 'Hero Image', 'about_hero_image' ),
			$text( 'field_aev_about_who_title', 'Who We Are Title', 'about_who_title' ),
			$text( 'field_aev_about_who_body', 'Who We Are Copy', 'about_who_body', 6 ),
			$image( 'field_aev_about_who_image', 'Who We Are Image', 'about_who_image' ),
			$text( 'field_aev_about_why_title', 'Why We Are Here Title', 'about_why_title' ),
			$text( 'field_aev_about_why_body', 'Why We Are Here Copy', 'about_why_body', 5 ),
			$image( 'field_aev_about_why_image', 'Why We Are Here Image', 'about_why_image' ),
			$text( 'field_aev_about_approach_title', 'Approach Title', 'about_approach_title', 3 ),
			$text( 'field_aev_about_approach_body', 'Approach Description', 'about_approach_body', 3 ),
			$text( 'field_aev_about_support_title', 'Who We Support Title', 'about_support_title' ),
			$image( 'field_aev_about_support_image', 'Who We Support Image', 'about_support_image' ),
			$text( 'field_aev_about_cta_title', 'Closing CTA Title', 'about_cta_title' ),
			$text( 'field_aev_about_cta_body', 'Closing CTA Description', 'about_cta_body', 3 ),
			$image( 'field_aev_about_cta_image', 'Closing CTA Image', 'about_cta_image' ),
		),
		'location'        => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-about.php' ) ) ),
		'position'        => 'acf_after_title',
		'label_placement' => 'top',
		'active'          => true,
	) );
}
add_action( 'acf/init', 'aev_about_acf_fields' );

function aev_contact_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	acf_add_local_field_group( array(
		'key'    => 'group_aev_contact',
		'title'  => 'American EV Contact Page',
		'fields' => array(
			array( 'key' => 'field_aev_contact_page_hero_title', 'label' => 'Hero Title', 'name' => 'contact_page_hero_title', 'type' => 'text' ),
			array( 'key' => 'field_aev_contact_page_hero_body', 'label' => 'Hero Description', 'name' => 'contact_page_hero_body', 'type' => 'textarea', 'rows' => 3 ),
			array( 'key' => 'field_aev_contact_page_form_title', 'label' => 'Form Section Title', 'name' => 'contact_page_form_title', 'type' => 'text' ),
			array( 'key' => 'field_aev_contact_page_form_body', 'label' => 'Form Section Description', 'name' => 'contact_page_form_body', 'type' => 'textarea', 'rows' => 3 ),
		),
		'location'        => array( array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-contact.php' ) ) ),
		'position'        => 'acf_after_title',
		'label_placement' => 'top',
		'active'          => true,
	) );
}
add_action( 'acf/init', 'aev_contact_acf_fields' );
