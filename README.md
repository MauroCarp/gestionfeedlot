# Gestion Feedlot - Reorganización Arquitectura

## Objetivo
Evolucionar desde estructura plana a una arquitectura modular (inspirada en MVC) sin romper compatibilidad inmediata.

## Estado Actual (Fase 1)
- `config/database.php`: Capa centralizada de conexión (clase `Database` y helper `db()`).
- `includes/conexion.php`: Wrapper legacy que apunta a `config/database.php`.
- `includes/funciones.php`: Mantiene funciones existentes + puente hacia `app/Support/functions.php`.
- `bootstrap.php`: Punto único de arranque (sesión, conexión, helpers, autoload Composer).
- `public/index.php`: Nuevo front controller con routing mínimo (`route=home`).
- `index.php` (raíz): Redirección a `public/index.php`.
- `resources/views/home.php`: Vista desacoplada del front controller.
- Autoload PSR-4 añadido para namespace `App\`.

## Próximos Pasos Sugeridos
1. Migrar páginas legacy (ej. `stock.php`, `status.php`, etc.) a controladores en `app/Http/Controllers` y vistas en `resources/views`.
2. Crear un router simple para mapear rutas limpias (`/stock`, `/status`) usando parámetro `route` o parsing de REQUEST_URI (requiere .htaccess / config Apache).
3. Extraer funciones de negocio a servicios/repositories (`app/Domain`, `app/Infrastructure`).
4. Unificar assets estáticos moviéndolos a `public/` (css, js, img) y ajustar rutas en `head.php`.
5. Introducir capa de layouts (`resources/views/layout.php`) para evitar repetición en vistas.
6. Implementar logger básico en `storage/` (crear carpeta) para errores.
7. Añadir tests unitarios mínimos (si se agrega PHPUnit al Composer).

## Compatibilidad
Hasta finalizar migración, archivos legacy fuera de `public/` siguen funcionando al acceder directamente (excepto redirección de `index.php`). Enlaces aún apuntan a archivos legacy; se migrarán gradual.

## Comandos Útiles
```bash
composer dump-autoload
```

## Notas
- No se eliminaron archivos legacy; esto minimiza riesgo.
- Ajustar DocumentRoot del servidor a `public/` cuando la migración de páginas principales esté completa.
