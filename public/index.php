<?php

/**
 * Entry Point of Application
 */

require_once dirname(__DIR__).'/config/bootstrap.php';


// Instance of Application
$app = new \Framework\App();


debug(\Framework\App::$app->properties());
