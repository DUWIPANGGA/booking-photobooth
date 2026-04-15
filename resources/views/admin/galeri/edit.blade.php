@extends('layouts.admin')

@section('page_title', 'Edit Galeri')

@section('styles')
<style>
    .edit-container { max-width: 800px; margin: 0 auto; background: var(--bg-light); padding: 40px; border-radius: 12px; position: relative; }
    .btn-close-edit { position: absolute; top: 20px; right: 20px; font-size: 1.5rem; color: #888; text-decoration: none; }
    
    .form-label { display: block; font-weight: 700; color: #8B4513; margin-bottom: 10px; font-size: 1.1rem; }
    .form-input-lg { width: 100%; border: 1.5px solid var(--border-color); padding: 12px 20px; border-radius: 10px; margin-bottom: 30px; font-family: 'Great Vibes', cursive; font-size: 1.4rem; }
    
    .section-title { font-weight: 700; color: #8B4513; margin-bottom: 20px; font-size: 1.1rem; }
    
    .cover-upload-area { 
        width: 100%; border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; 
        background: white; margin-bottom: 40px; text-align: center;
    }
    .cover-preview { width: 300px; aspect-ratio: 4/3; object-fit: cover; border-radius: 8px; margin-bottom: 15px; }
    .btn-upload { background: #80404D; color: white; padding: 10px 25px; border-radius: 8px; border: none; cursor: pointer; display: inline-block; font-size: 0.9rem; font-weight: 600; }

    .photos-list-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 40px; }
    .photo-item-card { 
        position: relative; border-radius: 8px; overflow: hidden; border: 1px solid var(--border-color);
        aspect-ratio: 1;
    }
    .photo-item-card img { width: 100%; height: 100%; object-fit: cover; }
    .btn-del-photo { 
        position: absolute; top: 5px; right: 5px; background: white; color: #333; 
        width: 24px; height: 24px; border-radius: 4px; display: flex; align-items: center; justify-content: center;
        border: 1px solid #ddd; cursor: pointer; font-size: 0.8rem;
    }
    .photo-label { position: absolute; bottom: 0; left: 0; right: 0; background: rgba(128, 64, 77, 0.8); color: white; padding: 5px; font-size: 0.7rem; text-align: center; }

    .btn-save-all { background: #80404D; color: white; border: none; padding: 15px 50px; border-radius: 8px; font-size: 1.1rem; font-weight: 700; cursor: pointer; display: block; margin: 0 auto; }
</style>
@endsection

@section('content')
<div class="edit-container">
    <a href="{{ route('admin.galeri.index') }}" class="btn-close-edit"><i class="fas fa-times"></i></a>
    
    <form action="{{ route('admin.galeri.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        
        <label class="form-label">Nama Kategori</label>
        <input type="text" name="name" class="form-input-lg" value="{{ $category->name }}">
        
        <label class="section-title">Foto Sampul</label>
        <div class="cover-upload-area">
            <img id="cover-preview-img" src="{{ $category->image ? asset('storage/' . $category->image) : 'https://images.unsplash.com/photo-1513519245088-0e12902e35ca?q=80&w=400' }}" class="cover-preview">
            <br>
            <label class="btn-upload">
                Unggah Foto
                <input type="file" name="image" style="display:none;" onchange="previewCover(this)">
            </label>
        </div>

        <label class="section-title">Daftar Foto Dalam Kategori</label>
        <div class="photos-list-grid" id="photos-container">
            @foreach($category->photos as $p)
            <div class="photo-item-card">
                <img src="{{ asset('storage/' . $p->image) }}">
                <button type="button" class="btn-del-photo"><i class="fas fa-trash-alt"></i></button>
                <div class="photo-label">Foto {{ $loop->iteration }}</div>
            </div>
            @endforeach
            
            <label class="photo-item-card add-category-card" id="add-photo-btn" style="min-height: auto; cursor: pointer; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 5px; background: #fafafa; border: 1px dashed #ddd;">
                <div class="add-icon" style="width: 30px; height: 30px; font-size: 1rem; border: 1.5px solid #80404D; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #80404D;"><i class="fas fa-plus"></i></div>
                <span style="font-size: 0.7rem; font-weight: 700; color: #80404D;">Tambah Foto</span>
                <input type="file" name="photos[]" multiple style="display:none;" onchange="previewPhotos(this)">
            </label>
        </div>

        <button type="submit" class="btn-save-all">Simpan</button>
    </form>
</div>
@endsection
@section('scripts')
<script>
    function previewCover(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('cover-preview-img').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewPhotos(input) {
        const container = document.getElementById('photos-container');
        const addBtn = document.getElementById('add-photo-btn');
        
        // Remove previous previews (if they were added manually)
        // Note: For simplicity, we just keep adding or we clear if we want "per selection"
        // The user said "pas nambahin foto... bisa langsung tampil", which usually means appending.
        
        if (input.files) {
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const card = document.createElement('div');
                    card.className = 'photo-item-card preview-item';
                    card.innerHTML = `
                        <img src="${e.target.result}">
                        <div class="photo-label" style="background: #27AE60;">Baru</div>
                    `;
                    container.insertBefore(card, addBtn);
                }
                reader.readAsDataURL(file);
            });
        }
    }
</script>
@endsection
