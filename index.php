<?php
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

error_reporting(E_ALL & ~E_DEPRECATED);

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/config'));
$loader->load('services.yaml');

$container->compile(true);

$app = $container->get(App\Lib\Application::class);
$app->start();

