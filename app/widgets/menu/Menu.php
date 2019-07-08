<?php
namespace app\widgets\menu;



use Framework\Library\Cache;
use ishop\App;
use RedBeanPHP\R;

/**
 * Class Menu
 *
 * @package app\widgets\menu
 */
class Menu
{
    /**
     * @var array $data
     * @var array $tree
     * @var string $menuHtml
     * @var string $tpl
     * @var string $container
     * @var string $table
     * @var string $cache
     * @var int $cacheKey
     * @var string $cacheKey
     * @var array $attrs
     * @var string $prepend
     */
    protected $data;
    protected $tree;
    protected $menuHtml;
    protected $tpl;
    protected $container = 'ul';
    protected $table = 'category';
    protected $cache = 3600;
    protected $cacheKey = 'menu_cache';
    protected $attrs = [];
    protected $prepend = '';


    /**
     * Menu constructor.
     *
     * @param $options
     */
    public function __construct($options = [])
    {
        $this->tpl = __DIR__.'/menu_tpl/menu.php';
        $this->setOptions($options);
        $this->run();
    }


    /**
     * Set options
     *
     * @param $options
     * @return void
     */
    protected function setOptions($options)
    {
        // populate parses options
        foreach($options as $key => $value)
        {
            // if $key exist in current class
            if(property_exists($this, $key))
            {
                 // we'll set it
                 $this->{$key} = $value;
            }
        }
    }


    /**
     *
     */
    protected function run()
    {
        // get instance of cache
       $cache = Cache::instance();

       // try to get menu from cache
       $this->menuHtml = $cache->get($this->cacheKey);

       // if has not menu from cache
       if(!$this->menuHtml)
       {
           // we'll assign value to property 'data'
           $this->data = App::$app->get('categories');

           // if has not data
           if(!$this->data)
           {
               $this->data = R::getAssoc("SELECT * FROM {$this->table}");
           }

       }

       // get output
       $this->output();
    }


    /**
     * Echo HTML code
     */
    protected function output()
    {
        echo $this->menuHtml;
    }


    /**
     * Get Tree
     *
     * @return array
     */
    protected function getTree()
    {

    }


    /**
     *  Get Menu HTML
     *
     *  Ex: $tab Help we to build this like:
     *  category 1
     *   - category 1.1
     *   -- category 1.1.1
     *
     *
     * @param $tree
     * @param string $tab
     */
    protected function getMenuHtml($tree, $tab = '')
    {

    }


    /**
     * Map template from categories
     *
     *
     * @param $category
     * @param $tab
     * @param $id
     */
    protected function catToTemplate($category, $tab, $id)
    {
         
    }

}