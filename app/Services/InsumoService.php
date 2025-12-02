<?php
namespace App\Services;

/**
 * Servicio para encapsular lógica de Insumos y Fórmulas.
 * Sustituye helpers legacy: nombreInsumo, precioInsumo, tomaPorcentajeMS, obtenerMSinsumo,
 * porceMS, porcentajeMS, traerNombreInsumo, dataInsumoPremix, obtenerTipoInsumo.
 */
class InsumoService {
    /** @var array<int,array<string,mixed>> Cache simple por id de insumo */
    protected array $cacheInsumos = [];

    /** Obtiene fila completa de insumos por id con caché. */
    public function getInsumoById(int $id, \mysqli $conexion): ?array {
        if(isset($this->cacheInsumos[$id])) { return $this->cacheInsumos[$id]; }
        $idEsc = $conexion->real_escape_string((string)$id);
        $sql = "SELECT * FROM insumos WHERE id = '$idEsc' LIMIT 1";
        if(($res = $conexion->query($sql)) && ($row = $res->fetch_assoc())) {
            $this->cacheInsumos[$id] = $row;
            return $row;
        }
        return null;
    }

    /** Obtiene nombre de insumo por id (traerNombreInsumo). */
    public function getNombre(int $id, \mysqli $conexion): ?string {
        $row = $this->getInsumoById($id, $conexion);
        return $row['insumo'] ?? null;
    }

    /** Obtiene tipo de insumo por nombre (obtenerTipoInsumo). */
    public function getTipoByNombre(string $nombre, \mysqli $conexion): ?string {
        $nombreEsc = $conexion->real_escape_string($nombre);
        $sql = "SELECT tipo FROM insumos WHERE insumo = '$nombreEsc' LIMIT 1";
        if(($res = $conexion->query($sql)) && ($row = $res->fetch_assoc())) { return $row['tipo'] ?? null; }
        return null;
    }

    /** Porcentaje de MS del insumo por id (obtenerMSinsumo). */
    public function getPorcentajeMS(int $id, \mysqli $conexion): float {
        $row = $this->getInsumoById($id, $conexion);
        return isset($row['porceMS']) ? (float)$row['porceMS'] : 0.0;
    }

    /** Calcula % MS aplicado según porcentaje (porceMS). */
    public function computeAplicadoMS(int $idInsumo, float $porcentaje, \mysqli $conexion): float {
        $porceMS = $this->getPorcentajeMS($idInsumo, $conexion);
        return round($porcentaje * ($porceMS / 100), 4);
    }

    /** Calcula porcentaje MS dado un porcentaje y un valor de porceMS (porcentajeMS). */
    public function computePorcentajeMS(float $porcentaje, float $porcentajeMSinsumo): float {
        return round($porcentaje * ($porcentajeMSinsumo / 100), 4);
    }

    /** Obtiene datos de insumo premix (dataInsumoPremix). */
    public function getPremixCampo(int $id, string $campo, \mysqli $conexion): mixed {
        // Validación mínima de campo para evitar inyección de columna.
        if(!preg_match('/^[a-zA-Z0-9_]+$/', $campo)) { return null; }
        $idEsc = $conexion->real_escape_string((string)$id);
        $sql = "SELECT `$campo` FROM insumospremix WHERE id = '$idEsc' LIMIT 1";
        if(($res = $conexion->query($sql)) && ($row = $res->fetch_assoc())) { return $row[$campo] ?? null; }
        return null;
    }

    /**
     * Consulta join formulas + insumos para un slot de fórmula.
     * Reemplaza nombreInsumo, precioInsumo, tomaPorcentajeMS.
     * $slotColumn es el nombre de la columna en formulas que referencia ID de insumo.
     */
    protected function queryFormulaSlot(string $slotColumn, int $insumoId, \mysqli $conexion): ?array {
        // Validar nombre de columna (patrón básico). Ideal: lista blanca.
        if(!preg_match('/^[a-zA-Z0-9_]+$/', $slotColumn)) { return null; }
        $insumoEsc = $conexion->real_escape_string((string)$insumoId);
        // La condición insumos.id = '$insumoEsc' garantiza coincidencia específica.
        $sql = "SELECT insumos.* FROM formulas INNER JOIN insumos ON formulas.$slotColumn = insumos.id WHERE insumos.id = '$insumoEsc' LIMIT 1";
        if(($res = $conexion->query($sql)) && ($row = $res->fetch_assoc())) { return $row; }
        return null;
    }

    /** Nombre de insumo según slot de fórmula (nombreInsumo). */
    public function getNombreFromFormulaSlot(string $slotColumn, int $insumoId, \mysqli $conexion): ?string {
        $row = $this->queryFormulaSlot($slotColumn, $insumoId, $conexion);
        return $row['insumo'] ?? null;
    }

    /** Precio de insumo según slot (precioInsumo). */
    public function getPrecioFromFormulaSlot(string $slotColumn, int $insumoId, \mysqli $conexion): float {
        $row = $this->queryFormulaSlot($slotColumn, $insumoId, $conexion);
        return isset($row['precio']) ? (float)$row['precio'] : 0.0;
    }

    /** Porcentaje MS según slot (tomaPorcentajeMS). */
    public function getPorcentajeMSFromFormulaSlot(string $slotColumn, int $insumoId, \mysqli $conexion): float {
        $row = $this->queryFormulaSlot($slotColumn, $insumoId, $conexion);
        return isset($row['porceMS']) ? (float)$row['porceMS'] : 0.0;
    }

    /** Limpia cache (p.e. tras actualizaciones masivas). */
    public function clearCache(): void { $this->cacheInsumos = []; }
}
