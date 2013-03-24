<?php

namespace OpenHack\Models;

class Theme extends \TinyDb\Orm
{
    public static $table_name = 'themes';
    public static $primary_key = 'themeID';

    protected $themeID;
    protected $directory;
}
