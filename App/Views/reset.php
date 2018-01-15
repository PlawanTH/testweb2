<html>

	<body>

		<?php if( isset($errMsg) ): ?>

			<?php echo htmlspecialchars($errMsg); ?>

		<?php elseif( isset($resultText) ): ?>

			<?php echo htmlspecialchars($resultText); ?>

		<?php else: ?>

			<form method="post"  action="/reset/submit">
				New Password: <input type="password" name="password" /> <br/>
				Repeated New Password: <input type="password" name="rpassword" /> <br/>
				<input type="hidden" name="email" value="<?php echo htmlspecialchars($email) ?>" />
				<input type="hidden" name="token" value="<?php echo htmlspecialchars($token) ?>" />
				<input type="submit" name="submit" />
			</form>

		<?php endif; ?>
		
	</body>

</html>