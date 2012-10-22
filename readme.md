Laravel Observer
================

Route Eloquent’s models events to the model’s instance, and / or a
specific class

### Installation

`php artisan bundle:install observer`

### Events

-   **saving**: before save
-   **saved**: after save
-   **updated**: after update
-   **created**: after creation
-   **deleting**: defore delete
-   **deleted**: after delete

### Usage

##### 1. Whithin the model

    class Post extends Eloquent {
        
        /**
         * This method will be run after an update or a creation.
         */
        public function event_saved()
        {
            Log::info(get_class($this).' with title "'.$this->title.'" saved');
        }
        
    }

##### 2. With an Observer

    // The Model
    class Post extends Eloquent {
        
        public static $observe = array(
            
            // Single observer for a single event
            'saving' => 'Observe_Slug',
            
            // Multiple observers for a single event
            'created' => array('Observe_Log', 'Observe_Mail'),
            
            // Observer with parameters
            'updated' => array('Observe_History' => array('log' => true))
        );
        
    }

    // Observer
    class Observer_Slug extends Observer\Observe {
        
        // Modelfy object before to save it
        public function saving($model)
        {
            model->slug = Str::slug($model->title);
        }
        
        // event with parameters: parameters from model are instance properties here
        public function updated($model)
        {
            if ($this->log == true)
            {
                Do something...
            }
        }
    }
