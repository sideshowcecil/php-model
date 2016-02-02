<?php
namespace sideshow_bob\Model\Connection;

/**
 * A static connection manager.
 * @package sideshow_bob\Model\Connection
 */
final class ConnectionManager
{
    /**
     * Array of connection instances.
     * @var array
     */
    private static $connections = [];

    /**
     * Add a connection to the manager.
     * @param mixed $connection
     * @param string $name [optional] connection name
     */
    public static function add($connection, $name = "default")
    {
        static::$connections[$name] = $connection;
    }

    /**
     * Return a specific or default connection.
     * @param string $name [optional] connection name
     * @return mixed
     * @throws ConnectionManagerException
     */
    public static function get($name = "default")
    {
        if (!isset(static::$connections[$name])) {
            throw new ConnectionManagerException("Connection not found!");
        }
        // fetch the connection
        $connection = static::$connections[$name];
        if (is_callable($connection)) {
            // the connection is a callable so we invoke it and save the result
            static::$connections[$name] = $connection();
        }
        return static::$connections[$name];
    }

    /**
     * Private constructor to prevent instantiation.
     */
    private function __construct()
    {
    }
}
