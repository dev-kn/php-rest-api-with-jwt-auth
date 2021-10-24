<?php

require_once __DIR__ . '/Request.php';
require_once __DIR__ . '/Response.php';

class Route
{
    private static array $get_routes = array();
    private static array $post_routes = array();
    private static array $put_routes = array();
    private static array $delete_routes = array();

    public static function add($request_method, $expression, $function, $enable_auth = true)
    {
        switch ($request_method) {
            case 'GET':
                array_push(self::$get_routes, array(
                    'expression' => $expression,
                    'function' => $function,
                    'enable_auth' => $enable_auth
                ));
                break;
            case 'POST':
                array_push(self::$post_routes, array(
                    'expression' => $expression,
                    'function' => $function,
                    'enable_auth' => $enable_auth
                ));
                break;
            case 'PUT':
                array_push(self::$put_routes, array(
                    'expression' => $expression,
                    'function' => $function,
                    'enable_auth' => $enable_auth
                ));
                break;
            case 'DELETE':
                array_push(self::$delete_routes, array(
                    'expression' => $expression,
                    'function' => $function,
                    'enable_auth' => $enable_auth
                ));
                break;
            default:
                break;
        }
    }

    public static function run()
    {

        $request_path_found = false;
        $routes = array();
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                $routes = self::$get_routes;
                break;
            case 'POST':
                $routes = self::$post_routes;
                break;
            case 'PUT':
                $routes = self::$put_routes;
                break;
            case 'DELETE':
                $routes = self::$delete_routes;
                break;
            default:
                break;
        }

        foreach ($routes as $route) {
            $request_uri = $_SERVER['REQUEST_URI'];
            $request_uri = (stripos($request_uri, "/") !== 0) ? "/" . $request_uri : $request_uri;
            $regex = str_replace('/', '\/', $route['expression']);

            if (preg_match('/^' . ($regex) . '$/', $request_uri, $matches)) {
                array_shift($matches);
                $request_path_found = true;

                if (
                    $route['enable_auth'] && static::checkRequestAuthentication()
                    || !$route['enable_auth']
                ) {
                    call_user_func_array($route['function'], array(new Request($matches)));
                }

                break;
            }
        }

        if (
            !$request_path_found
            && static::checkRequestAuthentication()
        ) {
            echo Response::sendWithCode(404, "resource does not exist");
        }
    }

    public static function checkRequestAuthentication()
    {
        if (Constants::JWT["TOKEN_AUTHENTICATION"]) {
            if (TokenHandler::authenticate()) {
                return true;
            } else {
                echo Response::sendWithCode(401, "Invalid token. Please login.");
                return false;
            }
        } else {
            return true;
        }
    }
}
