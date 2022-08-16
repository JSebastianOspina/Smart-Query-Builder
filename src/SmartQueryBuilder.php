<?php

namespace Ospina\SmartQueryBuilder;

class SmartQueryBuilder
{
    private $table;
    private $fields;
    private $filters;
    private $joins;
    private $query;
    //Select
    private $isSelect = false;
    private $selectStatement = '';
    private $fieldsString;
    private $filtersString;
    //Update
    private $isUpdate = false;
    private $updateStatement = '';

    /**
     * @param $table
     */
    public function __construct($table)
    {
        $this->table = $table;

        //Clear query's strings
        $this->fieldsString = '';
        $this->filtersString = '';
    }

    public static function table($tableName)
    {
        return new SmartQueryBuilder($tableName);
    }


    public function select(array $fields)
    {
        $this->isSelect = true;

        foreach ($fields as $key => $field) {
            if ($this->fieldsString === '') {
                $this->fieldsString .= $field;
            } else {
                $this->fieldsString .= ",$field";
            }
        }
        $this->selectStatement = "SELECT $this->fieldsString FROM $this->table ";

        return $this;
    }


    public function where($column, $operator, $value)
    {
        $string = "$column $operator $value";

        if ($this->filtersString === '') {
            $this->filtersString .= $string;
        } else {
            $this->filtersString .= " AND $string";
        }
        return $this;
    }

    public function update(array $columns)
    {
        $this->isUpdate = true;
        $this->updateStatement = "UPDATE $this->table SET ";
        foreach ($columns as $key => $column) {
            $this->updateStatement .= "$key = $column, ";
        }
        return $this;

    }

    public function getQuery()
    {
        if ($this->isSelect) {
            $query = $this->selectStatement
                . ' WHERE ' . $this->filtersString
                //extra
                . ';';
            $this->query = $query;
        } else if ($this->isUpdate) {
            $query = $this->updateStatement
                . ' WHERE ' . $this->filtersString
                //extra
                . ';';
            $this->query = $query;
        } else {
            $query = null;
        }

        return $query;
    }


}

