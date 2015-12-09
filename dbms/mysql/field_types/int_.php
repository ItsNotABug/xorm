<?php
/**
 * Created by PhpStorm.
 * User: alexw
 * Date: 11/21/15
 * Time: 10:27 PM
 */
namespace xorm\db;

//validate
//generateStructure
//structureChanged logic

/*
 * 1) validate
 * 2) generateStructure
 *      Options need to be specified in proper order in the configuration. EX length, not null, default value, auto_increment.
 *      Each option needs a create statement & a validate statement. Option validation should be handled whenever generateStructure is called. Options only really need validated before we alter the structure.
 *
 * 3) structureChanged
 *      Each option needs a code-block that handles if an assigned option has changed in the structure. This should handle initialization, logic, & return true if structure has changed. Do nothing if elements structure hasn't changed as the method will always return false at the end.
 *
 */
class int_ extends \xorm\db\Field implements \xorm\interfaces\Field {
    protected static $allowed_options = array('auto_increment','default','not_null');

    public function validate($column, $data)
    {
        // TODO: Implement validate() method.
    }

    public function generateStructure() {
        $structure = $this->alias .' int';
        if(isset($this->options['length']) && is_numeric($this->options['length']))
            $structure .= '('.$this->options['length'].')';
        if(isset($this->options['unsigned']) && $this->options['unsigned'] === true)
                $structure .= ' UNSIGNED';
        if(isset($this->options['not_null']))
            $structure .= ' NOT NULL';
        if(isset($this->options['default']) && is_numeric($this->options['default']))
            $structure .= ' DEFAULT "'.$this->options['default'].'"';
        if(isset($this->options['auto_increment']) && $this->options['auto_increment'] === true)
            $structure .= ' AUTO INCREMENT';
        return $structure;
    }

    public function structureChanged($describe_record) {
        $currentType = 'int';
        if(isset($this->options['length']) && is_numeric($this->options['length']))
            $currentType .='('.$this->options['length'].')';
        if(isset($this->options['unsigned']) && $this->options['unsigned'] === true)
            $currentType .= 'unsigned';




        $currentNull = (isset($this->options['not_null']) && $this->options['not_null']===true) ? 'NO' : 'YES';
        if($describe_record['null'] == $currentNull) {
            return true;
        }

        if(strtolower($describe_record['extra']) == 'auto_increment' && (!isset($this->options['auto_increment']) || $this->options['auto_increment'] !== true)) {
            return true;
        }

        $currentDefault = (isset($this->options['default'])) ? $this->options['default'] : null;
        if($describe_record['default'] != $currentDefault) {
            return true;
        }
        return false;
    }
}