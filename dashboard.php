<?php 
include 'config/database.php'; 
include 'auth/cek.php'; 

$data = $conn->query("SELECT * FROM siswa ORDER BY kelas, absen ASC");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" type="image/x-icon" href="assets/logo-sma.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- ICON -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <!-- ==================== PERBAIKAN CSS ==================== -->
<style>
html,
body {
    height: 100%;
}

body {
    display: flex;
    flex-direction: column;
    background: linear-gradient(135deg, #eef2ff, #f8fafc);
    font-family: 'Poppins', sans-serif;
    overflow-x: hidden;
}

.main-content {
    flex: 1;
}

/* CONTAINER RESPONSIVE */
.container {
    width: 100%;
    max-width: 1320px;
    margin: auto;
    padding-left: 15px;
    padding-right: 15px;
}

/* CARD */
.card {
    border-radius: 15px;
    border: none;
}

/* FOOTER */
footer {
    margin-top: auto;
    padding: 10px;
    background: #FFFFFF;
    color: black;
    text-align: center;
    font-weight: bold;
}

/* BUTTON */
.btn {
    border-radius: 30px;
    transition: all 0.2s ease;
}

.btn:hover {
    transform: scale(1.03);
}

.btn-primary {
    background: #4f46e5;
}

.btn-success {
    background: #16a34a;
}

.btn-dark {
    background: #1e293b;
}

/* TABLE */
.table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    border-radius: 10px;
}

#tabel {
    width: 100% !important;
}

table.dataTable {
    width: 100% !important;
}

table th {
    vertical-align: middle !important;
    text-align: center;
}

table td {
    vertical-align: middle !important;
}

.table tbody tr:hover {
    background: #eef2ff;
    transition: 0.2s;
}

td:nth-child(2) {
    font-weight: 500;
    color: #4f46e5;
}

/* AKSI BUTTON */
.aksi-btn {
    display: flex;
    gap: 6px;
    justify-content: center;
    flex-wrap: wrap;
}

/* DATATABLE PAGINATION */
.dataTables_wrapper .dataTables_paginate {
    margin-top: 15px;
    text-align: center;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 8px !important;
    padding: 6px 12px !important;
    margin: 2px;
    border: none !important;
    background: #e2e8f0 !important;
    color: #1e293b !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #4f46e5 !important;
    color: #fff !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #6366f1 !important;
    color: white !important;
}

/* MOBILE */
@media (max-width: 768px) {

    .container {
        padding-left: 10px;
        padding-right: 10px;
    }

    h4 {
        font-size: 20px;
    }

    table.dataTable th,
    table.dataTable td {
        font-size: 12px;
        white-space: nowrap;
    }

    .dataTables_wrapper .row {
        display: flex;
        flex-direction: column;
        width: 100%;
        margin-bottom: 10px;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        width: 100%;
        text-align: left !important;
        margin-bottom: 8px;
    }

    .dataTables_wrapper .dataTables_filter input {
        width: 100% !important;
        margin-left: 0 !important;
        margin-top: 5px;
    }

    .dataTables_wrapper .dataTables_paginate {
        text-align: center !important;
    }

    .aksi-btn {
        flex-direction: column;
        align-items: stretch;
    }

    .aksi-btn .btn {
        width: 100%;
        font-size: 11px;
        padding: 5px;
    }

    .aksi-btn .btn span {
        display: none;
    }
}


