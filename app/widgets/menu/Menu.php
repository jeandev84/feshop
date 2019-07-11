<?php
namespace app\widgets\menu;



use Framework\App;
use Framework\Library\Cache;
use R;



/**
 * Class Menu
 *
 *  PLUGINS
 * @github: https://github.com/marioloncarek/megamenu-js
 * @codepen : https://codepen.io/riogrande/pen/MKXweV
 *
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
     * @var string $class
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
    protected $class = 'menu';
    protected $table = 'category';
    protected $cache = 3600;
    protected $cacheKey = 'menu_cache';
    protected $attrs = [];
    protected $prepend = '';


    /**
     * Menu constructor.
     *
     *  Ex:
     *  echo new \Project\Widgets\Menu\Menu([
     *   // 'tpl' => WWW.'/menu/my_menu.php', 'class' => 'my-menu',
     *      'tpl' => WWW.'/select/select.php',
     *      'container' => 'select',
     *      'class' => 'my-menu',
     *      'table' => 'categories',
     *      'cache' => 60, // 60s
     *      'cacheKey' => 'menu_select',
     *      'attrs' => [
     *         'id' => 'menu_shop',
     *         'style' => 'border: 1px solid #ccc;'
     *      ]
     * ])
     *
     * @param array $options
     * @return void
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

           $this->tree = $this->getTree(); // debug($this->tree);
           $this->menuHtml = $this->getMenuHtml($this->tree);

           // add to cache if $this->cache !== 0
           if($this->cache)
           {
               // set menu cache
               $cache->set($this->cacheKey, $this->menuHtml, $this->cache);
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
        // echo $this->menuHtml;
        $attrs = $this->getattrs();
        $html = sprintf('<{container} class="%s"%s>%s%s</{container}>',
            $this->class,
            $attrs,
            $this->prepend,
            $this->menuHtml
        );
        echo str_replace('{container}', $this->container, $html);

        /*
        echo sprintf('<%s class="%s"%s>%s%s</%s>',
          $this->container,
          $this->class,
        $attrs
          $this->menuHtml,
          $this->container
        );
        */
    }


    /**
     * Get attrs from options
     *
     * @return string
     */
    protected function getattrs()
    {
        $str = '';
        if(!empty($this->attrs))
        {
            foreach($this->attrs as $k => $v)
            {
                $str .= sprintf(' %s="%s"', $k, $v);
            }
        }
        return $str;
    }


    /**
     * Get Tree
     *
     * @return array
     */
    protected function getTree()
    {
        $tree = [];
        $data = $this->data; // copy data

        // if we use directly $this->>data for populate, data'll be losted
        foreach($data as $id => &$node)
        {
            if(!$node['parent_id'])
            {
                $tree[$id] = &$node;
            }else{
                $data[$node['parent_id']]['childs'][$id] = &$node;
            }
        }
        return $tree;
    }


    /**
     *  Get Menu HTML [ Recursive ]
     *
     *  Ex: $tab Help we to build this like:
     *  category 1
     *   - category 1.1
     *   -- category 1.1.1
     *
     *
     * @param $tree
     * @param string $tab
     * @return string
     */
    protected function getMenuHtml($tree, $tab = '')
    {
        $str = '';
        foreach($tree as $id => $category)
        {
            $str .= $this->catToTemplate($category, $tab, $id);
        }
        return $str;
    }


    /**
     * Map template from categories
     *
     *
     * @param $category
     * @param $tab
     * @param $id
     * @return string
     */
    protected function catToTemplate($category, $tab, $id)
    {
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }

}