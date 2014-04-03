<?php

ini_set('display_errors', 'On');

require('client.php');
require('../helpers.php');

if (isset($_GET['path'])){
	$path = $_GET['path'];
} else {
	$path = '/';
}

$cat = $client->category($path=$path);

?>

<h1><?= $cat['title']; ?></h1>
<p><?= $cat['description']; ?></p>

<?php if( !empty($cat['categories'])): ?>	
<h2>Categories</h2>

<a href="search.php">Zoeken</a>

<ul>
<?php foreach($cat['categories'] as $categorie): ?>
	<li><a href="category.php?path=<?= $categorie['path']; ?>"><?= $categorie['title']; ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>


<?php foreach($cat['products']['filters'] as $filter): ?>
	
	<p>
		<?= $filter['title']; ?>
		<ul>
		<?php foreach($filter['options'] as $option): ?>
			<li><?= $option['label']; ?> (<?= $option['count']; ?>)</li>
			
			<li><?= facet_option_set_tag($filter, $option); ?></li>
		<?php endforeach;?>
		</ul>
	</p>
<?php endforeach; ?>

<?php if( !empty($cat['products']['results'])): ?>	
<h2>Products</h2>
<table>
	<tr>
		<td>Naam</td>
		<td>Foto</td>
		<td>Prijs</td>
		<td>Voorraad</td>
	</tr>

<?php foreach($cat['products']['results'] as $product): ?>
	<tr>
		<td><a href="product.php?slug=<?= $product['slug']; ?>"><?= $product['title']; ?></td>
		<td><img src="http://cdn.staging.brameda.com/assets/image/<?= $product['icon']['key']; ?>/pad/250x250/<?= $product['icon']['slug'].'.'. $product['icon']['ext']; ?>"></td>
		<td><?= $product['price']; ?> </td>
		<td><?= $product['stock']; ?> </td>
	</tr>
<?php endforeach; ?>
<?php endif; ?>
</table>