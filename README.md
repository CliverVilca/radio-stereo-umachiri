# Radio Stereo Umachiri - Laravel + Livewire

Sistema web profesional para Radio Stereo Umachiri construido con Laravel 12 y Livewire 3.

## 🚀 Características

- **Laravel 12**: Framework PHP moderno y robusto
- **Livewire 3**: Componentes reactivos sin JavaScript complejo
- **Diseño Responsivo**: Optimizado para todos los dispositivos
- **Reproductor de Radio en Vivo**: Componente Livewire interactivo
- **Formulario de Contacto**: Validación en tiempo real
- **Galería de Imágenes**: Con lightbox integrado
- **SEO Optimizado**: Meta tags y estructura semántica
- **Accesibilidad**: Cumple estándares WCAG
- **Performance**: Lazy loading y optimizaciones

## 📋 Requisitos

- PHP 8.2 o superior
- Composer
- Node.js y NPM
- Servidor web (Apache/Nginx)

## 🛠️ Instalación

1. **Clonar el repositorio**
   ```bash
   git clone [url-del-repositorio]
   cd radio-stereo-umachiri-laravel
   ```

2. **Instalar dependencias PHP**
   ```bash
   composer install
   ```

3. **Instalar dependencias Node.js**
   ```bash
   npm install
   ```

4. **Configurar variables de entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configurar la base de datos** (opcional)
   ```bash
   php artisan migrate
   ```

6. **Compilar assets**
   ```bash
   npm run build
   ```

7. **Iniciar el servidor de desarrollo**
   ```bash
   php artisan serve
   ```

## 🎵 Configuración del Stream de Radio

Edita el archivo `app/Livewire/RadioPlayer.php` y actualiza la variable `$streamUrl`:

```php
public $streamUrl = 'https://tu-stream-url-aqui.com/stream';
```

## 📁 Estructura del Proyecto

```
radio-stereo-umachiri-laravel/
├── app/
│   ├── Http/Controllers/
│   │   ├── HomeController.php
│   │   └── ContactController.php
│   └── Livewire/
│       ├── RadioPlayer.php
│       └── ContactForm.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   ├── livewire/
│   │   │   ├── radio-player.blade.php
│   │   │   └── contact-form.blade.php
│   │   └── home.blade.php
│   ├── css/
│   │   └── app.css
│   └── js/
│       └── app.js
├── public/
│   └── assets/
│       └── images/
│           └── gallery/
└── routes/
    └── web.php
```

## 🎨 Personalización

### Colores
Los colores principales están definidos en CSS variables:
```css
--primary-color: #667eea;
--secondary-color: #764ba2;
```

### Tipografía
El proyecto usa Google Fonts (Poppins). Puedes cambiar la fuente en `resources/views/layouts/app.blade.php`.

### Imágenes
Coloca las imágenes en `public/assets/images/`:
- `logo.png` - Logo de la radio
- `radio-studio.jpg` - Imagen del estudio
- `about-radio.jpg` - Imagen de la sección Nosotros
- `gallery/` - Imágenes de la galería

## 🔧 Funcionalidades

### Reproductor de Radio
- Play/Pause con botón y teclado (Espacio)
- Control de volumen con slider y teclado (Ctrl + Flechas)
- Indicador "EN VIVO" animado
- Estados de carga y error

### Formulario de Contacto
- Validación en tiempo real con Livewire
- Mensajes de éxito y error
- Protección CSRF automática
- Rate limiting integrado

### Navegación
- Menú responsive
- Smooth scrolling
- Header con efecto de scroll
- Botón "Volver arriba"

### Galería
- Grid responsive
- Lightbox al hacer clic
- Lazy loading de imágenes
- Animaciones suaves

## 🚀 Despliegue

### Producción
1. Configurar variables de entorno para producción
2. Optimizar assets:
   ```bash
   npm run build
   ```
3. Configurar el servidor web (Apache/Nginx)
4. Configurar SSL/HTTPS

### Hosting Compartido
1. Subir archivos al servidor
2. Configurar `.env` con datos de producción
3. Ejecutar `composer install --optimize-autoloader --no-dev`
4. Configurar la base de datos si es necesario

## 📊 Analytics

El proyecto incluye tracking básico de eventos. Para integrar Google Analytics:

1. Agrega el script de GA en `resources/views/layouts/app.blade.php`
2. Los eventos se trackean automáticamente:
   - Clicks en el reproductor
   - Navegación
   - Envío de formularios

## 🔒 Seguridad

- CSRF protection automática
- Validación de entrada
- Rate limiting en formularios
- Headers de seguridad
- Sanitización de datos

## 📱 Responsive Design

El sitio está optimizado para:
- Desktop (1200px+)
- Tablet (768px - 1199px)
- Mobile (320px - 767px)

## 🎯 SEO

- Meta tags optimizados
- Estructura HTML semántica
- Open Graph tags
- Schema markup básico
- URLs amigables

## 🛠️ Comandos Útiles

```bash
# Limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Optimizar para producción
php artisan optimize
composer install --optimize-autoloader --no-dev

# Verificar rutas
php artisan route:list

# Generar documentación de API (si aplica)
php artisan api:docs
```

## 🤝 Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 📞 Soporte

Para soporte técnico o preguntas:
- Email: soporte@radioumachiri.com
- Teléfono: +51 999 999 999

## 🔄 Changelog

### v1.0.0 (2024-01-08)
- ✅ Implementación inicial con Laravel 12
- ✅ Integración de Livewire 3
- ✅ Reproductor de radio en vivo
- ✅ Formulario de contacto reactivo
- ✅ Diseño responsive completo
- ✅ Galería con lightbox
- ✅ Optimizaciones de performance
- ✅ SEO básico implementado

---

**Radio Stereo Umachiri** - Llegando a tu corazón y más allá de tu imaginación
