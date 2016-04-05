<?php
$router = new Phalcon\Mvc\Router();

//Api

$router->add('/api/:action', [
    'controller' => 'api',
    'action'     => 1
]);


// Users

$router->add('/users', [
    'controller' => 'user',
    'action'     => 'index'
]);

$router->add('/users/:action', [
    'controller' => 'user',
    'action'     => 1
]);

$router->add('/users/:action/:params', [
    'controller' => 'user',
    'action'     => 1,
    'params'     => 2
]);

$router->add('/users{user_id:/[0-9]+}', [
    'controller' => 'user',
    'action'     => 'show',
    'params'     => 1
]);

$router->add('/users{user_id:/[0-9]+}/:action', [
    'controller' => 'user',
    'action'     => 2,
    'params'     => 1
]);

$router->add('/profile/:params', [
    'controller' => 'user',
    'action'     => 'show',
    'params'     => 1
]);

$router->add('/profile/update', [
    'controller' => 'user',
    'action'     => 'updateProfile'
]);

$router->add('/login', [
    'controller' => 'user',
    'action'     => 'login'
]);

$router->add('/register', [
    'controller' => 'user',
    'action'     => 'register'
]);

$router->add('/logout', [
    'controller' => 'user',
    'action'     => 'logout'
]);


// Projects

$router->add('/projects', [
    'controller' => 'project',
    'action'     => 'index'
]);

$router->add('/projects/:action', [
    'controller' => 'project',
    'action'     => 1
]);

$router->add('/projects/:action/:params', [
    'controller' => 'project',
    'action'     => 1,
    'params'     => 2
]);

$router->add('/projects{project_id:/[0-9]+}', [
    'controller' => 'project',
    'action'     => 'show',
    'params'     => 1
]);

$router->add('/projects{project_id:/[0-9]+}/:action', [
    'controller' => 'project',
    'action'     => 2,
    'params'     => 1
]);

$router->add('/projects{project_id:/[0-9]+}/posts/:action', [
    'controller' => 'project',
    'action'     => 2,
    'params'     => 1
])->convert('action', function($action) {
    return $action . 'Post';
});

$router->add('/projects{project_id:/[0-9]+}/posts{post_id:/[0-9]+}', [
    'controller' => 'project',
    'action'     => 'post',
    'params'     => 2
]);

$router->add('/projects{project_id:/[0-9]+}/posts{post_id:/[0-9]+}/:action', [
    'controller' => 'project',
    'action'     => 3,
    'params'     => 2
])->convert('action', function($action) {
    return $action . 'Post';
});

$router->add('/projects{project_id:/[0-9]+}/tasks/:action', [
    'controller' => 'project',
    'action'     => 2,
    'params'     => 1
])->convert('action', function($action) {
    return $action . 'Task';
});

$router->add('/projects{project_id:/[0-9]+}/tasks{task_id:/[0-9]+}', [
    'controller' => 'project',
    'action'     => 'task',
    'params'     => 2
]);

$router->add('/projects{project_id:/[0-9]+}/tasks{task_id:/[0-9]+}/:action', [
    'controller' => 'project',
    'action'     => 3,
    'params'     => 2
])->convert('action', function($action) {
    return $action . 'Task';
});


// Blog

$router->add('/posts', [
    'controller' => 'blog',
    'action'     => 'index'
]);

$router->add('/posts/:action', [
    'controller' => 'blog',
    'action'     => 1
])->convert('action', function($action) {
    return $action . 'Post';
});

$router->add('/posts{post_id:/[0-9]+}', [
    'controller' => 'blog',
    'action'     => 'post',
    'params'     => 1
]);

$router->add('/posts{post_id:/[0-9]+}/:action', [
    'controller' => 'blog',
    'action'     => 2,
    'params'     => 1
])->convert('action', function($action) {
    return $action . 'Post';
});


// Pages

$router->add('/pages', [
    'controller' => 'page',
    'action'     => 'index'
]);

$router->add('/pages/:action', [
    'controller' => 'page',
    'action'     => 1
]);

$router->add('/pages/:action/:params', [
    'controller' => 'page',
    'action'     => 1,
    'params'     => 2
]);

$router->add('/pages{page_id:/[0-9]+}', [
    'controller' => 'page',
    'action'     => 'show',
    'params'     => 1
]);

$router->add('/pages{page_id:/[0-9]+}/:action', [
    'controller' => 'page',
    'action'     => 2,
    'params'     => 1
]);


$router->handle();