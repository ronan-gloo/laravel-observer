<?php

namespace Observer;

abstract class Observe {
	
	/**
	 * Run an instance method.
	 * 
	 * @access public
	 * @static
	 * @param mixed $event
	 * @param mixed $model
	 * @return void
	 */
	final public static function factory($class, $params = null)
	{
		$instance = new $class();
		
		if ($params and is_array($params))
		{
			foreach ($params as $key => $param)
			{
				is_string($key) and $instance->$key = $param;
			}
		}
		return $instance;
	}
	
}