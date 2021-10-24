<?php

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../entities/User.php';
require_once __DIR__ . '/../util/Response.php';
require_once __DIR__ . '/../util/TokenHandler.php';

class AuthController
{
    private UserModel $user_model;

    public function __construct()
    {
        $this->user_model = new UserModel();
    }

    public function login($data)
    {
        $user = $this->user_model->findByUsernameAndPassword($data->username, $data->password);

        if ($user->getId()) {
            $token = TokenHandler::getSignedJWTForUser($user->getUsername());

            return json_encode(array(
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'token' => $token
            ));
        } else {
            return Response::sendWithCode(401, "invalid username or password");
        }
    }

}
