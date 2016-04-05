<?php
require_once "../../dbkernel/index.php";

error_reporting(E_ALL);
setlocale(LC_ALL, 'ru_RU.UTF-8', 'ru_RU.utf8', 'Russian_Russia.1251');


try {

    /**
     * Read the configuration
     */
    $config = include __DIR__ . "/../app/config/config.php";

    /**
     * Read auto-loader
     */
    include __DIR__ . "/../app/config/loader.php";

    /**
     * Read services
     */
    include __DIR__ . "/../app/config/services.php";

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);
    echo $application->handle()->getContent();



} catch (\Exception $e) {
    echo $e->getMessage();
}


