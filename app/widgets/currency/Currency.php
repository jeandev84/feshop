<?php
namespace app\widgets\currency;



use Framework\App;

/**
 * Class Currency
 *
 * @package app\widgets\currency
 */
class Currency
{
    /**
     * @var string $tpl         [ Path to template ]
     * @var array  $currencies  [ List of all availables currencies ]
     * @var string $currency    [ Current money (currency) ]
     */
    protected $tpl;
    protected $currencies = [];
    protected $currency;


    /**
     * Currency constructor.
     */
    public function __construct()
    {
        $this->tpl = __DIR__.'/currency_tpl/currency.php';
        $this->run();
    }


    /**
     * Run
     */
    public function run()
    {
        // Get currencies
        $this->currencies = App::$app->get('currencies');

        // Get currency
        $this->currency = App::$app->get('currency');


        // Get Html code
        echo $this->getHtml();
    }


    /**
     * @return array
     */
    public static function getCurrencies()
    {
        $sql = "SELECT code, title, symbol_left, symbol_right, value, base 
                FROM `currency` 
                ORDER BY base DESC";

        return \R::getAssoc($sql);
    }


    /**
     * Get currency
     *
     * @param $currencies
     * @return array
     */
    public static function getCurrency($currencies)
    {
          if(isset($_COOKIE['currency']) && array_key_exists($_COOKIE['currency'], $currencies))
          {
                $key = $_COOKIE['currency'];
          }else{
                $key = key($currencies); // key() : return first key / element array
          }

          $currency = $currencies[$key];
          $currency['code'] = $key;
          return $currency;
    }


    /**
     * Get HTML
     *
     * @return void
     */
    protected function getHtml()
    {
        ob_start();
        require_once $this->tpl;
        return ob_get_clean();
    }
}