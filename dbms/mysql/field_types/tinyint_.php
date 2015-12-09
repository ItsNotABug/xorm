<?php
/**
 * Created by PhpStorm.
 * User: alexw
 * Date: 11/22/15
 * Time: 1:41 PM
 * @desc Integer -128 to 127
 */

namespace xorm;

class tinyint_ extends \xorm\db\Field implements \xorm\interfaces\Field {
    protected static $allowed_options = array();

    public function validate($column, $data)
    {
        // TODO: Implement validate() method.
    }

    public function generateStructure()
    {
        // TODO: Implement generateStructure() method.
    }

    public function structureChanged()
    {
        // TODO: Implement structureChanged() method.
    }
}