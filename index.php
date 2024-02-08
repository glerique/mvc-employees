<?php
require_once 'vendor/autoload.php';
require_once 'config/config.php';

use App\Lib\Application;
/** Pour afficher les erreur en Dev */
ini_set('display_errors', 1);

Application::start();


