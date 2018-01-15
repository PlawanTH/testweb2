<html>

	<body>

	<?php if( isset($errMsg) ): ?>

		<?php echo htmlspecialchars($errMsg) ?>

	<?php elseif( isset($resetLink) ): ?>
		
		This is your reset link: <a href='../<?php echo htmlspecialchars($resetLink) ?>'>/<?php echo htmlspecialchars($resetLink) ?></a>

	<?php else: ?>

			<form method="post"  action="/forgot/submit">
				Email: <input type="text" name="email" /> <br/>
				<input type="submit" name="submit" />
			</form>

	<?php endif; ?>

	</body>

</html>