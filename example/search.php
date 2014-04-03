<?php

ini_set('display_errors', 'On');

require('client.php');
require('../helpers.php');

if (isset($_GET['q'])){
	$query = $_GET['q'];
} else {
	$query = Null;
}

$search = $client->search($query=$query);
?>

<h1>Zoeken</h1>

<form action='search.php' method="get">
	<input name="q" value="<?= $query; ?>" />
	
	<button type="submit" value="Zoeken" />Zoeken</button>
</form>

<ul>
<?php foreach($search['products'] as $product): ?>	
	<li><a href="product.php?slug=<?= $product['slug']; ?>"> <?= $product['title']; ?></a></li>
<?php endforeach; ?>
</ul>