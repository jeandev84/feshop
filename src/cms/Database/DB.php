<?php
namespace Framework\Database;


use Framework\Container\Singleton;



/**
 * Class DB
 *
 * @package Framework\Database
 */
class DB
{

    use Singleton;

    /**
     * DB constructor.
     *
     * @return void
     */
    protected function __construct()
    {
        $db = require_once CONFIG.'/db.php';
    }
}