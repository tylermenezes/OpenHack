<?php

namespace OpenHack;

class Application
{
    public static $config;
    public static $dir;
    public static $twig;

    protected static $spl_loader;

    /**
     * Gets directory path information and stores them in the $dir object.
     */
    private static function set_directories()
    {
        $webroot = dirname(dirname(dirname(__FILE__)));
        static::$dir = (object)[
            'webroot' => $webroot,
            'includes' => pathify($webroot, 'Includes'),
            'plugins' => pathify($webroot, 'Plugins'),
            'controllers' => pathify($webroot, 'Includes', 'OpenHack', 'Controllers'),
            'themes' => pathify($webroot, 'themes')
        ];
    }

    /**
     * Loads the config from config.user.json
     */
    private static function load_config()
    {
        $config = json_decode(file_get_contents(pathify(static::$dir->webroot, '.config.user.json')));

        static::$config = $config;
    }

    /**
     * Sets up an SPL class loader
     */
    private static function load_spl_loader()
    {
        require_once(pathify(static::$dir->includes, 'SplClassLoader.php'));
        static::$spl_loader = new \SplClassLoader(null, static::$dir->includes);
        static::$spl_loader->register();
    }

    /**
     * Loads Twig for templating
     */
    private static function load_twig()
    {
        $twig_config = [];

        // Enable debugging if the debug flag is on
        if (static::$config->debug === true) {
            $twig_config['debug'] = true;
        }

        // Enable caching if set
        if (static::$config->twig->cache_dir !== null) {
            $twig_config['cache'] = static::$config->twig->cache_dir;
        }

        // Figure out what domain we're on, and load the theme configured for that domain
        $domain = \CuteControllers\Request::Current()->host;
        $event = \OpenHack\Models\Event::GetEventByDomain($domain);
        $template_dir = pathify($event->theme->directory, 'tpl');

        // Actually load Twig
        $twig_loader = new \Twig_Loader_Filesystem(pathify(static::$dir->themes, $template_dir));
        static::$twig = new \Twig_Environment($twig_loader, $twig_conifg);

        // Twig can only load plugins after it's been loaded, but can only enable debugging before it's been loaded. So
        // we need to do another check if debugging is on so we can load the debug extension.
        if (static::$config->debug === true) {
            $twig->addExtension(new \Twig_Extension_Debug());
        }
    }

    /**
     * Generates a connection string from a database connection config object
     * @param  object $db_config Database connection config from config file
     * @return string            MDB2 connection string
     */
    private static function generate_connection_string($db_config)
    {
        if ($db_config === null) {
            return $db_config;
        }
        return implode('', [
                            $db_config->type,
                            '://',
                            $db_config->username,
                            ':',
                            $db_config->password,
                            '@',
                            $db_config->host,
                            '/',
                            $db_config->db
                        ]);
    }

    /**
     * Sets up TinyDb to do database work
     */
    private static function load_database()
    {
        \TinyDb\Db::set(
                            self::generate_connection_string(static::$config->database->read),
                            self::generate_connection_string(static::$config->database->write)
                        );
    }

    /**
     * Starts CuteControllers. The last step in bootstraping, since it maintains control until the application dies.
     */
    private static function start_routing()
    {
        try {
            \CuteControllers\Router::start(static::$dir->controllers);
        } catch (\CuteControllers\HttpError $error) {
            // Something went wrong!
        }
    }

    /**
     * Starts OpenHack! Bootstraps through the setup stages.
     */
    public static function start()
    {
        include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Functions.php');

        static::set_directories();
        static::load_config();
        static::load_spl_loader();
        static::load_database();
        static::load_twig();
        static::start_routing();
    }
}
