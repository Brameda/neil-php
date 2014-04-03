<?php

ini_set('display_errors', 'On');

require('client.php');
require('../helpers.php');

$navigation = $client->navigation();
?>

<ul>
<?php foreach($navigation as $item): ?>
	<li><?= $item['title']; ?> - url (<?= $item['path']; ?>)</li>
<?php endforeach; ?>
</ul>