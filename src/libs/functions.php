<?php


/**
 * Debug array data
 *
 * @param $arr
 * @param bool $die
 */
function debug($arr, $die = false)
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
    if($die) die;
}


/**
 * Die and Dump
 *
 * @param array $arr
 */
function dd($arr)
{
    echo '<pre>';
    var_dump($arr);
    echo '</pre>';
    die;
}



/**
 * Method redirect [ $http is url where we want to redirect user. ] can be write $url or $to ..
 *
 * @param bool $http
 * @return void
 */
function redirect($http = false)
{
    if($http)
    {
        $redirect = $http;
    }else{
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
    }
    header(sprintf('Location: %s', $redirect));
    exit;
}



/**
 * Escapce bad str
 *
 *  By default encoding UTF-8
 * @param $str
 * @return string
 */
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}



/**
 * Translater
 *
 * @param $key
 * @param $default
 * @return string
 */
function __t($key, $default='') // or named function __($key, $default='') {}
{
    echo Project\Template\Lang::get($key);
}