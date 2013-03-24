<?php

namespace OpenHack\Models;

class Event extends \TinyDb\Orm
{
    public static $table_name = 'events';
    public static $primary_key = 'eventID';

    protected $eventID;
    protected $eventTemplateID;
    protected $domain;

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
