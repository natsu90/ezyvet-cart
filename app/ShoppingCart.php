<?php

namespace App;

use SleekDB\SleekDB as DB;

class ShoppingCart {

	private $products = [
		[ "name" => "Sledgehammer", "price" => 125.75 ],
		[ "name" => "Axe", "price" => 190.50 ],
		[ "name" => "Bandsaw", "price" => 562.131 ],
		[ "name" => "Chisel", "price" => 12.9 ],
		[ "name" => "Hacksaw", "price" => 18.45 ],
	];

	private $db;

	public function __construct()
	{
		$dataDir = __DIR__ . '/../storage';

		$this->db = DB::store('db', $dataDir);
	}

	// assuming product name is unique
	public function getProductByName($product_name)
	{
		return array_values(array_filter($this->products, function($product) use ($product_name) {
			return strtolower($product['name']) == strtolower($product_name);
		}))[0];
	}

	public function getPriceByProduct($product_name)
	{
		$product = $this->getProductByName($product_name);

		if ($product)
			return $this->formatPrice($product['price']);

		return null;
	}

	public function formatPrice($decimal_number)
	{
		return number_format($decimal_number, 2, '.', '');
	}
	
	public function getAvailableProducts()
	{
		return $this->products;
	}

	public function addProductToCart($product_name)
	{
		$quantity = $this->getCountByProduct($product_name);

		$new_quantity = $quantity + 1;

		if ($this->db->where('product_name', '=', $product_name)->fetch())
			$this->db->where('product_name', '=', $product_name)->update(['quantity' => $new_quantity]);
		else
			$this->db->insert(['product_name' => $product_name, 'quantity' => $new_quantity]);
	}

	public function removeProductFromCart($product_name)
	{
		$quantity = $this->getCountByProduct($product_name);
		$new_quantity = 0;

		if ($quantity > 0)
			$new_quantity = $quantity - 1;

		if ($new_quantity > 0)
			$this->db->where('product_name', '=', $product_name)->update(['quantity' => $new_quantity]);
		else
			$this->db->where('product_name', '=', $product_name)->delete();
	}

	public function getCountByProduct($product_name)
	{
		$products = $this->db->where('product_name', '=', $product_name)->fetch();

		if ($products) return $products[0]['quantity'];

		return 0;
	}

	public function clearCart()
	{
		$this->db->delete();
	}

	public function getDatabase()
	{
		return $this->db;
	}

}

