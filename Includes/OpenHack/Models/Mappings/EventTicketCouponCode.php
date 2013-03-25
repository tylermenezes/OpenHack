<?php

namespace OpenHack\Models\Mappings;

class EventTicketCouponCode extends \TinyDb\Orm
{
    public static $table_name = 'event_tickets_coupon_codes';
    public static $primary_key = ['eventTicketID', 'eventCouponCodeID'];

    protected $eventTicketID;
    protected $eventCouponCodeID;
}
