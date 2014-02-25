<?php


class DebugPlugin extends BackNgPlugin {
    
    
    function log ($txt) {
        $this->app->Response->appendData(__CLASS__.'.log', $txt);
        return true;
    }
    function _bufferToJson () {
        $bl = ob_get_length();
        if ($bl == 0 || $bl == FALSE) return;
        $b = ob_get_contents();
        ob_clean();
        $this->app->Response->setData(__CLASS__.'.outputBuffer', $b);
        
    }
    
    function before_initialise () {
        return $this->log ('Doing ' . __FUNCTION__);
        ob_start();
    }
    
//    function before_route () {      return $this->log ('Doing ' . __FUNCTION__);    }
//    function before_parse () {      return $this->log ('Doing ' . __FUNCTION__);    }
//    function before_authorise () {  return $this->log ('Doing ' . __FUNCTION__);    }
//    function before_validate () {   return $this->log ('Doing ' . __FUNCTION__);    }
//    function before_store () {      return $this->log ('Doing ' . __FUNCTION__);    }
    
    function before_finish () {
        return $this->log ('Doing ' . __FUNCTION__);
        $this->_bufferToJson();
    }
    function before_error () {
        return $this->log ('Doing ' . __FUNCTION__);
        $this->_bufferToJson();
    }
    
//    function on_initialise () {        return $this->log ('Doing ' . __FUNCTION__);    }
//    function on_route () {             return $this->log ('Doing ' . __FUNCTION__);    }
//    function on_parse () {             return $this->log ('Doing ' . __FUNCTION__);    }
//    function on_authorise () {         return $this->log ('Doing ' . __FUNCTION__);    }
//    function on_validate () {          return $this->log ('Doing ' . __FUNCTION__);    }
//    function on_store () {             return $this->log ('Doing ' . __FUNCTION__);    }
//    function on_finish () {            return $this->log ('Doing ' . __FUNCTION__);    }
//    function on_error () {             return $this->log ('Doing ' . __FUNCTION__);    }
//    
//    function after_initialise () {  return $this->log ('Doing ' . __FUNCTION__);    }
//    function after_route () {       return $this->log ('Doing ' . __FUNCTION__);    }
//    function after_parse () {       return $this->log ('Doing ' . __FUNCTION__);    }
//    function after_authorise () {   return $this->log ('Doing ' . __FUNCTION__);    }
//    function after_validate () {    return $this->log ('Doing ' . __FUNCTION__);    }
//    function after_store () {       return $this->log ('Doing ' . __FUNCTION__);    }
//    function after_finish () {      return $this->log ('Doing ' . __FUNCTION__);    }
//    function after_error () {       return $this->log ('Doing ' . __FUNCTION__);    }
    
    
}


?>