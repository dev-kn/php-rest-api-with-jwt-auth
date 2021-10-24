<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Firebase\JWT\JWT;

class TokenHandler
{
    public static function getSignedJWTForUser($email)
    {
        $issued_at_time = time();
        $time_to_live = Constants::JWT["TIME_TO_LIVE"];
        $token_expiration = $issued_at_time + $time_to_live;
        $payload = [
            'email' => $email,
            'iat' => $issued_at_time,
            'exp' => $token_expiration,
        ];

        return JWT::encode($payload, Constants::JWT["SECRET_KEY"]);
    }

    public static function authenticate()
    {
        $headers = static::getAuthorizationHeader();
        if (!is_null($headers)) {
            $token = static::getBearerToken($headers);
            if (!is_null($token)) {
                return static::validateJWTFromUser($token);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getAuthorizationHeader()
    {
        $headers = null;

        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } else if (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }

        return $headers;
    }

    public static function getBearerToken($headers)
    {

        // HEADER: Get the access token from the header
        if (!empty($headers) && preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public static function validateJWTFromUser($encoded_token)
    {
        $decoded_token = JWT::decode($encoded_token, Constants::JWT["SECRET_KEY"], ['HS256']);
        $is_token_expired = ($decoded_token->exp - time()) < 0;

        return !$is_token_expired;
    }
}
