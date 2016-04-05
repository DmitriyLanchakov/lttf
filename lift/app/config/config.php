<?php

return new \Phalcon\Config(array(
//    'database' => array(
//        'adapter'     => 'Mysql',
//        'host'        => 'lttf.doesnotcompute.ru',
//        'username'    => 'root',
//        'password'    => '',
//        'dbname'      => 'test',
//    ),
    'application' => array(
        'helpersDir'     => __DIR__ . '/../../app/helpers/',
        'controllersDir' => __DIR__ . '/../../app/controllers/',
        'modelsDir'      => __DIR__ . '/../../app/models/',
        'viewsDir'       => __DIR__ . '/../../app/views/',
        'pluginsDir'     => __DIR__ . '/../../app/plugins/',
        'libraryDir'     => __DIR__ . '/../../app/library/',
        'cacheDir'       => __DIR__ . '/../../app/cache/',
        'baseUri'        => '',
    )
));



