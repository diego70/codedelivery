<?php


namespace CodeDelivery\OAuth2;


use Illuminate\Support\Facades\Auth;

class PasswordGrantVerifier
{
    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function verify($username, $password)
    {
        $credentials = [
            'email'    => $username,
            'password' => $password,
        ];

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        return false;
    }

}