<?php

namespace OpenHack\Models;

use \OpenHack\Traits;

class User extends \TinyDb\Orm
{
    use Traits\Passwords;
    use Traits\TenantOwned;

    public static $table_name = 'users';
    public static $primary_key = 'userID';

    protected $userID;
    protected $first_name;
    protected $middle_name;
    protected $last_name;
    protected $email;
}
