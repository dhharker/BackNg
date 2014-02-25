<?php


class MongoPlugin extends BackNgPlugin {
    
    function __construct ($options = array (), &$appInstance = null) {
        parent::__construct($options, $appInstance);
        $this->options = array_merge(array(
            'host' => '127.0.0.1',
            'db' => 'backng'
        ),$this->options);
    }
    
    function on_initialise () {
        try {
            // Connect to test database
            $m = new Mongo("mongodb://{$this->options['host']}");  
            $db = $m->{$this->options['db']};  

            $this->db =& $db;
        }
        catch (Exception $e) {
            $this->trigger_error($e->getMessage());
        }
    }
    
    function getCollectionNames ($sys = false) {
        $this->db->getCollectionNames ($sys);
    }
    
    function on_parse () {
        
        // select the collection  
//        $collection = $this->db->shows;  
//
//        // pull a cursor query  
//        $cursor = $collection->find();  
//        
//        foreach ($cursor as $document) {
//            var_dump($document);
//        }
        
        $this->app->Log->log($this->getCollectionNames(true));
        
    }
    
}


?>