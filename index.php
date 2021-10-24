<?php

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


require_once __DIR__ . '/util/Route.php';
require_once __DIR__ . '/controller/AuthController.php';
require_once __DIR__ . '/controller/PostController.php';

// Route::add($request_method, $request_path, $callback_function, $enable_auth = true)

Route::add('POST', '/api/auth/login', function (Request $request) {
    echo (new AuthController())->login($request->getJSON());
}, false);

Route::add('GET', '/api/post', function (Request $request) {
    echo (new PostController())->findAll();
});

Route::add('GET', '/api/post/([0-9]*)', function (Request $request) {
    echo (new PostController())->findById($request->params[0]);
});

Route::add('POST', '/api/post', function (Request $request) {
    echo (new PostController())->create($request->getJSON());
});

Route::add('PUT', '/api/post/([0-9]*)', function (Request $request) {
    echo (new PostController())->update($request->params[0], $request->getJSON());
});

Route::add('DELETE', '/api/post', function (Request $request) {
    echo (new PostController())->delete($request->getJSON());
});

Route::add('GET', '/api/get-posts-by-title/([a-zA-Z0-9]*)', function (Request $request) {
    echo (new PostController())->findByTitle($request->params[0]);
});

Route::run();