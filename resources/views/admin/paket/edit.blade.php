@extends('layouts.admin')

@section('page_title', $package->id ? 'Edit Paket' : 'Tambah Paket')

@section('styles')
<style>
    .edit-container { max-width: 800px; margin: 0 auto; background: var(--bg-light); padding: 20px; border-radius: 12px; position: relative; }
    @media (min-width: 768px) {
        .edit-container { padding: 40px; }
    }
    .btn-close-edit { position: absolute; top: 20px; right: 20px; font-size: 1.5rem; color: #888; text-decoration: none; }
    
    .form-label { display: block; font-weight: 700; color: #8B4513; margin-bottom: 10px; font-size: 1.1rem; }
    .form-input-box { width: 100%; border: 1.5px solid var(--border-color); padding: 12px 20px; border-radius: 10px; margin-bottom: 30px; background: white; font-size: 1rem; color: #5C1F2D; }
    
    .cover-upload-area { 
        width: 100%; border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; 
        background: white; margin-bottom: 40px; text-align: left;
    }
    .cover-preview { width: 100%; max-width: 400px; aspect-ratio: 1; object-fit: cover; border-radius: 8px; margin-bottom: 15px; border: 1px solid #eee; }
    .btn-upload { background: #80404D; color: white; padding: 10px 25px; border-radius: 8px; border: none; cursor: pointer; display: inline-block; font-size: 0.9rem; font-weight: 600; }

    .price-input-wrapper { display: flex; align-items: stretch; border: 1.5px solid var(--border-color); border-radius: 10px; overflow: hidden; margin-bottom: 30px; background: white; }
    .price-prefix { padding: 12px 20px; background: white; color: #8B4513; font-weight: 700; border-right: 1.5px solid var(--border-color); display: flex; align-items: center; }
    .price-input { flex: 1; border: none; padding: 12px 20px; outline: none; font-size: 1rem; font-weight: 600; color: #5C1F2D; }

    .features-input { 
        width: 100%; border: 1.5px solid var(--border-color); border-radius: 10px; padding: 20px; 
        background: white; min-height: 150px; font-size: 0.9rem; margin-bottom: 40px;
        color: #8B4513; font-weight: 500;
    }

    .btn-save { background: #80404D; color: white; border: none; padding: 10px 40px; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; display: block; margin: 0 auto; }
</style>
@endsection

@section('content')
<div class="edit-container">
    <a href="{{ route('admin.paket.index') }}" class="btn-close-edit"><i class="fas fa-times"></i></a>
    
    <header style="background: #80404D; margin: -20px -20px 40px; padding: 15px 20px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
        <h2 style="color: white; font-family: 'Playfair Display', serif; font-size: 1.3rem;">{{ $package->id ? 'Edit Paket' : 'Tambah Kategori' }}</h2>
        <a href="{{ route('admin.paket.index') }}" style="color: white; font-size: 1.5rem;"><i class="fas fa-times"></i></a>
    </header>

    <form action="{{ $package->id ? route('admin.paket.update', $package->id) : route('admin.paket.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($package->id) @method('PUT') @endif
        
        <label class="form-label">Nama Paket</label>
        <input type="text" name="name" class="form-input-box" value="{{ old('name', $package->name) }}" placeholder="Masukan Nama Paket">
        
        <label class="form-label">Foto Paket</label>
        <div class="cover-upload-area">
            @if($package->image)
                <img src="{{ asset('storage/' . $package->image) }}" class="cover-preview">
            @else
                <div class="card" style="width: 100%; max-width: 350px; aspect-ratio: 1; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #fff;">
                    <i class="fas fa-camera" style="font-size: 3rem; color: #ccc; margin-bottom: 10px;"></i>
                </div>
            @endif
            <br>
            <label class="btn-upload">
                Unggah Foto
                <input type="file" name="image" style="display:none;" onchange="previewImage(this)">
            </label>
        </div>

        <label class="form-label">Harga Paket</label>
        <div class="price-input-wrapper">
            <div class="price-prefix">RP</div>
            <input type="number" name="price" class="price-input" value="{{ old('price', $package->price) }}" placeholder="0.000">
        </div>

        <label class="form-label">Isi Paket</label>
        <textarea name="features_raw" class="features-input" placeholder="• 1-2 Orang&#10;• 7 Menit sesi foto&#10;• Cetak strip 2 lembar">{{ old('features_raw', $package->features ? implode("\n", $package->features) : '') }}</textarea>

        {{-- Hidden duration and max_person for simplicity or add fields if needed --}}
        <input type="hidden" name="duration" value="10">
        <input type="hidden" name="max_person" value="1-4 Orang">

        <button type="submit" class="btn-save">Simpan</button>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                let img = document.querySelector('.cover-preview');
                if(!img) {
                    img = document.createElement('img');
                    img.className = 'cover-preview';
                    document.querySelector('.cover-upload-area div').replaceWith(img);
                }
                img.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
