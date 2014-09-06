<?php

namespace Observer;

abstract class Observe
{
    /**
     * @param null $params
     * @return static
     */
    final public static function factory($params = null)
	{
		$instance = new static();
		
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