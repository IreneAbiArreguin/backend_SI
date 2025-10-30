# BACKEND SISTEMA DE INUNDACIÓN 
## Caracterizticas
### 1.-Gestión de Reportes: Crear, visualizar, actualizar y eliminar reportes de emergencia
### 2.-Refugios: Catálogo de refugios disponibles
### 3.-Usuarios: Gestión de usuarios del sistema
### 4.-Dockerizado: Entorno consistente con Docker

## Tecnologías 
### Backend: Laravel 
### Base de Datos: MySQL
### Contenedores: Docker & Docker Compose
### Servidor Web: Nginx

 # API Endpoints 
 ***Route::apiResource()***  Laravel crea 7 endpoints por cada recurso
 #### Ejemplo para Reportes (***/api/reportes***)
 | **Método** | **URL**                 | **Acción**   | **Descripción**              |
|-------------|------------------------|--------------|------------------------------|
| GET         | `/api/reportes`        | `index()`    | Listar todos los reportes    |
| POST        | `/api/reportes`        | `store()`    | Crear nuevo reporte          |
| GET         | `/api/reportes/{id}`   | `show()`     | Ver un reporte específico    |
| PUT/PATCH   | `/api/reportes/{id}`   | `update()`   | Actualizar un reporte        |
| DELETE      | `/api/reportes/{id}`   | `destroy()`  | Eliminar un reporte          |

#### Lo mismo para:
- ***/api/zonas-riesgo***
- ***/api/refugios***
- ***/api/usuarios (solo index y show)***
