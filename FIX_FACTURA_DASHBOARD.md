# Fix: Botón de Factura en Dashboard Admin

## Problema Identificado

Al hacer clic en el botón "Factura" en el dashboard de admin, aparecía:
- URL: `http://localhost/Starhotelhub/reserva/factura/undefined`
- Error: `{"error":"Reserva no encontrada"}`

## Causa Raíz

El problema tenía 3 causas:

1. **Modelo `DashboardModel.php`**: No estaba devolviendo el campo `id` de la reserva
2. **Controlador `Dashboard.php`**: Estaba usando nombres de campos incorrectos (`nombre_usuario` en lugar de `cliente`)
3. **JavaScript `dashboard.js`**: Estaba usando nombres de propiedades incorrectos para el gráfico

## Archivos Modificados

### 1. `models/admin/DashboardModel.php`

**Antes:**
```php
$sql = "SELECT r.fecha_reserva, r.estado, u.nombre AS cliente, h.estilo AS habitacion
        FROM reservas r
        INNER JOIN usuarios u ON r.id_usuario = u.id
        INNER JOIN habitaciones h ON r.id_habitacion = h.id
        ORDER BY r.fecha_reserva DESC
        LIMIT ?";
```

**Después:**
```php
$sql = "SELECT r.id, r.fecha_reserva, r.fecha_ingreso, r.estado, u.nombre AS cliente, h.estilo AS habitacion
        FROM reservas r
        INNER JOIN usuarios u ON r.id_usuario = u.id
        INNER JOIN habitaciones h ON r.id_habitacion = h.id
        ORDER BY r.fecha_reserva DESC
        LIMIT ?";
```

**Cambios:**
- ✅ Agregado `r.id` para identificar la reserva
- ✅ Agregado `r.fecha_ingreso` para mostrar la fecha correcta

---

### 2. `controllers/Admin/Dashboard.php`

**Antes:**
```php
$ultimasReservas[] = [
    'cliente' => $reserva['nombre_usuario'],    // Campo incorrecto
    'habitacion' => $reserva['habitacion'],
    'fecha_reserva' => $reserva['fecha_ingreso'],
    'estado_texto' => $estado_texto
];
```

**Después:**
```php
$ultimasReservas[] = [
    'id' => $reserva['id'],                      // ID de la reserva para la factura
    'cliente' => $reserva['cliente'],            // Nombre del cliente
    'habitacion' => $reserva['habitacion'],      // Estilo de habitación
    'fecha_reserva' => $reserva['fecha_ingreso'], // Fecha de ingreso
    'estado' => $reserva['estado'],              // Estado numérico para el badge
    'estado_texto' => $estado_texto              // Estado en texto
];
```

**Cambios:**
- ✅ Agregado `'id'` para el botón de factura
- ✅ Corregido `'nombre_usuario'` a `'cliente'`
- ✅ Agregado `'estado'` numérico para el badge en JavaScript

---

### 3. `assets/admin/js/dashboard.js`

**Antes:**
```javascript
function actualizarIndicadores(data) {
  document.getElementById("reservasHoy").textContent = data.reservasHoy ?? "0";
  // ...
}

function actualizarGrafico(graficoData) {
  graficoReservas.data.labels = graficoData.etiquetas;  // Propiedad incorrecta
  graficoReservas.data.datasets[0].data = graficoData.valores;  // Propiedad incorrecta
  // ...
}

// En cargarDatosDashboard:
actualizarIndicadores(data);  // data plano
actualizarGrafico(data.grafico);  // Propiedad incorrecta
```

**Después:**
```javascript
function actualizarIndicadores(indicadores) {
  if (!indicadores) return;
  document.getElementById("reservasHoy").textContent = indicadores.reservasHoy ?? "0";
  // ...
}

function actualizarGrafico(graficoData) {
  if (!graficoData) return;
  graficoReservas.data.labels = graficoData.labels ?? [];  // Correcto
  graficoReservas.data.datasets[0].data = graficoData.data ?? [];  // Correcto
  // ...
}

// En cargarDatosDashboard:
actualizarIndicadores(data.indicadores);  // Estructura correcta
actualizarGrafico(data.graficoReservas);  // Propiedad correcta
```

**Cambios:**
- ✅ Corregido acceso a `data.indicadores` en lugar de `data` plano
- ✅ Corregido `graficoData.labels` y `graficoData.data` (antes eran `etiquetas` y `valores`)
- ✅ Agregadas validaciones con `??` para evitar errores

---

## Estructura de Datos JSON Devuelta

El endpoint `admin/dashboard/getData` ahora devuelve:

```json
{
  "indicadores": {
    "reservasHoy": 5,
    "habitacionesDisponibles": 12,
    "ingresosMes": "1.500.000",
    "totalClientes": 45
  },
  "graficoReservas": {
    "labels": ["2025-10-23", "2025-10-24", "2025-10-25", ...],
    "data": [3, 5, 2, 4, 6, 3, 7]
  },
  "ultimasReservas": [
    {
      "id": 123,
      "cliente": "Juan Pérez",
      "habitacion": "Suite Ejecutiva",
      "fecha_reserva": "2025-10-29",
      "estado": 1,
      "estado_texto": "Pendiente"
    },
    // ...
  ]
}
```

---

## Flujo de Factura

1. **Usuario hace clic en botón "Factura"** en el dashboard
2. **JavaScript ejecuta:** `imprimirFactura(reserva.id)`
3. **Se abre ventana nueva con URL:** `http://localhost/Starhotelhub/reserva/factura/123`
4. **Controlador `Reserva::factura($idReserva)`** procesa la solicitud:
   - Valida que el ID existe
   - Obtiene datos de la reserva
   - Verifica permisos (admin, empleado, o cliente propietario)
   - Calcula factura (noches, subtotal, impuestos, total)
   - Renderiza vista `views/principal/reservas/factura.php`

---

## Verificación

Para verificar que funciona:

1. **Ir al dashboard admin:**
   ```
   http://localhost/Starhotelhub/admin/dashboard
   ```

2. **Verificar que la tabla "Últimas 5 Reservas" muestra:**
   - Cliente
   - Habitación
   - Fecha de Reserva
   - Estado (badge con color)
   - Botón "Factura"

3. **Hacer clic en "Factura":**
   - Debe abrir una ventana nueva
   - URL debe ser: `http://localhost/Starhotelhub/reserva/factura/[ID]`
   - Debe mostrar la factura completa con:
     - Logo del hotel
     - Número de factura
     - Datos del cliente
     - Detalles de la reserva
     - Desglose de costos
     - Botón de imprimir

---

## Notas Importantes

1. **Permisos:** Solo pueden ver facturas:
   - Administradores (rol = 1)
   - Empleados (rol = 2)
   - El cliente propietario de la reserva (rol = 3)

2. **Cálculo de Factura:**
   - El precio por noche YA incluye IVA (19%)
   - Se calcula: `subtotal = total / 1.19`
   - Se calcula: `impuestos = total - subtotal`

3. **Formato de Número de Factura:**
   - Formato: `FAC-000123`
   - Se usa el ID de la reserva con padding de 6 dígitos

---

## Pruebas Realizadas

- ✅ Botón de factura en dashboard muestra ID correcto
- ✅ URL de factura se genera correctamente
- ✅ Vista de factura se renderiza sin errores
- ✅ Indicadores del dashboard se actualizan correctamente
- ✅ Gráfico de reservas se muestra correctamente
- ✅ Tabla de últimas reservas muestra datos correctos

---

## Fecha de Fix
2025-10-29

