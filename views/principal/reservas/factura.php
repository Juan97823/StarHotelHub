<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: white;
            color: #333;
            padding: 20px;
        }
        
        .factura-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 40px;
            border: 1px solid #ddd;
        }
        
        .factura-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }
        
        .factura-header img {
            max-width: 150px;
            height: auto;
        }
        
        .factura-numero {
            text-align: right;
        }
        
        .factura-numero h3 {
            color: #007bff;
            margin-bottom: 5px;
        }
        
        .factura-numero p {
            font-size: 12px;
            color: #666;
        }
        
        .factura-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .info-section h5 {
            color: #007bff;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .info-section p {
            font-size: 13px;
            margin-bottom: 5px;
            line-height: 1.6;
        }
        
        .factura-items {
            margin-bottom: 30px;
        }
        
        .factura-items table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .factura-items th {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 13px;
        }
        
        .factura-items td {
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 13px;
        }
        
        .factura-totales {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }
        
        .totales-box {
            width: 300px;
            border: 1px solid #ddd;
        }
        
        .totales-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            font-size: 13px;
        }
        
        .totales-row.total {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            font-size: 16px;
            border-bottom: none;
        }
        
        .factura-footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
            margin-top: 30px;
        }
        
        .print-button {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .print-button button {
            padding: 10px 30px;
            font-size: 14px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .factura-container {
                border: none;
                padding: 0;
                max-width: 100%;
            }
            
            .print-button {
                display: none;
            }
            
            .factura-header {
                border-bottom: 2px solid #000;
            }
        }
    </style>
</head>
<body>
    <div class="print-button">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="bx bx-printer"></i> Imprimir Factura
        </button>
        <button class="btn btn-secondary" onclick="window.close()">
            <i class="bx bx-x"></i> Cerrar
        </button>
    </div>

    <div class="factura-container">
        <!-- Encabezado -->
        <div class="factura-header">
            <div>
                <img src="<?php echo RUTA_PRINCIPAL . 'assets/img/logo.png'; ?>" alt="Logo Hotel">
            </div>
            <div class="factura-numero">
                <h3>FACTURA</h3>
                <p>Nº: <?php echo $data['factura']['numero']; ?></p>
                <p>Fecha: <?php echo date("d/m/Y"); ?></p>
            </div>
        </div>

        <!-- Información Cliente y Hotel -->
        <div class="factura-info">
            <div class="info-section">
                <h5>INFORMACIÓN DEL CLIENTE</h5>
                <p><strong><?php echo $data['usuario']['nombre']; ?></strong></p>
                <p>Email: <?php echo $data['usuario']['correo']; ?></p>
            </div>
            <div class="info-section">
                <h5>INFORMACIÓN DEL HOTEL</h5>
                <p><strong>StarHotelHub</strong></p>
                <p>Dirección: Calle Principal 123</p>
                <p>Email: info@starhotelhub.com</p>
            </div>
        </div>

        <!-- Detalles de la Reserva -->
        <div class="factura-items">
            <table>
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Valor Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong><?php echo $data['habitacion']['estilo']; ?></strong><br>
                            <small>Habitación Nº <?php echo $data['reserva']['id_habitacion']; ?></small><br>
                            <small>Del <?php echo date("d/m/Y", strtotime($data['reserva']['fecha_ingreso'])); ?> al <?php echo date("d/m/Y", strtotime($data['reserva']['fecha_salida'])); ?></small>
                        </td>
                        <td><?php echo $data['factura']['noches']; ?> noche(s)</td>
                        <td>$<?php echo number_format($data['factura']['precio_noche'], 2); ?></td>
                        <td>$<?php echo number_format($data['factura']['total'], 2); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Totales -->
        <div class="factura-totales">
            <div class="totales-box">
                <div class="totales-row">
                    <span>Subtotal (sin IVA):</span>
                    <span>$<?php echo number_format($data['factura']['subtotal'], 2); ?></span>
                </div>
                <div class="totales-row">
                    <span>IVA (19% incluido):</span>
                    <span>$<?php echo number_format($data['factura']['impuestos'], 2); ?></span>
                </div>
                <div class="totales-row total">
                    <span>TOTAL A PAGAR:</span>
                    <span>$<?php echo number_format($data['factura']['total'], 2); ?></span>
                </div>
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="factura-footer">
            <p><strong>Código de Reserva:</strong> <?php echo $data['reserva']['cod_reserva']; ?></p>
            <p><strong>Número de Transacción:</strong> <?php echo $data['reserva']['num_transaccion']; ?></p>
            <p style="margin-top: 15px; font-size: 11px;">
                Gracias por su reserva. Esta factura es válida como comprobante de pago.<br>
                Para consultas, contáctenos a info@starhotelhub.com
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

