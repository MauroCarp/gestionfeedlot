# Estructura del Proyecto - Gestión Feedlot

## 📁 Estructura de Carpetas

```
gestionfeedlot/
├── app/                      # Aplicación MVC
│   ├── Http/
│   │   ├── Controllers/      # Controladores refactorizados
│   │   └── Router.php        # Enrutador
│   ├── Services/             # Servicios de negocio
│   └── Support/              # Funciones de ayuda
│
├── backend/                  # ⚠️ Lógica backend LEGACY (en uso activo)
│   ├── README.md             # Documentación y plan de migración
│   ├── raciones.backend.php  # TODO: migrar a RacionService
│   ├── status.backend.php    # TODO: migrar a StatusService
│   ├── stock.backend.php     # TODO: migrar a StockService
│   ├── usuarios.backend.php  # TODO: migrar a UserService
│   └── verTropa.backend.php  # TODO: migrar a TropaService
│
├── config/                   # Configuración
│   ├── database.php          # ✅ Conexión moderna (singleton)
│   └── conexion.php          # Wrapper legacy → database.php
│
├── public/                   # Punto de entrada público
│   ├── index.php            # Front controller
│   ├── ajax/                # Endpoints AJAX
│   ├── css/                 # Estilos
│   ├── js/                  # JavaScript
│   ├── img/                 # Imágenes
│   └── vendor/              # Vendors públicos (DataTables, etc)
│
├── resources/               # Recursos
│   └── views/               # Vistas
│       ├── partials/        # Fragmentos reutilizables
│       ├── home.php
│       ├── stock.php
│       ├── status.php
│       ├── raciones.php
│       ├── ingresos.php
│       ├── egresos.php
│       ├── muertes.php
│       └── usuarios.php
│
│
├── scripts/                 # Scripts de procesamiento
│   ├── generarEgresos.php
│   ├── generarIngresos.php
│   ├── generarMuertes.php
│   ├── importar.php
│   ├── exportar.php
│   └── ...
│
├── uploads/                 # Scripts de carga de archivos
│   ├── subirEgreso.php
│   ├── subirIngreso.php
│   ├── subirMuertes.php
│   └── ...
│
├── utils/                   # Utilidades y helpers
│   ├── paginador.php
│   ├── graficos.php
│   ├── verTropa.php
│   └── ...
│
├── includes/                # ⚠️ Funciones legacy (en migración)
│   ├── funciones.php         # TODO: migrar a Services/Helpers
│   ├── conexion.php          # Wrapper → config/database.php
│   └── init_session.php      # Inicialización sesión
│
├── vendor/                  # Dependencias Composer
├── docs/                    # Documentación
├── lib/                     # Librerías externas
├── planillas/               # Plantillas Excel
├── informes/                # Informes generados
├── imprimir/                # PDFs e impresiones
├── exportar/                # Archivos exportados
│
├── bootstrap.php            # ✅ Bootstrap de aplicación (debe quedar aquí)
├── composer.json            # Dependencias
└── README.md                # Readme principal

```

## 🔄 Migración MVC

### Rutas Refactorizadas
- ✅ `/public/index.php?route=home` → `HomeController`
- ✅ `/public/index.php?route=stock` → `StockController`
- ✅ `/public/index.php?route=status` → `StatusController`
- ✅ `/public/index.php?route=raciones` → `RacionesController`
- ✅ `/public/index.php?route=usuarios` → `UsuariosController`
- ✅ `/public/index.php?route=ingresos` → `IngresosController`
- ✅ `/public/index.php?route=egresos` → `EgresosController`
- ✅ `/public/index.php?route=muertes` → `MuertesController`
- ✅ `/public/index.php?route=login` → `LoginController`
- ✅ `/public/index.php?route=logout` → `LogoutController`

### Servicios Creados
- ✅ `AuthService` - Autenticación y sesiones
- ✅ `StockService` - Gestión de stock
- ✅ `InsumoService` - Gestión de insumos (esqueleto)

## 📝 Convenciones

### Naming
- Controllers: `PascalCase` + `Controller` suffix
- Services: `PascalCase` + `Service` suffix
- Views: `kebab-case.php`
- Partials: `kebab-case.php` en `resources/views/partials/`

### Rutas
- Rutas públicas: `/public/index.php?route={name}`
- AJAX: `/ajax/{endpoint}.ajax.php`
- Assets: `/public/{css|js|img}/{file}`

## 🚀 Próximos Pasos

1. Migrar lógica de `backend/*.backend.php` a Services
2. Refactorizar includes de `includes/funciones.php` a Services
3. Crear tests unitarios para Services
4. Implementar cache y optimizaciones

## 📚 Recursos

- **Framework**: Custom MVC-lite
- **PHP**: 8.2+
- **DB**: MySQL/MariaDB
- **Frontend**: Bootstrap 2.x, jQuery, DataTables
