<?php

namespace app\storage;

/**
 *
 * @author Stefano Mtangoo <mwinjilisti at gmail dot com>
 */
class JwtAccessToken extends \OAuth2\Storage\JwtAccessToken
{
    public function setAccessToken($oauth_token, $client_id, $user_id, $expires, $scope = null)
    {

    }

    public function unsetAccessToken($access_token)
    {

    }
}