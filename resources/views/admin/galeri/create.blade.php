@extends('layouts.admin')

@section('page_title', 'Tambah Kategori Galeri')

@section('styles')
<style>
    .form-container {
        background: white; border-radius: 20px; padding: 40px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto;
    }
    
    .form-header { margin-bottom: 30px; border-bottom: 1.5px solid #eee; padding-bottom: 20px; }
    .form-header h3 { font-family: 'Playfair Display', serif; color: #80404D; font-size: 1.8rem; }
    
    .form-group { margin-bottom: 25px; }
    .form-group label { display: block; font-weight: 700; color: #5C1F2D; margin-bottom: 10px; }
    .form-control { 
        width: 100%; padding: 12px 20px; border: 1.5px solid #D2B48C; border-radius: 12px;
        font-family: 'Poppins', sans-serif; font-size: 1rem; color: #333;
    }
    .form-control:focus { outline: none; border-color: #80404D; box-shadow: 0 0 0 3px rgba(128,64,77,0.1); }
    
    .photo-preview-box {
        width: 100%; height: 300px; background: #FAF3F0; border: 2px dashed #D2B48C;
        border-radius: 15px; display: flex; align-items: center; justify-content: center;
        overflow: hidden; cursor: pointer; position: relative;
    }
    .photo-preview-box img { width: 100%; height: 100%; object-fit: cover; }
    .photo-placeholder { text-align: center; color: #8C6474; }
    .photo-placeholder i { font-size: 3rem; margin-bottom: 10px; display: block; }
    
    .btn-submit { 
        background: #80404D; color: white; border: none; padding: 15px 40px; 
        border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.3s;
        display: inline-flex; align-items: center; gap: 10px; font-size: 1rem;
    }
    .btn-submit:hover { background: #5C1F2D; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(128,64,77,0.3); }
    
    .btn-back { 
        padding: 15px 25px; border-radius: 10px; color: #8C6474; text-decoration: none; 
        font-weight: 600; transition: 0.3s; display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-back:hover { color: #5C1F2D; background: #fdf5f2; }
</style>
@endsection

@section('content')
<div class="form-container">
    <div class="form-header">
        <h3><i class="fas fa-folder-plus"></i> Kategori Galeri Baru</h3>
        <p style="color: #888;">Tambahkan kategori baru untuk mengelompokkan koleksi foto studio Anda.</p>
    </div>

    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nama Kategori</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Bestie Vibes, Elevator Vibes..." required>
        </div>

        <div class="form-group">
            <label>Foto Sampul Kategori</label>
            <div class="photo-preview-box" onclick="document.getElementById('image').click()" id="preview-container">
                <div class="photo-placeholder" id="placeholder">
                    <i class="fas fa-camera"></i>
                    <span>Klik untuk pilih foto sampul</span>
                </div>
                <input type="file" name="image" id="image" style="display:none;" onchange="previewMainImage(this)" required>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 40px;">
            <a href="{{ route('admin.galeri.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali Ke List
            </a>
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Simpan Kategori
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function previewMainImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = document.getElementById('preview-container');
                const placeholder = document.getElementById('placeholder');
                
                // Reset content
                container.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                // Add click event back
                container.onclick = function() { document.getElementById('image').click(); };
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
