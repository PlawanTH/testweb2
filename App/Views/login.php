<html>

	<body>

	<?php if (isset($errMsg)): ?>

		<?php echo htmlspecialchars($errMsg); ?>

	<?php elseif (isset($user)): ?>

		<?php echo "Welcome, " . htmlspecialchars( $user->getName() ); ?>

	<?php else: ?>

		<form method="post" action="/login/submit">
			Username/Email: <input type="text" name="userInput" /> <br/>
			Password: <input type="password" name="password" /> <br/>
			<input type="submit" name="submit" />
		</form>

	<?php endif; ?>

	</body>

</html>