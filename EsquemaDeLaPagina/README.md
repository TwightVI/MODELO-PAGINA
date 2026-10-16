# Modelo de ecommerce MVC

Plantilla de tienda online independiente y vacía, implementada en PHP 8, MySQL y PDO. Incluye una organización MVC sencilla y las pantallas y funciones esenciales para personalizarla para distintos negocios. El catálogo comienza sin productos y el checkout es demostrativo: no procesa pagos ni crea pedidos reales.

## Requisitos y puesta en marcha (XAMPP)

1. Colocá la carpeta del proyecto dentro de `C:\xampp\htdocs\`.
2. Iniciá **Apache** y **MySQL** desde el panel de XAMPP.
3. Abrí `http://localhost/phpmyadmin`, elegí **Importar** y cargá `database.sql`. El script crea la base independiente `ecommerce_modelo_vacio`, sus tablas, tres categorías genéricas, una cuenta de administración de demostración y ningún producto.
4. Revisá los datos de conexión de MySQL en `config/config.php` si tu instalación usa otros valores.
5. Visitá `http://localhost/EsquemaDeLaPagina/`.

PHP necesita las extensiones `PDO` y `pdo_mysql`, activas por defecto en XAMPP.

### Cuenta de administración de demostración

- Usuario: `admin@tienda.local`
- Contraseña: `admin123`

La cuenta sirve para probar el panel y agregar productos. Es solo para desarrollo local: cambiá la contraseña antes de publicar el sitio.

## Funciones incluidas

- Vistas de inicio, catálogo y presentación del negocio.
- Registro e inicio de sesión.
- Búsqueda de productos y filtro por categoría.
- Alta, edición, publicación/ocultamiento y eliminación de productos para administradores.
- Carrito guardado en la sesión y disponible para usuarios autenticados.
- Flujo de checkout de demostración, sin pasarela de pago.
- Contraseñas con `password_hash`, consultas PDO preparadas y protección CSRF en formularios.

## Personalización

- Cambiá nombre, textos y conexión de base de datos en `config/config.php`.
- Adaptá los contenidos de las vistas en `app/views/` y la identidad visual en `css/style.css`.
- Las categorías iniciales son genéricas y se pueden ajustar en `database.sql`.
- Los productos se administran desde el panel, una vez iniciada la sesión de administrador.
- Integrá el proceso de compra propio del negocio en `app/controllers/StoreController.php`, acción `completeCheckout`.

El esquema SQL es compatible con MySQL/MariaDB y se importa con phpMyAdmin.
