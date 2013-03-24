<?php

namespace OpenHack\Models;

class Tenant extends \TinyDb\Orm
{
    public static $table_name = 'tenants';
    public static $primary_key = 'tenantID';

    protected $tenantID;
    protected $name;

    protected $stripe_id;
    protected $fb_public;
    protected $fb_private;
}
