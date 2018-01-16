<html>

	<body>

		<?php if (isset($errMsg)): ?>

			<?php echo htmlspecialchars($errMsg); ?>

		<?php elseif(isset($resultText)): ?>

			<?php echo htmlspecialchars($resultText); ?>

		<?php else: ?>

			<form method="post" action="/register/submit" onsubmit="return checkForm(this)">
				Name: <input type="text" name="name" /> <br/>
				Username: <input type="text" name="username" /> <br/>
				Password: <input type="password" name="password" /> <br/>
				E-mail: <input type="text" name="email" /> <br/>
				<input type="submit" name="submit" />
			</form>

			<script>
				function checkForm(form) {
					form.submit.disabled = true;
					return true;
				}
			</script>

		<?php endif; ?>

	</body>

</html>