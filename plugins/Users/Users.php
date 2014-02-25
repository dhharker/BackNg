<?php


class UsersPlugin {
    
    protected $options = array ();
    protected $app = null;
    var $schema = array (
        'users' => array (
            'first_name' => array (
                'type' => 'string',
                'length' => 30
            ),
            'last_name' => array (
                'type' => 'string',
                'length' => 30
            ),
            'username' => array (
                'type' => 'string',
                'length' => 30
            ),
            'password' => array (
                'type' => 'hash'
            ),
        )
    );
    
    
}


?>