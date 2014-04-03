<?php

ini_set('display_errors', 'On');

require('client.php');
require('../helpers.php');

$client->logout();

?>


<h1>Logouts</h1>
<?php if($client->is_login()): ?>
	<a href="logout.php">Foutje zijn nog steeds ingelogd</a>
<?php else: ?>
	<a href="login.php">login</a>
<?php endif; ?>