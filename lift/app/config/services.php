<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use \Phalcon\Mvc\Dispatcher as Dispatcher;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

/**
 * Setting up the view component
 */
$di->set('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);
    $view->setLayout('main');

    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ));

            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    return $view;
}, true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    return new DbAdapter(array(
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname
    ));
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function () {
    $session = new SessionAdapter();
    session_set_cookie_params(28800);
    $session->start();
    return $session;
});

/**
 * Router
 */
$di->set('router', function()
{
    require __DIR__.'/routes.php';
    return $router;
});

/**
 * Helpers
 */
$di->set('helper', function() {
    return new Helper();
});

/**
 * Dispatcher
 */
$di->set('dispatcher', function() use ($di) {
        $eventsManager = $di->getShared('eventsManager');
        $eventsManager->attach(
            'dispatch:beforeException',
            function($event, $dispatcher, $exception) {
                switch ($exception->getCode()) {
                    case 404:
                    case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        $dispatcher->forward([
                            'controller' => 'error',
                            'action' => 'notFound',
                            'params' => [$exception->getMessage()]
                        ]);
                    break;
                    
                    case 403:
                        $dispatcher->forward([
                            'controller' => 'error',
                            'action' => 'forbidden',
                            'params' => [$exception->getMessage()]
                        ]);
                    break;
                    
                    default:
                        $dispatcher->forward([
                            'controller' => 'error',
                            'action' => 'genericError',
                            'params' => [$exception->getMessage()]
                        ]);
                    break;
                }
                
                return false;
            }
        );
        $dispatcher = new Dispatcher();
        $dispatcher->setEventsManager($eventsManager);
        return $dispatcher;
    },
    true
);