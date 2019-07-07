<?php
namespace Framework\Container;


/**
 * Trait Singleton
 *
 * @package Framework\Container
 */
trait Singleton
{
     /**
      * @var self $instance
     */
     private static $instance;

    /**
     * @return Singleton
     */
    public static function instance()
   {
       if(self::$instance === null)
       {
           self::$instance = new self();
       }
       return self::$instance;
   }
}