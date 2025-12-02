<?php
// Futuro: migrar funciones aqui y namespacing.
// Por ahora se incluye desde includes/funciones.php para compatibilidad.

if (!function_exists('comprobarExisteCampo')) {
    function comprobarExisteCampo($nombreCampo) {
        return array_key_exists($nombreCampo, $_REQUEST);
    }
}
// Se irán migrando progresivamente las demás funciones.

// Helper de paginación reusable (Bootstrap 2 compatible) - uso: pagination_links($page,$total,$route)
if (!function_exists('pagination_links')) {
    function pagination_links(int $currentPage, int $totalPages, string $route, array $extraParams = []): string {
        if ($totalPages < 1) { $totalPages = 1; }
        $currentPage = max(0, min($currentPage, $totalPages-1));
        $paramsBase = $extraParams;
        $html = '<ul class="pagination" style="list-style:none;">';
        // Prev
        if ($currentPage > 0) {
            $paramsPrev = http_build_query(array_merge($paramsBase, ['page' => $currentPage-1]));
            $html .= '<li><a href="'.route_url($route).'&'.$paramsPrev.'">&laquo;</a></li>';
        } else {
            $html .= '<li class="disabled"><span>&laquo;</span></li>';
        }
        // Pages
        for ($p = 0; $p < $totalPages; $p++) {
            $params = http_build_query(array_merge($paramsBase, ['page' => $p]));
            $active = ($p === $currentPage) ? ' class="active"' : '';
            $html .= '<li'.$active.'><a href="'.route_url($route).'&'.$params.'">'.($p+1).'</a></li>';
        }
        // Next
        if ($currentPage < $totalPages-1) {
            $paramsNext = http_build_query(array_merge($paramsBase, ['page' => $currentPage+1]));
            $html .= '<li><a href="'.route_url($route).'&'.$paramsNext.'">&raquo;</a></li>';
        } else {
            $html .= '<li class="disabled"><span>&raquo;</span></li>';
        }
        $html .= '</ul>';
        return $html;
    }
}
