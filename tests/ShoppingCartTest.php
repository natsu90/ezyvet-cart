<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\ShoppingCart;

class ShoppingCartTest extends TestCase {

	private $shopping_cart;

	public function __construct()
	{
		parent::__construct();

		$this->shopping_cart = new ShoppingCart;
	}

	public function testGetProductByName()
	{
		$product = $this->shopping_cart->getProductByName('axe');

		$this->assertEquals($product['name'], 'Axe');
		$this->assertEquals($product['price'], 190.50);
	}

	public function testGetPriceByProduct()
	{
		$price = $this->shopping_cart->getPriceByProduct('axe');

		$this->assertEquals($price, 190.50);
	}
}