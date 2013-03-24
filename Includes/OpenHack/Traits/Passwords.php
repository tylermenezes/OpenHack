<?php

namespace OpenHack\Traits;

trait Passwords
{
    protected $password;

    public function __set_password($new)
    {
        $salt = hash('sha256', mt_rand());
        $this->password = $this->generate_password('whirlpool', $new, $salt);
        $this->invalidate('password');
    }

    private function generate_password($algo, $password, $salt)
    {
        $hash = hash($algo, $password . $salt);
        return implode('$', [$algo, $hash, $salt]);
    }

    private function check_password($password_to_check)
    {
        $expected = $this->password;
        list($algo, $hash, $salt) = explode('$', $expected);
        $actual = $this->generate_password($algo, $password_to_check, $salt);

        return $expected === $actual;
    }
}
