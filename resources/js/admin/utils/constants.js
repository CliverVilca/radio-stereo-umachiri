// Navigation items for the admin sidebar
export const NAV_ITEMS = [
  {
    to: '/dashboard',
    icon: 'fas fa-tachometer-alt',
    label: 'Dashboard'
  },
  {
    to: '/news',
    icon: 'fas fa-newspaper',
    label: 'Noticias'
  },
  {
    to: '/programs',
    icon: 'fas fa-broadcast-tower',
    label: 'Programas'
  },
  {
    to: '/events',
    icon: 'fas fa-calendar-alt',
    label: 'Eventos'
  },
  {
    to: '/galleries',
    icon: 'fas fa-images',
    label: 'Galerías'
  },
  {
    to: '/comments',
    icon: 'fas fa-comments',
    label: 'Comentarios'
  },
  {
    to: '/analytics',
    icon: 'fas fa-chart-line',
    label: 'Analytics'
  }
];

// Status colors for different content states
export const STATUS_COLORS = {
  draft: '#6b7280',
  published: '#16a34a',
  pending: '#f59e0b',
  approved: '#16a34a',
  rejected: '#ef4444',
  active: '#16a34a',
  inactive: '#6b7280'
};

// Status labels in Spanish
export const STATUS_LABELS = {
  draft: 'Borrador',
  published: 'Publicado',
  pending: 'Pendiente',
  approved: 'Aprobado',
  rejected: 'Rechazado',
  active: 'Activo',
  inactive: 'Inactivo'
};

// Days of the week in Spanish
export const DAYS_OF_WEEK = [
  'Lunes', 
  'Martes', 
  'Miércoles', 
  'Jueves', 
  'Viernes', 
  'Sábado', 
  'Domingo'
];

// File upload limits
export const FILE_LIMITS = {
  image: {
    maxSize: 2 * 1024 * 1024, // 2MB
    allowedTypes: ['image/jpeg', 'image/png', 'image/jpg', 'image/gif']
  },
  audio: {
    maxSize: 50 * 1024 * 1024, // 50MB
    allowedTypes: ['audio/mp3', 'audio/wav', 'audio/m4a']
  }
};

export default {
  NAV_ITEMS,
  STATUS_COLORS,
  STATUS_LABELS,
  DAYS_OF_WEEK,
  FILE_LIMITS
};