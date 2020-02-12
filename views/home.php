<html>
<head>
	<title>Shopping Cart</title>
	<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.1/build/pure-min.css" integrity="sha384-oAOxQR6DkCoMliIh8yFnu25d7Eq/PHS21PClpwjOTeU2jRSq11vu66rf90/cZr47" crossorigin="anonymous">
</head>


<body>

	<table class="pure-table pure-table-bordered">
		<thead>
			<tr><th>Product</th><th>Price</th><th></th></tr>
		</thead>
		<tbody>
			<?php foreach($products as $product) { ?>
				<tr>
					<td> <?php echo $product['name']; ?></td>
					<td> <?php echo $cart->formatPrice($product['price']); ?></td>

					<td> <a class="pure-button" href="/add-product-to-cart/<?php echo $product['name'];?>">Add Product</a></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	<table class="pure-table pure-table-bordered">
		<thead>
			<tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th></th></tr>
		</thead>
		<tbody>
		<?php $total_price = 0; ?>
		<?php foreach($products as $product) { ?>

			<?php 
				$quantity = $cart->getCountByProduct($product['name']);

				if ($quantity) { 
			?>
			<tr>
				<td> <?php echo $product['name']; ?></td>
				<td> <?php echo $cart->formatPrice($product['price']); ?></td>
				<td> <?php echo $quantity; ?></td>
				<td> 
					<?php 
						$total_product_price = $product['price'] * $quantity; 
						$total_price += $total_product_price;
						echo $cart->formatPrice($total_product_price);
					?>
						
				</td>
				<td> <a class="pure-button" href="/remove-product-from-cart/<?php echo $product['name'];?>">Remove Product</a></td>
			</tr>
			<?php } ?>

		<?php } ?>

			<tr><th colspan="2"></th><th></th><th><?php echo $cart->formatPrice($total_price); ?></th><th><a class="pure-button" href="/clear-cart">Clear Cart</a></th></tr>

		</tbody>

	</table>
	
</body>

</html>