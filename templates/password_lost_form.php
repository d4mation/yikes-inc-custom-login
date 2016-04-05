<div id="password-lost-form" class="widecolumn">

	<?php
		/** Custom Action Hook - Before Password Lost Form */
		do_action( 'yikes-inc-custom-login-before-password-lost-form' );
	?>

	<?php if ( $attributes['show_title'] ) : ?>
		<h3><?php _e( 'Forgot Your Password?', 'yikes-inc-custom-login' ); ?></h3>
	<?php endif; ?>

	<?php if ( count( $attributes['errors'] ) > 0 ) : ?>
		<?php foreach ( $attributes['errors'] as $error ) : ?>
			<p>
				<?php echo $error; ?>
			</p>
		<?php endforeach; ?>
	<?php endif; ?>

	<p>
		<?php
			_e(
				"Enter your email address and we'll send you a link you can use to pick a new password.",
				'yikes-inc-custom-login'
			);
		?>
	</p>

	<form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
		<p class="form-row">
			<label for="user_login"><?php _e( 'Email', 'yikes-inc-custom-login' ); ?>
			<input type="text" name="user_login" id="user_login">
		</p>

		<p class="lostpassword-submit">
			<input type="submit" name="submit" class="lostpassword-button"
			       value="<?php _e( 'Reset Password', 'yikes-inc-custom-login' ); ?>"/>
		</p>
	</form>

	<?php
		/** Custom Action Hook - After Password Lost Form */
		do_action( 'yikes-inc-custom-login-after-password-lost-form' );
	?>

</div>
