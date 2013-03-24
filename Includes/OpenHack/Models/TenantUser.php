<?php

namespace OpenHack\Models;

use \OpenHack\Traits;

class TenantUser extends \TinyDb\Orm
{
    use Traits\Passwords;

    public static $table_name = 'tenants_users';
    public static $primary_key = 'tenantUserID';

    protected $tenantUserID;
    protected $tenantID;
    protected $email;
}
