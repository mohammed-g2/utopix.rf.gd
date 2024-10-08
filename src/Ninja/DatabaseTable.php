<?php

namespace Ninja;

use \PDO;
use \PDOException;
use \DateTime;


/**
 * preforms database queries
 * @method int total() get total number of entries stored in table
 * @method array | false getById(string $id) get entry by id
 * @method array filterBy(array $values) get entries by specified columns
 * @method array getAll() get all entries in table
 * @method true save(array $record) will attempt to insert entry, 
 *         if failed attempt to update it, entry's id must be provided for update
 * @method true delete(string $id) delete an entry by id
 */
class DatabaseTable
{
    private PDO $pdo;
    private string $table;
    private string $primaryKey;
    private string $className;
    private array $constructorArgs;

    /**
     * @param PDO $pdo - database connection
     * @param string $table - database table name
     * @param string $primaryKey - database table's primary key 
     */
    public function __construct(
        PDO $pdo, string $table, string $primaryKey, 
        string $className='\stdClass', array $constructorArgs=[])
    {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->className = $className;
        $this->constructorArgs = $constructorArgs;
    }

    public function __toString(): string
    {
        return sprintf('<DatabaseTable %s>', $this->table);
    }

    /**
     * return the total number of entries in the table
     */
    public function total(): int
    {
        $sql = 'SELECT COUNT(*) FROM `' . $this->table . '`';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch()[0];
    }

    /**
     * find an entry by id
     */
    public function getById(string $id): object | null
    {
        $sql = 'SELECT * FROM `' . $this->table . '` WHERE `' . $this->table . '`.`id` = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $entry = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,
            $this->className, $this->constructorArgs)[0];
        return $entry;
    }

    /**
     * find an entry by specified columns
     */
    public function filterBy(array $values, ?string $orderBy=null, int $limit=0, int $offset=0): array
    {
        $sql = 'SELECT * FROM `' . $this->table . '` WHERE ';
        foreach ($values as $key => $val) {
            $sql .= '`' . $this->table . '`.`' . $key . '` = ' . ':' . $key . ',';
        }
        $sql = rtrim($sql, ',');
        if ($orderBy !== null) {
            $sql .= ' ORDER BY ' . $orderBy;
        }
        if ($limit !== 0) {
            $sql .= ' LIMIT ' . $limit;
        }
        if ($offset !== 0) {
            $sql .= ' OFFSET ' . $offset;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,
            $this->className, $this->constructorArgs);
    }

    /**
     * get all entries in table
     */
    public function getAll(?string $orderBy=null, int $limit=0, int $offset=0): array
    {
        $sql = 'SELECT * FROM `' . $this->table . '`';
        if ($orderBy !== null) {
            $sql .= ' ORDER BY ' . $orderBy;
        }
        if ($limit !== 0) {
            $sql .= ' LIMIT ' . $limit;
        }
        if ($offset !== 0) {
            $sql .= ' OFFSET ' . $offset;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,
            $this->className, $this->constructorArgs);
        return $entries;
    }

    /**
     * insert an entry into the table
     * @return true
     */
    private function insert(array $values): bool
    {
        $sql = 'INSERT INTO `' . $this->table . '` SET ';
        foreach ($values as $key => $val) {
            $sql .= '`' . $this->table . '`.`' . $key . '` = :' . $key . ',';
        }
        $sql = rtrim($sql, ',');
        $values = $this->processDate($values);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        return $this->pdo->lastInsertId();
    }

    /**
     * update given entry
     * @return true
     */
    private function update(array $values): bool
    {
        $sql = 'UPDATE `' . $this->table . '` SET ';
        foreach ($values as $key => $val) {
            $sql .= '`' . $this->table . '`.`' . $key . '` = :' . $key . ',';
        }
        $sql = rtrim($sql, ',');
        $sql .= ' WHERE `' . $this->table . '`.`id` = :id';
        $values = $this->processDate($values);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        return true;
    }

    /**
     * will attempt to insert entry, if failed will attempt to update it,
     * entry's id must be provided for update, returns the saved record
     * as instance of given entity class
     * @return true
     */
    public function save(array $record): object
    {
        $entity = new $this->className(...$this->constructorArgs);
        try {
            if (empty($record[$this->primaryKey])) {
                unset($record[$this->primaryKey]);
            }
            $insertId = $this->insert($record);
            $entity->{$this->primaryKey} = $insertId;
        } catch (PDOException $e) {
            $this->update($record);
        }
        foreach ($record as $key => $val) {
            if (!empty($val)) {
                if ($val instanceof \DateTime) {
                    $val = $val->format('Y:m:d H:i:s');
                }
                $entity->$key = $val;
            }
        }
        return $entity;
    }

    /**
     * delete entry by id
     * @return true
     */
    public function delete(string $id): bool
    {
        $sql = 'DELETE FROM `%s` WHERE `id` = :id';
        $sql = sprintf($sql, $this->table);
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return true;
    }

    /**
     * format fields that are instance of DateTime
     */
    private function processDate(array $values): array
    {
        foreach ($values as $key => $val) {
            if ($val instanceof DateTime) {
                $values[$key] = $val->format('Y-m-d H-i-s');
            }
        }
        return $values;
    }
}
