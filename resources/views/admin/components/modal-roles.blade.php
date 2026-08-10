<!-- Modal Detail Hak Akses -->
<div class="modal-backdrop" id="modalDetailRole">
    <div class="modal-container md">
        <h3 class="modal-title">Detail Hak Akses</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
            <div>
                <p style="font-size: 14px; color: #62748E; margin: 0 0 4px 0;">Nama Pengguna</p>
                <p id="detailRoleName" style="font-size: 16px; font-weight: 600; color: #1D293D; margin: 0;">Budi Santoso</p>
            </div>
            <div>
                <p style="font-size: 14px; color: #62748E; margin: 0 0 4px 0;">Divisi</p>
                <p id="detailRoleDivision" style="font-size: 16px; font-weight: 600; color: #1D293D; margin: 0;">Perizinan</p>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
            <div>
                <p style="font-size: 14px; color: #62748E; margin: 0 0 4px 0;">Role</p>
                <p id="detailRoleRole" style="font-size: 16px; font-weight: 600; color: #1D293D; margin: 0;">User Divisi</p>
            </div>
            <div>
                <p style="font-size: 14px; color: #62748E; margin: 0 0 4px 0;">Status</p>
                <div style="margin-top: 4px;">
                    <span id="detailRoleStatus" class="badge-status">Aktif</span>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <p style="font-size: 14px; color: #62748E; margin: 0 0 8px 0;">Hak Akses Aktif</p>
            <div id="detailRolePermissionsList" style="display: flex; gap: 8px; flex-wrap: wrap;">
                <!-- Filled dynamically by JS -->
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('modalDetailRole')">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Hak Akses -->
<div class="modal-backdrop" id="modalEditRole">
    <div class="modal-container md">
        <form id="editRoleForm" method="POST" action="">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            
            <h3 class="modal-title" id="editRoleModalTitle">Tambah/Edit Hak Akses</h3>
            
            <div class="form-group">
                <label class="form-label" style="color: #314158; font-weight: 600;">Pengguna</label>
                <select name="user_id" id="editRoleUserSelect" class="form-control" onchange="updateEditRoleFormAction(this.value)">
                    <option value="" disabled selected>Pilih Pengguna...</option>
                    @if(isset($allUsers))
                        @foreach($allUsers as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    @endif
                </select>
                <input type="hidden" id="hiddenEditRoleUserId" disabled>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="color: #314158; font-weight: 600;">Divisi</label>
                    <select name="division_id" id="editRoleDivision" class="form-control">
                        <option value="">Tidak Ada</option>
                        @if(isset($divisions))
                            @foreach($divisions as $div)
                                <option value="{{ $div->id }}">{{ $div->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="color: #314158; font-weight: 600;">Role</label>
                    <select name="role" id="editRoleRole" class="form-control">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label" style="color: #314158; font-weight: 600; margin-bottom: 12px;">Hak Akses</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <label class="checkbox-label">
                        <input type="checkbox" name="permissions[]" value="lihat_data" id="perm_lihat_data" class="custom-checkbox">
                        <span class="checkbox-text">Lihat Data</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="permissions[]" value="tambah_data" id="perm_tambah_data" class="custom-checkbox">
                        <span class="checkbox-text">Tambah Data</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="permissions[]" value="edit_data" id="perm_edit_data" class="custom-checkbox">
                        <span class="checkbox-text">Edit Data</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="permissions[]" value="hapus_data" id="perm_hapus_data" class="custom-checkbox">
                        <span class="checkbox-text">Hapus Data</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="permissions[]" value="kelola_publikasi" id="perm_kelola_publikasi" class="custom-checkbox">
                        <span class="checkbox-text">Kelola Publikasi</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="permissions[]" value="kelola_cctv" id="perm_kelola_cctv" class="custom-checkbox">
                        <span class="checkbox-text">Kelola CCTV</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="permissions[]" value="kelola_user" id="perm_kelola_user" class="custom-checkbox">
                        <span class="checkbox-text">Kelola User</span>
                    </label>
                </div>
            </div>

            <div class="modal-footer" style="margin-top: 28px;">
                <button type="button" class="btn btn-outline" onclick="closeModal('modalEditRole')">Batal</button>
                <button type="submit" class="btn btn-primary" id="btnSubmitRoleForm">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Hak Akses -->
<div class="modal-backdrop" id="modalDeleteRole">
    <div class="modal-container md">
        <form id="deleteRoleForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <h3 class="modal-title" style="margin-bottom: 8px;">Hapus Hak Akses?</h3>
            <p id="deleteRoleSubtitle" class="modal-subtitle">Hak akses untuk Budi Santoso akan dihapus dari sistem.</p>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('modalDeleteRole')">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div>
<script>
    function updateEditRoleFormAction(userId) {
        if (userId) {
            document.getElementById('editRoleForm').action = '/admin/roles/' + userId;
            document.getElementById('btnSubmitRoleForm').disabled = false;
        } else {
            document.getElementById('editRoleForm').action = '';
            document.getElementById('btnSubmitRoleForm').disabled = true;
        }
    }
</script>
