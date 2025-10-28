<?php
/**
 * ARCHIVO DE EJEMPLO - email.example.php
 * 
 * Copia este archivo a email.php y configura tus valores
 * NO SUBAS email.php a control de versiones (agrégalo a .gitignore)
 */

// ============================================
// CONFIGURACIÓN DE EMAILS
// ============================================

// Tipo de envío: 'mail' (PHP mail) o 'smtp' (SMTP)
// define('EMAIL_DRIVER', 'mail');
define('EMAIL_DRIVER', 'smtp');

// Email del remitente
define('EMAIL_FROM', 'noreply@starhotelhub.com');

// Nombre del remitente
define('EMAIL_FROM_NAME', 'StarHotelHub');

// ============================================
// CONFIGURACIÓN SMTP
// ============================================

// OPCIÓN 1: GMAIL
// 1. Habilita 2FA en tu cuenta de Google
// 2. Ve a https://myaccount.google.com/apppasswords
// 3. Crea una contraseña de aplicación
// 4. Usa esa contraseña aquí

define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'tu-email@gmail.com');
define('SMTP_PASS', 'tu-contraseña-app');
define('SMTP_SECURE', 'tls');

// ============================================
// OPCIÓN 2: OUTLOOK / HOTMAIL
// ============================================
/*
define('SMTP_HOST', 'smtp-mail.outlook.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'tu-email@outlook.com');
define('SMTP_PASS', 'tu-contraseña');
define('SMTP_SECURE', 'tls');
*/

// ============================================
// OPCIÓN 3: SENDGRID
// ============================================
/*
define('SMTP_HOST', 'smtp.sendgrid.net');
define('SMTP_PORT', 587);
define('SMTP_USER', 'apikey');
define('SMTP_PASS', 'tu-api-key-sendgrid');
define('SMTP_SECURE', 'tls');
*/

// ============================================
// OPCIÓN 4: MAILGUN
// ============================================
/*
define('SMTP_HOST', 'smtp.mailgun.org');
define('SMTP_PORT', 587);
define('SMTP_USER', 'postmaster@tu-dominio.mailgun.org');
define('SMTP_PASS', 'tu-contraseña-mailgun');
define('SMTP_SECURE', 'tls');
*/

// ============================================
// OPCIÓN 5: SERVIDOR SMTP PERSONALIZADO
// ============================================
/*
define('SMTP_HOST', 'mail.tu-servidor.com');
define('SMTP_PORT', 587); // o 465 para SSL
define('SMTP_USER', 'tu-usuario');
define('SMTP_PASS', 'tu-contraseña');
define('SMTP_SECURE', 'tls'); // o 'ssl'
*/

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

