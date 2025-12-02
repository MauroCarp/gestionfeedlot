// DataTables inicialización con soporte para tabs ocultos (Bootstrap 2)
 (function(){
  // Exponer una promesa global para otros scripts
  window.DataTablesReady = window.DataTablesReady || new Promise(function(resolve){ window.__resolveDT = resolve; });

  function buildConfig($table){
    var dtLangEs = {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Sin datos disponibles",
      sInfo: "Mostrando _START_ a _END_ de _TOTAL_",
      sInfoEmpty: "Mostrando 0 a 0 de 0",
      sInfoFiltered: "(filtrado de _MAX_ registros totales)",
      sSearch: "Buscar:",
      oPaginate: { sFirst: "Primero", sLast: "Último", sNext: "Siguiente", sPrevious: "Anterior" },
      oAria: { sSortAscending: ": Activar para ordenar ascendente", sSortDescending: ": Activar para ordenar descendente" }
    };
    var orderCol = parseInt($table.attr('data-dt-order-col') || '0',10);
    var pageLen = parseInt($table.attr('data-dt-page-length') || '10',10);
    return {
      pageLength: pageLen,
      lengthMenu: [10,25,50,100],
      dom: '<"row-fluid"<"span6"l><"span6"f>>rt<"row-fluid"<"span6"i><"span6"p>>',
      language: dtLangEs,
      order: [[orderCol, 'desc']]
    };
  }

  function isShim(){
    return !(window.jQuery && $.fn.DataTable && ($.fn.DataTable.version || ($.fn.dataTable && $.fn.dataTable.ext)));
  }

  function ensureFullLibrary(cb){
    if(!isShim()){ cb(); return; }
    console.warn('DataTables shim detectado. Cargando CDN para robustez...');
    var css = document.createElement('link');
    css.rel='stylesheet'; css.href='https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css';
    document.head.appendChild(css);
    var script = document.createElement('script');
    script.src='https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js';
    script.onload=function(){ cb(); };
    script.onerror=function(){ console.error('Fallo carga CDN DataTables'); cb(); };
    document.head.appendChild(script);
    // Timeout de seguridad
    setTimeout(function(){ cb(); }, 5000);
  }

  function initAll(){
    if(typeof jQuery === 'undefined'){ console.warn('jQuery ausente; abort DT init'); return; }
    var $tables = $('[data-datatable="stock"], .datatable-auto');
    $tables.each(function(){
      if(!$.fn.DataTable) return;
      if($.fn.DataTable.isDataTable(this)) return;
      var $t = $(this);
      var cfg = buildConfig($t);
      try {
        $t.DataTable(cfg);
      } catch(e){ console.error('Error inicializando DataTable', this, e); }
    });
    if(window.__resolveDT){ window.__resolveDT(); window.__resolveDT = null; }
  }

  $(function(){ ensureFullLibrary(initAll); });
})();
