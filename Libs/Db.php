<?php

class Db
{
    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * @var int
     */
    protected $affectedRows = 0;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function execute($sql, $params = array())
    {
        try {
            $stmt               = $this->pdo->prepare($sql);
            $return             = $stmt->execute($params);
            $this->affectedRows = $stmt->rowCount();
            return $return;
        } catch (PDOExecption $ex) {
            throw new Exception("Database Error: " . $ex->getMessage());
        }
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function rows($sql, $params = array())
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $this->affectedRows = $stmt->rowCount();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOExecption $ex) {
            throw new Exception("Database Error: " . $ex->getMessage());
        }
    }

    /**
     * @param string $sql
     * @param array $params
     * @return object|bool
     */
    public function row($sql, $params = array())
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $this->affectedRows = $stmt->rowCount();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOExecption $ex) {
            throw new Exception("Database Error: " . $ex->getMessage());
        }
    }

    /**
     * @param string $sql
     * @param array $params
     * @return int
     */
    public function numRows($sql, $params = array())
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $this->affectedRows = $stmt->rowCount();
            return $this->getAffectedRows();
        } catch (PDOExecption $ex) {
            throw new Exception("Database Error: " . $ex->getMessage());
        }
    }

    /**
     * @return int
     */
    public function getAffectedRows()
    {
        return $this->affectedRows;
    }

    /**
     * @return int
     */
    public function getInsetId()
    {
        return $this->pdo->lastInsertId;
    }

}
