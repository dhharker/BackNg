<?php

/*
 * BackNg = a RESTful backend for Angularjs apps
 * It only speaks JSON for now. Works a bit like node's middleware with plugins (but less well designed obv!)
 * 
 * Features:
 *  MongoDB backend
 *  Scaffold JSON REST API based on your schema
 *  Validation
 *      Fields
 *      Integrity
 *  Schemas
 *      Contain field & integrity validators/rules (can be simple strings or functions)
 *      Explicitly define mobility (data allowed to leave the server? Which fields, related docs? Can be functions)
 *      Field types extensible. If you add a "media manager" plugin you can e.g. define a field as type "MediaManager.Gallery" and leave it at that.
 *  
 * Plugins:
 *  Everything is a plugin. Plugins are transparent to frontend.
 *  Examples:
 *      Provide user signup, login, session, administration etc.
 *      
 * 
 * Flow:
 *  Request to REST endpoint (dynamic) with data for CRUD action
 *  Authorise request (read/write permission inc. in associated/nested documents) (C/R/U/D)
 *  Validate data (C/U)
 *  DB i/o
 *  JSON response
 *  
 */


$coreFiles = array (
    'core/getSetData.class.php',
        'core/BNgRequest.class.php',
        'core/BNgResponse.class.php',
        'core/BNgAppScope.class.php',
    'core/BackNgPlugin.class.php',
    'core/BackNg.class.php',
    'config/dbConfig.var.php'
);
foreach ($coreFiles as $cf)
    require_once $cf;


// Instantiate BackNg
$app = new BackNg();

// Add core plugins and config and shit
// @TODO support lazy loading plugins
$app->plugin('Debug', array(), array ('alias' => 'Log'));
$app->plugin('HttpJson');
$app->plugin('Mongo',$dbConfig);
$app->plugin('DbMagic');
$app->plugin('Users');

// Ready to rock!
$app->run();









?>
