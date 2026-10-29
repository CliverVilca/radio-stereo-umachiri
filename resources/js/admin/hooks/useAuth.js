import { useState, useEffect, useCallback } from 'react';
import { api } from '../utils/api';

export function useAuth() {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);
  const [isAuthenticated, setIsAuthenticated] = useState(false);

  // Check authentication status
  const checkAuth = useCallback(async () => {
    try {
      setLoading(true);
      // Try to get user info from a protected endpoint
      const response = await api.get('/user');
      setUser(response.data);
      setIsAuthenticated(true);
    } catch (error) {
      setUser(null);
      setIsAuthenticated(false);
      
      // If unauthorized, redirect to login
      if (error.response?.status === 401) {
        window.location.href = '/login';
      }
    } finally {
      setLoading(false);
    }
  }, []);

  // Logout function
  const logout = useCallback(async () => {
    try {
      // Create a form and submit it to logout
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '/logout';
      
      // Add CSRF token
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
      if (csrfToken) {
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = csrfToken;
        form.appendChild(tokenInput);
      }
      
      document.body.appendChild(form);
      form.submit();
    } catch (error) {
      console.error('Logout error:', error);
      // Fallback: redirect to login
      window.location.href = '/login';
    }
  }, []);

  // Check if user has specific role
  const hasRole = useCallback((role) => {
    return user?.role === role;
  }, [user]);

  // Check if user has any of the specified roles
  const hasAnyRole = useCallback((roles) => {
    return roles.includes(user?.role);
  }, [user]);

  // Check if user is admin
  const isAdmin = useCallback(() => {
    return hasRole('admin');
  }, [hasRole]);

  // Initialize auth check on mount
  useEffect(() => {
    checkAuth();
  }, [checkAuth]);

  return {
    user,
    loading,
    isAuthenticated,
    checkAuth,
    logout,
    hasRole,
    hasAnyRole,
    isAdmin
  };
}

export default useAuth;