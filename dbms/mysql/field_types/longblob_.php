<?php
/**
 * Created by PhpStorm.
 * User: alexw
 * Date: 11/22/15
 * Time: 1:38 PM
 * @desc String 0 - 4,294,967,295
 */

namespace xorm;

class longblob_ extends \xorm\db\Field implements \xorm\interfaces\Field {
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
