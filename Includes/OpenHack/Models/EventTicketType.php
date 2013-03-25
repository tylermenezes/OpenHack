<?php

namespace OpenHack\Models;

use \OpenHack\Traits;

class EventTicketType extends \TinyDb\Orm
{
    use Traits\EventOwned;

    public static $table_name = 'events_ticket_types';
    public static $primary_key = 'eventTicketTypeID';

    protected $eventTicketTypeID;
    protected $name;
    protected $price;
    protected $start_at;
    protected $end_at;

    protected $public;

    // Earlybird pricing
    protected $earlybird_enabled;
    protected $earlybird_price;
    protected $earlybird_end_at;

    public function __get_is_earlybird_period()
    {
        return $this->earlybird_enabled && $this->earlybird_end_at < $this->event->event_time();
    }

    public function __get_name()
    {
        if ($this->is_earlybird_period) {
            return $this->name . ' (Earlybird)';
        } else {
            return $this->name;
        }
    }

    public function __get_cost()
    {
        if ($this->is_earlybird_period) {
            return $this->earlybird_price;
        } else {
            return $this->price;
        }
    }
}
