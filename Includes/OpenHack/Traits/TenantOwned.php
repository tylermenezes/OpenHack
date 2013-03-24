<?php

namespace OpenHack\Traits;

use \OpenHack\Models;

trait TenantOwned
{
    protected $tenantID;
    public function __get_tenant()
    {
        return new Models\Tenant($this->tenantID);
    }
    public function __set_tenant($new)
    {
        $this->tenantID = $new->tenantID;
        $this->invalidate('tenantID');
    }
}
