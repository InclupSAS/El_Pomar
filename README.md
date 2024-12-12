# El Pomar Core

Plugin para WordPress que facilita la administración y visualización del catálogo de productos de Leches El Pomar.

## Información

- **Versión:** 2.1.5
- **Requiere WordPress:** 6.6.2 o superior
- **Probado hasta:** 6.6.2  
- **Requiere PHP:** 8.0
- **Licencia:** GPLv2 o posterior
- **URI de licencia:** https://www.gnu.org/licenses/gpl-2.0.html
- **Etiquetas:** catálogo, productos, wordpress, ui

## Desarrollado por

- [@kerackDiaz](https://www.github.com/kerackdiaz)
- [Inclup](https://inclup.com)

## Usado por

Este proyecto es utilizado por:

- Leches El Pomar

## Características

### Productos
- Gestión de catálogo de productos por marcas y categorías.
- Personalización de iconos para el catálogo de productos.
- **Shortcode:** `[catalog_pomar]`

### Ofertas laborales
- Ajustes en el template del correo que recibe el postulante.
- Personalización del correo que recibe las postulaciones de vacantes.
- Programación de eliminación de archivos.
- Descarga de todos los postulantes en archivo CSV.
- Personalización de iconos.
- **Shortcode:** `[jobs_pomar]`

### Recetas
- Creación de recetas.
- Generación de PDF de la receta.
- Lista de leads captados por el formulario de descarga de la receta.
- **Shortcode:** `[recipe_pomar]`

### News
- Creación de noticias externas publicadas por otros medios.

### Personalización
- Megamenu personalizado.
- Implementación de CSS personalizado.
- **Shortcode:** `[el_pomar_megamenu]`

## Instalación

1. Descarga la última versión desde [GitHub Releases](https://github.com/kerackdiaz/El_PomarCoreWP/releases)
2. Sube el archivo ZIP a `/wp-content/plugins/` o instala desde el panel de WordPress
3. Activa el plugin desde la sección 'Plugins'
4. Configura las opciones desde el menú 'El Pomar'
5. Usa los shortcodes correspondientes para mostrar las diferentes funcionalidades:
    - `[catalog_pomar]` para el catálogo de productos
    - `[jobs_pomar]` para las ofertas laborales
    - `[recipe_pomar]` para las recetas
    - `[el_pomar_megamenu]` para el megamenu

## Preguntas Frecuentes

### ¿Cómo configuro el plugin?
Accede al menú 'El Pomar' en el panel de administración para todas las opciones de configuración.

### ¿Necesito WooCommerce?
No, el plugin implementa su propio sistema de catálogo independiente.

### ¿Es compatible con constructores de páginas?
Sí, puedes insertar los shortcodes en cualquier constructor compatible.

## Registro de Cambios

### 2.1.5
- Gestión de catálogo de productos por marcas y categorías.
- Personalización de iconos para el catálogo de productos.
- Ajustes en el template del correo que recibe el postulante.
- Personalización del correo que recibe las postulaciones de vacantes.
- Programación de eliminación de archivos.
- Descarga de todos los postulantes en archivo CSV.
- Creación de recetas.
- Generación de PDF de la receta.
- Lista de leads captados por el formulario de descarga de la receta.
- Creación de noticias externas publicadas por otros medios.
- Megamenu personalizado.
- Implementación de CSS personalizado.

### 2.0.3
- Implementación responsive del frontend.
- Nuevos iconos personalizados.
- Correcciones de seguridad.
- Optimización de código.

### 1.0.2 
- Custom Post Types para marcas y categorías.
- Panel de administración mejorado.
- Protección de rutas.
- Shortcode para integración.
