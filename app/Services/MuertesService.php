<?php
namespace App\Services;

class MuertesService extends BaseService {
    public function totales(string $feedlot, string $hasta): array {
        $f = $this->esc($feedlot); $h = $this->esc($hasta);
        $rowCant = $this->fetchOne("SELECT COUNT(*) AS cantidad FROM muertes WHERE feedlot = '$f' AND fecha BETWEEN '2010-01-01' AND '$h'");
        return [
            'cantMuertes' => (int)($rowCant['cantidad'] ?? 0)
        ];
    }

    public function listar(string $feedlot, int $page = 0, int $perPage = 12): array {
        $offset = max(0,$page) * $perPage;
        $f = $this->esc($feedlot);
        $sql = "SELECT * FROM muertes WHERE feedlot = '$f' ORDER BY fecha DESC, id DESC LIMIT $perPage OFFSET $offset";
        return $this->fetchAll($sql);
    }

    public function totalPaginas(string $feedlot, int $perPage = 12): int {
        $f = $this->esc($feedlot);
        $row = $this->fetchOne("SELECT COUNT(*) AS c FROM muertes WHERE feedlot = '$f'");
        $total = (int)($row['c'] ?? 0);
        return ($total === 0) ? 1 : (int)ceil($total / $perPage);
    }

    public function causas(string $feedlot): array {
        $f = $this->esc($feedlot);
        $sql = "SELECT causaMuerte, COUNT(*) as total FROM muertes WHERE feedlot = '$f' GROUP BY causaMuerte ORDER BY causaMuerte";
        return $this->fetchAll($sql);
    }
}
