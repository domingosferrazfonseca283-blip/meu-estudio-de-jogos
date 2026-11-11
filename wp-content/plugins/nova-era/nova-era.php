<?php
/**
 * Plugin Name: Nova Era — Centro de Controlo
 * Plugin URI: https://github.com/domingosferrazfonseca283-blip/meu-estudio-de-jogos
 * Description: Um painel administrativo moderno para gerir conteúdos, acompanhar o site e aceder rapidamente às ferramentas do WordPress.
 * Version: 1.0.0
 * Requires at least: 6.5
 * Requires PHP: 7.4
 * Author: Nova Era Studio
 * License: GPL-2.0-or-later
 * Text Domain: nova-era
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NOVA_ERA_VERSION', '1.0.0' );

/**
 * Regista o centro de controlo no menu administrativo.
 */
function nova_era_register_admin_menu() {
	add_menu_page(
		__( 'Centro de Controlo', 'nova-era' ),
		__( 'Nova Era', 'nova-era' ),
		'manage_options',
		'nova-era',
		'nova_era_render_dashboard',
		'dashicons-admin-site-alt3',
		3
	);

	add_submenu_page(
		'nova-era',
		__( 'Visão geral', 'nova-era' ),
		__( 'Visão geral', 'nova-era' ),
		'manage_options',
		'nova-era',
		'nova_era_render_dashboard'
	);

	add_submenu_page(
		'nova-era',
		__( 'Personalização', 'nova-era' ),
		__( 'Personalização', 'nova-era' ),
		'manage_options',
		'nova-era-settings',
		'nova_era_render_settings'
	);
}
add_action( 'admin_menu', 'nova_era_register_admin_menu' );

/**
 * Carrega os estilos apenas nas páginas do plugin.
 *
 * @param string $hook_suffix Identificador da página administrativa.
 */
