<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Command Center Kota Magelang')</title>
    <link rel="icon" href="{{ asset('images/cmdcenterlogo.png') }}" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/admin.css', 'resources/js/app.js'])
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <img src="{{ asset('images/cmdcenterlogo.png') }}" alt="Logo Command Center" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Lambang_Kota_Magelang.png/403px-Lambang_Kota_Magelang.png'">
            </div>
            <h2>MagelangCC</h2>
        </div>
        <nav class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i> Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Daftar Pengguna
            </a>
            <a href="{{ route('admin.roles.index') }}" class="menu-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                <i class="fa-solid fa-shield-halved"></i> Hak Akses
            </a>
            <a href="{{ route('admin.divisions.index') }}" class="menu-item {{ request()->routeIs('admin.divisions.*') ? 'active' : '' }}">
                <i class="fa-solid fa-building"></i> Daftar Divisi
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-video"></i> CCTV
            </a>
            <a href="{{ route('profile.index') }}" class="menu-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <i class="fa-solid fa-user-circle"></i> Profil
            </a>
        </nav>
        <div class="sidebar-menu" style="flex-grow: 0; padding-top: 0;">
            <a href="#" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Topbar -->
        <header class="admin-topbar">
            <div class="topbar-left">
                <h2 class="topbar-title">Command Center</h2>
            </div>
            <div class="topbar-profile">
                <div class="profile-info">
                    <h4>{{ Auth::user()->name ?? 'Admin Utama' }}</h4>
                    <p>{{ Auth::user()->role ?? 'Administrator' }}</p>
                </div>
                <div class="profile-img">
                    <i class="fa-regular fa-user"></i>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="admin-content">
            @yield('content')
        </div>
    </main>

    <!-- Modals -->
    @include('admin.components.modal-roles')
    @include('admin.components.modal-divisions')

    <!-- Scripts -->
    @stack('scripts')
    <script>
        function openModal(id) {
            document.getElementById(id).classList.add('show');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('show');
        }

        function openRoleModal(type, name, division, role, status, id, permissionsStr) {
            let permissions = [];
            try {
                if (permissionsStr) permissions = JSON.parse(permissionsStr);
            } catch (e) {
                console.error("Failed to parse permissions", e);
            }
            
            if (type === 'create') {
                document.getElementById('editRoleModalTitle').innerText = 'Tambah Hak Akses';
                document.getElementById('editRoleUserSelect').value = '';
                document.getElementById('editRoleUserSelect').disabled = false;
                document.getElementById('hiddenEditRoleUserId').disabled = true;
                
                document.getElementById('editRoleDivision').value = '';
                document.getElementById('editRoleRole').value = 'user';
                
                // uncheck all
                document.querySelectorAll('#modalEditRole .custom-checkbox').forEach(cb => cb.checked = false);
                
                updateEditRoleFormAction(''); // disable submit until user is selected
                openModal('modalEditRole');
            } else if (type === 'edit') {
                document.getElementById('editRoleModalTitle').innerText = 'Edit Hak Akses';
                document.getElementById('editRoleUserSelect').value = id;
                document.getElementById('editRoleUserSelect').disabled = true; // prevent changing user during edit
                
                // Set hidden input since select is disabled (disabled fields don't submit)
                document.getElementById('hiddenEditRoleUserId').value = id;
                document.getElementById('hiddenEditRoleUserId').disabled = false;
                
                document.getElementById('editRoleDivision').value = division;
                document.getElementById('editRoleRole').value = role.toLowerCase();
                
                // check boxes
                document.querySelectorAll('#modalEditRole .custom-checkbox').forEach(cb => {
                    cb.checked = permissions.includes(cb.value);
                });
                
                updateEditRoleFormAction(id);
                openModal('modalEditRole');
            } else if (type === 'detail') {
                document.getElementById('detailRoleName').innerText = name;
                document.getElementById('detailRoleDivision').innerText = division;
                document.getElementById('detailRoleRole').innerText = role;
                document.getElementById('detailRoleStatus').innerText = status;
                
                let statusBadge = document.getElementById('detailRoleStatus');
                if (status.toLowerCase() === 'aktif') {
                    statusBadge.className = 'badge-status';
                    statusBadge.style.background = '#ECFDF5';
                    statusBadge.style.color = '#009966';
                    statusBadge.style.borderColor = '#A4F4CF';
                } else {
                    statusBadge.className = 'badge-status';
                    statusBadge.style.background = 'rgba(238, 93, 80, 0.1)';
                    statusBadge.style.color = 'var(--admin-danger)';
                    statusBadge.style.borderColor = 'var(--admin-danger)';
                }
                
                // render badges
                let badgesHtml = '';
                if (permissions && permissions.length > 0) {
                    permissions.forEach(p => {
                        let label = p.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
                        badgesHtml += `<span class="badge-permission">${label}</span>`;
                    });
                } else {
                    badgesHtml = '<span style="color: #94A3B8; font-size: 13px; font-style: italic;">Tidak ada hak akses khusus</span>';
                }
                document.getElementById('detailRolePermissionsList').innerHTML = badgesHtml;
                
                openModal('modalDetailRole');
            } else if (type === 'delete') {
                document.getElementById('deleteRoleSubtitle').innerText = `Hak akses untuk ${name} akan dihapus dari sistem.`;
                document.getElementById('deleteRoleForm').action = `/admin/roles/${id}`;
                openModal('modalDeleteRole');
            }
        }

        function openDivisionModal(type, id, name, desc, usersCount, status, divType) {
            if (type === 'create') {
                document.getElementById('editDivisionForm').action = '/admin/divisions';
                document.getElementById('editDivisionMethod').value = 'POST';
                document.getElementById('editDivisionModalTitle').innerText = 'Tambah Divisi/Sektor';
                document.getElementById('editDivisionName').value = '';
                document.getElementById('editDivisionDesc').value = '';
                document.getElementById('editDivisionStatus').value = 'aktif';
                document.getElementById('editDivisionType').value = 'internal';
                openModal('modalEditDivision');
            } else if (type === 'edit') {
                document.getElementById('editDivisionForm').action = '/admin/divisions/' + id;
                document.getElementById('editDivisionMethod').value = 'PUT';
                document.getElementById('editDivisionModalTitle').innerText = 'Edit Divisi/Sektor';
                document.getElementById('editDivisionName').value = name;
                document.getElementById('editDivisionDesc').value = desc;
                document.getElementById('editDivisionStatus').value = status.toLowerCase();
                document.getElementById('editDivisionType').value = divType.toLowerCase();
                openModal('modalEditDivision');
            } else if (type === 'detail') {
                document.getElementById('detailDivisionName').innerText = name;
                document.getElementById('detailDivisionDesc').innerText = desc || 'Tidak ada deskripsi';
                document.getElementById('detailDivisionUsers').innerText = usersCount + ' user';
                document.getElementById('detailDivisionType').innerText = divType;
                document.getElementById('detailDivisionStatus').innerText = status;
                
                let statusBadge = document.getElementById('detailDivisionStatus');
                if (status.toLowerCase() === 'aktif') {
                    statusBadge.className = 'badge-status';
                    statusBadge.style.background = '#ECFDF5';
                    statusBadge.style.color = '#009966';
                    statusBadge.style.borderColor = '#A4F4CF';
                } else {
                    statusBadge.className = 'badge-status';
                    statusBadge.style.background = 'rgba(238, 93, 80, 0.1)';
                    statusBadge.style.color = 'var(--admin-danger)';
                    statusBadge.style.borderColor = 'var(--admin-danger)';
                }
                openModal('modalDetailDivision');
            } else if (type === 'delete') {
                document.getElementById('deleteDivisionSubtitle').innerText = `Divisi ${name} akan dihapus dari daftar.`;
                document.getElementById('deleteDivisionForm').action = `/admin/divisions/${id}`;
                openModal('modalDeleteDivision');
            }
        }

        // Close when clicking outside modal container
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('show');
                }
            });
        });
    </script>
</body>
</html>
