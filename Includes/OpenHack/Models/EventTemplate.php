<?php

namespace OpenHack\Models;

class EventTemplate
{
    public static $table_name = 'event_templates';
    public static $primary_key = 'eventTemplateID';

    protected $eventTemplateID;
    protected $name;
    protected $description;

    protected $tenantID;
}
