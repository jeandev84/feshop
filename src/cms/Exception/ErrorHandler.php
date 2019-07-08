<?php
namespace Framework\Exception;


use Exception;


/**
 * Class ErrorHandler
 *
 * @package Framework\Exception
 */
class ErrorHandler
{

    /**
     * ErrorHandler constructor.
     *
     * @return void
     */
     public function __construct()
     {
         // set error reporting relative mode
         $status = DEBUG ? -1 : 0;
         error_reporting($status);

         // set own exception handler callback
         set_exception_handler([$this, 'exceptionHandler']);
     }


    /**
     * Get Error Exception
     *
     * @param Exception $e
     * @return bool
     */
     public function exceptionHandler(Exception $e)
     {
         $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());
         $this->displayErrors('Исключение (Exception):', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
     }


    /**
     * Log Errors
     *
     *
     * @param string $message
     * @param string $file
     * @param string $line
     */
     public function logErrors($message='', $file = '', $line = '')
     {
         error_log(
             "[". date('Y-m-d H:i:s') . "] Текст ошибки: {$message} | Файл: {$file} | Строка: {$file}\n=============\n",
             3,
             ROOT .'/tmp/errors.log'
             );
     }


    /**
     * Display Errors
     *
     *
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param int $response
     * @return void
     */
     public function displayErrors($errno, $errstr, $errfile, $errline, $response = 404)
     {
         // send headers
         http_response_code($response);

         if($response == 404 && !DEBUG)
         {
               require(WWW .'/errors/404.php');
               die;
         }

         /* $file = DEBUG ? 'dev.php' : 'prod.php';
         require WWW .'/errors/'. $file; */

         if(DEBUG)
         {
             // if DEBUG = true
             require(WWW .'/errors/dev.php');
         }else{
             // for exemple if $response !== 404 (ex: 500) && DEBUG = false
             require(WWW .'/errors/prod.php');
         }
         die;
     }
}