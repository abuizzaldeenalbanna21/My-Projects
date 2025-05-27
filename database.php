<?php
require_once 'config.php';

class Database {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    // Create
    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Read (all rows or with condition)
    public function select($table, $where = '', $params = []) {
        $sql = "SELECT * FROM $table";
        if (!empty($where)) {
            $sql .= " WHERE $where";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update
    public function update($table, $data, $where, $params = []) {
        $setStr = '';
        foreach ($data as $key => $value) {
            $setStr .= "$key = :$key, ";
        }
        $setStr = rtrim($setStr, ", ");
        
        $sql = "UPDATE $table SET $setStr WHERE $where";
        $stmt = $this->conn->prepare($sql);
        
        return $stmt->execute(array_merge($data, $params));
    }

    // Delete
   public function delete($table, $conditions) {
    $keys = array_keys($conditions);
    $where = implode(" = ? AND ", $keys) . " = ?";
    $values = array_values($conditions);

    $sql = "DELETE FROM $table WHERE $where";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute($values);
}
}
?>
