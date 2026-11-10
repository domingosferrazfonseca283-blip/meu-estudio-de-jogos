<?php
/**
 * Plugin Name: Kamba Core
 * Plugin URI: https://github.com/domingosferrazfonseca283-blip/meu-estudio-de-jogos
 * Description: The foundation of Kamba CMS: a modern, branded administration experience built on WordPress.
 * Version: 0.2.0
 * Requires at least: 6.6
 * Requires PHP: 7.4
 * Author: Kamba Project
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: kamba-core
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
define( 'KAMBA_CORE_VERSION', '0.2.0' );
define( 'KAMBA_CORE_FILE', __FILE__ );
define( 'KAMBA_CORE_URL', plugin_dir_url( __FILE__ ) );

function kamba_default_identity() {
	return array(
		'platform_name' => 'Kamba',
		'logo_url'      => '',
		'primary_color' => '#2864dc',
		'dark_color'    => '#172b4d',
	);
}

function kamba_get_identity() {
	return wp_parse_args( get_option( 'kamba_identity', array() ), kamba_default_identity() );
}

function kamba_sanitize_identity( $input ) {
	$defaults = kamba_default_identity();
	$input = is_array( $input ) ? $input : array();
	$primary = isset( $input['primary_color'] ) ? sanitize_hex_color( $input['primary_color'] ) : '';
	$dark = isset( $input['dark_color'] ) ? sanitize_hex_color( $input['dark_color'] ) : '';
	return array(
		'platform_name' => isset( $input['platform_name'] ) ? sanitize_text_field( $input['platform_name'] ) : $defaults['platform_name'],
		'logo_url'      => isset( $input['logo_url'] ) ? esc_url_raw( $input['logo_url'] ) : '',
		'primary_color' => $primary ? $primary : $defaults['primary_color'],
		'dark_color'    => $dark ? $dark : $defaults['dark_color'],
	);
}

function kamba_register_settings() {
	register_setting( 'kamba_identity_group', 'kamba_identity', array(
		'type'              => 'array',
		'sanitize_callback' => 'kamba_sanitize_identity',
		'default'           => kamba_default_identity(),
	) );
}
add_action( 'admin_init', 'kamba_register_settings' );

function kamba_register_admin_menu() {
	$identity = kamba_get_identity();
	add_menu_page( __( 'Kamba Dashboard', 'kamba-core' ), $identity['platform_name'], 'manage_options', 'kamba', 'kamba_render_dashboard', 'dashicons-admin-site-alt3', 3 );
	add_submenu_page( 'kamba', __( 'Kamba Settings', 'kamba-core' ), __( 'Identity', 'kamba-core' ), 'manage_options', 'kamba-settings', 'kamba_render_settings' );
}
add_action( 'admin_menu', 'kamba_register_admin_menu' );

function kamba_enqueue_admin_assets( $hook_suffix ) {
	if ( false === strpos( $hook_suffix, 'kamba' ) ) { return; }
	wp_enqueue_style( 'kamba-admin', KAMBA_CORE_URL . 'assets/admin.css', array(), KAMBA_CORE_VERSION );
	$identity = kamba_get_identity();
	$custom_css = '.kamba-wrap{--kamba-blue:' . $identity['primary_color'] . ';--kamba-ink:' . $identity['dark_color'] . ';}';
	wp_add_inline_style( 'kamba-admin', $custom_css );
}
add_action( 'admin_enqueue_scripts', 'kamba_enqueue_admin_assets' );

function kamba_get_brand_mark( $identity ) {
	return $identity['logo_url'] ? $identity['logo_url'] : KAMBA_CORE_URL . 'assets/kamba-mark.svg';
}

function kamba_render_dashboard() {
	if ( ! current_user_can( 'manage_options' ) ) { wp_die( esc_html__( 'You do not have permission to access this page.', 'kamba-core' ) ); }
	$identity = kamba_get_identity();
	$site_name = get_bloginfo( 'name' );
	?>
	<div class="wrap kamba-wrap">
		<header class="kamba-header">
			<div class="kamba-brand">
				<img src="<?php echo esc_url( kamba_get_brand_mark( $identity ) ); ?>" alt="" width="48" height="48">
				<div><p class="kamba-eyebrow"><?php echo esc_html( strtoupper( $identity['platform_name'] ) ); ?> · <?php esc_html_e( 'CONTENT MANAGEMENT', 'kamba-core' ); ?></p>
				<h1><?php echo esc_html( sprintf( __( 'Welcome to %s', 'kamba-core' ), $identity['platform_name'] ) ); ?></h1>
				<p class="kamba-subtitle"><?php esc_html_e( 'A clearer, more capable home for your digital presence.', 'kamba-core' ); ?></p></div>
			</div>
			<a class="kamba-button kamba-button-primary" href="<?php echo esc_url( admin_url( 'options-general.php' ) ); ?>"><?php esc_html_e( 'WordPress configuration', 'kamba-core' ); ?></a>
		</header>
		<section class="kamba-welcome">
			<div><span class="kamba-pill"><?php esc_html_e( 'YOUR WORKSPACE', 'kamba-core' ); ?></span>
			<h2><?php echo esc_html( sprintf( __( 'Hello, %s', 'kamba-core' ), wp_get_current_user()->display_name ) ); ?></h2>
			<p><?php echo esc_html( sprintf( __( '%s is being built in clear, reliable steps. Your existing WordPress content and tools remain available while we add the %s experience.', 'kamba-core' ), $identity['platform_name'], $identity['platform_name'] ) ); ?></p></div>
			<div class="kamba-welcome-mark" aria-hidden="true">K</div>
		</section>
		<div class="kamba-section-heading"><div><h2><?php esc_html_e( 'Your workspace at a glance', 'kamba-core' ); ?></h2>
		<p><?php esc_html_e( 'Quick access to the tools you use most.', 'kamba-core' ); ?></p></div></div>
		<div class="kamba-card-grid">
			<a class="kamba-card" href="<?php echo esc_url( admin_url( 'edit.php' ) ); ?>"><span class="kamba-card-icon dashicons dashicons-admin-post"></span><span class="kamba-card-title"><?php esc_html_e( 'Content', 'kamba-core' ); ?></span><span class="kamba-card-description"><?php esc_html_e( 'Create, edit and organise your posts.', 'kamba-core' ); ?></span><span class="kamba-card-link"><?php esc_html_e( 'Manage content', 'kamba-core' ); ?> &rarr;</span></a>
			<a class="kamba-card" href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>"><span class="kamba-card-icon dashicons dashicons-admin-page"></span><span class="kamba-card-title"><?php esc_html_e( 'Pages', 'kamba-core' ); ?></span><span class="kamba-card-description"><?php esc_html_e( 'Build the main pages of your website.', 'kamba-core' ); ?></span><span class="kamba-card-link"><?php esc_html_e( 'Manage pages', 'kamba-core' ); ?> &rarr;</span></a>
			<a class="kamba-card" href="<?php echo esc_url( admin_url( 'upload.php' ) ); ?>"><span class="kamba-card-icon dashicons dashicons-format-image"></span><span class="kamba-card-title"><?php esc_html_e( 'Media library', 'kamba-core' ); ?></span><span class="kamba-card-description"><?php esc_html_e( 'Keep images and files organised.', 'kamba-core' ); ?></span><span class="kamba-card-link"><?php esc_html_e( 'Open media', 'kamba-core' ); ?> &rarr;</span></a>
			<a class="kamba-card" href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>"><span class="kamba-card-icon dashicons dashicons-admin-appearance"></span><span class="kamba-card-title"><?php esc_html_e( 'Appearance', 'kamba-core' ); ?></span><span class="kamba-card-description"><?php esc_html_e( 'Choose and customise your site theme.', 'kamba-core' ); ?></span><span class="kamba-card-link"><?php esc_html_e( 'Customise site', 'kamba-core' ); ?> &rarr;</span></a>
		</div>
		<footer class="kamba-footer"><span><?php echo esc_html( sprintf( __( '%1$s Core %2$s', 'kamba-core' ), $identity['platform_name'], KAMBA_CORE_VERSION ) ); ?></span><span><?php echo esc_html( sprintf( __( 'Current website: %s', 'kamba-core' ), $site_name ) ); ?></span></footer>
	</div>
	<?php
}

function kamba_render_settings() {
	if ( ! current_user_can( 'manage_options' ) ) { wp_die( esc_html__( 'You do not have permission to access this page.', 'kamba-core' ) ); }
	$identity = kamba_get_identity();
	?>
	<div class="wrap kamba-wrap">
		<header class="kamba-header"><div class="kamba-brand"><img src="<?php echo esc_url( kamba_get_brand_mark( $identity ) ); ?>" alt="" width="48" height="48"><div><p class="kamba-eyebrow"><?php esc_html_e( 'KAMBA PLATFORM', 'kamba-core' ); ?></p><h1><?php esc_html_e( 'Platform identity', 'kamba-core' ); ?></h1><p class="kamba-subtitle"><?php esc_html_e( 'Customise the name, logo and colours of your administration experience.', 'kamba-core' ); ?></p></div></div></header>
		<section class="kamba-settings-panel">
			<h2><?php esc_html_e( 'Brand settings', 'kamba-core' ); ?></h2>
			<p><?php esc_html_e( 'These settings affect the Kamba administration screens only. Your public website theme and WordPress core files are not changed.', 'kamba-core' ); ?></p>
			<form method="post" action="options.php" class="kamba-identity-form">
				<?php settings_fields( 'kamba_identity_group' ); ?>
				<p><label for="kamba-platform-name"><strong><?php esc_html_e( 'Platform name', 'kamba-core' ); ?></strong></label><input class="regular-text" id="kamba-platform-name" name="kamba_identity[platform_name]" type="text" value="<?php echo esc_attr( $identity['platform_name'] ); ?>" maxlength="60"><span class="description"><?php esc_html_e( 'Shown in the Kamba menu and dashboard.', 'kamba-core' ); ?></span></p>
				<p><label for="kamba-logo-url"><strong><?php esc_html_e( 'Logo URL', 'kamba-core' ); ?></strong></label><input class="large-text" id="kamba-logo-url" name="kamba_identity[logo_url]" type="url" value="<?php echo esc_attr( $identity['logo_url'] ); ?>" placeholder="https://example.com/logo.png"><span class="description"><?php esc_html_e( 'Optional. Leave empty to use the built-in Kamba mark. Use an image hosted on your own site when possible.', 'kamba-core' ); ?></span></p>
				<p><label for="kamba-primary-color"><strong><?php esc_html_e( 'Primary colour', 'kamba-core' ); ?></strong></label><input id="kamba-primary-color" name="kamba_identity[primary_color]" type="color" value="<?php echo esc_attr( $identity['primary_color'] ); ?>"></p>
				<p><label for="kamba-dark-color"><strong><?php esc_html_e( 'Dark colour', 'kamba-core' ); ?></strong></label><input id="kamba-dark-color" name="kamba_identity[dark_color]" type="color" value="<?php echo esc_attr( $identity['dark_color'] ); ?>"></p>
				<?php submit_button( __( 'Save identity', 'kamba-core' ) ); ?>
			</form>
		</section>
		<section class="kamba-settings-panel kamba-preview-panel"><h2><?php esc_html_e( 'Current identity preview', 'kamba-core' ); ?></h2><div class="kamba-identity-preview"><span class="kamba-preview-mark" style="background:<?php echo esc_attr( $identity['primary_color'] ); ?>"><?php if ( $identity['logo_url'] ) : ?><img src="<?php echo esc_url( $identity['logo_url'] ); ?>" alt=""><?php else : ?>K<?php endif; ?></span><span><strong><?php echo esc_html( $identity['platform_name'] ); ?></strong><small><?php esc_html_e( 'Kamba administration', 'kamba-core' ); ?></small></span></div></section>
	</div>
	<?php
}
