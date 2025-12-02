# Plan de Migración - Siguiente Batch

## Criterios de Prioridad
1. Frecuencia de uso y criticidad operativa.
2. Impacto en datos transaccionales (ingresos / egresos / muertes).
3. Riesgo de errores por includes repetidos / lógica duplicada.
4. Beneficio de centralizar servicios y reutilizar helpers existentes.

## Grupo 1 (Transaccional Alto)
- ingresoBalanza.php / ingresoBalanza.old.php / ingresoManual.php
- egresosBalanza.php / egresosBalanza.old.php / verTropaEgreso.php
- muertesBalanza.php / cargarMuertes.php / generarMuertes.php
- generarIngresos.php / generarEgresos.php
- tablaIngresos.php / tablaEgresos.php / tablaMuertes.php
- infoIngresos.php / infoEgresos.php / infoMuertes.php

Acciones: Crear `IngresosController`, `EgresosController`, `MuertesController` + servicios (`app/Services/{IngresosService,EgresosService,MuertesService}.php`). Unificar paginación y fecha.

## Grupo 2 (Importación / Carga Masiva)
- subirIngreso.php / subirIngresoEXCEL.php / subirIngreso.new.php
- subirEgreso.php / subirEgresoEXCEL.php
- subirMuertes.php / subirMuertesEXCEL.php
- subirInsumosEXCEL.php / subirRacion.php / subirPlantilla.php

Acciones: Controller `ImportController` con métodos por tipo, mover validaciones y sanitización a helpers.

## Grupo 3 (Formulación y Dietas)
- formulas.php / formulas2.php / modificarFormula.php / modificarFormula2.php
- premix.php / modificarPremix.php / recetas.ajax.php
- compararDietas.php / ingresoRacion.php / ingresoRacion.v1.php / ingresoMixer1.php / ingresoMixer2.php

Acciones: Controller `FormulasController` y `RacionesController` (extender actual). Extraer cálculo de MS y porcentajes a `NutritionService`.

## Grupo 4 (Reportes / Informes / Gráficos)
- informe.php / informe2.php / informe.old.php / informe.borrador.php
- informeAcopiadora.borrador.php
- datosInforme.php / datosInforme.borrador.php / datosInformeAcopiadora.borrador.php
- graficos.php / cantidadSegunPeso.php / cantidadSegunPesoInforme.php
- imprimirStatus.php / imprimirStatusTropa.php

Acciones: Controller `ReportesController`. Refactor de generación de arrays y reutilizar Chart dataset builders.

## Grupo 5 (Utilidad / Exportación / Descargas)
- exportar.php / exportarTodo.php
- descargas.ajax.php / exportar/ (scripts internos)
- data.php / datos.php / alerta.php

Acciones: `ExportController` para flujos de CSV/XLS centralizando cabeceras y sanitización.

## Grupo 6 (Ajax / Backends legacy a consolidar)
- status.backend.php / stock.backend.php / raciones.backend.php / usuarios.backend.php
- filtroOperaciones.ajax.php / animales.ajax.php / cargarSelect.ajax.php

Acciones: Unificar endpoints bajo `public/index.php?route=api&action=...` o crear `ApiController` con dispatch interno. Mantener compat temporal con nombres antiguos.

## Grupo 7 (Menor prioridad / Históricos / Old)
- *.old.php y *.borrador.php (mantener aislados, migrar sólo si necesarios)

## Pasos Concretos Inmediatos
1. Crear carpeta `app/Services` y stub de servicios transaccionales.
2. Migrar ingresoBalanza.php → `IngresosController::index()` + vista `resources/views/ingresos.blade.php` (nombre provisional).
3. Extraer consultas repetidas de stock/ingresos a `IngresosService`.
4. Implementar paginador reutilizable (helper) reemplazando HTML generado en `paginador()`.
5. Reemplazar includes directos en páginas del Grupo 1 con llamadas a servicios.

## Consideraciones Técnicas
- Reutilizar `$GLOBALS['conexion']` mientras se desacopla hacia inyección (futuro).
- Evitar side-effects en servicios (sólo retorno de datos estructurados).
- Unificar formateo de fechas con helper ya existente `formatearFecha()`.
- Aplicar guardas `function_exists` sólo de forma transitoria; remover funciones legacy a medida que migran.
- Documentar cada migración en este archivo (añadir sección "Progreso").

## Métricas de Finalización
- Grupo 1 completo: 60% cobertura funcional migrada.
- Grupos 1-3 completos: ~80% lógica del negocio estabilizada.
- Grupos 1-5 + Api: 95% (restan históricos / borradores / old).

## Riesgos y Mitigaciones
- Riesgo: ruptura de enlaces legacy → Mantener `route_url()` y añadir redirecciones 301 si se decide.
- Riesgo: duplicación de queries → Centralizar en servicios antes de migrar segundo archivo similar.
- Riesgo: timeouts en importaciones grandes → Añadir `set_time_limit()` y chunking en `ImportController`.
- Riesgo: encoding CSV/Excel → Forzar UTF-8 y sanitizar separadores.

## Próximos Hitos
- [ ] Crear servicios base.
- [ ] Migrar ingreso/egreso/muertes (pantallas + tablas + info*).
- [ ] Unificar paginación.
- [ ] Implementar capa Api para *.backend / *.ajax.
- [ ] Retirar funciones legacy migradas.
