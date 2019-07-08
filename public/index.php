<?php

/**
 * Entry Point of Application
 */

require_once dirname(__DIR__).'/app/bootstrap.php';


// Instance of Application
$app = new \Framework\App();



/*
// Container properties
debug(\Framework\App::$app->properties());


// Testing error handler
DEBUG = true , throw new Exception('Страница не найдена', 500); prod
DEBUG = true,  throw new Exception('Страница не найдена', 404); dev
DEBUG = false,  throw new Exception('Страница не найдена', 404); 404 page


// Routes collections
debug(Router::routes());
*/
