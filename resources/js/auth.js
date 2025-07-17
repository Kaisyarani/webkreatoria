document.addEventListener('DOMContentLoaded', () => {
    const notification = document.getElementById('notification');
    const loginForm = document.getElementById('login-form');
    const signupForm = document.getElementById('signup-form');
    const logoutBtn = document.getElementById('logout-btn');

    // --- UTILITY FUNCTION FOR NOTIFICATION ---
    function showNotification(message, type = 'success') {
        if (!notification) return;
        notification.textContent = message;
        notification.className = `notification ${type} show`;
        setTimeout(() => {
            notification.classList.remove('show');
        }, 4000);
    }

    // --- SIGN UP LOGIC (DENGAN PENYIMPANAN KE DAFTAR PENGGUNA) ---
    if (signupForm) {
        signupForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const usernameInput = document.getElementById('username');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const accountTypeRadios = document.querySelectorAll('input[name="accountType"]');
            const companyNameInput = document.getElementById('companyName');

            const username = usernameInput.value.trim();
            const email = emailInput.value.trim();
            const password = passwordInput.value;
            let accountType;
            for (const radio of accountTypeRadios) {
                if (radio.checked) {
                    accountType = radio.value;
                    break;
                }
            }
            const companyName = (accountType === 'company') ? companyNameInput.value.trim() : '';

            if (!username || !email || !password || !accountType) {
                showNotification('Semua kolom yang wajib diisi harus dilengkapi.', 'error');
                return;
            }
            if (accountType === 'company' && !companyName) {
                showNotification('Nama Perusahaan harus diisi.', 'error');
                return;
            }
            if (password.length < 8) {
                showNotification('Password harus minimal 8 karakter.', 'error');
                return;
            }

            const userList = JSON.parse(localStorage.getItem('kreatoria_user_list')) || [];

            const userExists = userList.some(user => user.email === email);
            if (userExists) {
                showNotification('Email ini sudah terdaftar. Silakan gunakan email lain.', 'error');
                return;
            }

            userList.push({ 
                name: username, 
                email: email, 
                password: password,
                accountType: accountType,
                companyName: companyName
            });
            localStorage.setItem('kreatoria_user_list', JSON.stringify(userList));
            localStorage.setItem('temp_registered_email', email);

            showNotification('Pendaftaran berhasil! Mengarahkan ke halaman login...', 'success');
            setTimeout(() => {
                window.location.href = 'login.html';
            }, 2000);
        });
    }

    // --- LOGIN LOGIC ---
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            const userList = JSON.parse(localStorage.getItem('kreatoria_user_list')) || [];
            
            const foundUser = userList.find(user => user.email === email);

            if (foundUser && foundUser.password === password) {
                localStorage.setItem('isLoggedIn', 'true');
                localStorage.setItem('current_user_email', foundUser.email);
                localStorage.setItem('current_user_name', foundUser.name);
                localStorage.setItem('current_user_account_type', foundUser.accountType);

                showNotification('Login berhasil! Mengarahkan ke halaman utama...', 'success');
                
                // --- PERUBAHAN DI SINI ---
                // Logika dikembalikan ke versi semula sesuai permintaan.
                setTimeout(() => {
                    // Redireksi berdasarkan jenis akun
                    if (foundUser.accountType === 'company') {
                        window.location.href = 'dashboard-perusahaan.html'; // Arahkan ke dashboard perusahaan
                    } else { // Asumsi 'user' (kreator) atau default lainnya
                        window.location.href = 'index1.html'; // Arahkan ke dashboard user umum
                    }
                }, 2000);

            } else {
                showNotification('Email atau password salah.', 'error');
            }
        });
    }
    
    // --- LOGIC UNTUK SEMUA HALAMAN SETELAH LOGIN ---
    const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
    if (isLoggedIn) {
        const userDisplayName = document.getElementById('user-display-name');
        const profileImg = document.querySelector('.navbar .profile-img');
        const storedName = localStorage.getItem('current_user_name');
        
        if (storedName && userDisplayName) {
            userDisplayName.textContent = storedName;
        }

        if (profileImg) {
            const userPhoto = localStorage.getItem('user_photo');
            if (userPhoto) {
                profileImg.src = userPhoto;
            } else if (storedName) {
                const formattedName = storedName.split(' ').join('+');
                profileImg.src = `https://ui-avatars.com/api/?name=${formattedName}&background=0E7490&color=F9FAFB&bold=true`;
            }
        }

        if (logoutBtn) {
            logoutBtn.addEventListener('click', (e) => {
                e.preventDefault();
                localStorage.removeItem('isLoggedIn');
                localStorage.removeItem('current_user_email');
                localStorage.removeItem('current_user_name');
                localStorage.removeItem('current_user_account_type');
                localStorage.removeItem('temp_registered_email'); 
                window.location.href = 'index.html';
            });
        }

        const profileBtn = document.querySelector('.profile-btn');
        if (profileBtn) {
            const dropdownMenu = profileBtn.nextElementSibling;
            profileBtn.addEventListener('click', (event) => {
                event.stopPropagation();
                dropdownMenu.classList.toggle('show');
            });
        }
    }

    window.addEventListener('click', () => {
        const openDropdown = document.querySelector('.dropdown-menu.show');
        if (openDropdown) {
            openDropdown.classList.remove('show');
        }
    });

    // PERUBAHAN: Menghapus index2.html dari halaman terproteksi
    const protectedPages = ['index1.html', 'gallery-loggedin.html', 'jobs-loggedin.html', 'about-loggedin.html', 'my-profile.html', 'settings.html', 'create-post.html', 'dashboard-perusahaan.html'];
    const currentPage = window.location.pathname.split('/').pop();
    if (protectedPages.includes(currentPage) && !isLoggedIn) {
        window.location.href = 'login.html';
    }
});