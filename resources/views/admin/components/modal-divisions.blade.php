<!-- Modal Detail Divisi/Sektor -->
<div class="modal-backdrop" id="modalDetailDivision">
    <div class="modal-container lg">
        <h3 class="modal-title">Detail Divisi/Sektor</h3>
        
        <div style="display: flex; gap: 16px; margin-bottom: 24px;">
            <div style="width: 48px; height: 48px; background: #EFF6FF; border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-building" style="color: #155DFC; font-size: 24px;"></i>
            </div>
            <div>
                <p id="detailDivisionName" style="font-size: 20px; font-weight: 700; color: #1D293D; margin: 0 0 4px 0;">Badan Pengelolaan Keuangan dan Aset Daerah</p>
                <p style="font-size: 14px; color: #62748E; margin: 0;">Informasi ringkas unit pengelola data Command Center.</p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
            <div>
                <p style="font-size: 14px; color: #62748E; margin: 0 0 4px 0;">Tipe Divisi</p>
                <p id="detailDivisionType" style="font-size: 16px; font-weight: 600; color: #1D293D; margin: 0;">Internal</p>
            </div>
            <div>
                <p style="font-size: 14px; color: #62748E; margin: 0 0 4px 0;">Jumlah Pengguna</p>
                <p id="detailDivisionUsers" style="font-size: 16px; font-weight: 600; color: #1D293D; margin: 0;">8 user</p>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
            <div>
                <p style="font-size: 14px; color: #62748E; margin: 0 0 4px 0;">Status</p>
                <div style="margin-top: 4px;">
                    <span id="detailDivisionStatus" class="badge-status">Aktif</span>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <p style="font-size: 14px; color: #62748E; margin: 0 0 8px 0;">Deskripsi</p>
            <div style="background: #F8FAFC; border: 0.668531px solid #E2E8F0; border-radius: 10px; padding: 16px;">
                <p id="detailDivisionDesc" style="font-size: 14px; color: #314158; margin: 0;">Deskripsi Divisi</p>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('modalDetailDivision')">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Divisi/Sektor -->
<div class="modal-backdrop" id="modalEditDivision">
    <div class="modal-container lg">
        <form id="editDivisionForm" method="POST" action="">
            @csrf
            <input type="hidden" name="_method" id="editDivisionMethod" value="POST">
            <h3 class="modal-title" id="editDivisionModalTitle">Tambah/Edit Divisi/Sektor</h3>
            
            <div class="form-group">
                <label class="form-label" style="color: #314158; font-weight: 600;">Nama Divisi/Sektor</label>
                <input type="text" name="name" id="editDivisionName" class="form-control" placeholder="Contoh: Pariwisata" required>
            </div>

            <div class="form-group">
                <label class="form-label" style="color: #314158; font-weight: 600;">Deskripsi</label>
                <textarea name="description" id="editDivisionDesc" class="form-control" placeholder="Nama instansi atau fungsi sektor" style="height: 93px; resize: none;"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="color: #314158; font-weight: 600;">Status</label>
                    <select name="status" id="editDivisionStatus" class="form-control">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="color: #314158; font-weight: 600;">Tipe</label>
                    <select name="type" id="editDivisionType" class="form-control">
                        <option value="internal">Internal</option>
                        <option value="eksternal">Eksternal</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer" style="margin-top: 28px;">
                <button type="button" class="btn btn-outline" onclick="closeModal('modalEditDivision')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Divisi/Sektor -->
<div class="modal-backdrop" id="modalDeleteDivision">
    <div class="modal-container lg">
        <form id="deleteDivisionForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <h3 class="modal-title" style="margin-bottom: 8px;">Hapus Divisi/Sektor?</h3>
            <p id="deleteDivisionSubtitle" class="modal-subtitle">Divisi ini akan dihapus dari daftar.</p>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('modalDeleteDivision')">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div>
