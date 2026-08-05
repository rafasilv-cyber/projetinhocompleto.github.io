<?php

class Database
{
    private static $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $dsn = "mysql:host=localhost;dbname=gestao;charset=utf8";
            $usuario = "root";
            $senha = "";

            try {
                self::$instance = new PDO($dsn, $usuario, $senha);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Erro na conexão com o banco de dados: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}