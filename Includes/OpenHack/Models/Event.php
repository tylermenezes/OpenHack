<?php

namespace OpenHack\Models;

class Event extends \TinyDb\Orm
{
    public static $table_name = 'events';
    public static $primary_key = 'eventID';

    protected $eventID;
    protected $eventTemplateID;
    protected $domain;

    protected $starts_at;
    protected $ends_at;

    protected $location_name;
    protected $location_address_1;
    protected $location_address_2;
    protected $location_city;
    protected $location_state;
    protected $location_country;
    protected $timezone;

    protected $rules;

    public function __get_ticket_types()
    {
        return new \TinyDb\Collection('\OpenHack\Models\Event', \TinyDb\Sql::create()
                                      ->where('eventID = ?', $this->eventID));
    }

    /**
     * Gets the current time in the event's locale
     * @return int Unix timestamp in the event's locale
     */
    public function event_time()
    {
        $timezone = new \DateTimeZone($this->timezone);
        $offset = $timezone->getOffset(new \DateTime("now"));
        return time() - $offset;
    }


    protected $themeID;
    public function __get_theme()
    {
        return new Theme($this->themeID);
    }
    public function __set_theme($new)
    {
        $this->themeID = $new->themeID;
    }

    public static function GetEventByDomain($domain)
    {
        // TODO
    }
}
