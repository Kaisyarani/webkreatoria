document.addEventListener('DOMContentLoaded', () => {

    const createPostForm = document.getElementById('create-post-form');
    const projectGridContainer = document.getElementById('project-grid-container');
    const postDetailContainer = document.getElementById('post-detail-container');

    // =================================================================
    // LOGIKA UNTUK HALAMAN BUAT POSTINGAN (create-post.html)
    // =================================================================
    if (createPostForm) {
        const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
        if (!isLoggedIn) {
            alert('Anda harus login terlebih dahulu untuk membuat postingan.');
            window.location.href = 'login.html';
            return;
        }

        const toBase64 = file => new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
        });

        createPostForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const imageInput = document.getElementById('stage-image');
            const file = imageInput.files[0];

            if (!file) {
                alert('Silakan pilih gambar untuk diunggah.');
                return;
            }

            const submitButton = createPostForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            
            try {
                const imageUrl = await toBase64(file);
                const authorName = localStorage.getItem('current_user_name');
                const authorEmail = localStorage.getItem('current_user_email');
                const newPost = {
                    id: Date.now(),
                    ownerEmail: authorEmail,
                    title: document.getElementById('post-title').value,
                    category: document.getElementById('post-category').value,
                    description: document.getElementById('post-description').value,
                    imageUrl: imageUrl, 
                    author: authorName,
                    likes: 0,
                    comments: []
                };

                const existingPosts = JSON.parse(localStorage.getItem('kreatoria_posts')) || [];
                existingPosts.unshift(newPost);
                localStorage.setItem('kreatoria_posts', JSON.stringify(existingPosts));

                alert('Karya berhasil dipublikasikan!');
                window.location.href = 'gallery-loggedin.html';

            } catch (error) {
                console.error("Gagal mengubah gambar:", error);
                alert("Terjadi kesalahan saat memproses gambar. Silakan coba lagi.");
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-rocket"></i> Publikasikan Proyek';
            }
        });
    }

    // =================================================================
    // LOGIKA UNTUK HALAMAN GALERI (gallery-loggedin.html)
    // =================================================================
    if (projectGridContainer) {
        const currentUserEmail = localStorage.getItem('current_user_email');
        const posts = JSON.parse(localStorage.getItem('kreatoria_posts')) || [];

        // ===== PERUBAHAN UTAMA DIMULAI DI SINI =====
        // Hanya jalankan logika render jika ada postingan di localStorage
        if (posts.length > 0) {
            
            // Fungsi render tetap sama, tapi sekarang hanya dipanggil jika ada post
            function renderPosts(postsToRender) {
                projectGridContainer.innerHTML = ''; // Hapus dummy dan render post asli
                postsToRender.forEach(post => {
                    let deleteButtonHTML = '';
                    if (post.ownerEmail === currentUserEmail) {
                        deleteButtonHTML = `<button class="action-btn delete-btn" data-post-id="${post.id}"><i class="fas fa-trash"></i><span>Hapus</span></button>`;
                    }
                    const commentCount = Array.isArray(post.comments) ? post.comments.length : 0;

                    const postCardHTML = `
                        <div class="project-card" data-category="${post.category.toLowerCase().replace(/ /g, '-')}" data-id="${post.id}">
                            <a href="post-detail.html?id=${post.id}">
                                <img class="project-card-image" src="${post.imageUrl}" alt="${post.title}">
                            </a>
                            <div class="project-card-content">
                                <h3><a href="post-detail.html?id=${post.id}">${post.title}</a></h3>
                                <p>Oleh: ${post.author}</p>
                            </div>
                            <div class="project-card-footer">
                                <div class="card-actions">
                                    <span class="action-btn"><i class="far fa-heart"></i><span>${post.likes}</span></span>
                                    <span class="action-btn"><i class="far fa-comment"></i><span>${commentCount}</span></span>
                                </div>
                                <div class="card-actions">
                                    ${deleteButtonHTML}
                                    <span class="action-btn share-btn"><i class="fas fa-share-alt"></i></span>
                                </div>
                            </div>
                        </div>`;
                    projectGridContainer.innerHTML += postCardHTML;
                });
            }

            renderPosts(posts); // Render semua post asli saat pertama kali load

            // --- LOGIKA FILTER DAN SEARCH ---
            const filterBar = document.querySelector('.filter-bar');
            const searchBar = document.getElementById('search-bar');

            function filterAndSearch() {
                const activeFilter = filterBar.querySelector('.active').dataset.filter;
                const searchTerm = searchBar.value.toLowerCase();

                const filteredPosts = posts.filter(post => {
                    const categoryMatch = activeFilter === 'all' || post.category.toLowerCase().replace(/ /g, '-') === activeFilter;
                    const searchMatch = post.title.toLowerCase().includes(searchTerm) || post.author.toLowerCase().includes(searchTerm);
                    return categoryMatch && searchMatch;
                });
                
                // Jika hasil filter kosong, tampilkan pesan
                if(filteredPosts.length === 0){
                    projectGridContainer.innerHTML = '<p style="text-align: center; color: var(--text-secondary);">Tidak ada karya yang cocok dengan filter atau pencarian Anda.</p>';
                } else {
                    renderPosts(filteredPosts);
                }
            }

            filterBar.addEventListener('click', function(e) {
                if (e.target.classList.contains('filter-btn')) {
                    filterBar.querySelector('.active').classList.remove('active');
                    e.target.classList.add('active');
                    filterAndSearch();
                }
            });

            searchBar.addEventListener('keyup', filterAndSearch);

            projectGridContainer.addEventListener('click', function(e) {
                if (e.target.closest('.delete-btn')) {
                    const postId = e.target.closest('.delete-btn').dataset.postId;
                    if (confirm('Apakah Anda yakin ingin menghapus karya ini?')) {
                        const updatedPosts = posts.filter(p => p.id.toString() !== postId);
                        localStorage.setItem('kreatoria_posts', JSON.stringify(updatedPosts));
                        location.reload(); 
                    }
                }
            });
        }
        // Jika posts.length === 0 (localStorage kosong), skrip tidak melakukan apa-apa.
        // Ini akan membiarkan contoh karya (dummy) yang ada di HTML tetap terlihat.
        // ===== AKHIR DARI PERUBAHAN UTAMA =====
    }

    // =================================================================
    // LOGIKA UNTUK HALAMAN DETAIL (TIDAK ADA PERUBAHAN)
    // =================================================================
    if (postDetailContainer) {
        // ... (seluruh logika untuk halaman detail tetap sama)
        const urlParams = new URLSearchParams(window.location.search);
        const postId = parseInt(urlParams.get('id'));
        let allPosts = JSON.parse(localStorage.getItem('kreatoria_posts')) || [];
        const post = allPosts.find(p => p.id === postId);

        if (post) {
            document.title = `${post.title} - Kreatoria`;
            if (!Array.isArray(post.comments)) post.comments = [];

            const postDetailHTML = `
                <div class="post-header"><h1>${post.title}</h1><div class="author"><span>Oleh: <strong>${post.author}</strong></span></div></div>
                <div class="post-image-container"><img src="${post.imageUrl}" alt="${post.title}"></div>
                <div class="post-content"><h2>Deskripsi Karya</h2><p>${post.description || 'Kreator tidak memberikan deskripsi.'}</p></div>
                <div class="post-actions-bar">
                    <div class="action-btn"><i class="far fa-heart"></i>&nbsp; Suka (${post.likes || 0})</div>
                    <div class="action-btn" id="comment-count"><i class="far fa-comment"></i>&nbsp; Komentar (${post.comments.length})</div>
                    <div class="action-btn"><i class="fas fa-share-alt"></i>&nbsp; Bagikan</div>
                </div>
                <div class="comments-section">
                    <div class="comments-header"><h3>Komentar</h3><button id="toggle-comments-btn">Lihat Komentar (${post.comments.length})</button></div>
                    <div id="comments-list"></div>
                    <form id="comment-form"><textarea id="comment-text" placeholder="Tulis komentar Anda..." required></textarea><button type="submit">Kirim</button></form>
                </div>`;
            postDetailContainer.innerHTML = postDetailHTML;

            const commentsList = document.getElementById('comments-list');
            const toggleBtn = document.getElementById('toggle-comments-btn');

            function renderComments() {
                commentsList.innerHTML = '';
                if (post.comments.length === 0) {
                    commentsList.innerHTML = '<p style="color: var(--text-secondary); text-align: center;">Jadilah yang pertama berkomentar!</p>';
                } else {
                    post.comments.forEach(c => {
                        commentsList.innerHTML += `<div class="comment-item"><img src="https://ui-avatars.com/api/?name=${c.author.split(' ').join('+')}&background=1F2937&color=F9FAFB" alt="${c.author}"><div class="comment-content"><p class="author-name">${c.author}</p><p class="comment-text">${c.text}</p></div></div>`;
                    });
                }
                document.getElementById('comment-count').innerHTML = `<i class="far fa-comment"></i>&nbsp; Komentar (${post.comments.length})`;
                toggleBtn.textContent = commentsList.classList.contains('show') ? `Sembunyikan Komentar (${post.comments.length})` : `Lihat Komentar (${post.comments.length})`;
            }

            renderComments();

            toggleBtn.addEventListener('click', () => {
                commentsList.classList.toggle('show');
                renderComments();
            });

            document.getElementById('comment-form').addEventListener('submit', (e) => {
                e.preventDefault();
                const textInput = document.getElementById('comment-text');
                const currentUser = localStorage.getItem('current_user_name') || 'Anonymous';
                
                if (localStorage.getItem('isLoggedIn') !== 'true') {
                    alert('Anda harus login untuk berkomentar.');
                    window.location.href = 'login.html';
                    return;
                }

                if (textInput.value.trim()) {
                    post.comments.push({ author: currentUser, text: textInput.value.trim() });
                    
                    const postIndex = allPosts.findIndex(p => p.id === postId);
                    if(postIndex > -1) {
                        allPosts[postIndex] = post;
                    }

                    localStorage.setItem('kreatoria_posts', JSON.stringify(allPosts));
                    commentsList.classList.add('show');
                    renderComments();
                    textInput.value = '';
                }
            });
        } else {
            postDetailContainer.innerHTML = '<h1>404 - Karya Tidak Ditemukan</h1><p>Karya yang Anda cari mungkin telah dihapus atau URL tidak valid.</p>';
        }
    }
});