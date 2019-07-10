<?php

/*
return [
     'admin_email'    => 'admin@mail.com',
     'shop_name'      => 'Магазин Innovation',
     'perpage'        => 3, // pagination
     'smtp_login'     => '',
     'smtp_password'  => ''
];
*/

return [
    'admin_email'    => 'admin@ymail.com',
    'shop_name'      => 'Магазин Innovation',
    // pagination
    'perpage'        => 3,
    // swift_mailer config
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => '2525',
    'smtp_protocol' => 'ssl',
    'smtp_login' => 'eshop@gmail.com',
    'smtp_password' => 'eshop_2',
    // gallery images
    'img_width' => 125,
    'img_height' => 200,
    'gallery_width' => 700,
    'gallery_height' => 1000,
];

/**
 * Exemple
 *
 * 'smtp_host' => 'smtp.ukr.net',
 * 'smtp_port' => '2525',
 * 'smtp_protocol' => 'ssl',
 * 'smtp_login' => 'testishop2@ukr.net',
 * 'smtp_password' => 'testishop_2',
 *
 */