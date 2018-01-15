<html>

	<body>

		<?php if (isset($errMsg)): ?>

			<?php echo htmlspecialchars($errMsg); ?>

		<?php elseif(isset($resultText)): ?>

			<?php echo htmlspecialchars($resultText); ?>

		<?php else: ?>

			<form method="post" action="/register/submit" >
				Name: <input type="text" name="name" /> <br/>
				Username: <input type="text" name="username" /> <br/>
				Password: <input type="password" name="password" /> <br/>
				E-mail: <input type="text" name="email" /> <br/>
				<input type="submit" name="submit" />
			</form>

		<?php endif; ?>

	</body>

</html>