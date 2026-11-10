<?php
/**
 * Plugin Name: Kamba Core
 * Plugin URI: https://github.com/domingosferrazfonseca283-blip/meu-estudio-de-jogos
 * Description: The foundation of Kamba CMS: a modern, branded administration experience built on WordPress.
 * Version: 0.1.0
 * Requires at least: 6.6
 * Requires PHP: 7.4
 * Author: Kamba Project
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: kamba-core
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
define( 'KAMBA_CORE_VERSION', '0.1.0' );
define( 'KAMBA_CORE_FILE', __FILE__ );
define( 'KAMBA_CORE_URL', plugin_dir_url( __FILE__ ) );

function kamba_register_admin_menu() {
	add_menu_page( __( 'Kamba Dashboard', 'kamba-core' ), __( 'Kamba', 'kamba-core' ), 'manage_options', 'kamba', 'kamba_render_dashboard', 'dashicons-admin-site-alt3', 3 );
	add_submenu_page( 'kamba', __( 'Kamba Settings', 'kamba-core' ), __( 'Settings', 'kamba-core' ), 'manage_options', 'kamba-settings', 'kamba_render_settings' );
}
add_action( 'admin_menu', 'kamba_register_admin_menu' );

function kamba_enqueue_admin_assets( $hook_suffix ) {
	if ( false === strpos( $hook_suffix, 'kamba' ) ) { return; }
	wp_enqueue_style( 'kamba-admin', KAMBA_CORE_URL . 'assets/admin.css', array(), KAMBA_CORE_VERSION );
}
add_action( 'admin_enqueue_scripts', 'kamba_enqueue_admin_assets' );

function kamba_render_dashboard() {
	if ( ! current_user_can( 'manage_options' ) ) { wp_die( esc_html__( 'You do not have permission to access this page.', 'kamba-core' ) ); }
	$site_name = get_bloginfo( 'name' );
	?>
	<div class="wrap kamba-wrap">
		<header class="kamba-header">
			<div class="kamba-brand">
				<img src="<?php echo esc_url( KAMBA_CORE_URL . 'assets/kamba-mark.svg' ); ?>" alt="" width="48" height="48">
				<div><p class="kamba-eyebrow"><?php esc_html_e( 'CONTENT MANAGEMENT PLATFORM', 'kamba-core' ); ?></p>
				<h1><?php esc_html_e( 'Welcome to Kamba', 'kamba-core' ); ?></h1>
				<p class="kamba-subtitle"><?php esc_html_e( 'A clearer, more capable home for your digital presence.', 'kamba-core' ); ?></p></div>
			</div>
			<a class="kamba-button kamba-button-primary" href="<?php echo esc_url( admin_url( 'options-general.php' ) ); ?>"><?php esc_html_e( 'WordPress configuration', 'kamba-core' ); ?></a>
		</header>
		<section class="kamba-welcome">
			<div><span class="kamba-pill"><?php esc_html_e( 'YOUR WORKSPACE', 'kamba-core' ); ?></span>
			<h2><?php echo esc_html( sprintf( __( 'Hello, %s', 'kamba-core' ), wp_get_current_user()->display_name ) ); ?></h2>
			<p><?php esc_html_e( 'Kamba is being built in clear, reliable steps. Your existing WordPress content and tools remain available while we add the Kamba experience.', 'kamba-core' ); ?></p></div>
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
		<footer class="kamba-footer"><span><?php echo esc_html( sprintf( __( 'Kamba Core %s', 'kamba-core' ), KAMBA_CORE_VERSION ) ); ?></span><span><?php echo esc_html( sprintf( __( 'Current website: %s', 'kamba-core' ), $site_name ) ); ?></span></footer>
	</div>
	<?php
}

function kamba_render_settings() {
	if ( ! current_user_can( 'manage_options' ) ) { wp_die( esc_html__( 'You do not have permission to access this page.', 'kamba-core' ) ); }
	?>
	<div class="wrap kamba-wrap">
		<header class="kamba-header"><div class="kamba-brand"><img src="<?php echo esc_url( KAMBA_CORE_URL . 'assets/kamba-mark.svg' ); ?>" alt="" width="48" height="48"><div><p class="kamba-eyebrow"><?php esc_html_e( 'KAMBA PLATFORM', 'kamba-core' ); ?></p><h1><?php esc_html_e( 'Kamba settings', 'kamba-core' ); ?></h1><p class="kamba-subtitle"><?php esc_html_e( 'The central place for future Kamba modules and preferences.', 'kamba-core' ); ?></p></div></div></header>
		<section class="kamba-settings-panel"><h2><?php esc_html_e( 'Platform foundation', 'kamba-core' ); ?></h2>
		<p><?php esc_html_e( 'This first release establishes the Kamba administration area. Branding controls, user roles, site tools and extensions will be added in later releases.', 'kamba-core' ); ?></p>
		<div class="kamba-status-row"><span class="kamba-status-dot"></span><strong><?php esc_html_e( 'Kamba Core is active', 'kamba-core' ); ?></strong><span class="kamba-version"><?php echo esc_html( KAMBA_CORE_VERSION ); ?></span></div></section>
	</div>
	<?php
}
