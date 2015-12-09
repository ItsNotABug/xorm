<?php
/**
 * Created by PhpStorm.
 * User: alexw
 * Date: 11/21/15
 * Time: 10:11 PM
 */

    CONST XORM_PATH = 'xorm/';
    CONST XORM_DBMS = 'mysql';

    require_once(XORM_PATH.'Exceptions.php');
    $xorm_interfaces = scandir(XORM_PATH.'interfaces/');
    foreach($xorm_interfaces as $xorm_interface) {
        if($xorm_interface != '.' && $xorm_interface != '..' && substr($xorm_interface, -4)=='.php')
            require_once(XORM_PATH.'interfaces/'.$xorm_interface);
    }


    unset($xorm_interfaces);

    require_once(XORM_PATH.'dbms/'.XORM_DBMS.'/dbms_init.php');

/* TODO: write xorm\Loader
        register(\xorm\Object $object)
        generateStructure()

        updateDatabaseStructure()

TODO: check file namespaces and make sure everything is accurate
TODO: write save, load, loadList methods for xorm\dbms\MySQL
TODO: figure out filters (And, Or, Equals, In, NotEquals, GreaterThan, GreaterThanEqualTo, LessThan, LessThanEqualTo, NotIn, Like)
TODO: create objects for various MySQL field types.
TODO: Cross reference MySQL field types to Mongo, PostgreSQL, MSSQL, and Oracle*
TODO: Cross reference indexes / filters to Mongo, PostgreSQL, MSSQL, and Oracle
TODO: investigate PDO library
*/