# Partials de Vistas

Esta carpeta contiene fragmentos de vistas (partials) que son incluidos desde vistas principales.

## Partials de Stock

Estos archivos son incluidos en la vista `resources/views/stock.php`:

- `ingreso-balanza.php` - Formulario de carga de ingresos
- `egresos-balanza.php` - Formulario de carga de egresos
- `muertes-balanza.php` - Formulario de carga de muertes
- `tabla-ingresos.php` - Tabla de ingresos con DataTables
- `tabla-egresos.php` - Tabla de egresos con DataTables
- `tabla-muertes.php` - Tabla de muertes con DataTables
- `info-ingresos.php` - Totales y estadísticas de ingresos
- `info-egresos.php` - Totales y estadísticas de egresos
- `info-muertes.php` - Totales y estadísticas de muertes

## Partials de Raciones

Estos archivos son incluidos como tabs en la vista `resources/views/raciones.php`:

- `ingresoRacion.php` - Tab de ingreso de raciones
- `insumos.php` - Tab de gestión de insumos
- `formulas.php` - Tab de listado de fórmulas
- `mixer.php` - Tab de operaciones de mixer
- `premix.php` - Tab de gestión de premix
- `modificarFormula.php` - Formulario de edición de fórmula
- `modificarPremix.php` - Formulario de edición de premix

## Partials Globales

Componentes reutilizables en múltiples vistas:

- `head.php` - Header con CSS/JS (incluido globalmente)
- `alertas.php` - Componente de alertas (home, status)
- `modal-stock.php` - Modal de descarga de planillas Stock
- `modal-status.php` - Modal de descarga de planillas Status
- `modal-raciones.php` - Modal de descarga de planillas Raciones
- `modal-estadisticas.php` - Modal de estadísticas

## Uso

```php
// Desde resources/views/stock.php
include __DIR__ . '/partials/tabla-ingresos.php';

// Desde resources/views/raciones.php
include(__DIR__ . "/partials/insumos.php");
```

## Dependencias

Estos partials dependen de variables pasadas desde el controller:

- `$feedlot` - Nombre del feedlot actual
- `$fechaDeHoy` - Fecha actual formateada
- `$conexion` - Conexión MySQLi
- `$seccion` - Sección activa (para tabs)
- `$accion` - Acción actual (modificar, eliminar, etc)

## DataTables

Las tablas de Stock (`tabla-ingresos.php`, `tabla-egresos.php`, `tabla-muertes.php`) 
usan DataTables para paginación, búsqueda y ordenamiento.

La inicialización se hace automáticamente en `public/js/datatables-init.js` detectando 
los IDs: `#tablaIngresos`, `#tablaEgresos`, `#tablaMuertes`.
