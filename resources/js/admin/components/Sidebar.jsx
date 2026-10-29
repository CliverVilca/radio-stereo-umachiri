import React from 'react';
import { NavLink } from 'react-router-dom';
import { NAV_ITEMS } from '../utils/constants';

export default function Sidebar() {
  return (
    <nav
      style={{
        width: '260px',
        backgroundColor: '#1e293b',
        color: '#cbd5e1',
        display: 'flex',
        flexDirection: 'column',
        height: '100vh',
        position: 'fixed',
        top: 0,
        left: 0,
        padding: '2rem 1.5rem',
        boxShadow: '2px 0 8px rgba(0,0,0,0.7)',
      }}
    >
      <div style={{ marginBottom: '2rem', textAlign: 'center' }}>
        <h3 style={{ fontWeight: 700, fontSize: '1.5rem', letterSpacing: '1px' }}>
          Admin Panel
        </h3>
      </div>
      <div style={{ flexGrow: 1 }}>
        {NAV_ITEMS.map(({ to, icon, label }) => (
          <NavLink
            key={to}
            to={to}
            style={({ isActive }) => ({
              display: 'flex',
              alignItems: 'center',
              padding: '1rem 1.5rem',
              color: isActive ? 'white' : '#cbd5e1',
              textDecoration: 'none',
              fontWeight: isActive ? 700 : 600,
              fontSize: '1rem',
              borderLeft: isActive ? '4px solid #3b82f6' : '4px solid transparent',
              transition: 'background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease',
              cursor: 'pointer',
              backgroundColor: isActive ? '#2563eb' : 'transparent',
              marginBottom: '0.25rem',
              borderRadius: '6px',
            })}
            end
          >
            <i
              className={icon}
              style={{ marginRight: '1rem', fontSize: '1.2rem', width: '24px', textAlign: 'center' }}
            ></i>
            <span>{label}</span>
          </NavLink>
        ))}
      </div>
    </nav>
  );
}
