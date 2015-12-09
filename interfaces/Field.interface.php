<?php
/**
 * Created by PhpStorm.
 * User: alexw
 * Date: 11/21/15
 * Time: 10:31 PM
 */

namespace xorm\interfaces;
interface Field {
    public function validate($column, $data);

    public function generateStructure();
    public function structureChanged();
}