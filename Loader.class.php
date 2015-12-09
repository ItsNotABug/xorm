<?php
/**
 * Created by PhpStorm.
 * User: alexw
 * Date: 11/22/15
 * Time: 9:42 AM
 */

namespace xorm;

use xorm\interfaces\Object;

class Loader {
    protected static $objects;
    protected static $structure_loaded = false;

    public static function registerObject($class_name) {
        if(!($class_name instanceof \xorm\Object))
            throw new \xorm\FatalException('Attempting to registerObject which is not an instanceof \\xorm\\Object');
        static::$objects[$class_name] = true;
    }

    public static function getObject($class_name) {
        if(isset(static::$objects[$class_name]))
            return static::$objects[$class_name];
        return null;
    }

    public static function getObjects() {
        return static::$objects;
    }

    public static function unregisterObject($class_name) {
        static::$objects[$class_name] = false;
    }

    public static function loadStructures() {
        foreach(static::$objects as $object) {
            $object::__structure();
        }
        static::$structure_loaded = true;
    }

    public static function updateDatabaseStructures() {
        if(!static::$structure_loaded)
            static::loadStructures();

        foreach(static::$objects as $object) {
            //validate collection exists, if not, generate create statement
            $querries[] = array();
            if(!$object::collectionExists()) {
                //generate create statement
            } else {
                //check for collection schema changes
                //first check for new columns
                //then check for dropped columns
                //then check for altered columns
                //lastly generate alter table statement
            }

            //process statements

            $querries = null;
        }
    }
}