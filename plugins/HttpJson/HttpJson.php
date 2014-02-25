<?php


class HttpJsonPlugin extends BackNgPlugin {
    
    protected $responseType = 'json';
    
    function _setResponseType ($rt) {
        $this->responseType = ($rt == 'jsonp' ? $rt : 'json');
    }
    
    function on_initialise () {
        if (isset ($_REQUEST['data'])) {
            $data = json_decode($_REQUEST['data']);
            $this->app->Request->setData(isset ($data) ? $data : array ());
        }
    }
    
    
    function on_finish () {
        $json = json_encode ($this->app->Response->getData());
        switch ($this->responseType) {
            case "json":
                header('Content-type: application/json');
                echo $json;
                break;
            case "jsonp":
                header('Content-type: text/javascript');
                echo $json;
                break;
        }
    }
    
    
}


?>