<?php

function configurator_template_kits_blocks_fail_load_admin_notice() {


	$screen = get_current_screen();
	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	if ( 'true' === get_user_meta( get_current_user_id(), '_configurator_template_kits_install_notice', true ) ) {
		return;
	}

	$plugin = 'configurator-template-kits-blocks/configurator-template-kits-blocks.php';

	$installed_plugins = get_plugins();

	$is_elementor_installed = isset( $installed_plugins[ $plugin ] );
	

	if ( $is_elementor_installed ) {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$message = __( 'Configurator Template Kits Blocks Pro require Configurator Template Kits Blocks Plugin to work', 'configurator-elementor' );

		$button_text = __( 'Activate Configurator Template Kits Blocks', 'configurator-elementor' );
		$button_link = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$message = __( 'Configurator Template Kits Blocks Pro require Configurator Template Kits Blocks Plugin to work', 'configurator-elementor' );

		$button_text = __( 'Install Configurator Template Kits Blocks', 'configurator-elementor' );
		$button_link = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
	}




	?>
	<style>
		.notice.configurator-elementor-notice {
			border: 1px solid #ccd0d4;
			border-left: 4px solid #9b0a46 !important;
			box-shadow: 0 1px 4px rgba(0,0,0,0.15);
			display: flex;
			padding: 0px;
		}
		.rtl .notice.configurator-elementor-notice {
			border-right-color: #9b0a46 !important;
		}
		.notice.configurator-elementor-notice .configurator-elementor-notice-aside {
			width: 50px;
			display: flex;
			align-items: start;
			justify-content: center;
			padding-top: 15px;
			background: rgba(215,43,63,0.04);
		}
		.notice.configurator-elementor-notice .configurator-elementor-notice-aside img{
			width: 1.5rem;
		}
		.notice.configurator-elementor-notice .configurator-elementor-notice-inner {
			display: table;
			padding: 20px 0px;
			width: 100%;
		}
		.notice.configurator-elementor-notice .configurator-elementor-notice-content {
			padding: 0 20px;
		}
		.notice.configurator-elementor-notice p {
			padding: 0;
			margin: 0;
		}
		.notice.configurator-elementor-notice h3 {
			margin: 0 0 5px;
		}
		.notice.configurator-elementor-notice .configurator-elementor-install-now {
			display: block;
			margin-top: 15px;
		}
		.notice.configurator-elementor-notice .configurator-elementor-install-now .configurator-elementor-install-button {
			background: #127DB8;
			border-radius: 3px;
			color: #fff;
			text-decoration: none;
			height: auto;
			line-height: 20px;
			padding: 0.4375rem 0.75rem;
			text-transform: capitalize;
		}
		.notice.configurator-elementor-notice .configurator-elementor-install-now .configurator-elementor-install-button:active {
			transform: translateY(1px);
		}
		@media (max-width: 767px) {
			.notice.configurator-elementor-notice.configurator-elementor-install-elementor {
				padding: 0px;
			}
			.notice.configurator-elementor-notice .configurator-elementor-notice-inner {
				display: block;
				padding: 10px;
			}
			.notice.configurator-elementor-notice .configurator-elementor-notice-inner .configurator-elementor-notice-content {
				display: block;
				padding: 0;
			}
			.notice.configurator-elementor-notice .configurator-elementor-notice-inner .configurator-elementor-install-now {
				display: none;
			}
		}
	</style>
	<div class="notice notice-warning  configurator-elementor-notice configurator-elementor-install-elementor" <?php if ( is_plugin_active( 'configurator-template-kits-blocks/configurator-template-kits-blocks.php' ) ) { ?> style="display:none;" <?php }  ?>>
		<div class="configurator-elementor-notice-inner">
			<div class="configurator-elementor-notice-content">
				<p><?php echo esc_html( $message ); ?></p>
				<div class="configurator-elementor-install-now">
					<a class="configurator-elementor-install-button" href="<?php echo esc_attr( $button_link ); ?>"><?php echo esc_html( $button_text ); ?></a>
				</div>
			</div>
		</div>
	</div>
	<?php
}






/**
 * Set Admin Notice Viewed.
 *
 * @return void
 */
function ajax_configurator_template_kits_blocks_set_admin_notice_viewed() {
	update_user_meta( get_current_user_id(), '_configurator_template_kits_install_notice', 'true' );
	die;
}

add_action( 'wp_ajax_configurator_elementor_set_admin_notice_viewed', 'ajax_configurator_template_kits_blocks_set_admin_notice_viewed' );
if ( ! did_action( 'configurator-template-kits-blocks/loaded' ) ) {
	add_action( 'admin_notices', 'configurator_template_kits_blocks_fail_load_admin_notice' );
}

