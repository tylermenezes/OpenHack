<?php

namespace OpenHack\Traits;

trait SocialLogin
{

    /* Facebook */
    protected $fb_id;
    protected $fb_token;

    public function __get_is_facebook_connected()
    {
        return isset($this->fb_id) && isset($this->fb_token);
    }

    public function facebook_connect_start($redirect, $scopes)
    {
        $redirect_url = implode('', [
                            'https://www.facebook.com/dialog/oauth?',
                            'client_id=', $this->tenant->fb_public,
                            '&redirect_uri=', $redirect,
                            '&scope=', implode(',', $scopes)
                       ]);
        \CuteControllers\Router::redirect($redirect_url);
    }

    public function facebook_connect_end($code)
    {
        $token_request_url = implode('', [
                            'https://graph.facebook.com/oauth/access_token?',
                            'client_id=', $this->tenant->fb_public,
                            '&client_secret=', $this->tenant->fb_private,
                            '&code=', $code
                        ]);

        // Exchange the code for a token
        $response = file_get_contents($token_request_url);
        $params = null;
        parse_str($response, $params);

        // Set the token
        $this->fb_token = $params['access_token'];
        $this->invalidate('fb_token');
        $this->update();

        if (method_exists($this, 'facebook_after_connect')) {
            $this->facebook_after_connect();
        }
    }
}
