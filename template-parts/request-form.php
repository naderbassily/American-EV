<?php
/**
 * Shared website request form.
 *
 * @package AmericanEV
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	isset( $args ) ? $args : array(),
	array(
		'form_id'      => 'website-request',
		'form_type'    => 'service',
		'redirect_to'  => home_url( '/#contact' ),
		'button_label' => __( 'Send Request', 'american-ev' ),
	)
);

$form_id      = sanitize_html_class( $args['form_id'] );
$form_type    = 'general' === $args['form_type'] ? 'general' : 'service';
$is_general   = 'general' === $form_type;
$redirect_to  = wp_validate_redirect( $args['redirect_to'], home_url( '/#contact' ) );
$form_url     = preg_replace( '/#.*$/', '', $redirect_to );
$button_label = sanitize_text_field( $args['button_label'] );
$email        = aev_field( 'contact_email', 'info@americanevsolutions.com' );
$phone        = aev_field( 'contact_phone', '404-309-4880' );
?>
<?php if ( isset( $_GET['quote'] ) ) : ?>
	<div class="form-alert form-alert--error" role="alert"><?php esc_html_e( 'Please check the required fields and try again.', 'american-ev' ); ?></div>
<?php endif; ?>
<form class="aev-request-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="action" value="aev_quote_request">
	<input type="hidden" name="form_type" value="<?php echo esc_attr( $form_type ); ?>">
	<input type="hidden" name="redirect_to" value="<?php echo esc_url( $redirect_to ); ?>">
	<input type="hidden" name="form_url" value="<?php echo esc_url( $form_url ); ?>">
	<?php wp_nonce_field( 'aev_quote_request', 'aev_quote_nonce' ); ?>
	<div class="hp-field" aria-hidden="true"><label>Leave this field empty <input type="text" name="company_url" tabindex="-1" autocomplete="off"></label></div>

	<div class="form-grid">
		<div class="field"><label for="<?php echo esc_attr( $form_id ); ?>-name">Name *</label><input id="<?php echo esc_attr( $form_id ); ?>-name" name="name" type="text" autocomplete="name" required></div>
		<div class="field"><label for="<?php echo esc_attr( $form_id ); ?>-email">Email *</label><input id="<?php echo esc_attr( $form_id ); ?>-email" name="email" type="email" autocomplete="email" required></div>
		<div class="field"><label for="<?php echo esc_attr( $form_id ); ?>-phone">Phone</label><input id="<?php echo esc_attr( $form_id ); ?>-phone" name="phone" type="tel" autocomplete="tel"></div>
		<div class="field"><label for="<?php echo esc_attr( $form_id ); ?>-company">Company</label><input id="<?php echo esc_attr( $form_id ); ?>-company" name="company" type="text" autocomplete="organization"></div>
		<div class="field field--full">
			<label for="<?php echo esc_attr( $form_id ); ?>-service"><?php echo esc_html( $is_general ? __( 'What would you like to discuss?', 'american-ev' ) : __( 'What do you need?', 'american-ev' ) ); ?></label>
			<select id="<?php echo esc_attr( $form_id ); ?>-service" name="service">
				<?php if ( $is_general ) : ?>
					<option value="General Inquiry">General inquiry</option>
					<option value="Parts Question">Parts question</option>
					<option value="Maintenance Question">Maintenance question</option>
					<option value="Partnership or Business Inquiry">Partnership or business inquiry</option>
					<option value="Other">Other</option>
				<?php else : ?>
					<option value="Replacement Part">Replacement part</option>
					<option value="Part Sourcing">Part sourcing</option>
					<option value="Preventive Maintenance">Preventive maintenance</option>
					<option value="Parts and Maintenance">Parts and maintenance</option>
					<option value="Other">Other</option>
				<?php endif; ?>
			</select>
		</div>

		<?php if ( ! $is_general ) : ?>
			<div class="field"><label for="<?php echo esc_attr( $form_id ); ?>-manufacturer">Charger Manufacturer</label><input id="<?php echo esc_attr( $form_id ); ?>-manufacturer" name="charger_manufacturer" type="text"></div>
			<div class="field"><label for="<?php echo esc_attr( $form_id ); ?>-model">Charger Model</label><input id="<?php echo esc_attr( $form_id ); ?>-model" name="charger_model" type="text"></div>
			<div class="field field--full"><label for="<?php echo esc_attr( $form_id ); ?>-part-number">Part Number</label><input id="<?php echo esc_attr( $form_id ); ?>-part-number" name="part_number" type="text"></div>
		<?php endif; ?>

		<div class="field field--full"><label for="<?php echo esc_attr( $form_id ); ?>-message"><?php echo esc_html( $is_general ? __( 'How can we help? *', 'american-ev' ) : __( 'Tell us what you’re looking for *', 'american-ev' ) ); ?></label><textarea id="<?php echo esc_attr( $form_id ); ?>-message" name="message" required></textarea></div>

		<?php if ( ! $is_general ) : ?>
			<div class="field field--full"><label for="<?php echo esc_attr( $form_id ); ?>-attachment">Upload Photo or Document</label><input id="<?php echo esc_attr( $form_id ); ?>-attachment" name="attachment" type="file" accept="image/jpeg,image/png,image/webp,application/pdf"><small>Upload a component photo, equipment label, specification, or reference image.</small></div>
		<?php endif; ?>
	</div>

	<div class="form-actions">
		<button class="btn" type="submit"><?php echo esc_html( $button_label ); ?></button>
		<div class="form-contact">
			<a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><svg aria-hidden="true" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg><span><?php echo esc_html( antispambot( $email ) ); ?></span></a>
			<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><svg aria-hidden="true" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.69 2.8a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.33 1.84.56 2.8.69A2 2 0 0 1 22 16.92Z"/></svg><span><?php echo esc_html( $phone ); ?></span></a>
		</div>
	</div>
</form>
