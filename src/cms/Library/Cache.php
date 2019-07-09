<?php
namespace Framework\Library;


use Framework\Container\Singleton;

/**
 * Class Cache
 *
 * @package Framework\Library
 */
class Cache
{
     use Singleton;


    /**
     * Set cache
     *
     * @param $key
     * @param $data
     * @param int $seconds
     * @return void
     */
     public function set($key, $data, $seconds = 3600)
     {
          // if $seconds !== 0
          if($seconds)
          {
              $content['data'] = $data;
              $content['end_time'] = time() + $seconds;

              if(file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content)))
              {
                    return true;
              }
          }

          return false;
     }


    /**
     * Get cache
     *
     * @param string $key
     * @return  bool|string
     */
     public function get($key)
     {
        $file = CACHE . '/' . md5($key) . '.txt';
        if(file_exists($file))
        {
            $content = unserialize(file_get_contents($file));

            if(time() <= $content['end_time'])
            {
                return $content['data'];
            }
            unlink($file);
        }
        return false;
     }


    /**
     * Delete file
     *
     * @param $key
     * @return void
     */
     public function delete($key)
     {
         $file = CACHE . '/' . md5($key) . '.txt';
         if(file_exists($file))
         {
             unlink($file);
         }
         // return false;
     }
}