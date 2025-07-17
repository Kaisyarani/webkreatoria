document.addEventListener('DOMContentLoaded', () => {
    if (localStorage.getItem('isLoggedIn') !== 'true') {
        alert('Anda harus login untuk membuat postingan!');
        window.location.href = 'login.html';
        return;
    }

    const postForm = document.getElementById('create-post-form');
    const fileInput = document.getElementById('post-file');
    const fileUploadTrigger = document.getElementById('file-upload-trigger');
    const fileNameDisplay = document.getElementById('file-name-display');
    let uploadedFileData = null;

    const textContainer = document.getElementById('text-input-container');
    const videoContainer = document.getElementById('video-input-container');
    const fileContainer = document.getElementById('file-input-container');
    const postTypeRadios = document.querySelectorAll('input[name="post-type"]');

    // --- [BARU] KOLABORATOR LOGIC ---
    const collaboratorSearchInput = document.getElementById('collaborator-search');
    const addCollaboratorBtn = document.getElementById('add-collaborator-btn');
    const selectedCollaboratorsContainer = document.getElementById('selected-collaborators');
    const userSuggestionsDatalist = document.getElementById('user-suggestions');
    let selectedCollaborators = [];
    
    const allUsers = JSON.parse(localStorage.getItem('kreatoria_user_list')) || [];
    const currentUserEmail = localStorage.getItem('user_email');

    // Isi datalist dengan pengguna lain
    allUsers.forEach(user => {
        if (user.email !== currentUserEmail) {
            const option = document.createElement('option');
            option.value = `${user.name} (${user.email})`;
            userSuggestionsDatalist.appendChild(option);
        }
    });

    addCollaboratorBtn.addEventListener('click', () => {
        const searchTerm = collaboratorSearchInput.value;
        const foundUser = allUsers.find(user => searchTerm.includes(user.email));

        if (foundUser && !selectedCollaborators.find(c => c.email === foundUser.email)) {
            selectedCollaborators.push(foundUser);
            renderSelectedCollaborators();
            collaboratorSearchInput.value = '';
        } else {
            alert('Pengguna tidak ditemukan atau sudah ditambahkan.');
        }
    });

    function renderSelectedCollaborators() {
        selectedCollaboratorsContainer.innerHTML = '';
        selectedCollaborators.forEach(user => {
            const tag = document.createElement('span');
            tag.className = 'collaborator-tag';
            tag.textContent = user.name;
            const removeBtn = document.createElement('button');
            removeBtn.textContent = 'x';
            removeBtn.onclick = () => {
                selectedCollaborators = selectedCollaborators.filter(c => c.email !== user.email);
                renderSelectedCollaborators();
            };
            tag.appendChild(removeBtn);
            selectedCollaboratorsContainer.appendChild(tag);
        });
    }


    // --- Post Type Toggle Logic (Tetap Sama) ---
    function toggleFormInputs(type) {
        textContainer.style.display = 'none';
        videoContainer.style.display = 'none';
        fileContainer.style.display = 'none';
        if (type === 'text') textContainer.style.display = 'block';
        else if (type === 'video') videoContainer.style.display = 'block';
        else {
            fileContainer.style.display = 'block';
            fileInput.accept = (type === 'image') ? 'image/*' : '';
        }
    }
    postTypeRadios.forEach(radio => radio.addEventListener('change', () => toggleFormInputs(radio.value)));
    toggleFormInputs('image');

    // --- File Upload Logic (Tetap Sama) ---
    fileUploadTrigger.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (!file) {
            uploadedFileData = null;
            fileNameDisplay.textContent = 'Tidak ada file yang dipilih';
            return;
        }
        const reader = new FileReader();
        reader.onload = (e) => {
            uploadedFileData = { name: file.name, type: file.type, data: e.target.result };
            fileNameDisplay.textContent = `File terpilih: ${file.name}`;
        };
        reader.readAsDataURL(file);
    });

    // --- Form Submit Logic (Diperbarui) ---
    postForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const postType = document.querySelector('input[name="post-type"]:checked').value;
        const title = document.getElementById('post-title').value;
        const category = document.getElementById('post-category').value;
        const caption = document.getElementById('post-caption').value;
        const description = document.getElementById('post-description').value;

        // [DIPERBARUI] Gabungkan pengguna saat ini dengan kolaborator yang dipilih
        const currentUser = { name: localStorage.getItem('user_name'), email: localStorage.getItem('user_email') };
        const authors = [currentUser, ...selectedCollaborators];
        
        const newPost = { id: Date.now(), type: postType, title, category, caption, description, authors };

        // Validasi konten (Tetap Sama)
        if (postType === 'image' || postType === 'file') {
            if (!uploadedFileData) { alert('Harap pilih sebuah file.'); return; }
            newPost.file = uploadedFileData;
        } else if (postType === 'text') {
            const content = document.getElementById('post-content').value;
            if (!content.trim()) { alert('Isi tulisan tidak boleh kosong.'); return; }
            newPost.content = content;
        } else if (postType === 'video') {
            const videoUrl = document.getElementById('post-video-url').value;
            if (!videoUrl.trim()) { alert('URL Video tidak boleh kosong.'); return; }
            newPost.videoUrl = videoUrl;
        }

        const existingPosts = JSON.parse(localStorage.getItem('kreatoria_posts')) || [];
        existingPosts.unshift(newPost);
        localStorage.setItem('kreatoria_posts', JSON.stringify(existingPosts));

        alert('Karya berhasil dipublikasikan!');
        window.location.href = 'gallery-loggedin.html';
    });
});