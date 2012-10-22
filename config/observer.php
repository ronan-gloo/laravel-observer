<?php

return array(
	
	// Model method prefixes. ie: function event_saving()
	'prefix' => 'event_',
	
	// Eloquent events to listen
	'events' => array(
		'saving',
		'saved',
		'updated',
		'created',
		'deleting',
		'deleted'
	)
);