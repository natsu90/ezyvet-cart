<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\ShoppingCart;
use Slim\Views\PhpRenderer;
use SleekDB\SleekDB;

require __DIR__ . '/../vendor/autoload.php';

$dataDir = __DIR__ . '/../storage';
$db = SleekDB::store('db', $dataDir);

$renderer = new PhpRenderer(__DIR__ . '/../views');

$cart = new ShoppingCart;

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) use ($app, $renderer, $cart) {

	$products = $cart->getAvailableProducts();

    return $renderer->render($response, 'home.php', compact('cart', 'products'));
});

$app->get('/add-product-to-cart/{product_name}', function(Request $request, Response $response, $args) use ($cart) {

	$product_name = $args['product_name'];

	$cart->addProductToCart($product_name);

	return $response->withHeader('Location', '/');
});

$app->get('/remove-product-from-cart/{product_name}', function(Request $request, Response $response, $args) use ($cart) {

	$product_name = $args['product_name'];

	$cart->removeProductFromCart($product_name);

	return $response->withHeader('Location', '/');
});

$app->get('/clear-cart', function(Request $request, Response $response, $args) use ($cart) {

	$cart->clearCart();

	return $response->withHeader('Location', '/');
});

$app->run();

