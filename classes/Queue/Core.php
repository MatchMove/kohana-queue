<?php defined('SYSPATH') OR die('No direct script access.');

class Queue_Core {
    
    const PREFIX = 'Queue';
    
    const ENGINE_KEY = 'engine';
    const CONFIG_KEY = 'config';
    
    /**
     * Default configuration path.
     */
    const DEFAULT_CONFIG_PATH = 'queue';
    
    static private $instances = array();
    
    /**
     * Configuration group to be used.
     */
    protected static $_config_group = 'default';
    
    /**
     * @param string $type instance type to created.
     * @param string $group configuration group to be used.
     */
    public static function instance($type, $group = null)
    {
        // Load if instance was already created.
        if (!empty(self::$instances[$type]))
        {
            return self::$instances[$type];
        }
        
        if (empty($group))
        {
            $group = self::$_config_group;
        }
        
        if (is_string($group))
        {
            $config = Kohana::$config->load(self::DEFAULT_CONFIG_PATH)->as_array();
            
            // load configuration from kohana config file.
            if (empty($config[$group]))
            {
                throw new Kohana_Exception('Cannot find :class configuration group `:group` on file `:file`',
                    array(':class' => __CLASS__, ':group' => $group, ':file' => self::DEFAULT_CONFIG_PATH));
                
                return false;
            }
            
            $config = $config[$group];
            
            // load type.
            if (empty($config[$type]) || empty($config[$type][self::ENGINE_KEY]))
            {
                throw new Kohana_Exception('Cannot find type `:type` for the class :class configuration on file `:file`',
                    array(':class' => __CLASS__, ':type' => $type, ':file' => self::DEFAULT_CONFIG_PATH));
                
                return false;
            }
            
            $config = $config[$type];
        }
        
        $class = new ReflectionClass('Queue_'. $type . '_' . $config[self::ENGINE_KEY]);
        return self::$instances[$type] = $class->newInstanceArgs(array($config[self::CONFIG_KEY]));
    }
}