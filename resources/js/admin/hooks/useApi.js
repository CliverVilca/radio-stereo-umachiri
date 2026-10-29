import { useState, useEffect } from 'react';
import { api } from '../utils/api';

export const useApi = (endpoint, options = {}) => {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    const { immediate = true, method = 'GET' } = options;

    const execute = async (customEndpoint = endpoint, customOptions = {}) => {
        try {
            setLoading(true);
            setError(null);
            
            const finalEndpoint = customEndpoint || endpoint;
            const finalMethod = customOptions.method || method;
            
            let response;
            
            switch (finalMethod.toUpperCase()) {
                case 'GET':
                    response = await api.get(finalEndpoint);
                    break;
                case 'POST':
                    response = await api.post(finalEndpoint, customOptions.data);
                    break;
                case 'PUT':
                    response = await api.put(finalEndpoint, customOptions.data);
                    break;
                case 'DELETE':
                    response = await api.delete(finalEndpoint);
                    break;
                default:
                    throw new Error(`Unsupported method: ${finalMethod}`);
            }
            
            setData(response.data);
            return response.data;
        } catch (err) {
            setError(err);
            throw err;
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        if (immediate && endpoint) {
            execute();
        }
    }, [endpoint, immediate]);

    return {
        data,
        loading,
        error,
        execute,
        refetch: () => execute(),
    };
};

export default useApi;