@extends('layouts.admin')

@section('page_title', 'Profil')

@section('styles')
<style>
    .profile-card { 
        max-width: 600px; margin: 40px auto; background: white; 
        border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); padding: 50px;
        text-align: center;
    }
    .profile-avatar-wrapper { 
        position: relative; width: 120px; height: 120px; margin: 0 auto 40px; 
        border-radius: 50%; border: 4px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden; background: #ddd;
    }
    .profile-avatar-wrapper img { width: 100%; height: 100%; object-fit: cover; }
    .camera-overlay { 
        position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
        background: rgba(0,0,0,0.3); display: flex; align-items: center; 
        justify-content: center; color: white; border-radius: 50%; transition: 0.3s;
    }

    .form-group-profile { margin-bottom: 20px; position: relative; }
    .profile-input-wrapper { display: flex; align-items: center; border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; }
    .profile-icon { padding: 12px 20px; color: #8B4513; font-size: 1rem; border-right: 1px solid var(--border-color); }
    .profile-input { flex: 1; border: none; padding: 12px 20px; outline: none; font-size: 0.95rem; color: #5C1F2D; }

    .btn-row-profile { display: flex; gap: 20px; margin-top: 40px; justify-content: center; }
    .btn-simpan { background: #80404D; color: white; padding: 12px 50px; border-radius: 12px; border: none; font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; cursor: pointer; }
    .btn-batalkan { background: white; border: 1.5px solid #80404D; color: #5C1F2D; padding: 12px 40px; border-radius: 12px; font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; text-decoration: none; display: inline-block; }
</style>
@endsection

@section('content')
<div class="profile-card">
    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf @method('PUT')
        
        <div class="profile-avatar-wrapper">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=E8D5D0&color=7B2D3E" alt="Profile">
            <div class="camera-overlay"><i class="fas fa-camera"></i></div>
        </div>

        <div class="form-group-profile">
            <div class="profile-input-wrapper">
                <div class="profile-icon"><i class="fas fa-user"></i></div>
                <input type="text" name="name" class="profile-input" value="{{ old('name', $user->name) }}" placeholder="Nama">
            </div>
        </div>

        <div class="form-group-profile">
            <div class="profile-input-wrapper">
                <div class="profile-icon"><i class="fas fa-phone"></i></div>
                <input type="text" name="phone_number" class="profile-input" value="{{ old('phone_number', $user->phone_number) }}" placeholder="No HP">
            </div>
        </div>

        <div class="form-group-profile">
            <div class="profile-input-wrapper">
                <div class="profile-icon"><i class="fas fa-lock"></i></div>
                <input type="password" name="password" class="profile-input" value="12345" placeholder="Password" disabled>
                <div style="padding-right: 20px; color: #888;"><i class="fas fa-eye-slash"></i></div>
            </div>
        </div>

        <div class="btn-row-profile">
            <button type="submit" class="btn-simpan">Simpan</button>
            <a href="{{ route('admin.dashboard') }}" class="btn-batalkan">Batalkan</a>
        </div>
    </form>
</div>
@endsection
