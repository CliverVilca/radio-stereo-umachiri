import React, { useState, useEffect } from 'react';

export default function ResponsiveTable({ 
  data, 
  columns, 
  onEdit, 
  onDelete, 
  loading = false,
  emptyMessage = "No hay datos disponibles",
  emptyIcon = "fas fa-inbox"
}) {
  const [isMobile, setIsMobile] = useState(window.innerWidth <= 768);

  useEffect(() => {
    const handleResize = () => {
      setIsMobile(window.innerWidth <= 768);
    };

    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
  }, []);

  if (loading) {
    return (
      <div style={{ 
        textAlign: 'center', 
        color: '#94a3b8', 
        padding: '3rem',
        backgroundColor: '#1f2937',
        borderRadius: '8px'
      }}>
        <i className="fas fa-spinner fa-spin" style={{ fontSize: '2rem', marginBottom: '1rem' }}></i>
        <p>Cargando datos...</p>
      </div>
    );
  }

  if (!data || data.length === 0) {
    return (
      <div style={{ 
        textAlign: 'center', 
        color: '#94a3b8', 
        padding: '3rem',
        backgroundColor: '#1f2937',
        borderRadius: '8px'
      }}>
        <i className={emptyIcon} style={{ fontSize: '3rem', marginBottom: '1rem', opacity: 0.5 }}></i>
        <p>{emptyMessage}</p>
      </div>
    );
  }

  // Mobile Card View
  if (isMobile) {
    return (
      <div style={{ display: 'grid', gap: '1rem' }}>
        {data.map((item, index) => (
          <div
            key={item.id || index}
            style={{
              backgroundColor: '#1f2937',
              borderRadius: '8px',
              padding: '1rem',
              border: '1px solid #374151'
            }}
          >
            {columns.map((column) => (
              <div key={column.key} style={{ marginBottom: '0.75rem' }}>
                <div style={{ 
                  color: '#9ca3af', 
                  fontSize: '0.8rem', 
                  fontWeight: '600',
                  marginBottom: '0.25rem',
                  textTransform: 'uppercase',
                  letterSpacing: '0.5px'
                }}>
                  {column.label}
                </div>
                <div style={{ color: '#e5e7eb' }}>
                  {column.render ? column.render(item) : item[column.key]}
                </div>
              </div>
            ))}
            
            {/* Actions */}
            {(onEdit || onDelete) && (
              <div style={{ 
                display: 'flex', 
                gap: '0.5rem', 
                marginTop: '1rem',
                paddingTop: '1rem',
                borderTop: '1px solid #374151'
              }}>
                {onEdit && (
                  <button
                    onClick={() => onEdit(item)}
                    style={{
                      backgroundColor: '#2563eb',
                      color: 'white',
                      border: 'none',
                      borderRadius: '6px',
                      padding: '0.75rem 1rem',
                      cursor: 'pointer',
                      fontSize: '0.9rem',
                      fontWeight: '600',
                      display: 'flex',
                      alignItems: 'center',
                      gap: '0.5rem',
                      flex: 1,
                      justifyContent: 'center'
                    }}
                  >
                    <i className="fas fa-edit"></i>
                    Editar
                  </button>
                )}
                {onDelete && (
                  <button
                    onClick={() => onDelete(item)}
                    style={{
                      backgroundColor: '#ef4444',
                      color: 'white',
                      border: 'none',
                      borderRadius: '6px',
                      padding: '0.75rem 1rem',
                      cursor: 'pointer',
                      fontSize: '0.9rem',
                      fontWeight: '600',
                      display: 'flex',
                      alignItems: 'center',
                      gap: '0.5rem',
                      flex: 1,
                      justifyContent: 'center'
                    }}
                  >
                    <i className="fas fa-trash"></i>
                    Eliminar
                  </button>
                )}
              </div>
            )}
          </div>
        ))}
      </div>
    );
  }

  // Desktop Table View
  return (
    <div style={{
      backgroundColor: '#1f2937',
      borderRadius: '8px',
      overflow: 'hidden'
    }}>
      <div style={{ overflowX: 'auto' }}>
        <table style={{ width: '100%', borderCollapse: 'collapse' }}>
          <thead>
            <tr style={{ backgroundColor: '#374151' }}>
              {columns.map((column) => (
                <th
                  key={column.key}
                  style={{ 
                    padding: '1rem', 
                    textAlign: column.align || 'left', 
                    color: '#e5e7eb', 
                    fontWeight: '600',
                    whiteSpace: 'nowrap'
                  }}
                >
                  {column.label}
                </th>
              ))}
              {(onEdit || onDelete) && (
                <th style={{ 
                  padding: '1rem', 
                  textAlign: 'center', 
                  color: '#e5e7eb', 
                  fontWeight: '600' 
                }}>
                  Acciones
                </th>
              )}
            </tr>
          </thead>
          <tbody>
            {data.map((item, index) => (
              <tr 
                key={item.id || index}
                style={{ 
                  borderBottom: '1px solid #374151',
                  backgroundColor: index % 2 === 0 ? '#1f2937' : '#111827'
                }}
              >
                {columns.map((column) => (
                  <td
                    key={column.key}
                    style={{ 
                      padding: '1rem',
                      color: '#d1d5db',
                      textAlign: column.align || 'left'
                    }}
                  >
                    {column.render ? column.render(item) : item[column.key]}
                  </td>
                ))}
                {(onEdit || onDelete) && (
                  <td style={{ padding: '1rem', textAlign: 'center' }}>
                    <div style={{ display: 'flex', gap: '0.5rem', justifyContent: 'center' }}>
                      {onEdit && (
                        <button
                          onClick={() => onEdit(item)}
                          style={{
                            backgroundColor: '#2563eb',
                            color: 'white',
                            border: 'none',
                            borderRadius: '4px',
                            padding: '0.5rem',
                            cursor: 'pointer',
                            fontSize: '0.8rem'
                          }}
                          title="Editar"
                        >
                          <i className="fas fa-edit"></i>
                        </button>
                      )}
                      {onDelete && (
                        <button
                          onClick={() => onDelete(item)}
                          style={{
                            backgroundColor: '#ef4444',
                            color: 'white',
                            border: 'none',
                            borderRadius: '4px',
                            padding: '0.5rem',
                            cursor: 'pointer',
                            fontSize: '0.8rem'
                          }}
                          title="Eliminar"
                        >
                          <i className="fas fa-trash"></i>
                        </button>
                      )}
                    </div>
                  </td>
                )}
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}