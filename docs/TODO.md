# Plan de Mejoras para Stereo Umachiri

## 1. Corrección de Bugs Críticos
- [x] Arreglar WeatherController: Cambiar env() a env('OPENWEATHER_API_KEY') y agregar key al .env
- [x] Verificar modelos y relaciones (ej. Program, Podcast)

## 2. Optimizaciones de Rendimiento
- [x] Agregar caching a HomeController para noticias
- [x] Optimizar imágenes (lazy loading en vistas)
- [ ] Minificar assets con Vite
- [ ] Agregar CDN para external assets

## 3. Mejoras de Estilos Profesionales
- [x] Implementar modo oscuro con toggle en navbar
- [x] Mejorar animaciones (fade-in, hover)
- [ ] Actualizar tipografía (fuentes modernas)
- [ ] Mejorar responsive (mobile UX)

## 4. Mejoras Funcionales
- [x] Completar clima: Geolocalización dinámica
- [ ] Verificar radio player Livewire
- [ ] Agregar RSS feeds para noticias
- [ ] Implementar SEO (sitemap, structured data)
- [ ] Agregar accesibilidad (ARIA)

## 5. Verificación de Funcionamiento
- [x] Ejecutar php artisan serve y navegar rutas
- [ ] Probar admin panel y formularios
- [ ] Ejecutar tests y corregir
- [ ] Verificar PWA
