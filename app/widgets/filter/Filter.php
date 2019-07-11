<?php
namespace app\widgets\filter;


use Framework\Library\Cache;
use R;


/**
 * Class Filter
 * Filtre les produits par categories par brand etc
 * This class has role to filter products by categories / by brands etc..
 *
 *
 * @package app\widgets\filter
 */
class Filter
{

     /**
      * @var array $groups  [ Groups filtres ]
      * @var array $attrs   [ Attributes ]
      * @var string $tpl    [ Path to default filter template ]
     */
     public $groups;
     public $attrs;
     public $tpl;
     public $filter;


    /**
     * Filter constructor.
     *
     * Ex:(new Filter('mecanic', ROOT.'/public/test_filter_tpl.php'))
     *
     * @param null $filter [ concret option ]
     * @param string $tpl
     */
    public function __construct($filter = null, $tpl = '')
    {
        $this->filter = $filter;
        $this->tpl = $tpl ?: __DIR__ . '/filter_tpl.php';
        $this->run();
    }


    /**
     * Run Filter
     *
     * @return void
     */
     protected function run()
     {
         // new instance of cache
         $cache = Cache::instance();

         // Try to get data Filter groups from cache
         $this->groups = $cache->get('filter_group');

         // if has not data of groups from cache
         if(!$this->groups)
         {
             // we'll get groups and store them in the cache
             $this->groups = $this->getGroups();
             $cache->set('filter_group', $this->groups, 1); // 1 second
         }

         // Try to get data Attributes from cache
         $this->attrs  = $cache->get('filter_attrs');

         // if has not data of groups from cache
         if(!$this->attrs)
         {
             $this->attrs = self::getAttrs();
             $cache->set('filter_attrs', $this->attrs, 1); // 1 second
         }

         /*
         debug($this->groups);
         debug($this->attrs);
         */

         $filters = $this->getHtml();
         echo $filters;
     }


    /**
     * Get HTML
     *
     */
     protected function getHtml()
     {
         /*
         ob_start();
         require $this->tpl;
         return ob_get_clean();
         */
         ob_start();
         $filter = self::getFilter();
         if(!empty($filter)){
             $filter = explode(',', $filter);
         }
         require $this->tpl;
         return ob_get_clean();
     }


    /**
     * Get all groups
     *
     * @return array
     */
     protected function getGroups()
     {
          return R::getAssoc('SELECT id, title FROM attribute_group');
     }


    /**
     * Get attributes
     *
     * @return array
     */
     protected static function getAttrs()
     {
         $data = R::getAssoc('SELECT * FROM attribute_value');

         $attrs = [];
         foreach ($data as $k => $v)
         {
             $attrs[$v['attr_group_id']][$k] = $v['value'];
         }
         return $attrs;
     }


    /**
     * Get Filter
     *
     * @return string|string[]|null
     */
    public static function getFilter()
    {
        $filter = null;
        if(!empty($_GET['filter'])){
            $filter = preg_replace("#[^\d,]+#", '', $_GET['filter']);
            $filter = trim($filter, ',');
        }
        return $filter;
    }


    /**
     * Get Groups
     *
     *
     * @param $filter
     * @return int
     */
    public static function getCountGroups($filter)
    {
        $filters = explode(',', $filter);
        $cache = Cache::instance();
        $attrs = $cache->get('filter_attrs');

        if(!$attrs)
        {
            $attrs = self::getAttrs();
        }
        $data = [];
        foreach($attrs as $key => $item)
        {
            foreach($item as $k => $v)
            {
                if(in_array($k, $filters))
                {
                    $data[] = $key;
                    break;
                }
            }
        }
        return count($data);
    }
}