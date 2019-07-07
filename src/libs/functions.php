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