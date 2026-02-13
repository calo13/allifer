

import TomSelect from 'tom-select';


window.confirmDelete = function(id, name, componentMethod = 'delete') {
    return Swal.fire({
        title: '¿Eliminar elemento?',
        html: `¿Estás seguro de eliminar "<strong>${name}</strong>"?<br><small class="text-gray-500">Esta acción puede ser irreversible.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true,
        showLoaderOnConfirm: true,
        allowOutsideClick: false,
        preConfirm: () => {
            return Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'))
                .call(componentMethod, id);
        }
    });
};

/**
 * Alerta de éxito
 */
window.showSuccess = function(title, message, showConfetti = false) {
    if (showConfetti && typeof confetti !== 'undefined') {
        confetti({
            particleCount: 100,
            spread: 70,
            origin: { y: 0.6 }
        });
    }
    
    return Swal.fire({
        title: title,
        text: message,
        icon: 'success',
        confirmButtonColor: '#10b981',
        confirmButtonText: '👍 Perfecto',
        timer: 3000,
        timerProgressBar: true
    });
};

/**
 * Alerta de información/advertencia
 */
window.showInfo = function(title, message, icon = 'info') {
    return Swal.fire({
        title: title,
        html: message,
        icon: icon,
        confirmButtonColor: icon === 'warning' ? '#f59e0b' : '#3b82f6',
        confirmButtonText: 'Entendido',
        timer: 5000,
        timerProgressBar: true
    });
};

/**
 * Alerta de error
 */
window.showError = function(title, message) {
    return Swal.fire({
        title: title,
        text: message,
        icon: 'error',
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'Entendido'
    });
};

// ============================================
// LIVEWIRE EVENT LISTENERS
// ============================================

document.addEventListener('livewire:init', () => {
    
    // Producto eliminado
    Livewire.on('product-deleted', (event) => {
        showSuccess('¡Eliminado!', event[0].message, true); // con confetti
    });
    
    // Producto desactivado (tiene ventas)
    Livewire.on('product-deactivated', (event) => {
        showInfo('⚠️ Producto desactivado', event[0].message, 'warning');
    });
    
    // Producto activado
    Livewire.on('product-activated', (event) => {
        showSuccess('✅ Activado', event[0].message, false);
    });
    
    // Producto creado
    Livewire.on('product-created', (event) => {
        showSuccess('¡Producto creado!', event[0].message, true);
    });
    
    // Producto actualizado
    Livewire.on('product-updated', (event) => {
        showSuccess('¡Actualizado!', event[0].message, false);
    });
    
    // Categoría creada
    Livewire.on('category-saved', (event) => {
        showSuccess('✅ Guardado', event[0].message, false);
    });
    
    // Categoría eliminada
    Livewire.on('category-deleted', (event) => {
        showSuccess('¡Eliminado!', event[0].message, false);
    });
    
    // Marca creada
    Livewire.on('brand-saved', (event) => {
        showSuccess('✅ Guardado', event[0].message, false);
    });
    
    // Marca eliminada
    Livewire.on('brand-deleted', (event) => {
        showSuccess('¡Eliminado!', event[0].message, false);
    });
    
    // Error genérico
    Livewire.on('show-error', (event) => {
        showError('Error', event[0].message);
    });
});
// Proveedores
Livewire.on('supplier-saved', (event) => {
    showSuccess('✅ Guardado', event[0].message, false);
});

Livewire.on('supplier-deleted', (event) => {
    showSuccess('¡Eliminado!', event[0].message, false);
});

Livewire.on('supplier-deactivated', (event) => {
    showInfo('⚠️ Desactivado', event[0].message, 'warning');
});

// ============================================
// UTILIDADES
// ============================================

/**
 * Formatear número como moneda (Quetzales)
 */
window.formatCurrency = function(amount) {
    return new Intl.NumberFormat('es-GT', {
        style: 'currency',
        currency: 'GTQ'
    }).format(amount);
};

/**
 * Confirmar acción genérica
 */
window.confirmAction = function(title, message, confirmText = 'Confirmar') {
    return Swal.fire({
        title: title,
        text: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        confirmButtonText: confirmText,
        cancelButtonText: 'Cancelar'
    });
};

// ============================================
// TOM SELECT - Searchable Selects
// ============================================

document.addEventListener('livewire:init', () => {
    // Inicializar después de que Livewire cargue
    initializeTomSelects();
    
    // Reinicializar después de actualizaciones de Livewire
    Livewire.hook('morph.updated', () => {
        initializeTomSelects();
    });
});

function initializeTomSelects() {
    // Configuración común mejorada
    const commonConfig = {
        allowEmptyOption: true,
        create: false,
        sortField: 'text',
        maxOptions: 1000,
        plugins: ['clear_button'],
        onInitialize: function() {
            // Asegurar que el placeholder se muestre
            if (!this.getValue()) {
                this.control_input.placeholder = this.settings.placeholder;
            }
        },
        onChange: function(value) {
            // Actualizar placeholder cuando cambia
            if (!value) {
                this.control_input.placeholder = this.settings.placeholder;
            }
        },
        render: {
            no_results: function(data, escape) {
                return '<div class="p-3 text-gray-500 text-sm text-center">No se encontraron resultados</div>';
            },
            option: function(data, escape) {
                return '<div class="py-2 px-3 hover:bg-indigo-50 cursor-pointer transition-colors">' + escape(data.text) + '</div>';
            },
            item: function(data, escape) {
                return '<div>' + escape(data.text) + '</div>';
            }
        }
    };
    
    // Selects de categorías
    const categorySelects = document.querySelectorAll('select[data-tom-select="category"]:not(.tomselected)');
    categorySelects.forEach(select => {
        new TomSelect(select, {
            ...commonConfig,
            placeholder: 'Buscar categoría...',
        });
    });
    
    // Selects de marcas
    const brandSelects = document.querySelectorAll('select[data-tom-select="brand"]:not(.tomselected)');
    brandSelects.forEach(select => {
        new TomSelect(select, {
            ...commonConfig,
            placeholder: 'Buscar marca...',
        });
    });
    
    // Selects de proveedores
    const supplierSelects = document.querySelectorAll('select[data-tom-select="supplier"]:not(.tomselected)');
    supplierSelects.forEach(select => {
        new TomSelect(select, {
            ...commonConfig,
            placeholder: 'Buscar proveedor...',
        });
    });
}