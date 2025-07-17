document.addEventListener('DOMContentLoaded', () => {
    // Pastikan pengguna sudah login
    if (localStorage.getItem('isLoggedIn') !== 'true') {
        window.location.href = 'login.html';
        return;
    }

    const currentUserEmail = localStorage.getItem('user_email');
    const allUsers = JSON.parse(localStorage.getItem('kreatoria_user_list')) || [];

    // --- VIEW ELEMENTS ---
    const mainProfileView = document.getElementById('main-profile-view');
    const editProfileView = document.getElementById('edit-profile-view');
    const editProfileBtn = document.getElementById('edit-profile-btn');
    const cancelEditBtn = document.getElementById('cancel-edit-btn');
    const editProfileForm = document.getElementById('edit-profile-form');

    // --- PROFILE DATA DISPLAY ELEMENTS ---
    const profileViewImg = document.getElementById('profile-view-img');
    const profileViewName = document.getElementById('profile-view-name');
    const profileViewTitle = document.getElementById('profile-view-title');
    // ... (elemen profil lainnya akan ditambahkan di sini jika diperlukan)

    // --- CONNECTION ELEMENTS ---
    const connectionsContainer = document.getElementById('connections-list');
    const pendingReceivedContainer = document.getElementById('pending-received-list');
    const pendingSentContainer = document.getElementById('pending-sent-list');


    // --- MAIN FUNCTION TO LOAD AND DISPLAY PROFILE ---
    function loadAndDisplayProfile() {
        let profileData = JSON.parse(localStorage.getItem('kreatoria_profile_' + currentUserEmail));
        
        // Jika tidak ada profil, buat struktur data default
        if (!profileData) {
            profileData = {
                name: localStorage.getItem('user_name') || 'Pengguna Baru',
                title: 'Belum ada jabatan',
                about: 'Belum ada ringkasan.',
                photo: '',
                skills: [],
                social: { linkedin: '', github: '' },
                experience: []
            };
        }

        // --- Populate Profile View ---
        profileViewName.textContent = profileData.name;
        profileViewTitle.textContent = profileData.title;
        document.getElementById('profile-view-about').textContent = profileData.about;

        // Populate Photo (Gunakan UI Avatars sebagai fallback)
        if (profileData.photo) {
            profileViewImg.src = profileData.photo;
        } else {
            const formattedName = profileData.name.split(' ').join('+');
            profileViewImg.src = `https://ui-avatars.com/api/?name=${formattedName}&background=0E7490&color=F9FAFB&bold=true&size=140`;
        }

        // ... (Kode untuk populate elemen profil lainnya seperti skill, experience, dll.)

        // --- Load and Display Connections ---
        loadAndDisplayConnections();
    }
    
    // --- CONNECTIONS LOGIC ---
    function getConnectionsData() {
        return JSON.parse(localStorage.getItem('kreatoria_connections')) || {};
    }

    function saveConnectionsData(data) {
        localStorage.setItem('kreatoria_connections', JSON.stringify(data));
    }

    function loadAndDisplayConnections() {
        const connectionsData = getConnectionsData();
        const userConnections = connectionsData[currentUserEmail] || { connections: [], pending_received: [], pending_sent: [] };

        // Helper function untuk membuat elemen koneksi
        const createConnectionElement = (email, type) => {
            const user = allUsers.find(u => u.email === email);
            if (!user) return '';

            const element = document.createElement('div');
            element.className = 'connection-item';
            element.innerHTML = `
                <span class="connection-name">${user.name}</span>
                <div class="connection-actions">
                    ${type === 'connection' ? `<button class="btn-remove-connection" data-email="${email}">Hapus</button>` : ''}
                    ${type === 'received' ? `<button class="btn-accept" data-email="${email}">Terima</button><button class="btn-reject" data-email="${email}">Tolak</button>` : ''}
                    ${type === 'sent' ? `<button class="btn-cancel" data-email="${email}">Batalkan</button>` : ''}
                </div>
            `;
            return element;
        };
        
        // Clear existing lists
        connectionsContainer.innerHTML = '<h4>Tidak ada koneksi.</h4>';
        pendingReceivedContainer.innerHTML = '<h4>Tidak ada permintaan masuk.</h4>';
        pendingSentContainer.innerHTML = '<h4>Tidak ada permintaan terkirim.</h4>';

        // Populate connections
        if(userConnections.connections.length > 0) {
            connectionsContainer.innerHTML = '';
            userConnections.connections.forEach(email => connectionsContainer.appendChild(createConnectionElement(email, 'connection')));
        }

        // Populate pending received
        if(userConnections.pending_received.length > 0) {
            pendingReceivedContainer.innerHTML = '';
            userConnections.pending_received.forEach(email => pendingReceivedContainer.appendChild(createConnectionElement(email, 'received')));
        }
        
        // Populate pending sent
        if(userConnections.pending_sent.length > 0) {
            pendingSentContainer.innerHTML = '';
            userConnections.pending_sent.forEach(email => pendingSentContainer.appendChild(createConnectionElement(email, 'sent')));
        }

        addConnectionEventListeners();
    }

    function addConnectionEventListeners() {
        document.querySelectorAll('.btn-accept').forEach(btn => btn.onclick = (e) => handleAccept(e.target.dataset.email));
        document.querySelectorAll('.btn-reject').forEach(btn => btn.onclick = (e) => handleReject(e.target.dataset.email));
        document.querySelectorAll('.btn-cancel').forEach(btn => btn.onclick = (e) => handleCancel(e.target.dataset.email));
        document.querySelectorAll('.btn-remove-connection').forEach(btn => btn.onclick = (e) => handleRemove(e.target.dataset.email));
    }

    function handleAccept(targetEmail) {
        let data = getConnectionsData();
        // Update untuk user saat ini
        data[currentUserEmail].pending_received = data[currentUserEmail].pending_received.filter(e => e !== targetEmail);
        data[currentUserEmail].connections.push(targetEmail);

        // Update untuk target user
        data[targetEmail].pending_sent = data[targetEmail].pending_sent.filter(e => e !== currentUserEmail);
        data[targetEmail].connections.push(currentUserEmail);

        saveConnectionsData(data);
        loadAndDisplayConnections();
    }

    function handleReject(targetEmail) {
        let data = getConnectionsData();
        data[currentUserEmail].pending_received = data[currentUserEmail].pending_received.filter(e => e !== targetEmail);
        data[targetEmail].pending_sent = data[targetEmail].pending_sent.filter(e => e !== currentUserEmail);
        saveConnectionsData(data);
        loadAndDisplayConnections();
    }

    function handleCancel(targetEmail) {
        handleReject(targetEmail); // Logikanya sama persis dengan menolak
    }

    function handleRemove(targetEmail) {
        if (!confirm(`Apakah Anda yakin ingin menghapus ${targetEmail} dari koneksi Anda?`)) return;
        let data = getConnectionsData();
        data[currentUserEmail].connections = data[currentUserEmail].connections.filter(e => e !== targetEmail);
        data[targetEmail].connections = data[targetEmail].connections.filter(e => e !== currentUserEmail);
        saveConnectionsData(data);
        loadAndDisplayConnections();
    }


    // --- EVENT LISTENERS FOR VIEW TOGGLING ---
    editProfileBtn.addEventListener('click', () => {
        mainProfileView.style.display = 'none';
        editProfileView.style.display = 'block';
        // Populate edit form with current data
        // ... (Logika untuk mengisi form edit)
    });

    cancelEditBtn.addEventListener('click', () => {
        mainProfileView.style.display = 'block';
        editProfileView.style.display = 'none';
    });
    
    editProfileForm.addEventListener('submit', (e) => {
       e.preventDefault();
       // ... (Logika untuk menyimpan data profil dari form edit)
       
       alert('Profil berhasil diperbarui!');
       mainProfileView.style.display = 'block';
       editProfileView.style.display = 'none';
       loadAndDisplayProfile(); // Reload to show changes
    });


    // --- INITIAL LOAD ---
    loadAndDisplayProfile();
});