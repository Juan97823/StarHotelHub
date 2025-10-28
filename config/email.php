<?php
/**
 * Configuración de Emails
 * 
 * Este archivo contiene la configuración para el envío de emails
 * Soporta tanto PHP mail() como SMTP
 */

// ============================================
// CONFIGURACIÓN DE EMAILS
// ============================================

// Tipo de envío: 'mail' (PHP mail) o 'smtp' (SMTP)
define('EMAIL_DRIVER', getenv('EMAIL_DRIVER') ?: 'smtp');

// Email del remitente
define('EMAIL_FROM', getenv('EMAIL_FROM') ?: 'starhotelhub@gmail.com');

// Nombre del remitente
define('EMAIL_FROM_NAME', getenv('EMAIL_FROM_NAME') ?: 'StarHotelHub');

// ============================================
// CONFIGURACIÓN SMTP (si se usa SMTP)
// ============================================

define('SMTP_HOST', getenv('SMTP_HOST') ?: 'smtp.gmail.com');
define('SMTP_PORT', getenv('SMTP_PORT') ?: 587);
define('SMTP_USER', getenv('SMTP_USER') ?: 'starhotelhub@gmail.com');
// IMPORTANTE: Esta contraseña de aplicación se puede definir aquí para pruebas locales
define('SMTP_PASS', getenv('SMTP_PASS') ?: 'lofwwzbsmhtyywgx');
define('SMTP_SECURE', getenv('SMTP_SECURE') ?: 'tls'); // 'tls' o 'ssl'

// ============================================
// CONFIGURACIÓN DE PLANTILLAS
// ============================================

// Ruta de las plantillas de email
define('EMAIL_TEMPLATES_PATH', RUTA_RAIZ . '/views/emails/');

// ============================================
// CONFIGURACIÓN DE SEGURIDAD
// ============================================

// Token para recuperación de contraseña (duración en horas)
define('PASSWORD_RESET_TOKEN_EXPIRY', 24);

// Contraseña temporal (longitud)
define('TEMP_PASSWORD_LENGTH', 12);

