@extends('layouts.admin')

@section('page_title', 'Manajemen Galeri')

@section('styles')
    <style>
        :root {
            --primary-maroon: #80404D;
            --bg-cream: #F5EBE0;
            --border-tan: #D2B48C;
            --text-brown: #8B4513;
        }

        /* GRID */
        .search-row {
            margin-bottom: 30px;
        }

        .galeri-admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
        }
        @media (min-width: 1024px) {
            .galeri-admin-grid {
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            }
        }

        /* CARD */
        .category-admin-card {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #eee;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: 0.3s;
        }

        .category-admin-card:hover {
            transform: translateY(-5px);
        }

        .thumb-wrapper {
            width: 100%;
            aspect-ratio: 4/3;
            overflow: hidden;
            background: #eee;
        }

        .thumb-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cat-info {
            padding: 20px;
        }

        .cat-name {
            font-weight: 700;
            color: var(--primary-maroon);
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .cat-meta {
            font-size: 0.8rem;
            color: #888;
            margin-bottom: 15px;
        }

        .cat-actions {
            display: flex;
            gap: 10px;
        }

        .btn-edit,
        .btn-delete {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-edit {
            background: white;
            border: 1px solid #ddd;
        }

        .btn-edit:hover {
            background: #f5f5f5;
        }

        .btn-delete {
            background: var(--primary-maroon);
            color: white;
            border: none;
        }

        .btn-delete:hover {
            background: #5c2c36;
        }

        /* ADD CARD */
        .add-category-card-main {
            background: #F2E8E4;
            border: 2px dashed #D2B48C;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            cursor: pointer;
            min-height: 380px;
            transition: 0.3s;
            gap: 15px;
        }

        .add-category-card-main:hover {
            background: #fafafa;
        }

        .add-icon-main {
            font-size: 2rem;
        }

        /* ================= MODAL BARU ================= */

        /* Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;

            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);

            display: flex;
            align-items: center;
            justify-content: center;

            z-index: 9999;

            opacity: 0;
            visibility: hidden;
            transition: 0.3s;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Modal Box */
        .modal-container {
            width: 100%;
            max-width: 600px;

            background: white;
            border-radius: 16px;

            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.2);

            overflow: hidden;

            transform: scale(0.9);
            opacity: 0;
            transition: 0.3s;
        }

        .modal-overlay.active .modal-container {
            transform: scale(1);
            opacity: 1;
        }

        /* Header */
        .modal-header {
            background: var(--primary-maroon);
            color: white;
            padding: 18px 25px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-close-modal {
            font-size: 1.5rem;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
        }

        /* Body */
        .modal-body {
            padding: 25px;
            max-height: 65vh;
            overflow-y: auto;
        }

        .form-label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        /* Cover */
        .cover-preview-img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        /* Photo grid */
        .photo-grid-modal {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .photo-item-modal {
            position: relative;
        }

        .photo-item-modal img {
            width: 100%;
            border-radius: 10px;
        }

        .btn-trash-modal {
            position: absolute;
            top: 5px;
            right: 5px;
            background: white;
            border: none;
            cursor: pointer;
        }

        /* Footer */
        .modal-footer {
            padding: 20px;
            border-top: 1px solid #eee;
            text-align: right;
        }

        .btn-save-modal {
            background: var(--primary-maroon);
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
            font-weight: 700;
        }

        .btn-save-modal:hover {
            background: #5c2c36;
            transform: scale(1.02);
        }

        .section-title-modal {
            display: block;
            font-weight: 700;
            color: var(--primary-maroon);
            margin: 20px 0 10px;
            font-size: 1rem;
        }

        .btn-unggah {
            background: #fdf5f2;
            color: var(--primary-maroon);
            border: 1.5px solid var(--border-tan);
            padding: 8px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            display: inline-block;
            font-size: 0.9rem;
        }

        .add-photo-btn-modal {
            border: 2px dashed #ddd;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            cursor: pointer;
            transition: 0.3s;
            gap: 8px;
            background: #fafafa;
        }

        .add-photo-btn-modal:hover {
            background: #f5f5f5;
            border-color: var(--primary-maroon);
        }

        .add-photo-btn-modal .at-icon {
            font-size: 1.5rem;
            color: var(--primary-maroon);
        }

        .add-photo-btn-modal span {
            font-size: 0.8rem;
            font-weight: 700;
            color: #888;
        }

        .photo-num-label {
            position: absolute;
            bottom: 5px;
            left: 5px;
            right: 5px;
            background: rgba(128, 64, 77, 0.8);
            color: white;
            font-size: 0.65rem;
            padding: 3px;
            border-radius: 4px;
            text-align: center;
        }

        .btn-trash-modal {
            position: absolute;
            top: 5px;
            right: 5px;
            background: white;
            border: 1px solid #ddd;
            width: 26px;
            height: 26px;
            border-radius: 5px;
            color: #e74c3c;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="search-row">
        <input type="text" class="search-box" style="margin-bottom: 0;" placeholder="Cari Galeri...">
    </div>

    <div class="galeri-admin-grid">
        @foreach ($categories as $cat)
            <div class="category-admin-card">
                <div class="thumb-wrapper">
                    <img src="{{ $cat->image ? asset('storage/' . $cat->image) : 'https://images.unsplash.com/photo-1513519245088-0e12902e35ca?q=80&w=400' }}"
                        class="thumb-img">
                </div>
                <div class="cat-info">
                    <h4 class="cat-name">{{ $cat->name }}</h4>
                    <p class="cat-meta">{{ $cat->photos_count }} Foto • {{ $cat->created_at->format('d M Y') }}</p>
                    <div class="cat-actions">
                        <button type="button" class="btn-edit" data-cat="{{ $cat->toJson() }}"
                            data-photos="{{ $cat->photos->toJson() }}" onclick="openEditModal(this)">
                            <i class="far fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('admin.galeri.destroy', $cat->id) }}" method="POST" style="flex:1;"
                            onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete"><i class="far fa-trash-alt"></i> Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="category-admin-card add-category-card-main" onclick="openAddModal()">
            <div class="add-icon-main"><i class="fas fa-plus"></i></div>
            <span style="font-weight: 700; font-family: 'Playfair Display', serif;">Tambah Kategori</span>
        </div>
    </div>

    <!-- Modal Galeri -->
    <div class="modal-overlay" id="galleryModal">
        <div class="modal-container">
            <div class="modal-header">
                <h3 id="modalTitle">Edit Galeri</h3>
                <button class="btn-close-modal" onclick="closeModal()"><i class="fas fa-times"></i></button>
            </div>
            <form id="galleryForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="modal-body">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="name" id="catName" class="form-input" placeholder="Elevator Vibes"
                        required>

                    <span class="section-title-modal">Foto Sampul</span>
                    <div class="cover-box">
                        <img id="coverPreview" src="https://images.unsplash.com/photo-1513519245088-0e12902e35ca?q=80&w=400"
                            class="cover-preview-img">
                        <div style="text-align: left;">
                            <label class="btn-unggah">
                                Unggah Foto
                                <input type="file" name="image" id="coverInput" style="display:none;"
                                    onchange="previewImage(this, 'coverPreview')">
                            </label>
                        </div>
                    </div>

                    <span class="section-title-modal">Daftar Foto Dalam Kategori</span>
                    <div class="photo-grid-modal" id="photoGrid">
                        <!-- Dynamic Photos -->
                        <label class="add-photo-btn-modal">
                            <div class="at-icon"><i class="fas fa-plus-circle"></i></div>
                            <span>Tambah Foto</span>
                            <input type="file" name="photos[]" multiple style="display:none;"
                                onchange="handleMultiplePhotos(this)">
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn-save-modal">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const modal = document.getElementById('galleryModal');
        const form = document.getElementById('galleryForm');
        const methodInput = document.getElementById('formMethod');
        const modalTitle = document.getElementById('modalTitle');
        const catNameInput = document.getElementById('catName');
        const coverPreview = document.getElementById('coverPreview');
        const photoGrid = document.getElementById('photoGrid');
        let selectedFiles = new DataTransfer();

        function openAddModal() {
            modalTitle.innerText = "Tambah Galeri";
            form.action = "{{ route('admin.galeri.store') }}";
            methodInput.value = "POST";
            catNameInput.value = "";
            coverPreview.src = "https://images.unsplash.com/photo-1513519245088-0e12902e35ca?q=80&w=400";
            renderPhotos([]);
            selectedFiles = new DataTransfer(); // Reset accumulated files
            modal.classList.add('active');
        }

        function openEditModal(btn) {
            const category = JSON.parse(btn.getAttribute('data-cat'));
            const photos = JSON.parse(btn.getAttribute('data-photos'));

            modalTitle.innerText = "Edit Galeri";
            form.action = `/admin/galeri/${category.id}`;
            methodInput.value = "PUT";

            catNameInput.value = category.name;
            coverPreview.src = category.image ? `/storage/${category.image}` :
                "https://images.unsplash.com/photo-1513519245088-0e12902e35ca?q=80&w=400";

            renderPhotos(photos);
            selectedFiles = new DataTransfer(); // Reset accumulated files
            modal.classList.add('active');
        }

        function renderPhotos(photos) {
            let photosHtml = '';
            photos.forEach((p, index) => {
                photosHtml += `
                <div class="photo-item-modal" id="photo-${p.id}">
                    <img src="/storage/${p.image}">
                    <button type="button" class="btn-trash-modal" onclick="deleteExistingPhoto(${p.id})">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <div class="photo-num-label">Foto ${index + 1}</div>
                </div>
            `;
            });

            photosHtml += `
            <label class="add-photo-btn-modal">
                <div class="at-icon"><i class="fas fa-plus-circle"></i></div>
                <span>Tambah Foto</span>
                <input type="file" name="photos[]" multiple style="display:none;" onchange="handleMultiplePhotos(this)">
            </label>
        `;
            photoGrid.innerHTML = photosHtml;
        }

        function closeModal() {
            modal.classList.remove('active');
        }

        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function handleMultiplePhotos(input) {
            if (input.files && input.files.length > 0) {
                const addBtn = input.closest('label');
                
                let oversizedFiles = 0;
                const MAX_TOTAL_SIZE = 8 * 1024 * 1024; // 8MB batas aman server
                
                // Add new files to our DataTransfer object
                Array.from(input.files).forEach((file) => {
                    let currentTotalSize = 0;
                    for(let i = 0; i < selectedFiles.files.length; i++) {
                        currentTotalSize += selectedFiles.files[i].size;
                    }
                    
                    // Cek jika menambah file ini akan melebihi 8MB
                    if (currentTotalSize + file.size > MAX_TOTAL_SIZE) {
                        oversizedFiles++;
                    } else {
                        selectedFiles.items.add(file);
                        
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const tempId = 'new-' + Math.random().toString(36).substr(2, 9);
                            const card = document.createElement('div');
                            card.className = 'photo-item-modal';
                            card.id = tempId;
                            card.innerHTML = `
                                <img src="${e.target.result}" style="opacity: 0.8; border: 2px solid #27AE60;">
                                <button type="button" class="btn-trash-modal" onclick="removeNewPhoto('${tempId}', '${file.name}')">
                                    <i class="fas fa-times" style="color: #e74c3c"></i>
                                </button>
                                <div class="photo-num-label" style="background: #27AE60;">Baru</div>
                            `;
                            photoGrid.insertBefore(card, addBtn);
                        }
                        reader.readAsDataURL(file);
                    }
                });

                // Update the file input with ALL accumulated files
                input.files = selectedFiles.files;

                if (oversizedFiles > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Batas Upload Tercapai',
                        text: `${oversizedFiles} foto gagal ditambah karena total ukuran melebihi batas server (8MB). Silakan simpan dulu, lalu tambah sisanya.`,
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Foto Ditambahkan',
                        text: `${input.files.length} foto siap diunggah.`,
                        timer: 1000,
                        showConfirmButton: false
                    });
                }
            }
        }

        function removeNewPhoto(tempId, fileName) {
            const container = document.getElementById(tempId);
            if (container) {
                container.remove();
                
                // Remove from DataTransfer
                const newDataTransfer = new DataTransfer();
                Array.from(selectedFiles.files).forEach(file => {
                    if (file.name !== fileName) {
                        newDataTransfer.items.add(file);
                    }
                });
                selectedFiles = newDataTransfer;
                
                // Update the actual input
                document.querySelector('input[name="photos[]"]').files = selectedFiles.files;
            }
        }

        function deleteExistingPhoto(photoId) {
            Swal.fire({
                title: 'Hapus foto?',
                text: "Foto akan dihapus permanen setelah Anda klik Simpan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#80404D',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'delete_photos[]';
                    input.value = photoId;
                    form.appendChild(input);
                    document.getElementById(`photo-${photoId}`).remove();
                }
            });
        }

        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        // Auto-open modal if there are validation errors
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan input, silakan cek kembali.',
            });
            // Check if we were adding or editing (this is a bit tricky, but we can assume add if no old ID)
            openAddModal();
        @endif
    </script>
@endsection
