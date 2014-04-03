<?php

ini_set('display_errors', 'On');

require('client.php');
require('../helpers.php');

if (isset($_GET['slug'])){
	$slug = $_GET['slug'];
} else {
	$slug = Null;
}

try {
	$product = $client->product($slug=$slug);
} catch (Exception $e) {
	print_r('error 404');
	exit();
}

?>

<h1>Product : <?= $product['title']; ?></h1>

<p>
	Prijs : <?= $product['price']; ?> <br />
	Voorraad : <?= $product['stock']; ?> <br />
</p>
	
<?= $product['description']; ?>

<ul>
	<?php foreach($product['images'] as $image): ?>
		<li><img src="http://cdn.staging.brameda.com/assets/image/<?= $image['key']; ?>/pad/250x250/<?= $image['slug']; ?>.<?= $image['ext']; ?>"></li>
	<?php endforeach; ?>
</ul>

<table>
	<tr>
		<td>Eigenschap</td>
		<td>Waarde</td>
	</tr>
<?php foreach($product['properties'] as $propertie): ?>
	<tr>
		<td><?= $propertie['name']; ?></td>
		<td><?= $propertie['value']; ?></td>
	</tr>
<?php endforeach; ?>
</table>
