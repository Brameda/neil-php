<?php

ini_set('display_errors', 'On');

require('client.php');
require('../helpers.php');

if (isset($_POST['username']) && isset($_POST['password'])){
	
	if ($client->login($_POST['username'], $_POST['password'])) {
		echo 'login oke';
	} else {
		echo 'niet oke';
	}
}
?>


<h1>Login</h1>

<?php if(!$client->is_login()): ?>
<form name="login" method="post">
	<input name="username" />
	<input name="password" type="password">
	
	<button type="submit">Login</button>
</form>
<?php else: ?>
	
	<a href="logout.php">logout</a>
	
<?php endif; ?>