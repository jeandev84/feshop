<?php

/**
 * Routes registring
 */



// http://eshop.loc/product/casio-mq-24-7bul/ or no '/'
Router::add('product/(?P<alias>[a-z0-9-]+)/?', [
    'controller' => 'Product',
    'action'     => 'view'
]);


// http://eshop.loc/category/men
Router::add('category/(?P<alias>[a-z0-9-]+)/?', [
    'controller' => 'Category',
    'action' => 'view'
]);


# Defaults routes

// http://eshop.loc/admin/
Router::add('admin', [
    'controller' => 'Main',
    'action'     => 'index',
    'prefix'     => 'admin'
]);

// http://eshop.loc/admin/...
Router::add('admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?', ['prefix' => 'admin']);


// http://eshop.loc/
Router::add('', [
    'controller' => 'Main',
    'action'     => 'index'
]);

// http://eshop.loc/...
Router::add('(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?');