<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Queues used by the system. Used in requesting asynchronous processes
 */

/**
 * Checks for server-side configs. Configuration file should be properly written in ini format.
 */
if (!empty($_SERVER['QUEUE_CONFIG']))
{
    return parse_ini_file($_SERVER['QUEUE_CONFIG']);
}

return array(
    
    'default' => array(
        
        'Email' => array(
            
            'engine' => 'AWS', // module key of which to use.
            
            'config' => array(
                'default'    => 'default',
                'queue_url'  => '<aws_amazon_queue_url>'
            )
            
        )
    ),
);
