-- Agregar campo para marcar contraseñas temporales
ALTER TABLE `usuarios` 
ADD COLUMN `temp_password` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = contraseña temporal, 0 = contraseña normal' AFTER `clave`;

