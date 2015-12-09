<?php
/**
 * Created by PhpStorm.
 * User: alexw
 * Date: 11/21/15
 * Time: 11:22 PM
 */

namespace project;
    require_once('xorm_init.php');

    class User extends \xorm\Object implements \xorm\interfaces\Object {
        public static function __structure() {
            parent::__structure();
            static::__addField('firstName', new \xorm\Str('firstName','First Name', array('length'=>60)));
            static::__addField('lastName', new \xorm\Str('lastName', 'Last Name', array('length'=>60)));
            static::__addField('username', new \xorm\Str('username', 'Username', array('length'=>'160')));
            return parent::__structure();
        }
    }