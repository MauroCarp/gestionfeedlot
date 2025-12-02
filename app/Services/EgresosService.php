<?php
namespace App\Services;

class EgresosService extends BaseService {
    public function totales(string $feedlot, string $hasta): array {
        $f = $this->esc($feedlot); $h = $this->esc($hasta);
        $rowCant = $this->fetchOne("SELECT SUM(cantidad) AS cantidad FROM registroegresos WHERE feedlot = '$f' AND fecha BETWEEN '2010-01-01' AND '$h'");
        // La tabla registroegresos tampoco posee columna 'peso'; usa 'pesoPromedio'.
        $rowPeso = $this->fetchOne("SELECT SUM(cantidad * pesoPromedio) AS pesoTotal, AVG(pesoPromedio) AS pesoProm, MIN(pesoPromedio) AS pesoMin, MAX(pesoPromedio) AS pesoMax FROM registroegresos WHERE feedlot = '$f' AND fecha BETWEEN '2010-01-01' AND '$h'");
        return [
            'cantEgr' => (int)($rowCant['cantidad'] ?? 0),
            'pesoTotalEgr' => (int)($rowPeso['pesoTotal'] ?? 0),
            'kgEgrProm' => (float)($rowPeso['pesoProm'] ?? 0),
            'kgMinEgr' => (int)($rowPeso['pesoMin'] ?? 0),
            'kgMaxEgr' => (int)($rowPeso['pesoMax'] ?? 0),
        ];
    }

    public function listar(string $feedlot, int $page = 0, int $perPage = 12): array {
        $offset = max(0,$page) * $perPage;
        $f = $this->esc($feedlot);
        $sql = "SELECT * FROM registroegresos WHERE feedlot = '$f' ORDER BY fecha DESC, id DESC LIMIT $perPage OFFSET $offset";
        return $this->fetchAll($sql);
    }

    public function totalPaginas(string $feedlot, int $perPage = 12): int {
        $f = $this->esc($feedlot);
        $row = $this->fetchOne("SELECT COUNT(*) AS c FROM registroegresos WHERE feedlot = '$f'");
        $total = (int)($row['c'] ?? 0);
        return ($total === 0) ? 1 : (int)ceil($total / $perPage);
    }
}
