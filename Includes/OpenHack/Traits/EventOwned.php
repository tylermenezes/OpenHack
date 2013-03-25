<?php

namespace OpenHack\Traits;

use \OpenHack\Models;

trait EventOwned
{
    protected $eventID;
    public function __get_event()
    {
        return new Models\Event($this->eventID);
    }
    public function __set_event($new)
    {
        $this->eventID = $new->eventID;
        $this->invalidate('eventID');
    }
}
