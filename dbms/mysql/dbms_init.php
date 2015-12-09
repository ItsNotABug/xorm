<?php
/**
 * Created by PhpStorm.
 * User: alexw
 * Date: 11/21/15
 * Time: 10:18 PM
 */


    namespace xorm\db;

    CONST DBMS_PATH = XORM_PATH.'dbms/mysql/';

    require_once(xorm\dbms\mysql\DBMS_PATH.'Field.class.php');
    require_once(xorm\dbms\mysql\DBMS_PATH.'Index.class.php');

    $xorm_field_types = scandir(xorm\dbms\mysql\DBMS_PATH.'field_types/');
    foreach($xorm_field_types as $xorm_field_type) {
        if($xorm_field_type != '.' && $xorm_field_type != '..' && substr($xorm_field_type,-4) =='.php')
            require_once(xorm\dbms\mysql\DBMS_PATH.'field_types/'.$xorm_field_type);
    }

    unset($xorm_field_types, $xorm_field_type);

    $xorm_indexes = scandir(xorm\dbms\mysql\DBMS_PATH.'field_indexes/');

    foreach($xorm_indexes as $xorm_index) {
        if($xorm_index != '.' && $xorm_index != '..' && substr($xorm_index,-4) == '.php')
            require_once(xorm\dbms\mysql\DBMS_PATH.'field_indexes/'.$xorm_index);
    }
    unset($xorm_indexes, $xorm_index);

    require_once(xorm\dbms\mysql\DBMS_PATH.'MySQL.class.php');