/* ================= TOOLBAR MENU ================= */
.toolbar-menu {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.toolbar-group {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

/* BUTTON STYLE */
.toolbar-menu .btn {
    border-radius: 30px;
    padding: 8px 18px;
    font-size: 14px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
    transition: 0.2s ease;
}

.toolbar-menu .btn:hover {
    transform: translateY(-2px);
}

/* MOBILE */
@media (max-width: 768px) {

    .toolbar-menu {
        flex-direction: column;
        align-items: stretch;
    }

    .toolbar-group {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        width: 100%;
    }

    .toolbar-group .btn {
        width: 100%;
        justify-content: center;
        font-size: 13px;
        padding: 10px;
    }
}

/* EXTRA SMALL */
@media (max-width: 480px) {

    .toolbar-group .btn {
        font-size: 12px;
        padding: 9px;
    }
}
</style>

</head>

<body>

    <div class="container mt-4 main-content">

        <div class="card shadow-sm p-3 mb-3 d-flex flex-column flex-md-row align-items-start align-items-md-center">

            <div>
                <h4 class="mb-0">Data Siswa</h4>
                <small class="text-muted">Manajemen Label Siswa</small>
            </div>

            <div class="ms-auto mt-2 mt-md-0">
                <a href="auth/logout.php" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin logout?')">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>

        </div>

        <!-- BUTTON -->
        <!--<div class="d-flex flex-wrap gap-2 mb-3 justify-content-between">-->

            <!-- kiri -->
        <!--    <div class="d-flex gap-2 flex-wrap">-->
        <!--        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">-->
        <!--            <i class="bi bi-plus"></i> Tambah-->
        <!--        </button>-->

        <!--        <a href="modules/siswa/pdf.php" target="_blank" class="btn btn-dark btn-sm">-->
        <!--            <i class="bi bi-file-earmark-pdf"></i> Export-->
        <!--        </a>-->
        <!--    </div>-->

            <!-- kanan -->
        <!--    <div class="d-flex gap-2 flex-wrap">-->
        <!--        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalImport">-->
        <!--            <i class="bi bi-upload"></i> Import-->
        <!--        </button>-->

        <!--        <a href="modules/siswa/template.php" class="btn btn-info btn-sm">-->
        <!--            <i class="bi bi-download"></i> Template-->
        <!--        </a>-->
        <!--    </div>-->

        <!--</div>-->
        
        <!-- BUTTON TOOLBAR RESPONSIVE -->
<div class="toolbar-menu mb-3">

    <!-- kiri -->
    <div class="toolbar-group">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus"></i> Tambah
        </button>

        <a href="modules/siswa/pdf.php" target="_blank" class="btn btn-dark btn-sm">
            <i class="bi bi-file-earmark-pdf"></i> Export
        </a>
    </div>

    <!-- kanan -->
    <div class="toolbar-group">
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalImport">
            <i class="bi bi-upload"></i> Import
        </button>

        <a href="modules/siswa/template.php" class="btn btn-info btn-sm">
            <i class="bi bi-download"></i> Template
        </a>
    </div>

</div>

        <!-- ALERT -->
        <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success">Data berhasil disimpan</div>
        <?php endif; ?>

        <?php if(isset($_GET['deleted'])): ?>
        <div class="alert alert-danger">Data berhasil dihapus</div>
        <?php endif; ?>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tabel">

                <thead class="table-dark">
                    <tr style="text-align: center;">
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Absen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no=1; while($d=$data->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $d['nisn'] ?></td>
                        <td><?= $d['nama'] ?></td>
                        <td><?= $d['kelas'] ?></td>
                        <td><?= $d['absen'] ?></td>
                        <td>
                            <div class="aksi-btn">

                                <!-- EDIT -->
                                <button class="btn btn-warning btn-sm btn-edit" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit" data-id="<?= $d['id'] ?>" data-nisn="<?= $d['nisn'] ?>"
                                    data-nama="<?= $d['nama'] ?>" data-kelas="<?= $d['kelas'] ?>"
                                    data-absen="<?= $d['absen'] ?>"><i class="bi bi-pencil-square"></i> <span
                                        class="d-none d-md-inline">Edit</span> </button>

                                <!-- HAPUS -->
                                <a href="modules/siswa/hapus.php?id=<?= $d['id'] ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus data?')">
                                    <i class="bi bi-trash"></i>
                                    <span class="d-none d-md-inline">Hapus</span>
                                </a>

                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>

            </table>
        </div>

    </div>

    <!-- FOOTER -->
    <footer class="mt-2">Copyright &copy; <?= date('Y'); ?>
        <a href="https://robbyilham.com/" target="_blank" class="text-primary font-weight-bold"
            style="text-decoration: none;">
            by
        </a>
        IT Development IHBS
    </footer>

    <!-- ================= MODAL TAMBAH ================= -->
    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog">
            <form action="modules/siswa/save.php" method="POST" class="modal-content">

                <div class="modal-header">
                    <h5>Tambah Siswa</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text" name="nisn" class="form-control mb-2" placeholder="NISN" required>
                    <input type="text" name="nama" class="form-control mb-2" placeholder="Nama" required>
                    <input type="text" name="kelas" class="form-control mb-2" placeholder="Kelas" required>
                    <input type="number" name="absen" class="form-control mb-2" placeholder="Absen" required>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>

    <!-- ================= MODAL EDIT ================= -->
    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog">
            <form action="modules/siswa/save.php" method="POST" class="modal-content">

                <input type="hidden" name="id" id="edit_id">

                <div class="modal-header">
                    <h5>Edit Siswa</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text" name="nisn" id="edit_nisn" class="form-control mb-2" required>
                    <input type="text" name="nama" id="edit_nama" class="form-control mb-2" required>
                    <input type="text" name="kelas" id="edit_kelas" class="form-control mb-2" required>
                    <input type="number" name="absen" id="edit_absen" class="form-control mb-2" required>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>

    <!-- ================= MODAL IMPORT ================= -->
    <div class="modal fade" id="modalImport">
        <div class="modal-dialog">
            <form action="modules/siswa/import.php" method="POST" enctype="multipart/form-data" class="modal-content">

                <div class="modal-header bg-success text-white">
                    <h5>📥 Import Excel</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="file" name="file" class="form-control mb-2" accept=".xlsx,.xls" required>
                    <small class="text-muted">Format: NISN | Nama | Kelas | Absen</small>
                </div>

                <div class="modal-footer">
                    <button type="submit" name="import" class="btn btn-success">Import</button>
                </div>

            </form>
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
$(document).ready(function() {

    $('#tabel').DataTable({
        responsive: true,
        autoWidth: false,
        scrollX: true,
        pagingType: "simple_numbers",
        language: {
            search: "🔍 Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                previous: "←",
                next: "→"
            }
        }
    });

    // MODAL EDIT
    $(document).on('click', '.btn-edit', function() {
        $('#edit_id').val($(this).data('id'));
        $('#edit_nisn').val($(this).data('nisn'));
        $('#edit_nama').val($(this).data('nama'));
        $('#edit_kelas').val($(this).data('kelas'));
        $('#edit_absen').val($(this).data('absen'));
    });

});
</script>

</body>

</html>