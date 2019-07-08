<?php
namespace Framework\Database;


use Framework\Container\Singleton;
use Exception;
use R;


/**
 * Class DB
 *
 * @link https://packagist.org/packages/gabordemooij/redbean
 * @package Framework\Database
 */
class DB
{

    use Singleton;

    /**
     * DB constructor.
     *
     * @return void
     * @throws Exception
     */
    protected function __construct()
    {
        $db = require_once CONFIG.'/db.php';
        R::setup($db['dsn'], $db['user'], $db['pass']);

        if(!R::testConnection())
        {
            throw new Exception('Нет соединения с БД', 500);
        }
        // echo 'Соединение установлено!';

        // запретить изменение в Таблице
        R::freeze(true);

        // включить режим откладки
        if(DEBUG)
        {
            R::debug(true, 1);
        }
    }
}