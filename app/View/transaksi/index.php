<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KrisnaLTE | Transaksi</title>
    <?php require __DIR__ . "/../layouts/headlinks.php" ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 2em;
        }
        .select2-container--default .select2-selection--single {
            padding: 0;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-top: 4px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">

<?php
    use Krispachi\KrisnaLTE\App\FlashMessage;
    FlashMessage::flashMessage();
?>
    
<div class="wrapper">
    <?php require __DIR__ . "/../layouts/nav-aside.php"; ?>

    <!-- Modal -->
    <div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
        <!-- form start -->
        <form action="/transactions" method="post" id="modal-form">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transactionModalLabel">Tambah Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="id_mahasiswa">Mahasiswa (NIM - Nama)</label>
                                <select style="width: 100%;" class="js-example-basic-single" id="id_mahasiswa" name="id_mahasiswa">
                                    <option value="" selected disabled>Pilih Mahasiswa</option>
                                    <?php
                                        $mahasiswas = $model["mahasiswas"];
                                        foreach($mahasiswas as $mahasiswa) {
                                            if(isset($_SESSION["form-input"]["id_mahasiswa"]) && $_SESSION["form-input"]["id_mahasiswa"] == $mahasiswa["id"]) {
                                                echo "<option value=" . $mahasiswa["id"] . " selected>" . $mahasiswa["nim"] . " - " . $mahasiswa["nama"] . "</option>";
                                            } else {
                                                echo "<option value=" . $mahasiswa["id"] . ">" . $mahasiswa["nim"] . " - " . $mahasiswa["nama"] . "</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori Biaya</label>
                                <select style="width: 100%;" class="js-example-basic-single-category" id="kategori" name="kategori">
                                    <option value="" selected disabled>Pilih Kategori</option>
                                    <?php
                                        $categories = ["Biaya UKT", "Biaya Wisuda", "Biaya PKKMB", "Biaya Seragam", "Biaya Seminar", "Biaya Lainnya"];
                                        foreach($categories as $category) {
                                            if(isset($_SESSION["form-input"]["kategori"]) && $_SESSION["form-input"]["kategori"] == $category) {
                                                echo "<option value='" . $category . "' selected>" . $category . "</option>";
                                            } else {
                                                echo "<option value='" . $category . "'>" . $category . "</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nominal">Nominal (Rp)</label>
                                <input type="number" name="nominal" class="form-control" id="nominal" value="<?= $_SESSION["form-input"]["nominal"] ?? "" ?>" placeholder="Masukkan Nominal">
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal Transaksi</label>
                                <input type="date" name="tanggal" class="form-control" id="tanggal" value="<?= $_SESSION["form-input"]["tanggal"] ?? "" ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="create_transaction" class="btn btn-success button-save">Tambah</button>
                </div>
            </div>
        </form>
        </div>
    </div>
    <?php
        if(isset($_SESSION["form-input"])) {
            unset($_SESSION["form-input"]);
        }
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Transaksi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active">Transaksi</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
								<h3 class="card-title">Tabel Daftar Transaksi Masuk</h3>
								<a class="btn btn-success ml-auto button-create" data-toggle="modal" data-target="#transactionModal">Tambah Transaksi</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mahasiswa (NIM)</th>
                                    <th>Kategori</th>
                                    <th>Nominal</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $transactions = $model["transactions"];
                                        $mahasiswas = $model["mahasiswas"];
                                        $iteration = 0;

                                        foreach($transactions as $transaction) :
                                            $iteration++;
                                            $nama_mhs = "-";
                                            $nim_mhs = "-";
                                            foreach($mahasiswas as $m) {
                                                if ($m["id"] == $transaction["id_mahasiswa"]) {
                                                    $nama_mhs = $m["nama"];
                                                    $nim_mhs = $m["nim"];
                                                    break;
                                                }
                                            }
                                    ?>
                                    <tr>
                                        <td><?= $iteration ?></td>
                                        <td><?= $nama_mhs . " (" . $nim_mhs . ")" ?></td>
                                        <td><?= $transaction["kategori"] ?></td>
                                        <td>Rp <?= number_format($transaction["nominal"], 0, ',', '.') ?></td>
                                        <td><?= date('d M Y', strtotime($transaction["tanggal"])) ?></td>
                                        <td style="white-space: nowrap;">
                                            <button data-id="<?= $transaction["id"] ?>" class="btn btn-sm btn-warning button-edit">Ubah</button>
                                            <form action="/transactions/delete/<?= $transaction["id"] ?>" method="post" class="form-delete d-inline-block">
												<button type="submit" class="btn btn-sm btn-danger button-delete">Hapus</button>
											</form>
                                        </td>
                                    </tr>
                                    <?php
                                        endforeach;
                                    ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Mahasiswa (NIM)</th>
                                    <th>Kategori</th>
                                    <th>Nominal</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                                </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php require __DIR__ . "/../layouts/footer.php"; ?>

</div>
<!-- ./wrapper -->

<?php require __DIR__ . "/../layouts/bodyscripts.php" ?>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="AdminLTE/plugins/jszip/jszip.min.js"></script>
<script src="AdminLTE/plugins/pdfmake/pdfmake.min.js"></script>
<script src="AdminLTE/plugins/pdfmake/vfs_fonts.js"></script>
<script src="AdminLTE/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="AdminLTE/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="AdminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Page specific script -->
<script>
$(document).ready(function() {
    $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false, "responsive": true,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $('.js-example-basic-single').select2({
        placeholder: "Pilih Mahasiswa",
        allowClear: true
    });
    $('.js-example-basic-single-category').select2({
        placeholder: "Pilih Kategori",
        allowClear: true
    });

    $(".form-delete").on("submit", function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "kamu tidak bisa kembali setelah ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus sekarang!'
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).unbind("submit").submit();
            } else {
                Swal.fire({
                    title: 'Batal!',
                    text: 'Transaksi tidak jadi dihapus.',
                    icon: 'success',
                    timer: 4000
                });
            }
        });
    });

    $(".button-create").click(function() {
        $(".button-save").text("Tambah").removeClass("btn-warning").addClass("btn-success").attr("name", "create_transaction");
        $("#transactionModalLabel").text("Tambah Transaksi");
    });

    $(".button-edit").click(function() {
        // Reset form
        $("#modal-form").attr("action", "/transactions");
        $("#modal-form")[0].reset();
        $("#id_mahasiswa").val("").trigger('change');
        $("#kategori").val("").trigger('change');

        $.get("/transactions/" + $(this).data("id"), function(response) {
            let data;
            try {
                data = JSON.parse(response);
                if(data.error) {
                    // console.log(data.error);
                } else {
                    $("#modal-form").attr("action", "/transactions/" + data.id);
                    $("#id_mahasiswa").val(data.id_mahasiswa).trigger("change");
                    $("#kategori").val(data.kategori).trigger("change");
                    $("#nominal").val(data.nominal);
                    $("#tanggal").val(data.tanggal);
                }
            } catch (exception) {
                // error
            }
            $(".button-save").text("Ubah").removeClass("btn-success").addClass("btn-warning").attr("name", "edit_transaction");
            $("#transactionModalLabel").text("Ubah Transaksi");
            $("#transactionModal").modal("show");
        });
    });

    $("#transactionModal").on('hidden.bs.modal', function() {
        if($(".button-save").attr("name") == "edit_transaction") {
            $("#modal-form").attr("action", "/transactions");
            $("#modal-form")[0].reset();
            $("#id_mahasiswa").val("").trigger('change');
            $("#kategori").val("").trigger('change');
        }
        $(".button-save").attr("name", "create_transaction");
    });
});
</script>
</body>
</html>
