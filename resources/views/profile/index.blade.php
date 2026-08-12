@extends($layout)

@section('content')
<style>
    .profile-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding-top: 16px;
        font-family: 'Inter', sans-serif;
    }
    .profile-title {
        font-size: 26px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 32px;
        text-align: center;
    }
    .profile-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        padding: 48px 80px;
        width: 100%;
        max-width: 580px;
        text-align: center;
    }
    .profile-avatar-large {
        width: 124px;
        height: 124px;
        background: #f8fafc;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        color: #94a3b8;
    }
    .profile-avatar-large svg {
        width: 56px;
        height: 56px;
        stroke: currentColor;
        stroke-width: 2.5;
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .profile-name-large {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 6px 0;
    }
    .profile-subtitle {
        font-size: 15px;
        color: #64748b;
        margin: 0 0 32px 0;
    }
    .btn-edit-profile {
        display: block;
        width: 100%;
        box-sizing: border-box;
        background: #1c4ed8;
        color: #ffffff;
        padding: 14px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 15px;
        text-decoration: none;
        transition: background 0.2s;
        margin-bottom: 12px;
    }
    .btn-edit-profile:hover {
        background: #1e40af;
    }
    .btn-logout-profile {
        display: block;
        width: 100%;
        box-sizing: border-box;
        background: #fef2f2;
        color: #dc2626;
        padding: 14px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 15px;
        text-decoration: none;
        transition: background 0.2s;
        border: none;
        cursor: pointer;
    }
    .btn-logout-profile:hover {
        background: #fee2e2;
    }
</style>

<div class="profile-container">
    <h1 class="profile-title">Profil Saya</h1>
    
    <div class="profile-card">
        <div class="profile-avatar-large">
            <svg viewBox="0 0 24 24">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
        </div>
        
        <h2 class="profile-name-large">{{ $user->name }}</h2>
        <p class="profile-subtitle">
            {{ ucfirst($user->role) === 'Admin' ? 'Administrator' : 'User Divisi' }} 
            {{ $user->division ? '- ' . $user->division->name : '' }}
        </p>
        
        <a href="{{ route('profile.edit') }}" class="btn-edit-profile">
            Edit Profil
        </a>
        
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-logout-profile">
                Logout
            </button>
        </form>
    </div>
</div>
@endsection
