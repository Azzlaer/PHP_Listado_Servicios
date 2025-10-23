# 🔧 Panel de Administración de Servicios de Windows vía PHP + PowerShell

![Preview](https://github.com/Azzlaer/PHP_Listado_Servicios/blob/main/Screenshot_1.png)

Este proyecto permite listar, iniciar y detener servicios de Windows desde una interfaz web desarrollada en PHP. Ideal para servidores que requieren control remoto de servicios específicos, como en un entorno Windows Server.

> 🖥️ Compatible con **Windows Server 2012 o superior** con PowerShell habilitado.

---

## 🧩 Características

- ✅ Listado solo de servicios autorizados desde `config.ini`.
- 🚀 Botones para **Iniciar** y **Detener** servicios.
- 🎨 Interfaz amigable, moderna y responsiva.
- 🎯 Código PHP puro, sin dependencias externas.
- 📄 Estilo personalizado con emojis y colores según el estado.

---

## 📦 Estructura del Proyecto

/mi-panel-servicios/
├── index.php
├── config.ini
├── README.md

---

## ⚙️ Requisitos

- PHP 7.0 o superior instalado en Windows
- Servidor Web (IIS, Apache, XAMPP, etc.)
- PowerShell habilitado
- Permisos de administrador para controlar servicios

---

## 🚀 Instalación

1. Clona este repositorio en tu servidor Windows:
git clone https://github.com/tuusuario/mi-panel-servicios.git

Abre el archivo config.ini y define los servicios que deseas administrar:

[ServiciosPermitidos]
servicios[] = wuauserv
servicios[] = Spooler
servicios[] = Dhcp
servicios[] = WinDefend


⚠️ Usa el nombre del servicio (por ejemplo, Spooler), no el nombre visible como "Print Spooler".

Accede al panel vía navegador:

http://localhost/mi-panel-servicios/index.php


🖱️ Uso
Los servicios permitidos se mostrarán en una tabla.

El estado se mostrará en:

🟢 Verde si está en ejecución (Running)

🔴 Rojo si está detenido (Stopped)

Puedes usar los botones:

🚀 Iniciar

⛔ Detener

Los cambios se aplican en tiempo real y la página se recarga automáticamente después de cada acción.

🔐 Seguridad
Solo los servicios definidos en config.ini son visibles y administrables.

El uso de PowerShell está limitado a comandos de Start-Service y Stop-Service.

Para mayor seguridad, protege el acceso con autenticación .htaccess o un sistema de login en PHP.

📷 Captura de Pantalla

📌 Notas
Asegúrate de que el servidor web tenga permisos suficientes para ejecutar PowerShell.

Puedes ejecutar el panel en local o desde red interna en entornos corporativos.

🤝 Contribuciones
¿Tienes sugerencias o mejoras? ¡Pull requests y issues son bienvenidos!