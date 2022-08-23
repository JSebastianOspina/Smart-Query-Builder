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
    //Insert
    private $isInsert = false;
    private $insertStatement = '';

    //Limit
    private $hasLimit = false;
    private $limitStatement = '';

    /**
     * @param $table
     */
    public function __construct($table)
    {
        $this->table = $table;

        //Clear query's strings
        $this->fieldsString = '';
        $this->filtersString = 'WHERE 1 = 1';
    }

    public static function table($tableName): SmartQueryBuilder
    {
        return new SmartQueryBuilder($tableName);
    }


    public function select(array $fields): SmartQueryBuilder
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


    public function where($column, $operator, $value): SmartQueryBuilder
    {
        $string = "$column $operator $value";
        $this->filtersString .= " AND $string";
        return $this;
    }

    public function update(array $columns): SmartQueryBuilder
    {
        $this->isUpdate = true;
        $this->updateStatement = "UPDATE $this->table SET ";
        foreach ($columns as $key => $column) {
            $this->updateStatement .= "$key = $column, ";
        }
        return $this;
    }

    public function insert(array $columns): SmartQueryBuilder
    {
        $this->isInsert = true;
        $this->insertStatement = "INSERT INTO $this->table (";
        foreach ($columns as $key => $column) {
            if ($key === array_key_last($columns)) {
                $this->insertStatement .= "$key) ";
            } else {
                $this->insertStatement .= "$key, ";
            }
        }
        $this->insertStatement .= "VALUES (";
        foreach ($columns as $key => $column) {
            if ($key === array_key_last($columns)) {
                $this->insertStatement .= "'$column')";
            } else {
                $this->insertStatement .= "'$column', ";
            }
        }
        return $this;
    }

    /**
     * @throws \Exception
     */
    public function limit(int $limit, int $offset = 0): SmartQueryBuilder
    {
        if ($limit < 0) {
            throw new \RuntimeException('You must specify a limit value greather than 0');
        }
        $this->hasLimit = true;
        $this->limitStatement = "LIMIT $offset,$limit";
        return $this;
    }

    public function getQuery(): ?string
    {
        if ($this->isSelect) {
            $query = $this->selectStatement
                . ' WHERE ' . $this->filtersString;
            //extra
        } else if ($this->isUpdate) {
            $query = $this->updateStatement
                . ' WHERE ' . $this->filtersString;
            //extra
        } else if ($this->isInsert) {
            $query = $this->insertStatement;
        } else {
            throw new \RuntimeException('You must specify at least one SQl statement');
        }

        //Add clauses
        if ($this->hasLimit) {
            $query .= " $this->limitStatement";
        }
        $this->query = $query . ';'; //Ending query
        return $this->query;
    }


}

