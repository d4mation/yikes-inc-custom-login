<?php
/**
 * Override the default styles with customizer styles
 * @since 1.0
 */
class YIKES_Custom_Login_Customizer_Stlyes_Override {
	/**
	 * Get all of our styles, and return CSS we can enqueue
	 * @since 1.0
	 */
	public static function generate_customizer_styles() {
		// Get our theme modifications
		$login_container_background_hex = get_theme_mod( 'login_container_background', '#F0E7DE' ); //E.g. #FF0000
		$login_container_background_opacity = get_theme_mod( 'login_container_opacity', 1 );
		// Calculate the final RGBA value for the background
		$login_container_background_final = self::yikes_inc_convert_hex2rgba( $login_container_background_hex, $login_container_background_opacity );
		// Login Container border color/width/opacity/style
		$login_container_border_hex = get_theme_mod( 'login_container_border_color', false );
		$login_container_border_opacity = get_theme_mod( 'login_container_border_opacity', 0 );
		$login_container_border_color_final = self::yikes_inc_convert_hex2rgba( $login_container_border_hex, $login_container_border_opacity );
		$login_container_border_width = get_theme_mod( 'login_container_border_width', 0 );
		$login_container_border_style = get_theme_mod( 'login_container_border_style', solid );
		// Login container border radius
		$login_container_border_radius = get_theme_mod( 'login_container_border_radius', 12 );
		// Hide Password Link
		$login_container_hide_forgot_password_link = get_theme_mod( 'login_container_hide_forgot_password_link', false );
		// Hide Register Link
		$login_container_hide_register_link = get_theme_mod( 'login_container_hide_register_link', false );
		// Login Background
		$login_background = esc_url( get_theme_mod( 'login_background_image', false ) );
		$login_background_size = ( 'default' !== get_theme_mod( 'login_background_size', 'cover' ) ) ? get_theme_mod( 'login_background_size', 'cover' ) : '';
		$login_background_position = get_theme_mod( 'login_background_position', 'center center' );
		$login_background_repeat = get_theme_mod( 'login_background_repeat', 'no-repeat' );
		// Custom CSS
		$login_custom_css = get_theme_mod( 'yikes_login_custom_styles', false );
		// Full Width Sign In Button
		$login_container_full_width_sign_in_button = get_theme_mod( 'login_container_full_width_sign_in_button', false );
		// Login Container Link Color
		$login_container_link_color = get_theme_mod( 'login_container_link_color', '#0000EE' );
		// Login Container Link Hover color (same as standard color, with a 20% drop in opacity (autogenerated))
		$login_container_link_hover_color = get_theme_mod( 'login_container_link_hover_color', self::yikes_inc_convert_hex2rgba( $login_container_link_color, .7 ) );
		// Login Container Text Color (Field labels)
		$login_container_text_color = get_theme_mod( 'login_container_text_color', '#2d2d2d' );
		// Setup our custom CSS
		$custom_css = "
			.yikes-custom-page-template-interior .interior {
				background: {$login_container_background_final};
				color: {$login_container_text_color};
				border: {$login_container_border_width}px {$login_container_border_style} {$login_container_border_color_final};
				border-radius: {$login_container_border_radius}px;
				-ms-border-radius: {$login_container_border_radius}px;
				-moz-border-radius: {$login_container_border_radius}px;
				-webkit-border-radius: {$login_container_border_radius}px;
			}
			.yikes-custom-page-template-interior a,
			.yikes-custom-page-template-interior a:visited {
				color: {$login_container_link_color};
				-o-transition: .25s;
			  -ms-transition: .25s;
			  -moz-transition: .25s;
			  -webkit-transition: .25s;
			  transition: .25s;
			}
			.yikes-custom-page-template-interior a:hover {
				color: {$login_container_link_hover_color};
			}
		";
		// Conditionally append our hide links styles
		if ( $login_container_hide_forgot_password_link ) {
			$custom_css .= "
				a.forgot-password.pull-left {
					display: none !important;
				}
			";
		}
		// Conditionally append our hide links styles
		if ( $login_container_hide_register_link ) {
			$custom_css .= "
				a.register-account.pull-right {
					display: none !important;
				}
			";
		}
		// Background Image Styles
		if ( $login_background ) {
			$custom_css .= "
				body.yikes-custom-page-template .yikes-custom-page-template-interior {
					background: url( '{$login_background}' );
					background-position: {$login_background_position};
					background-repeat: {$login_background_repeat};
					background-size: {$login_background_size};
				}
			";
		}
		// Full Width Sign In Button
		if ( $login_container_full_width_sign_in_button ) {
			$custom_css .= "
				#yikes-custom-login-form input#wp-submit{
					width: 100%;
				}
			";
		}
		// Custom User Defined Scripts
		if ( $login_custom_css ) {
			$custom_css .= $login_custom_css;
		}
		return $custom_css;
	}
	/**
	 * Enqueue any custom scripts the user has entered
	 * @since 1.0
	 */
	public static function generate_customizer_scripts() {
		return html_entity_decode( get_theme_mod( 'yikes_login_custom_scripts', false ), ENT_QUOTES | ENT_HTML5 );
	}
	/**
	* Helper function to convert the HEX values into RGBA
	* using the opacity input fields
	* @since 1.0
	*/
	public static function yikes_inc_convert_hex2rgba( $color, $opacity = false ) {
		$default = 'rgb(0,0,0,0)';

		if ( empty( $color ) ) {
			 return $default;
		}

		if ( '#' === $color[0] ) {
			$color = substr( $color, 1 );
		}

		if ( strlen( $color ) === 6 ) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) === 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}

		$rgb = array_map( 'hexdec', $hex );

		if ( $opacity ) {
			if ( abs( $opacity ) > 1 ) {
				$opacity = 1.0;
			}
			$output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
		} else {
			$output = 'rgb(' . implode( ',', $rgb ) . ')';
		}
		return $output;
	}
}