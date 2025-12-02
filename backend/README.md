# Backend Legacy

Esta carpeta contiene archivos `*.backend.php` que son **utilizados activamente** por los controllers, pero contienen **lógica de negocio que debería estar en Services**.

## Archivos actuales y su uso:

### ✅ En uso activo (incluidos por controllers)

- **`raciones.backend.php`** (823 líneas)
  - Incluido por: `RacionesController`
  - Función: Procesa acciones de raciones (ingreso, modificar, eliminar)
  - **TODO**: Migrar a `RacionService`

- **`status.backend.php`**
  - Incluido por: `StatusController`
  - Función: Lógica de status sanitario
  - **TODO**: Migrar a `StatusService`

- **`stock.backend.php`**
  - Incluido por: `StockController` (vía API)
  - Función: Procesamiento de stock
  - **TODO**: Migrar a `StockService` (parcialmente hecho)

- **`usuarios.backend.php`**
  - Incluido por: `UsuariosController` (vía API)
  - Función: CRUD de usuarios
  - **TODO**: Migrar a `UserService`

- **`verTropa.backend.php`**
  - Incluido por: scripts de informes
  - Función: Datos de tropas
  - **TODO**: Migrar a `TropaService`

## ⚠️ Estado de migración

**IMPORTANTE**: Estos archivos NO son obsoletos, se están usando activamente.

### Plan de migración:

1. **Fase 1** (actual): Controllers incluyen `*.backend.php` directamente
2. **Fase 2** (próximo): Crear Services y mover lógica de negocio
3. **Fase 3** (final): Eliminar `*.backend.php` cuando todo esté en Services

## 🔄 Ejemplo de migración:

**Antes** (actual):
```php
class RacionesController {
    public function index() {
        require __DIR__ . '/../../../backend/raciones.backend.php';
        // Usa variables y lógica del backend
    }
}
```

**Después** (objetivo):
```php
class RacionesController {
    private RacionService $racionService;
    
    public function __construct() {
        $this->racionService = new RacionService();
    }
    
    public function index() {
        $data = $this->racionService->index();
        layout_view('raciones', $data);
    }
}
```

## 📝 Notas

- Los archivos backend están escritos en estilo procedural
- Mezclan lógica de presentación, negocio y datos
- Usan `$_GET`, `$_POST`, `$conexion` directamente
- Hacen `echo` de HTML (mal diseño)
- Tienen SQL inline (sin prepared statements en muchos casos)

**No eliminar hasta que la migración a Services esté completa y probada.**
