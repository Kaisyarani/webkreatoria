document.addEventListener('DOMContentLoaded', () => {
    // Pastikan pengguna sudah login
    if (localStorage.getItem('isLoggedIn') !== 'true') {
        window.location.href = 'login.html';
        return;
    }

    const notification = document.getElementById('notification');
    const changePasswordForm = document.getElementById('change-password-form');
    
    // Elemen Modal
    const deleteAccountBtn = document.getElementById('delete-account-btn');
    const modalOverlay = document.getElementById('delete-confirm-modal');
    const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
    const confirmDeleteBtn = document.getElementById('confirm-delete-btn');

    // --- Utility Notifikasi ---
    function showNotification(message, type = 'success') {
        if (!notification) return;
        notification.textContent = message;
        notification.className = `notification ${type} show`;
        setTimeout(() => {
            notification.classList.remove('show');
        }, 4000);
    }

    // --- Logika Ubah Password ---
    if (changePasswordForm) {
        changePasswordForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const currentPasswordInput = document.getElementById('current-password');
            const newPasswordInput = document.getElementById('new-password');
            const confirmPasswordInput = document.getElementById('confirm-password');

            const storedPassword = localStorage.getItem('user_password');

            // Validasi 1: Cek password saat ini
            if (currentPasswordInput.value !== storedPassword) {
                showNotification('Password saat ini salah.', 'error');
                return;
            }
            
            // Validasi 2: Cek password baru tidak kosong dan cukup panjang
            if (newPasswordInput.value.length < 8) {
                showNotification('Password baru harus minimal 8 karakter.', 'error');
                return;
            }

            // Validasi 3: Cek konfirmasi password baru
            if (newPasswordInput.value !== confirmPasswordInput.value) {
                showNotification('Konfirmasi password baru tidak cocok.', 'error');
                return;
            }

            // Jika semua validasi lolos
            localStorage.setItem('user_password', newPasswordInput.value);
            showNotification('Password berhasil diubah!', 'success');
            changePasswordForm.reset(); // Kosongkan form
        });
    }

    // --- Logika Hapus Akun & Modal ---
    function showModal() {
        if (modalOverlay) modalOverlay.classList.add('show');
    }

    function hideModal() {
        if (modalOverlay) modalOverlay.classList.remove('show');
    }

    if (deleteAccountBtn) {
        deleteAccountBtn.addEventListener('click', showModal);
    }
    
    if (cancelDeleteBtn) {
        cancelDeleteBtn.addEventListener('click', hideModal);
    }
    
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', () => {
            // Hapus semua data dari localStorage
            localStorage.clear();
            
            // Arahkan ke halaman utama (seperti pengguna baru)
            window.location.href = 'index.html';
        });
    }
});