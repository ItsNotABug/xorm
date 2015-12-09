<?php
/**
 * Created by PhpStorm.
 * User: alexw
 * Date: 11/21/15
 * Time: 10:30 PM
 */

namespace xorm\interfaces;

interface DBMS {
    public static function __structure();
    public static function __addField($alias, $field);
    public static function __addIndex($alias,$index);
    public static function __validateColumn($column);
    public function __construct($data);

    public function validate($column,$data);
    public function set($column,$data);
    public function setData($data);
    public function get($column);
    public function getNew($column);
    public function getOrig($column);

    public function save();

    public static function load($id);
    public static function loadList($filters);

    public static function collectionExists();
}