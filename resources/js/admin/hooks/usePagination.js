import { useState, useCallback } from 'react';

export function usePagination(initialPage = 1, initialPerPage = 10) {
  const [currentPage, setCurrentPage] = useState(initialPage);
  const [perPage, setPerPage] = useState(initialPerPage);
  const [totalItems, setTotalItems] = useState(0);
  const [totalPages, setTotalPages] = useState(0);

  const updatePagination = useCallback((paginationData) => {
    if (paginationData) {
      setCurrentPage(paginationData.current_page || 1);
      setTotalItems(paginationData.total || 0);
      setTotalPages(paginationData.last_page || 0);
      if (paginationData.per_page) {
        setPerPage(paginationData.per_page);
      }
    }
  }, []);

  const goToPage = useCallback((page) => {
    if (page >= 1 && page <= totalPages) {
      setCurrentPage(page);
    }
  }, [totalPages]);

  const goToNextPage = useCallback(() => {
    if (currentPage < totalPages) {
      setCurrentPage(prev => prev + 1);
    }
  }, [currentPage, totalPages]);

  const goToPreviousPage = useCallback(() => {
    if (currentPage > 1) {
      setCurrentPage(prev => prev - 1);
    }
  }, [currentPage]);

  const goToFirstPage = useCallback(() => {
    setCurrentPage(1);
  }, []);

  const goToLastPage = useCallback(() => {
    setCurrentPage(totalPages);
  }, [totalPages]);

  const changePerPage = useCallback((newPerPage) => {
    setPerPage(newPerPage);
    setCurrentPage(1); // Reset to first page when changing per page
  }, []);

  const reset = useCallback(() => {
    setCurrentPage(initialPage);
    setPerPage(initialPerPage);
    setTotalItems(0);
    setTotalPages(0);
  }, [initialPage, initialPerPage]);

  const getPageNumbers = useCallback((maxVisible = 5) => {
    const pages = [];
    const half = Math.floor(maxVisible / 2);
    
    let start = Math.max(1, currentPage - half);
    let end = Math.min(totalPages, start + maxVisible - 1);
    
    // Adjust start if we're near the end
    if (end - start + 1 < maxVisible) {
      start = Math.max(1, end - maxVisible + 1);
    }
    
    for (let i = start; i <= end; i++) {
      pages.push(i);
    }
    
    return pages;
  }, [currentPage, totalPages]);

  const hasNextPage = currentPage < totalPages;
  const hasPreviousPage = currentPage > 1;
  const isFirstPage = currentPage === 1;
  const isLastPage = currentPage === totalPages;

  return {
    // State
    currentPage,
    perPage,
    totalItems,
    totalPages,
    
    // Computed
    hasNextPage,
    hasPreviousPage,
    isFirstPage,
    isLastPage,
    
    // Actions
    goToPage,
    goToNextPage,
    goToPreviousPage,
    goToFirstPage,
    goToLastPage,
    changePerPage,
    updatePagination,
    reset,
    getPageNumbers,
    
    // Helpers
    getOffset: () => (currentPage - 1) * perPage,
    getParams: () => ({
      page: currentPage,
      per_page: perPage
    })
  };
}

export default usePagination;