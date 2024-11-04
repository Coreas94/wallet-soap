
# Virtual Wallet SOAP PROJECT

Este proyecto implementa un servicio SOAP en Laravel para simular una billetera virtual. Proporciona operaciones básicas para registrar clientes, recargar saldo, realizar pagos, confirmar pagos y consultar saldo. Este servicio SOAP está diseñado para ser consumido por un servicio REST construido en Node.js.

## Requisitos

- PHP 8.x
- Composer
- Laravel 10
- MySQL

## Instalación

1. Clona este repositorio en tu máquina local:

    ```bash
    git clone <URL del repositorio>
    ```

2. Navega al directorio del proyecto:

    ```bash
    cd WalletSoapProject
    ```

3. Instala las dependencias de Laravel:

    ```bash
    composer install
    ```

4. Crea un archivo `.env` basado en el ejemplo proporcionado:

    ```bash
    cp .env.example .env
    ```

5. Configura las credenciales de tu base de datos en el archivo `.env`:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=virtual_wallet
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_contraseña
    ```

6. Genera una clave de aplicación:

    ```bash
    php artisan key:generate
    ```

7. Ejecuta las migraciones para crear las tablas en la base de datos:

    ```bash
    php artisan migrate
    ```

8. Configura Mailtrap para el envío de correos en el archivo `.env`:

    ```plaintext
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=93a02fe764b692
    MAIL_PASSWORD=78d61d694a94f3
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS=no-reply@virtualwallet.com
    MAIL_FROM_NAME="${APP_NAME}"
    ```

## Endpoints SOAP

Los siguientes métodos están disponibles en este servicio SOAP:

1. **Registro de Clientes**
    - **Descripción**: Registra un nuevo cliente en el sistema.
    - **Parámetros**:
        - `documento`: Número de documento del cliente
        - `nombres`: Nombre completo del cliente
        - `email`: Correo electrónico del cliente
        - `celular`: Número de teléfono del cliente

2. **Recarga de Billetera**
    - **Descripción**: Recarga saldo en la billetera de un cliente.
    - **Parámetros**:
        - `documento`: Número de documento del cliente
        - `celular`: Número de teléfono del cliente
        - `valor`: Monto a recargar en la billetera

3. **Realizar Pago**
    - **Descripción**: Inicia un pago y envía un token de confirmación al correo electrónico del cliente.
    - **Parámetros**:
        - `documento`: Número de documento del cliente
        - `celular`: Número de teléfono del cliente
        - `monto`: Monto del pago

4. **Confirmar Pago**
    - **Descripción**: Confirma un pago utilizando el token enviado por correo.
    - **Parámetros**:
        - `sessionId`: ID de sesión del pago
        - `token`: Token de confirmación enviado al cliente

5. **Consulta de Saldo**
    - **Descripción**: Consulta el saldo de la billetera de un cliente.
    - **Parámetros**:
        - `documento`: Número de documento del cliente
        - `celular`: Número de teléfono del cliente

## Estructura de Respuesta

Todas las respuestas siguen la misma estructura:

```json
{
    "success": true,
    "cod_error": "00",
    "message_error": "Mensaje descriptivo",
    "data": {
        // Información adicional según la operación realizada
    }
}
```

- **success**: Indica si la operación fue exitosa (`true`) o fallida (`false`).
- **cod_error**: Código de error. `00` indica éxito; otros códigos indican errores específicos.
- **message_error**: Mensaje descriptivo del error o del éxito de la operación.
- **data**: Contiene la información relevante para cada operación.

## Ejecución del Servidor

Para iniciar el servidor de desarrollo de Laravel:

```bash
php artisan serve
```

Por defecto, el servidor estará disponible en `http://127.0.0.1:8000`.

## Pruebas

**Simulación de Correos con Mailtrap**

Para la simulación de envíos de correo en este proyecto, se ha configurado Mailtrap como el servicio de correo en el archivo .env. Mailtrap permite interceptar correos electrónicos sin enviarlos realmente, lo que facilita el proceso de pruebas.

Para ver los correos generados durante las pruebas, incluyendo el token de confirmación para pagos, puedes iniciar sesión en la cuenta de Mailtrap proporcionada:

```bash
URL: https://mailtrap.io/signin
Usuario: projectwallet.24@gmail.com
Contraseña: Projectwallet$$
```

*Uso en Pruebas*

- Realizar la función de pago para enviar el correo.
- Inicia sesión en Mailtrap y accede a Email Testing / My Inbox.
- Toma el token del correo para confirmar la operación en el siguiente paso de la prueba.

## Notas

1. **Mensajería y Notificaciones**: Este servicio envía un token de confirmación por correo para cada pago. Se debe configurar correctamente el servicio de correo en el archivo `.env` para garantizar el envío adecuado.
2. **Persistencia de Sesiones de Pago**: Los tokens de pago y los montos asociados se almacenan en caché (usando `Cache::put`) por un periodo de 10 minutos.
3. **Integración con Node.js**: Este servicio SOAP está diseñado para integrarse con un servicio REST en Node.js, que actúa como intermediario entre el cliente y este servicio SOAP.