function nova_era_enqueue_admin_assets( $hook_suffix ) {
	if ( false === strpos( $hook_suffix, 'nova-era' ) ) {
		return;
	}

	$accent = get_option( 'nova_era_accent_color', '#6558f5' );
	$accent = sanitize_hex_color( $accent );

	if ( ! $accent ) {
		$accent = '#6558f5';
	}

	wp_register_style( 'nova-era-admin', false, array(), NOVA_ERA_VERSION );
	wp_enqueue_style( 'nova-era-admin' );

	$css = '
		.nova-era-wrap{max-width:1440px;margin:24px 20px 40px 0;color:#172033}
		.nova-era-hero{position:relative;overflow:hidden;padding:34px 38px;border-radius:20px;background:linear-gradient(120deg,#151b35 0%,#28265b 58%,' . $accent . ' 140%);color:#fff;box-shadow:0 16px 40px rgba(20,25,55,.16)}
		.nova-era-hero:after{content:"";position:absolute;width:280px;height:280px;border:1px solid rgba(255,255,255,.13);border-radius:50%;right:8%;top:-170px;box-shadow:0 0 0 35px rgba(255,255,255,.035),0 0 0 70px rgba(255,255,255,.025)}
		.nova-era-eyebrow{margin:0 0 10px;color:#d8d6ff;text-transform:uppercase;letter-spacing:.14em;font-size:11px;font-weight:700}
		.nova-era-hero h1{position:relative;z-index:1;color:#fff;font-size:clamp(27px,4vw,38px);line-height:1.15;margin:0 0 10px}
		.nova-era-hero p{position:relative;z-index:1;color:#e5e7ff;font-size:14px;margin:0;max-width:620px}
		.nova-era-layout{display:grid;grid-template-columns:minmax(0,1.65fr) minmax(260px,1fr);gap:20px;margin-top:22px}
		.nova-era-stats{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px;margin-top:20px}
		.nova-era-card{background:#fff;border:1px solid #e7e9f1;border-radius:16px;padding:20px;box-shadow:0 4px 16px rgba(24,32,56,.035)}
		.nova-era-stat-label{color:#70798c;font-size:12px;font-weight:600;margin:0 0 10px}
		.nova-era-stat-value{font-size:30px;line-height:1.1;font-weight:750;color:#172033;margin:0}
		.nova-era-stat-note{color:#8991a2;font-size:11px;margin:8px 0 0}
		.nova-era-section-title{font-size:16px;font-weight:700;margin:0 0 15px;color:#172033}
		.nova-era-actions{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:11px}
		.nova-era-action{display:flex;align-items:center;gap:12px;padding:14px;border:1px solid #e9ebf2;border-radius:12px;text-decoration:none;color:#172033;background:#fff;transition:transform .18s ease,border-color .18s ease,box-shadow .18s ease}
		.nova-era-action:hover,.nova-era-action:focus{border-color:' . $accent . ';color:' . $accent . ';transform:translateY(-2px);box-shadow:0 8px 20px rgba(25,30,60,.07)}
		.nova-era-action .dashicons{font-size:19px;width:20px;height:20px;color:' . $accent . '}
		.nova-era-action strong{display:block;font-size:12px}
		.nova-era-action small{display:block;color:#858da0;font-size:11px;margin-top:3px}
		.nova-era-list{margin:0}
		.nova-era-list li{display:flex;justify-content:space-between;gap:14px;padding:11px 0;border-bottom:1px solid #eef0f5;margin:0;font-size:12px}
		.nova-era-list li:last-child{border-bottom:0;padding-bottom:0}
		.nova-era-list a{color:#27314a;text-decoration:none;font-weight:600}
		.nova-era-list a:hover{color:' . $accent . '}
		.nova-era-muted{color:#858da0}
		.nova-era-pill{display:inline-block;padding:4px 8px;border-radius:30px;background:#f0efff;color:' . $accent . ';font-size:10px;font-weight:700}
		.nova-era-status{display:flex;align-items:center;gap:9px;font-size:12px;margin:12px 0}
		.nova-era-dot{width:8px;height:8px;background:#22a06b;border-radius:50%;display:inline-block;box-shadow:0 0 0 4px #e8f7f0}
		.nova-era-footer{margin-top:18px;color:#8a91a1;font-size:11px}
		.nova-era-form{max-width:700px}
		.nova-era-form label{display:block;font-weight:600;margin:18px 0 7px}
		.nova-era-form input[type=text]{width:100%;max-width:520px}
		.nova-era-form input[type=color]{width:64px;height:40px;padding:3px;border:1px solid #d9dce6;border-radius:8px}
		@media(max-width:1100px){.nova-era-stats{grid-template-columns:repeat(2,minmax(0,1fr))}.nova-era-layout{grid-template-columns:1fr}}
		@media(max-width:600px){.nova-era-wrap{margin-right:10px}.nova-era-hero{padding:25px 22px}.nova-era-stats{gap:9px}.nova-era-card{padding:15px}.nova-era-actions{grid-template-columns:1fr}.nova-era-stat-value{font-size:25px}}
		@media(prefers-reduced-motion:reduce){.nova-era-action{transition:none}}
	';

	wp_add_inline_style( 'nova-era-admin', $css );
}
add_action( 'admin_enqueue_scripts', 'nova_era_enqueue_admin_assets' );

/**
 * Devolve a contagem de um tipo de conteúdo.
 *
 * @param string $post_type Tipo de conteúdo.
 * @param string $status Estado editorial.
 * @return int
 */
function nova_era_count_posts( $post_type, $status ) {
	$counts = wp_count_posts( $post_type );

	if ( ! is_object( $counts ) || ! isset( $counts->{$status} ) ) {
		return 0;
	}

	return (int) $counts->{$status};
}

/**
 * Renderiza o painel principal.
 */
function nova_era_render_dashboard() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Não tens permissões para aceder a esta página.', 'nova-era' ) );
	}

	$posts_published = nova_era_count_posts( 'post', 'publish' );
	$posts_draft     = nova_era_count_posts( 'post', 'draft' );
	$pages_published = nova_era_count_posts( 'page', 'publish' );
	$users           = count_users();
	$recent_posts    = get_posts(
		array(
			'post_type'           => array( 'post', 'page' ),
			'post_status'         => array( 'publish', 'draft', 'pending' ),
			'numberposts'         => 5,
			'orderby'             => 'modified',
			'order'               => 'DESC',
			'ignore_sticky_posts' => true,
		)
	);

	$welcome = get_option( 'nova_era_welcome_message', __( 'O teu espaço de criação está pronto. Gere o site com clareza e controlo.', 'nova-era' ) );
	?>
	<div class="wrap nova-era-wrap">
		<section class="nova-era-hero">
			<p class="nova-era-eyebrow"><?php esc_html_e( 'Nova Era · Centro de Controlo', 'nova-era' ); ?></p>
			<h1><?php esc_html_e( 'O teu WordPress. Uma nova experiência.', 'nova-era' ); ?></h1>
			<p><?php echo esc_html( $welcome ); ?></p>
		</section>

		<section class="nova-era-stats" aria-label="<?php esc_attr_e( 'Estatísticas do site', 'nova-era' ); ?>">
			<div class="nova-era-card">
				<p class="nova-era-stat-label"><?php esc_html_e( 'Artigos publicados', 'nova-era' ); ?></p>
				<p class="nova-era-stat-value"><?php echo esc_html( number_format_i18n( $posts_published ) ); ?></p>
				<p class="nova-era-stat-note"><?php esc_html_e( 'Conteúdo disponível no site', 'nova-era' ); ?></p>
			</div>
			<div class="nova-era-card">
				<p class="nova-era-stat-label"><?php esc_html_e( 'Páginas publicadas', 'nova-era' ); ?></p>
				<p class="nova-era-stat-value"><?php echo esc_html( number_format_i18n( $pages_published ) ); ?></p>
				<p class="nova-era-stat-note"><?php esc_html_e( 'Páginas institucionais e de conteúdo', 'nova-era' ); ?></p>
			</div>
			<div class="nova-era-card">
				<p class="nova-era-stat-label"><?php esc_html_e( 'Rascunhos', 'nova-era' ); ?></p>
				<p class="nova-era-stat-value"><?php echo esc_html( number_format_i18n( $posts_draft ) ); ?></p>
				<p class="nova-era-stat-note"><?php esc_html_e( 'Artigos por terminar', 'nova-era' ); ?></p>
			</div>
			<div class="nova-era-card">
				<p class="nova-era-stat-label"><?php esc_html_e( 'Utilizadores', 'nova-era' ); ?></p>
				<p class="nova-era-stat-value"><?php echo esc_html( number_format_i18n( (int) $users['total_users'] ) ); ?></p>
				<p class="nova-era-stat-note"><?php esc_html_e( 'Contas registadas', 'nova-era' ); ?></p>
			</div>
		</section>

		<div class="nova-era-layout">
			<div class="nova-era-card">
				<h2 class="nova-era-section-title"><?php esc_html_e( 'Acesso rápido', 'nova-era' ); ?></h2>
				<div class="nova-era-actions">
					<a class="nova-era-action" href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>">
						<span class="dashicons dashicons-edit"></span><span><strong><?php esc_html_e( 'Novo artigo', 'nova-era' ); ?></strong><small><?php esc_html_e( 'Publica uma nova ideia', 'nova-era' ); ?></small></span>
					</a>
					<a class="nova-era-action" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=page' ) ); ?>">
						<span class="dashicons dashicons-admin-page"></span><span><strong><?php esc_html_e( 'Nova página', 'nova-era' ); ?></strong><small><?php esc_html_e( 'Cria uma página para o site', 'nova-era' ); ?></small></span>
					</a>
					<a class="nova-era-action" href="<?php echo esc_url( admin_url( 'site-editor.php' ) ); ?>">
						<span class="dashicons dashicons-layout"></span><span><strong><?php esc_html_e( 'Editor do site', 'nova-era' ); ?></strong><small><?php esc_html_e( 'Personaliza blocos e modelos', 'nova-era' ); ?></small></span>
					</a>
					<a class="nova-era-action" href="<?php echo esc_url( admin_url( 'upload.php' ) ); ?>">
						<span class="dashicons dashicons-format-image"></span><span><strong><?php esc_html_e( 'Biblioteca multimédia', 'nova-era' ); ?></strong><small><?php esc_html_e( 'Organiza imagens e ficheiros', 'nova-era' ); ?></small></span>
					</a>
					<a class="nova-era-action" href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>">
						<span class="dashicons dashicons-art"></span><span><strong><?php esc_html_e( 'Temas', 'nova-era' ); ?></strong><small><?php esc_html_e( 'Gere o visual do WordPress', 'nova-era' ); ?></small></span>
					</a>
					<a class="nova-era-action" href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>">
						<span class="dashicons dashicons-admin-plugins"></span><span><strong><?php esc_html_e( 'Extensões', 'nova-era' ); ?></strong><small><?php esc_html_e( 'Gere as funcionalidades', 'nova-era' ); ?></small></span>
					</a>
				</div>
			</div>

			<div class="nova-era-card">
				<h2 class="nova-era-section-title"><?php esc_html_e( 'Atividade recente', 'nova-era' ); ?></h2>
				<?php if ( $recent_posts ) : ?>
					<ul class="nova-era-list">
						<?php foreach ( $recent_posts as $recent_post ) : ?>
							<li>
								<a href="<?php echo esc_url( get_edit_post_link( $recent_post->ID ) ); ?>"><?php echo esc_html( wp_trim_words( get_the_title( $recent_post ), 7 ) ); ?></a>
								<span class="nova-era-muted"><?php echo esc_html( get_post_status_object( $recent_post->post_status )->label ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php else : ?>
					<p class="nova-era-muted"><?php esc_html_e( 'Ainda não há conteúdo para apresentar.', 'nova-era' ); ?></p>
				<?php endif; ?>
				<h2 class="nova-era-section-title" style="margin-top:24px"><?php esc_html_e( 'Estado do sistema', 'nova-era' ); ?></h2>
				<p class="nova-era-status"><span class="nova-era-dot"></span><?php esc_html_e( 'Painel Nova Era ativo', 'nova-era' ); ?></p>
				<p class="nova-era-status"><span class="nova-era-pill"><?php echo esc_html( 'WordPress ' . get_bloginfo( 'version' ) ); ?></span><span class="nova-era-muted"><?php esc_html_e( 'Versão instalada', 'nova-era' ); ?></span></p>
				<p class="nova-era-status"><span class="nova-era-pill"><?php echo esc_html( PHP_VERSION ); ?></span><span class="nova-era-muted"><?php esc_html_e( 'Versão PHP', 'nova-era' ); ?></span></p>
			</div>
		</div>
		<p class="nova-era-footer"><?php esc_html_e( 'Nova Era Centro de Controlo · Construído para ampliar o WordPress sem alterar os seus ficheiros centrais.', 'nova-era' ); ?></p>
	</div>
	<?php
}

/**
 * Processa a gravação das preferências.
 */
function nova_era_save_settings() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Ação não autorizada.', 'nova-era' ) );
	}

	check_admin_referer( 'nova_era_save_settings' );

	$welcome = isset( $_POST['nova_era_welcome_message'] )
		? sanitize_text_field( wp_unslash( $_POST['nova_era_welcome_message'] ) )
		: '';
	$accent  = isset( $_POST['nova_era_accent_color'] )
		? sanitize_hex_color( wp_unslash( $_POST['nova_era_accent_color'] ) )
		: '#6558f5';

	update_option( 'nova_era_welcome_message', $welcome );
	update_option( 'nova_era_accent_color', $accent ? $accent : '#6558f5' );

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'    => 'nova-era-settings',
				'updated' => 'true',
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_nova_era_save_settings', 'nova_era_save_settings' );

/**
 * Renderiza as definições de personalização.
 */
function nova_era_render_settings() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Não tens permissões para aceder a esta página.', 'nova-era' ) );
	}

	$welcome = get_option( 'nova_era_welcome_message', __( 'O teu espaço de criação está pronto. Gere o site com clareza e controlo.', 'nova-era' ) );
	$accent  = get_option( 'nova_era_accent_color', '#6558f5' );
	?>
	<div class="wrap nova-era-wrap">
		<section class="nova-era-hero">
			<p class="nova-era-eyebrow"><?php esc_html_e( 'Nova Era · Preferências', 'nova-era' ); ?></p>
			<h1><?php esc_html_e( 'Personaliza o teu centro de controlo.', 'nova-era' ); ?></h1>
			<p><?php esc_html_e( 'Define a mensagem de boas-vindas e a cor principal do painel.', 'nova-era' ); ?></p>
		</section>
		<div class="nova-era-card nova-era-form" style="margin-top:22px">
			<?php if ( isset( $_GET['updated'] ) && 'true' === sanitize_text_field( wp_unslash( $_GET['updated'] ) ) ) : ?>
				<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Preferências guardadas com sucesso.', 'nova-era' ); ?></p></div>
			<?php endif; ?>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="nova_era_save_settings">
				<?php wp_nonce_field( 'nova_era_save_settings' ); ?>
				<label for="nova-era-welcome"><?php esc_html_e( 'Mensagem de boas-vindas', 'nova-era' ); ?></label>
				<input id="nova-era-welcome" type="text" name="nova_era_welcome_message" value="<?php echo esc_attr( $welcome ); ?>" maxlength="180">
				<label for="nova-era-accent"><?php esc_html_e( 'Cor principal', 'nova-era' ); ?></label>
				<input id="nova-era-accent" type="color" name="nova_era_accent_color" value="<?php echo esc_attr( $accent ); ?>">
				<p class="description"><?php esc_html_e( 'Estas opções alteram apenas o painel Nova Era, não o conteúdo público do teu site.', 'nova-era' ); ?></p>
				<p><button type="submit" class="button button-primary"><?php esc_html_e( 'Guardar preferências', 'nova-era' ); ?></button></p>
			</form>
		</div>
	</div>
	<?php
}
