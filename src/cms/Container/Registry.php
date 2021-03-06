<?php
namespace Framework\Container;



class Registry
{
    use Singleton;

    /**
     * @var array $properties
     */
    private static $properties = [];


    /**
     * Set property
     *
     * @param $name
     * @param $value
     */
     public function set($name, $value)
     {
          self::$properties[$name] = $value;
     }


    /**
     * Get property
     *
     *
     * @param $name
     * @return mixed|null
     */
      public function get($name)
      {
         if(isset(self::$properties[$name]))
         {
             return self::$properties[$name];
         }
         return null;
      }


      /**
      * Add properties
      *
      * @param array $properties
     */
      public function add(array $properties = [])
      {
          self::$properties = array_merge(self::$properties, $properties);
      }


     /**
      * @return array
     */
      public function properties()
      {
          return self::$properties;
      }
}