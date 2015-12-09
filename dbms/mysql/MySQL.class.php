<?php
/**
 * Created by PhpStorm.
 * User: alexw
 * Date: 11/21/15
 * Time: 10:26 PM
 */
namespace xorm\db;

class MySQL implements \xorm\interfaces\DBMS {

    protected static $collection;
    protected static $collectionName;
    protected static $records;
    protected static $structure = array();

    protected static $conn = null;

    protected $id = null;
    protected $data=array();
    protected $new_data = array();

    public static function __structure() {
        static::__addField('id', new \xorm\db\Integer('id', 'ID',array('auto_increment'=>true)));
        static::__addIndex('id', new \xorm\db\PrimaryKey('id'));
    }

    public static function __addField($alias, $field) {
        if(!($field instanceof \xorm\db\Field))
            throw new \xorm\FatalException('Attempting to call __addField but field is not an instanceof xorm\db\Field');

        static::$structure['fields'][$alias] = $field;
    }

    public static function __addIndex($alias, $index) {
        if(!($index instanceof \xorm\db\index))
            throw new \xorm\FatalException('Attempting to call __addIndex but index is not an instanceof xorm\db\Index');

        static::$structure['indexes'][$alias]  = $index;
    }

    public static function __validateColumn($column) {
        if(!array_key_exists($column, static::$structure['fields']))
            return false;
        return true;
    }


    public function __construct($data) {
        $data = array_merge(static::$default_data, $data);

        return $this->setData($data);
    }

    public function validate($column, $data) {
        if(!static::__validateColumn($column))
            throw new \xorm\FatalException('Attempting to assign data to column '.htmlspecialchars($column).' which doesn\'t exsist on Model '.__CLASS__);

        static::$structure['fields'][$column]::validate($column, $data);

        return $this;
    }

    public function get($column) {
        if(!static::__validateColumn($column))
            throw new \xorm\FatalException('Attempting to get data from column .'.htmlspecialchars($column).' which doesn\'t exsist on Model '.__CLASS);

        if(isset($this->new_data[$column]))
            return $this->new_data[$column];
        elseif(isset($this->data[$column]))
            return $this->data[$column];
        return null;
    }

    public function getNew($column) {
        if(!static::__validateColumn($column))
            throw new \xorm\FatalException('Attempting to get new_data from column .'.htmlspecialchars($column).' which doesn\'t exsist on Model '.__CLASS);
        if(isset($this->new_data[$column]))
            return $this->new_data[$column];
        return null;
    }

    public function getOrig($column) {

        if(!static::__validateColumn($column))
            throw new \xorm\FatalException('Attempting to get original data from column .'.htmlspecialchars($column).' which doesn\'t exsist on Model '.__CLASS);
        if(isset($this->data[$column]))
            return $this->data[$column];
        return null;
    }

    public function set($column, $data) {
        if(static::validate($column, $data))
            $this->new_data[$column] = $data;
        return $this;
    }

    public function setData($data) {
        foreach($data as $column=>$value) {
            $this->set($column, $value);
        }
    }

    public function save()
    {
        // TODO: Implement save() method.
    }

    public static function load($id)
    {
        // TODO: Implement load() method.
    }

    public static function loadList($filters)
    {
        // TODO: Implement loadList() method.
    }

    public static function collectionExists() {
        $conn = static::$conn;
        if(is_null(static::$collection))
            return false;
        elseif($conn->query('SHOW TABLES LIKE "'.$conn->real_escape_string(static::$collection).'"')->num_rows==1)
            return true;
        return false;
    }

    public static function createCollection() {
        $conn = static::$conn;
        $query = 'CREATE TABLE '.$conn->real_escape_strin(static::$collection).' {';
        foreach(static::$structure['fields'] AS $field) {
            $query .= "\n\t".$field::generateCreateStatement().',';
        }

        foreach(static::$structure['indexes'] as $index) {
            $query .= "\n\t".$index::generateCreateStatement().',';
        }

        $query = substr($query, 0, strlen($query)-1);
        $query .= "\n".'} ';

        return $query;
    }

    public static function updateCollection() {
        $conn = static::$conn;

        $descriptions = array();
        foreach($conn->query("DESCRIBE ".$conn->real_escape_string(static::$collection))->fetch_array() as $row) {
            $descriptions[$row['field']] = $row;
        }

        foreach(static::$structure['fields'] as $column) {
            if(!array_key_exists($column, $descriptions)) {
                $parts[] = 'ADD COLUMN '.$column->generateStructure();
            } elseif($column->structureChanged($descriptions[$column])) {
                $parts[] = 'ALTER COLUMN '.$column->generateStructure();
            }
        }

        foreach($descriptions as $column=>$structure) {
            if(!array_key_exists($column, static::$structure['fields'])) {
                $parts[] = 'DROP COLUMN '.$conn->real_escape_string($column);
            }
        }

        $keys = array();
        foreach($conn->query('SHOW KEYS FROM '.$conn->real_escape_string(static::$collection))->fetch_array() as $row) {
            $keys[$row['key_name']] = $row;
        }

        foreach(static::$structure['indexes'] AS $alias=>$index) {
            if(!array_key_exists($alias, $keys)) {
                $parts[] = $index::generateStructure();
                //TODO: check syntax for properly creating indexes
            }
            elseif($index->structureChanges($keys[$alias])) {
                $parts[] = $index::generateStructure();
                //TODO: check syntax for properly altering indexes. Is this even needed?
            }
        }

        foreach($keys as $alias=>$index) {
            if(!array_key_exists($index, static::$structure['fields'])) {
                $parts[] = 'DROP INDEX '.$conn->real_escape_string($alias);
                //TODO: check syntax for properly dropping indexes
            }
        }

        if(count($parts)>0) {
            $query = 'ALTER TABLE `' . $conn->real_escape_string(static::$collection) . '` {';
            $query .= implode(",\n\t", $parts);
            $query .= "\n}";

            if (!$conn->query($query))
                throw new \xorm\FatalException('Failed to execute the ALTER TABLE statement for collection ' . htmlspecialchars(static::$collection));
        }
        return true;
    }
}

//TODO: make generateStructure method on columns
//TODO: make structureChanged method on columns
//TODO: rename xorm/dbms/mysql/MySQL.class.php to xorm/dbms/mysql/Object.class.php for additional transparency