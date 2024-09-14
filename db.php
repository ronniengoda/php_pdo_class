<?php
class Database {
    private $pdo;
    private $stmt;

    public function __construct($host, $dbname, $user, $pass) {
        try {
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
            $this->pdo = new PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function query($sql, $params = []) {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($params);
        return $this;
    }

    public function fetchAll() {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetch() {
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount() {
        return $this->stmt->rowCount();
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
    
    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $this->query($sql, array_values($data));
        return $this->lastInsertId();
    }
    
    public function update($table, $data, $where) {
        // Prepare the SET part of the query
        $setClause = implode(", ", array_map(function($key) {
            return "$key = ?";
        }, array_keys($data)));
        
        // Prepare the WHERE part of the query
        $whereClause = implode(" AND ", array_map(function($key) {
            return "$key = ?";
        }, array_keys($where)));
        
        // Build the full SQL query
        $sql = "UPDATE $table SET $setClause WHERE $whereClause";
        
        // Execute the query with combined data and where values
        $this->query($sql, array_merge(array_values($data), array_values($where)));
        return $this->rowCount();
    }

    public function close() {
        $this->pdo = null;
    }
}
