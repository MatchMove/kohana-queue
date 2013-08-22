<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Queue_Queue_Email {
    
    protected $config = array();
    
    public function __construct($config)
    {
        $this->config = $config;
    }
    
    abstract protected function _push($recipient, $subject, $body, $config);
    
    public function push($recipient, $subject, $body, $config = null)
    {
        return $this->_push($recipient, $subject, $body, !empty($config) ?$config: $this->config['default'] );
    }
}