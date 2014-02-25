<?php

class BackNg {
    
    /**
     * Stores global app state (e.g. logged in user, session vars)
     */
    public $AppScope = null;
    
    /**
     * Request & data from client. Endpoint, conditions etc.
     */
    public $Request = null;
    
    /**
     * Data, error messages, push updates or whatever to send to client.
     */
    public $Response = null;
    
    /**
     * Where to look for config, plugins etc. (if not right here)
     */
    protected $appPath = false;
    protected $DS = '/'; // Some nub might want to run this on windows lol
    
    protected $pluginPath = 'plugins'; // with trailing not leading /. Relative below appPath or absolute.
    protected $pluginRegistry = array (); // remember which plugins instantiated (by alias to allow multiples of same one)
    protected $pluginsIncluded = array (); // names of plugins whose files have been require'd
    /**
     * Load a plugin into the system. Pretty well everything should be a plugin (even your app)
     * @param string $name name of plugin in CamelCase loads /plugins/Name/Name.php and instantiates new Name($options, &$BackNg);
     * @param mixed $pluginOpts array of options to be passed to the plugin OR false if the plugin is not to be instantiated (i.e. just contains defs or global whatever-stuff)
     * @param array $systemOpts options determining how the plugin is treated e.g. set different alias for loading same plugin >once, or define that plugin can be lazy loaded
     */
    function plugin ($name, $pluginOpts = array (), $systemOpts = array ()) {
        $alias = (isset ($systemOpts['alias']) ? $systemOpts['alias'] : $name);
        $className = $name.'Plugin';
        if (!in_array ($name, $this->pluginsIncluded)) { // Don't load stuff twice
            $f = "{$this->pluginPath}{$name}{$this->DS}{$name}.php";
            if (!file_exists($f)) throw new Exception ("Plugin file not found: " . $f);
            require_once ($f);
            $this->pluginsIncluded[] = $name;
        }
        if ($pluginOpts !== false) {
            if (!class_exists($className)) throw new Exception ("Plugin class not found: " . $className);
            $app =& $this;
            $$alias = new $className($pluginOpts, $app);
            $this->$alias =& $$alias;
            $this->pluginRegistry[$alias] =& $$alias;
        }
    }
    
    function despatch ($eventName) {
        $modifiers = array ('before_', 'on_', 'after_');
        foreach ($modifiers as $m) {
            $methodName = $m . $eventName;
            foreach ($this->pluginRegistry as &$p) {
                if (method_exists($p, $methodName))
                    if ($p->{$methodName}() === false)
                        return false;
            }
        }
        return true;
    }
    
    function kickAssAndChewGum () {
        $eventSequence = array ('initialise','route','parse','authorise','validate','store','finish');
        while (!empty($eventSequence)) {
            $en = array_shift($eventSequence);
            if ($this->despatch($en) === false)
                $this->despatch('error');
        }
    }
    
    function __construct($options) {
        // Setup path to include * from.
        $this->appPath = (isset ($options['appPath']) ? $options['appPath'] : implode($this->DS, array_slice (explode ($this->DS,pathinfo (__FILE__,PATHINFO_DIRNAME)), 0, -1)) . $this->DS);
        if (!file_exists($this->appPath)) throw new ErrorException ("App Path doesn't exist: " . $this->appPath);
        
        // Set plugin path
        if (isset ($options['pluginPath'])) $this->pluginPath = $options['pluginPath'];
        
        // Make all paths nice (no windows support)
        $makeNice = array (&$this->appPath, &$this->pluginPath);
        foreach ($makeNice as &$path) {
            if (substr($path,-1,1) != $this->DS) // Trailing slash
                $path .= $this->DS;
            if (substr($path,0,1) != $this->DS) // Make relative paths absolute
                $path = $this->appPath . $path;
            $path = preg_replace ('@['.$this->DS.']+@',$this->DS,$path); // Filter out accidentally added slashes
        }
        
        // Instantiate empty request and response objects
        $this->AppScope = new BNgAppScope();
        $this->Request = new BNgRequest();
        $this->Response = new BNgResponse();
    }
    
    function run () {
        $this->kickAssAndChewGum();
    }
}

?>