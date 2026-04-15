@extends('layouts.admin')

@section('page_title', 'Manajemen Paket')

@section('styles')
    <style>
        /* Grid Layout - FIXED with !important to override Tailwind */
        .paket-admin-grid {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 30px !important;
            margin-top: 20px !important;
            width: 100% !important;
        }

        /* Responsive grid */
        @media (max-width: 1200px) {
            .paket-admin-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 25px !important;
            }
        }

        @media (max-width: 768px) {
            .paket-admin-grid {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }
        }

        .paket-admin-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid #eee;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            text-align: left;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .paket-admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(123, 45, 62, 0.1);
        }

        .thumb-wrapper-paket {
            width: 100%;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            background: #eee;
            position: relative;
        }

        .thumb-img-paket {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .pkg-float-name {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
            padding: 20px 10px 10px;
            color: white;
            font-weight: 700;
            font-family: 'Great Vibes', cursive;
            font-size: 1.8rem;
        }

        .paket-body {
            padding: 20px;
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .paket-price-title {
            font-weight: 800;
            color: #80404D;
            font-size: 1.25rem;
            margin-bottom: 20px;
            font-family: 'Poppins', sans-serif;
        }

        .pkg-features-list {
            list-style: none;
            margin-bottom: 25px;
            text-align: left;
            padding: 0 10px;
            flex: 1;
        }

        .pkg-features-list li {
            font-size: 0.82rem;
            color: #5C1F2D;
            margin-bottom: 8px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-weight: 600;
        }

        .pkg-features-list li::before {
            content: '•';
            color: #80404D;
            font-weight: 900;
            font-size: 1.2rem;
        }

        .cat-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .btn-edit,
        .btn-delete {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            border: none;
            transition: 0.2s;
        }

        .btn-edit {
            background: #F8F9FA;
            color: #333;
            border: 1px solid #ddd;
            text-decoration: none;
        }

        .btn-edit:hover {
            background: #eee;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #80404D;
            color: white;
        }

        .btn-delete:hover {
            background: #5C1F2D;
            transform: translateY(-2px);
        }

        /* Add Card */
        .add-package-card {
            background: #F2E8E4;
            border: 2px dashed #D2B48C;
            border-radius: 20px;
            min-height: 400px;
            display: flex !important;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
            gap: 15px;
        }

        .add-package-card:hover {
            background: #EADED9;
            transform: scale(0.98);
        }

        .add-icon-circle {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 2.5px solid #80404D;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #80404D;
            font-size: 1.8rem;
        }

        .add-text {
            color: #80404D;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
        }

        /* Search Row */
        .search-row {
            margin-bottom: 25px;
        }

        .search-wrapper {
            width: 100%;
            position: relative;
        }

        .search-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #ccc;
            z-index: 1;
        }

        .search-input {
            width: 100%;
            border-radius: 12px;
            padding: 12px 15px 12px 45px;
            border: 1.5px solid #eee;
            background: white;
            transition: 0.2s;
        }

        .search-input:focus {
            outline: none;
            border-color: #80404D;
            box-shadow: 0 0 0 3px rgba(128, 64, 77, 0.1);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .modal-content-custom {
            background: #FDF5F2;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            border-radius: 20px;
            overflow-y: auto;
            position: relative;
            animation: slideUp 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header-custom {
            background: #80404D;
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .modal-header-custom h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0;
        }

        .btn-close-modal {
            background: none;
            border: none;
            color: white;
            font-size: 1.8rem;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-close-modal:hover {
            transform: scale(1.1);
        }

        .modal-body-custom {
            padding: 25px;
        }

        @media (min-width: 768px) {
            .modal-body-custom {
                padding: 40px;
            }
        }

        .form-group-custom {
            margin-bottom: 25px;
        }

        .form-group-custom label {
            display: block;
            font-weight: 700;
            color: #80404D;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .form-control-custom {
            width: 100%;
            padding: 12px 20px;
            border: 1.5px solid #D2B48C;
            border-radius: 12px;
            background: white;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            color: #5C1F2D;
            transition: 0.2s;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: #80404D;
            box-shadow: 0 0 0 3px rgba(128, 64, 77, 0.1);
        }

        .price-input-wrapper {
            display: flex;
            align-items: center;
            border: 1.5px solid #D2B48C;
            border-radius: 12px;
            overflow: hidden;
            background: white;
        }

        .currency-prefix {
            background: #fdf5f2;
            padding: 0 20px;
            height: 100%;
            font-weight: 700;
            color: #80404D;
            border-right: 1.5px solid #D2B48C;
            display: flex;
            align-items: center;
        }

        .price-input-wrapper input {
            border: none !important;
            flex: 1;
        }

        .photo-upload-container {
            border: 1px solid #D2B48C;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            background: #FAF3F0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .photo-preview-placeholder {
            width: 100%;
            max-width: 300px;
            aspect-ratio: 1;
            background: #FDF9F8;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 10px;
        }

        .photo-preview-placeholder i {
            font-size: 5rem;
            color: #ccc;
        }

        .btn-upload-custom {
            background: #80404D;
            color: white;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-size: 0.9rem;
            border: none;
            transition: 0.2s;
        }

        .btn-upload-custom:hover {
            background: #5C1F2D;
            transform: translateY(-2px);
        }

        .btn-save-custom {
            display: block;
            width: 120px;
            margin: 30px auto 0;
            background: #80404D;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-save-custom:hover {
            background: #5C1F2D;
            transform: scale(1.05);
        }

        .features-textarea {
            min-height: 150px;
            resize: vertical;
            padding: 20px;
            line-height: 1.6;
        }

        /* Override Tailwind default styles */
        .paket-admin-grid>* {
            min-width: 0;
        }
    </style>
@endsection

@section('content')
    <div class="search-row">
        <div class="search-wrapper">
            <i class="fas fa-search"></i>
            <input type="text" class="search-input" id="pkgSearch" placeholder="Cari Paket...">
        </div>
    </div>

    <div class="paket-admin-grid">
        @foreach ($packages as $pkg)
            <div class="paket-admin-card">
                <div class="thumb-wrapper-paket">
                    <img src="{{ $pkg->image ? asset('storage/' . $pkg->image) : 'https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=400' }}"
                        class="thumb-img-paket" alt="{{ $pkg->name }}">
                    <div class="pkg-float-name">{{ $pkg->name }}</div>
                </div>
                <div class="paket-body">
                    <h4 class="paket-price-title">Mulai RP. {{ number_format($pkg->price, 0, ',', '.') }}</h4>
                    <ul class="pkg-features-list">
                        <li>👥 {{ $pkg->max_person }}</li>
                        <li>⏱️ {{ $pkg->duration }} Menit Sesi Foto</li>
                        @if (is_array($pkg->features))
                            @foreach ($pkg->features as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        @endif
                    </ul>
                    <div class="cat-actions">
                        <button type="button" class="btn-edit"
                            onclick="openEditModal('{{ $pkg->id }}', '{{ addslashes($pkg->name) }}', '{{ $pkg->price }}', '{{ $pkg->duration }}', '{{ addslashes($pkg->max_person) }}', '{{ is_array($pkg->features) ? str_replace(["\r", "\n"], ['\r', '\n'], addslashes(implode("\n", $pkg->features))) : '' }}', '{{ $pkg->image ? asset('storage/' . $pkg->image) : '' }}')">
                            <i class="far fa-edit"></i> Edit
                        </button>
                        <button type="button" class="btn-delete" onclick="confirmDelete('{{ $pkg->id }}')">
                            <i class="far fa-trash-alt"></i> Hapus
                        </button>
                        <form id="delete-form-{{ $pkg->id }}" action="{{ route('admin.paket.destroy', $pkg->id) }}"
                            method="POST" style="display:none;">
                            @csrf @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="add-package-card" onclick="openCreateModal()">
            <div class="add-icon-circle"><i class="fas fa-plus"></i></div>
            <span class="add-text">Tambah Paket</span>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal-overlay" id="modalCreate">
        <div class="modal-content-custom">
            <div class="modal-header-custom">
                <h2>Tambah Paket</h2>
                <button class="btn-close-modal" onclick="closeModal('modalCreate')">&times;</button>
            </div>
            <div class="modal-body-custom">
                <form action="{{ route('admin.paket.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group-custom">
                        <label>Nama Paket</label>
                        <input type="text" name="name" class="form-control-custom" placeholder="Masukkan nama paket"
                            required>
                    </div>

                    <div class="form-group-custom">
                        <label>Foto Paket</label>
                        <div class="photo-upload-container">
                            <div class="photo-preview-placeholder" id="preview-create">
                                <i class="fas fa-camera"></i>
                            </div>
                            <input type="file" name="image" id="file-create" style="display:none;"
                                onchange="previewImage(this, 'preview-create')" accept="image/*" required>
                            <button type="button" class="btn-upload-custom"
                                onclick="document.getElementById('file-create').click()">Unggah Foto</button>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label>Harga Paket</label>
                        <div class="price-input-wrapper">
                            <div class="currency-prefix">RP</div>
                            <input type="number" name="price" class="form-control-custom" placeholder="35000" required>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label>Informasi Sesi (Duration & Max Person)</label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <input type="number" name="duration" class="form-control-custom" value="7"
                                placeholder="Durasi (Menit)" required>
                            <input type="text" name="max_person" class="form-control-custom" value="1 - 2 Orang"
                                placeholder="Max Person" required>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label>Isi Paket</label>
                        <textarea name="features_raw" class="form-control-custom features-textarea"
                            placeholder="• 1-2 Orang&#10;• 7 Menit sesi foto&#10;• Cetak strip 2 lembar"></textarea>
                    </div>

                    <button type="submit" class="btn-save-custom">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal-overlay" id="modalEdit">
        <div class="modal-content-custom">
            <div class="modal-header-custom">
                <h2>Edit Paket</h2>
                <button class="btn-close-modal" onclick="closeModal('modalEdit')">&times;</button>
            </div>
            <div class="modal-body-custom">
                <form id="edit-form" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="form-group-custom">
                        <label>Nama Paket</label>
                        <input type="text" name="name" id="edit-name" class="form-control-custom" required>
                    </div>

                    <div class="form-group-custom">
                        <label>Foto Paket</label>
                        <div class="photo-upload-container">
                            <div class="photo-preview-placeholder" id="preview-edit">
                                <i class="fas fa-camera"></i>
                            </div>
                            <input type="file" name="image" id="file-edit" style="display:none;"
                                onchange="previewImage(this, 'preview-edit')" accept="image/*">
                            <button type="button" class="btn-upload-custom"
                                onclick="document.getElementById('file-edit').click()">Unggah Foto</button>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label>Harga Paket</label>
                        <div class="price-input-wrapper">
                            <div class="currency-prefix">RP</div>
                            <input type="number" name="price" id="edit-price" class="form-control-custom" required>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label>Informasi Sesi</label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <input type="number" name="duration" id="edit-duration" class="form-control-custom"
                                required>
                            <input type="text" name="max_person" id="edit-max-person" class="form-control-custom"
                                required>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label>Isi Paket</label>
                        <textarea name="features_raw" id="edit-features" class="form-control-custom features-textarea"></textarea>
                    </div>

                    <button type="submit" class="btn-save-custom">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function openCreateModal() {
            document.getElementById('modalCreate').style.display = 'flex';
        }

        function openEditModal(id, name, price, duration, maxPerson, features, image) {
            document.getElementById('edit-form').action = `/admin/paket/${id}`;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-price').value = Math.round(price);
            document.getElementById('edit-duration').value = duration;
            document.getElementById('edit-max-person').value = maxPerson;
            document.getElementById('edit-features').value = features;

            if (image && image !== '') {
                document.getElementById('preview-edit').innerHTML =
                    `<img src="${image}" style="width:100%; height:100%; object-fit:cover;">`;
            } else {
                document.getElementById('preview-edit').innerHTML = `<i class="fas fa-camera"></i>`;
            }

            document.getElementById('modalEdit').style.display = 'flex';
        }

        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }

        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML =
                        `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Paket ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#80404D',
                cancelButtonColor: '#eee',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#FDF5F2',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal-overlay')) {
                event.target.style.display = 'none';
            }
        }

        // Search functionality
        document.getElementById('pkgSearch').addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            let cards = document.querySelectorAll('.paket-admin-card');

            cards.forEach(card => {
                let title = card.querySelector('.pkg-float-name').innerText.toLowerCase();
                if (title.includes(searchValue)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
@endsection
