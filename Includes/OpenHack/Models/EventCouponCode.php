<?php

namespace OpenHack\Models;

use \OpenHack\Traits;

class EventCouponCode extends \TinyDb\Orm
{
    use Traits\EventOwned;

    public static $table_name = 'event_coupon_codes';
    public static $primary_key = 'eventCouponCodeID';

    protected $eventCouponCodeID;
    protected $code;

    protected $current_uses;
    protected $max_uses;

    protected $discount_percent;
    protected $discount_amount;

    public function __get_is_percent_discount()
    {
        return isset($this->discount_percent);
    }

    public function __get_is_amount_discount()
    {
        return isset($this->discount_amount);
    }

    public function __get_is_access_coupon()
    {
        return !($this->is_percent_discount || $this->is_amount_discount);
    }

    public function __get_allowed_ticket_types()
    {
        return new \TinyDb\Collection('\OpenHack\Models\EventTicketType', \TinyDb\Sql::create()
                                      ->join('event_tickets_coupon_codes ON (event_tickets_coupon_codes.eventTicketID = events_ticket_types.eventTicketID)', 'LEFT')
                                      ->where('event_tickets_coupon_codes.eventCouponCodeID = ?', $this->eventCouponCodeID)
                                    );
    }
}
