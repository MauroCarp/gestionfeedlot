# Auditoría de Partials - Noviembre 2025

## 📊 Resumen Ejecutivo

**Total de archivos en partials/:** 25
**Archivos en uso:** 21
**Archivos NO usados:** 2 (formulas2.php, modificarFormula2.php)
**Código duplicado encontrado:** Scripts inline de DataTables en 3 archivos

---

## ✅ Archivos en Uso Activo

### Stock Module (9 archivos)
- ✅ `tabla-ingresos.php` - Usado en `resources/views/stock.php`
- ✅ `tabla-egresos.php` - Usado en `resources/views/stock.php`
- ✅ `tabla-muertes.php` - Usado en `resources/views/stock.php`
- ✅ `info-ingresos.php` - Usado en `resources/views/stock.php`
- ✅ `info-egresos.php` - Usado en `resources/views/stock.php`
- ✅ `info-muertes.php` - Usado en `resources/views/stock.php`
- ✅ `ingreso-balanza.php` - Usado en `resources/views/stock.php`
- ✅ `egresos-balanza.php` - Usado en `resources/views/stock.php`
- ✅ `muertes-balanza.php` - Usado en `resources/views/stock.php`

### Raciones Module (7 archivos)
- ✅ `insumos.php` - Usado en `resources/views/raciones.php`
- ✅ `formulas.php` - Usado en `resources/views/raciones.php`
- ✅ `mixer.php` - Usado en `resources/views/raciones.php`
- ✅ `premix.php` - Usado en `resources/views/raciones.php`
- ✅ `ingresoRacion.php` - Usado en `resources/views/raciones.php`
- ✅ `modificarFormula.php` - Usado en `resources/views/raciones.php` y `utils/compararDietas.php`
- ✅ `modificarPremix.php` - Usado en `resources/views/raciones.php`

### Global Components (5 archivos)
- ✅ `head.php` - Header global con CSS/JS
- ✅ `alertas.php` - Usado en `resources/views/status.php` y `resources/views/home.php`
- ✅ `modal-stock.php` - Usado en `includes/nav.php`
- ✅ `modal-status.php` - Usado en `includes/nav.php`
- ✅ `modal-raciones.php` - Usado en `includes/nav.php`
- ✅ `modal-estadisticas.php` - Usado en `includes/nav.php`

### Documentación
- ✅ `README.md` - Documentación de partials

---

## ⚠️ Archivos NO Utilizados

### 1. `formulas2.php`
- **Líneas:** 239
- **Descripción:** Vista alternativa de fórmulas
- **Usado en:** Ninguna vista actual
- **Documentado en:** `README.md` y `docs/MIGRATION_PLAN.md`
- **Recomendación:** ❌ ELIMINAR (no se usa en el proyecto actual)
- **Diferencia con formulas.php:** 511 líneas vs 239 líneas - archivos diferentes

### 2. `modificarFormula2.php`
- **Líneas:** 295
- **Descripción:** Formulario alternativo de edición
- **Usado en:** Ninguna vista actual
- **Documentado en:** `README.md` y `docs/MIGRATION_PLAN.md`
- **Recomendación:** ❌ ELIMINAR (no se usa en el proyecto actual)
- **Diferencia con modificarFormula.php:** 618 líneas vs 295 líneas - archivos diferentes

---

## 🔄 Código Duplicado Encontrado

### DataTables Initialization (Crítico)

**Ubicación:** Scripts inline en 3 archivos
- `tabla-ingresos.php` (líneas 59-85)
- `tabla-egresos.php` (líneas 49-75)
- `tabla-muertes.php` (líneas 120-149)

**Código duplicado:**
```javascript
$(document).ready(function() {
    if($('#tabla[ID]').length && $.fn.DataTable) {
        $('#tabla[ID]').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            dom: '<"row-fluid"<"span6"l><"span6"f>>rt<"row-fluid"<"span6"i><"span6"p>>',
            language: {
                sProcessing: "Procesando...",
                sLengthMenu: "Mostrar _MENU_ registros",
                sZeroRecords: "No se encontraron resultados",
                sEmptyTable: "Sin datos disponibles",
                sInfo: "Mostrando _START_ a _END_ de _TOTAL_",
                sInfoEmpty: "Mostrando 0 a 0 de 0",
                sInfoFiltered: "(filtrado de _MAX_ registros totales)",
                sSearch: "Buscar:",
                oPaginate: {
                    sFirst: "Primero",
                    sLast: "Último",
                    sNext: "Siguiente",
                    sPrevious: "Anterior"
                }
            }
        });
    }
});
```

**Líneas duplicadas:** ~27 líneas × 3 archivos = 81 líneas de código repetido

**Impacto:**
- Mantenimiento: Si se necesita cambiar configuración, hay que hacerlo en 3 lugares
- Consistencia: Riesgo de configuraciones diferentes entre tablas
- DRY Principle: Violación del principio "Don't Repeat Yourself"

**Solución propuesta:**
1. Eliminar scripts inline de los 3 archivos
2. Usar `public/js/datatables-init.js` que ya existe
3. Actualizar `datatables-init.js` para inicializar automáticamente tablas con IDs específicos

---

## 📋 Recomendaciones

### Alta Prioridad
1. ✅ **Eliminar archivos no usados:**
   - `formulas2.php`
   - `modificarFormula2.php`

2. ✅ **Eliminar código duplicado:**
   - Remover scripts inline de DataTables en las 3 tablas
   - Centralizar inicialización en `datatables-init.js`

3. ✅ **Actualizar documentación:**
   - Actualizar `README.md` eliminando referencias a archivos obsoletos

### Media Prioridad
4. ⚙️ **Revisar `utils/compararDietas.php`:**
   - Usa `include('modificarFormula.php')` con path relativo
   - Debería usar `__DIR__ . '/../resources/views/partials/modificarFormula.php'`

### Baja Prioridad
5. 📝 **Documentar dependencias:**
   - Agregar comentarios en cada partial indicando variables requeridas
   - Crear diagrama de dependencias entre partials

---

## 🎯 Métricas de Optimización

**Antes de optimización:**
- Total líneas en partials: ~6,500 líneas
- Código duplicado: 81 líneas
- Archivos obsoletos: 2 (534 líneas)
- Duplicación: 1.25%

**Después de optimización (estimado):**
- Total líneas: ~5,885 líneas
- Código duplicado: 0 líneas
- Archivos obsoletos: 0
- Reducción: ~9.5% (615 líneas menos)

---

## ✅ Plan de Acción

1. Eliminar `formulas2.php` y `modificarFormula2.php`
2. Remover scripts inline de las 3 tablas
3. Actualizar `datatables-init.js` para inicializar automáticamente
4. Actualizar `README.md` en partials
5. Verificar funcionamiento en navegador
6. Ejecutar pruebas de regresión
