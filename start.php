<?php

/*
|--------------------------------------------------------------------------
| Register Observer class
|--------------------------------------------------------------------------
*/
Autoloader::map(array( 'Observer\Observe' => __DIR__.'/observe.php' ));

/*
|--------------------------------------------------------------------------
| Eloquent Events rollbacks
|--------------------------------------------------------------------------
|
| Attach listeners on each Eloquent's model events;
| 1. Check if current method is embed in the model
| 2. call the observer if defined in model properties
|
*/
foreach (Config::get('observer::observer.events') as $event)
{
	Event::listen('eloquent.'.$event, function($model) use($event)
	{
		$method = Config::get('observer::observer.prefix').$event;
		
		// havea look to the instance itself, and run method if found
		if (method_exists($model, $method) and is_callable(array($model, $method)))
		{
			$model->$method();
		}
		
		// Check is developper has defined events in class properties
		if (property_exists(get_class($model), 'observe') and array_key_exists($event, $model::$observe))
		{
			foreach ((array)$model::$observe[$event] as $name => $params)
			{
				// Check if params are presents, and setup the instance
				$class = is_int($name) ? $params : $name;
				
				// instatiate Observer with parameters
				$instance = $class::factory($class, is_array($params) ? $params : null);
				
				// run the method
				$instance->$event($model);
			}
		}
	});
}