<?php

class DbSingleton
{

    /**
     * @var mixed
     */
    private static $dbInstance;

    private function __construct()
    {}

    protected static function GetDbInstance()
    {
        if (is_null(self::$dbInstance)) {
            die("Db Instance not set");
        }
        return self::$dbInstance;
    }

    /**
     * @param $sql
     * @param array $params
     */
    public static function Execute($sql, array $params = array())
    {
        return self::GetDbInstance()->execute($sql, $params);
    }

    /**
     * @param $sql
     * @param array $params
     */
    public static function Rows($sql, array $params = array())
    {
        return self::GetDbInstance()->rows($sql, $params);
    }

    /**
     * @param $sql
     * @param array $params
     */
    public static function Row($sql, array $params = array())
    {

        return self::GetDbInstance()->row($sql, $params);
    }

    /**
     * @param $sql
     * @param array $params
     */
    public static function NumRows($sql, array $params = array())
    {
        return self::GetDbInstance()->numRows($sql, $params);
    }

    public static function GetAffectedRows()
    {
        return self::GetDbInstance()->getAffectedRows();
    }

    public static function GetInsertId()
    {
        return self::GetDbInstance()->getInsertId();
    }

    /**
     * @param Db $dbInstance
     */
    public static function SetDbInstance(Db $dbInstance)
    {
        self::$dbInstance = $dbInstance;
    }

}
