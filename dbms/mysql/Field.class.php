<?php
/**
 * Created by PhpStorm.
 * User: alexw
 * Date: 11/21/15
 * Time: 10:27 PM
 */

namespace xorm\db;

class Field {
    protected $alias = null;
    protected $label = null;
    protected $options = array();
    protected static $allowed_options = array();

    public function __construct($alias, $label, $options=null) {
        $this->setAlias($alias)->setLabel($label)->setOptions($options);
        return $this;
    }

    public function setAlias($alias) {
        if(is_null($alias)) {
            throw new \xorm\FatalException('Attempting to set field ID of null');
        }
        $this->alias=$alias;

        return $this;
    }

    public function setLabel($label) {
        if(is_null($label))
            throw new \xormFatalException('Attempting to set field label of null');
        $this->label = $label;

        return $this;
    }

    public function setOptions($options=null) {
        if(is_array($options)) {
            foreach($options as $option=>$value) {
                $option = strtolower($option);
                if(!in_array($option,static::$allowed_options))
                    throw \xorm\FatalException('Attempting to set invalid / disallowed field option.');
                $this->options[$option] = $value;
            }
        }
        return $this;
    }
}