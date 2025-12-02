<?php
namespace App\Services;

class ReferenceService {
    protected \mysqli $conexion;
    public function __construct(\mysqli $conexion){ $this->conexion = $conexion; }

    private function fetchColumn(string $sql, string $col): array {
        $out=[]; if($res=$this->conexion->query($sql)){ while($row=$res->fetch_assoc()){ $val = $row[$col]; if($val!==''){ $out[] = $val; } } } return $out;
    }

    // Tabla 'razas' no tiene columna feedlot (inserciones sólo agregan raza).
    public function razas(string $feedlot): array {
        return $this->fetchColumn("SELECT raza FROM razas ORDER BY raza ASC","raza");
    }
    public function origenes(string $feedlot, string $seccion): array {
        $feedlotEsc = $this->conexion->real_escape_string($feedlot);
        $secEsc = $this->conexion->real_escape_string($seccion);
        return $this->fetchColumn("SELECT origen FROM origenes WHERE feedlot='$feedlotEsc' AND seccion='$secEsc' ORDER BY origen ASC","origen");
    }
    public function destinos(string $feedlot, string $seccion): array {
        $feedlotEsc = $this->conexion->real_escape_string($feedlot);
        $secEsc = $this->conexion->real_escape_string($seccion);
        return $this->fetchColumn("SELECT destino FROM destinos WHERE feedlot='$feedlotEsc' AND seccion='$secEsc' ORDER BY destino ASC","destino");
    }
    // Tabla 'causas' tampoco posee columna feedlot.
    public function causasMuertes(string $feedlot): array {
        return $this->fetchColumn("SELECT causa FROM causas ORDER BY causa ASC","causa");
    }
}
