import axios from 'axios';

// Configure axios defaults
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';

// Get CSRF token from meta tag
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// Base API URL for admin endpoints - using the working routes
const API_BASE_URL = '/admin/api';

// API utility functions
export const api = {
    // Generic GET request
    get: (endpoint) => axios.get(`${API_BASE_URL}${endpoint}`),
    
    // Generic POST request
    post: (endpoint, data) => axios.post(`${API_BASE_URL}${endpoint}`, data),
    
    // Generic PUT request
    put: (endpoint, data) => axios.put(`${API_BASE_URL}${endpoint}`, data),
    
    // Generic DELETE request
    delete: (endpoint) => axios.delete(`${API_BASE_URL}${endpoint}`),
    
    // File upload with FormData
    upload: (endpoint, formData) => {
        return axios.post(`${API_BASE_URL}${endpoint}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
    },

    // Specific API endpoints
    dashboard: {
        getStats: () => api.get('/dashboard/stats'),
        getQuickActions: () => api.get('/dashboard/quick-actions'),
    },

    analytics: {
        get: (params = {}) => api.get('/analytics?' + new URLSearchParams(params)),
    },

    news: {
        getAll: (params = {}) => api.get('/news?' + new URLSearchParams(params)),
        get: (id) => api.get(`/news/${id}`),
        create: (data) => {
            if (data instanceof FormData) {
                return api.upload('/news', data);
            }
            return api.post('/news', data);
        },
        update: (id, data) => {
            if (data instanceof FormData) {
                // For file uploads, we need to use POST with _method=PUT
                data.append('_method', 'PUT');
                return axios.post(`${API_BASE_URL}/news/${id}`, data, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
            }
            return api.put(`/news/${id}`, data);
        },
        delete: (id) => api.delete(`/news/${id}`),
    },

    programs: {
        getAll: (params = {}) => api.get('/programs?' + new URLSearchParams(params)),
        get: (id) => api.get(`/programs/${id}`),
        create: (data) => {
            if (data instanceof FormData) {
                return api.upload('/programs', data);
            }
            return api.post('/programs', data);
        },
        update: (id, data) => {
            if (data instanceof FormData) {
                // For file uploads, we need to use POST with _method=PUT
                data.append('_method', 'PUT');
                return api.post(`/programs/${id}`, data);
            }
            return api.put(`/programs/${id}`, data);
        },
        delete: (id) => api.delete(`/programs/${id}`),
        
        // Podcasts nested under programs
        podcasts: {
            getAll: (programId, params = {}) => api.get(`/programs/${programId}/podcasts?` + new URLSearchParams(params)),
            get: (programId, id) => api.get(`/programs/${programId}/podcasts/${id}`),
            create: (programId, data) => api.upload(`/programs/${programId}/podcasts`, data),
            update: (programId, id, data) => api.post(`/programs/${programId}/podcasts/${id}`, data),
            delete: (programId, id) => api.delete(`/programs/${programId}/podcasts/${id}`),
        }
    },

    events: {
        getAll: (params = {}) => api.get('/events?' + new URLSearchParams(params)),
        get: (id) => api.get(`/events/${id}`),
        create: (data) => {
            if (data instanceof FormData) {
                return api.upload('/events', data);
            }
            return api.post('/events', data);
        },
        update: (id, data) => {
            if (data instanceof FormData) {
                // For file uploads, we need to use POST with _method=PUT
                data.append('_method', 'PUT');
                return api.post(`/events/${id}`, data);
            }
            return api.put(`/events/${id}`, data);
        },
        delete: (id) => api.delete(`/events/${id}`),
    },

    galleries: {
        getAll: (params = {}) => api.get('/galleries?' + new URLSearchParams(params)),
        get: (id) => api.get(`/galleries/${id}`),
        create: (data) => {
            if (data instanceof FormData) {
                return api.upload('/galleries', data);
            }
            return api.post('/galleries', data);
        },
        update: (id, data) => {
            if (data instanceof FormData) {
                // For file uploads, we need to use POST with _method=PUT
                data.append('_method', 'PUT');
                return api.post(`/galleries/${id}`, data);
            }
            return api.put(`/galleries/${id}`, data);
        },
        delete: (id) => api.delete(`/galleries/${id}`),
        addImages: (id, formData) => api.upload(`/galleries/${id}/images`, formData),
        reorderImages: (id, images) => api.put(`/galleries/${id}/reorder`, { images }),
    },

    comments: {
        getAll: (params = {}) => api.get('/comments?' + new URLSearchParams(params)),
        approve: (id) => api.post(`/comments/${id}/approve`),
        reject: (id) => api.post(`/comments/${id}/reject`),
        delete: (id) => api.delete(`/comments/${id}`),
        bulkApprove: (commentIds) => api.post('/comments/bulk-approve', { comment_ids: commentIds }),
        bulkReject: (commentIds) => api.post('/comments/bulk-reject', { comment_ids: commentIds }),
        bulkDelete: (commentIds) => api.delete('/comments/bulk-destroy', { data: { comment_ids: commentIds } }),
    },

    sports: {
        getAll: (params = {}) => api.get('/sports?' + new URLSearchParams(params)),
        get: (id) => api.get(`/sports/${id}`),
        create: (data) => api.post('/sports', data),
        update: (id, data) => api.post(`/sports/${id}`, { ...data, _method: 'PUT' }),
        delete: (id) => api.delete(`/sports/${id}`),
    },

    djs: {
        getAll: (params = {}) => api.get('/djs?' + new URLSearchParams(params)),
        get: (id) => api.get(`/djs/${id}`),
        create: (data) => api.post('/djs', data),
        update: (id, data) => api.post(`/djs/${id}`, { ...data, _method: 'PUT' }),
        delete: (id) => api.delete(`/djs/${id}`),
    },
};

// Response interceptor for error handling
axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            // Redirect to login if unauthorized
            window.location.href = '/login';
        } else if (error.response?.status === 419) {
            // CSRF token mismatch - reload page
            window.location.reload();
        }
        return Promise.reject(error);
    }
);

export default api;