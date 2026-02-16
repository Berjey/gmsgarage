/**
 * GMSGARAGE Admin Panel - Delete Confirmation
 * Kurumsal Kimlik Tasarımına Uygun SweetAlert2 Konfig
 */

window.confirmDelete = function(form, itemName = 'bu öğeyi') {
    Swal.fire({
        title: 'Emin misiniz?',
        html: `<p class="text-gray-600">${itemName} <strong>kalıcı olarak silinecek</strong>.</p><p class="text-sm text-gray-500 mt-2">Bu işlem geri alınamaz!</p>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626', // red-600
        cancelButtonColor: '#6b7280', // gray-500
        confirmButtonText: '<i class="fas fa-trash-alt mr-2"></i>Evet, Sil',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>İptal',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-xl shadow-2xl',
            title: 'text-2xl font-bold text-gray-900',
            confirmButton: 'px-6 py-3 rounded-lg font-bold shadow-lg hover:shadow-xl transition-all',
            cancelButton: 'px-6 py-3 rounded-lg font-bold shadow-sm hover:shadow-md transition-all',
        },
        buttonsStyling: true,
        focusCancel: true,
        showClass: {
            popup: 'animate__animated animate__fadeInDown animate__faster'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp animate__faster'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Silme işlemi başladı - loading göster
            Swal.fire({
                title: 'Siliniyor...',
                html: 'Lütfen bekleyin.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Form'u submit et
            form.submit();
        }
    });
    
    return false;
};

// Toplu silme için
window.confirmBulkDelete = function(count) {
    Swal.fire({
        title: 'Toplu Silme',
        html: `<p class="text-gray-600"><strong>${count} öğe</strong> kalıcı olarak silinecek.</p><p class="text-sm text-gray-500 mt-2">Bu işlem geri alınamaz!</p>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: `<i class="fas fa-trash-alt mr-2"></i>Evet, ${count} Öğeyi Sil`,
        cancelButtonText: '<i class="fas fa-times mr-2"></i>İptal',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-xl shadow-2xl',
            title: 'text-2xl font-bold text-gray-900',
            confirmButton: 'px-6 py-3 rounded-lg font-bold shadow-lg hover:shadow-xl transition-all',
            cancelButton: 'px-6 py-3 rounded-lg font-bold shadow-sm hover:shadow-md transition-all',
        },
        focusCancel: true,
    });
};

// Başarılı mesaj
window.showSuccess = function(message) {
    Swal.fire({
        icon: 'success',
        title: 'Başarılı!',
        text: message,
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
        customClass: {
            popup: 'rounded-xl shadow-xl'
        }
    });
};

// Hata mesajı
window.showError = function(message) {
    Swal.fire({
        icon: 'error',
        title: 'Hata!',
        text: message,
        confirmButtonColor: '#dc2626',
        customClass: {
            popup: 'rounded-xl shadow-2xl',
            confirmButton: 'px-6 py-3 rounded-lg font-bold'
        }
    });
};
