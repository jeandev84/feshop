<?php
namespace Framework;


use Framework\Container\Registry;
use Framework\Exception\ErrorHandler;
use Framework\Routing\Router;


/**
 * Class App
 *
 * @package Framework
 */
class App
{

    /**
     * @var Registry $app
     */
    public static $app;


    /**
     * App constructor.
     *
     * @return void
     * @throws \Exception
     */
    public function __construct()
    {
         // Request get URL
         $query = trim($_SERVER['QUERY_STRING'], '/');

         // Start Session
         session_start();

         // Instancied Registry
         self::$app = Registry::instance();


         // Set params
         $this->setParams();


         // Instancied Error Handler
         new ErrorHandler();


         // Dispatch routes
         Router::dispatch($query);
    }


    /**
     *  set Params
     *
     * @retrun void
     */
     protected function setParams()
     {
        $params = require_once CONFIG . '/app.php';

        if(!empty($params))
        {
            foreach($params as $k => $v)
            {
                self::$app->set($k, $v);
            }
        }
     }
}