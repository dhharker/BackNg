<?php

abstract class BackNgPlugin {
    
    
    var $options = array ();    // Config options
    var $app = null;            // Ref to BackNg object
    
    var $name = false;          // Name of the plugin
    var $alias = null;         // Alias of plugin in BackNg::pluginRegistry
    
    var $schema = array ();     // Exportable schema
    
    function __construct ($options = array (), &$appInstance = null) {
        $this->options = $options;
        $this->app =& $appInstance;
        if ($this->name === false)
            $this->name = substr (__CLASS__, -6);
        if ($this->alias === false)
            $this->name = $this->name;
    }
    
    function trigger_error ($error) {
        throw new Exception ("{$this->name} Plugin Error: {$error}");
    }
    
    
    function getSchema ($schemaName = null) {
        if ($schemaName === null) return $this->schema;
        if (isset ($this->schema[$schemaName]))
            return $this->schema[$schemaName];
        $this->trigger_error ("Schema $schemaName not found!");
    }
    
}

?>