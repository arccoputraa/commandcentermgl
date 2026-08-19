@extends($layout)

@section('content')
<style>
    .profile-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding-top: 48px;
        font-family: 'Inter', sans-serif;
    }
    .profile-title {
        font-size: 32px;
        line-height: 1.2;
        font-weight: 800;
        color: #1d293d;
        margin: 0 0 46px 0;
        text-align: center;
    }
    .profile-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e8edf3;
        box-shadow: 0 2px 5px rgba(15, 23, 42, 0.12);
        padding: 48px 80px 40px;
        width: 100%;
        max-width: 720px;
        min-height: 420px;
        text-align: center;
        box-sizing: border-box;
    }
    .profile-avatar-large {
        width: 160px;
        height: 160px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 36px;
        color: #94a3b8;
    }
    .profile-avatar-large svg {
        width: 92px;
        height: 92px;
        stroke: currentColor;
        stroke-width: 2;
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;
    }
    .profile-name-large {
        font-size: 32px;
        line-height: 1.2;
        font-weight: 800;
        color: #1d293d;
        margin: 0 0 8px 0;
    }
    .profile-subtitle {
        font-size: 21px;
        color: #708098;
        margin: 0 0 36px 0;
    }
    .btn-edit-profile {
        display: block;
        width: 100%;
        max-width: 400px;
        box-sizing: border-box;
        background: #2563eb;
        color: #ffffff;
        padding: 14px 18px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 18px;
        text-decoration: none;
        transition: background 0.2s;
        margin: 0 auto 14px;
    }
    .btn-edit-profile:hover {
        background: #1d4ed8;
    }
    .btn-logout-profile {
        display: block;
        width: 100%;
        max-width: 400px;
        box-sizing: border-box;
        background: #fef2f2;
        color: #ef1f1f;
        padding: 14px 18px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 18px;
        text-decoration: none;
        transition: background 0.2s;
        border: none;
        cursor: pointer;
        margin: 0 auto;
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
