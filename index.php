<?php
require_once 'vendor/autoload.php';
require_once 'config/config.php';

ini_set('display_errors', 1);

use App\Lib\Application;
use App\Lib\QueryBuilder;
use App\Lib\DatabaseConfig;
use App\Lib\DatabaseConnection;
use App\Factory\ControllerFactory;

// Configurer les dépendances
$config = new DatabaseConfig(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
$dbConnection = new DatabaseConnection($config);
$queryBuilder = new QueryBuilder($dbConnection);

// Créer les objets nécessaires
$controllerFactory = new ControllerFactory($queryBuilder);


// Initialiser l'application
$app = new Application($controllerFactory);

// Démarrer l'application
$app->start();