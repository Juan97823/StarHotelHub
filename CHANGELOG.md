# 📝 CHANGELOG - StarHotelHub

## [v2.1.0] - 2025-10-29

### ✨ Nuevas Características

#### 📧 Sistema de Reservas Mejorado
- ✅ **Envío automático de emails de confirmación** después de completar reserva
- ✅ **Generación automática de credenciales** para usuarios nuevos
- ✅ **Envío de credenciales por email** a nuevos usuarios
- ✅ **Códigos únicos de reserva** (num_transaccion y cod_reserva)
- ✅ **Cálculo de IVA incluido en el precio** (no adicional)

#### 📋 Panel de Mensajes de Contacto
- ✅ **CRUD completo** para gestionar mensajes de contacto
- ✅ **Tabla DataTables** con búsqueda, paginación y ordenamiento
- ✅ **Modal para ver detalles** de mensajes
- ✅ **Marcar como leído/no leído**
- ✅ **Eliminar mensajes** con confirmación
- ✅ **Auto-marcar como leído** al ver el mensaje

#### 🎨 Mejoras en UI/UX
- ✅ **Footer modernizado** con 4 columnas (Logo, Links, Contacto, Newsletter)
- ✅ **Header consistente** en todas las páginas
- ✅ **Estilos mejorados** para login y registro
- ✅ **CSS optimizado** para impresión de facturas

#### 📄 Vista de Confirmación/Factura
- ✅ **Sincronización con BD** - Todos los datos vienen de la base de datos
- ✅ **Información completa** - ID reserva, usuario, habitación, transacción
- ✅ **Desglose de pago** - Subtotal, IVA, Total
- ✅ **Optimizado para impresión** - CSS para PDF
- ✅ **Información de contacto** - Teléfono, email, dirección

### 🔧 Cambios Técnicos

#### Controllers
- `controllers/Principal/Reserva.php`
  - Nuevo método: `enviarConfirmacionReserva()` - Envía email con detalles de reserva
  - Nuevo método: `enviarCredencialesNuevoUsuario()` - Envía credenciales a nuevos usuarios
  - Mejorado: `guardarPublica()` - Genera códigos únicos y envía emails
  - Mejorado: `confirmacion()` - Cálculo de IVA incluido

- `controllers/Admin/Contacto.php` (NUEVO)
  - Métodos: `index()`, `listarMensajes()`, `verMensaje()`, `cambiarEstado()`, `eliminarMensaje()`

#### Models
- `models/principal/ReservaModel.php`
  - Mejorado: `insertReservaPublica()` - Ahora guarda todos los campos de la tabla
  - Nuevo método: `getUsuarioByCorreo()` - Busca usuario por correo

- `models/admin/ContactoModel.php` (NUEVO)
  - Métodos: `getMensajes()`, `getMensaje()`, `cambiarEstado()`, `eliminarMensaje()`

#### Views
- `views/principal/reservas/confirmacion.php`
  - Mejorado: Muestra todos los datos de la BD
  - Nuevo: Tabla con información de transacción
  - Nuevo: Tabla con datos guardados en BD
  - Mejorado: CSS para impresión
  - Mejorado: Claridad sobre IVA incluido

- `views/template/header-cliente.php`
  - Agregado: Variable global `base_url` para JavaScript

#### Assets
- `assets/admin/js/Pages/ContactoMensajes.js` (NUEVO)
- `assets/principal/css/footer-moderno.css` (NUEVO)
- `assets/principal/css/header-login-consistencia.css` (NUEVO)
- `assets/principal/js/footer-moderno.js` (NUEVO)

### 🐛 Correcciones

- ✅ Error: `AdminModel` no se pudo cargar - Solucionado
- ✅ Error: `base_url is not defined` en clientes.js - Solucionado
- ✅ Error: Métodos duplicados en ReservaModel - Solucionado
- ✅ Error: IDE warnings sobre tipos null - Solucionado

### 📊 Campos Guardados en Reservas

Ahora se guardan **TODOS** estos campos:
- `id`, `id_habitacion`, `id_usuario`, `id_empleado`
- `fecha_ingreso`, `fecha_salida`, `fecha_reserva`
- `descripcion`, `estado`, `metodo`
- `monto` (con IVA incluido)
- `num_transaccion` (generado: TX...)
- `cod_reserva` (generado: RES...)
- `facturacion` (tipo de facturación)

### 💰 Cambio en Cálculo de IVA

**ANTES:** IVA se sumaba al precio
```
Subtotal: $480,000
IVA 19%: $91,200
TOTAL: $571,200
```

**AHORA:** IVA está incluido en el precio
```
TOTAL: $480,000 (incluye IVA)
Desglose:
  Subtotal: $403,361
  IVA: $76,639
```

### 📧 Emails Enviados

1. **Email de Confirmación de Reserva**
   - Número de reserva, código, transacción
   - Detalles de habitación y fechas
   - Resumen de pago

2. **Email de Credenciales (usuarios nuevos)**
   - Email de acceso
   - Contraseña temporal
   - Enlace para login

### 📚 Documentación

- ✅ `RESERVA-CAMPOS-BD.md` - Guía completa de campos y cálculos
- ✅ `PANEL-MENSAJES-CONTACTO.md` - Documentación del panel de contacto

### 🔗 URLs Nuevas

- `http://localhost/Starhotelhub/admin/contacto` - Panel de mensajes de contacto
- `http://localhost/Starhotelhub/reserva/confirmacion` - Confirmación de reserva

### ⚠️ Notas Importantes

1. **Precios en BD:** Asegúrate que los precios en la tabla `habitaciones` ya incluyen el IVA
2. **Emails:** Verifica que la configuración SMTP en `config/email.php` sea correcta
3. **Contraseñas:** Las contraseñas de nuevos usuarios son aleatorias de 10 caracteres
4. **IVA:** El sistema ahora calcula IVA desglosado para facturación

### 🚀 Próximas Mejoras

- [ ] Pasarela de pago integrada
- [ ] Descarga de factura en PDF
- [ ] Historial de cambios de estado
- [ ] Notificaciones en tiempo real
- [ ] Dashboard mejorado

---

**Versión:** 2.1.0  
**Fecha:** 2025-10-29  
**Autor:** StarHotelHub Team

