<?php
namespace App\Services;

class BaseService {
    protected \mysqli $db;

    public function __construct(?\mysqli $conexion = null) {
        if($conexion) { $this->db = $conexion; }
        else { $this->db = $GLOBALS['conexion']; }
    }

    protected function esc(string $value): string {
        return $this->db->real_escape_string($value);
    }

    protected function fetchAll(string $sql): array {
        $res = $this->db->query($sql);
        $out = [];
        if($res){ while($row = $res->fetch_assoc()){ $out[] = $row; } }
        return $out;
    }

    protected function fetchOne(string $sql): ?array {
        $res = $this->db->query($sql);
        if($res && ($row = $res->fetch_assoc())) return $row;
        return null;
    }
}
