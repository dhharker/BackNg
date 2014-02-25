<?php

abstract class getSetData {
    public $data = array ();
    function &_getPtr ($where) {
        $ptr =& $this->data;
        if ($where == false) return $ptr;
        $path = is_array ($where) ? $where : explode(".", $where);
        while (!empty ($path)) {
            $key = array_shift($path);
            if (!isset ($ptr[$key]))
                $ptr[$key] = array ();
            $ptr =& $ptr[$key];
        }
        return $ptr;
    }
    function setData ($where,$data) {
        $ptr =& $this->_getPtr($where);
        $ptr = $data;
    }
    function appendData ($where,$data) {
        $ptr =& $this->_getPtr($where);
        if (!is_array ($ptr))
            $ptr = array ($ptr);
        $ptr[] = $data;
    }
    function getData($where = false) {
        $ptr =& $this->_getPtr($where);
        return $ptr;
    }
}

?>