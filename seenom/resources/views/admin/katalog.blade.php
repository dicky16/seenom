@extends('admin.master')
@section('content')
<div class="container-fluid">
                        <h1 class="mt-4">Tables</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">Data Produk
                              <button type="button" class="btn btn-primary float-right" id="btn-tambah">Tambah Produk</button>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-table mr-1"></i>DataTable Produk</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama</th>
                                                <th>Harga</th>
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $produk)
                                        <?php $no = null; ?>
                                            <tr>
                                                <td>{{$no++}}</td>
                                                <td>{{$produk->nama}}</td>
                                                <td>{{$produk->harga}}</td>
                                                <td>{{$produk->img_path}}</td>
                                                <td>
                                                    <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn-edit-faq" style="font-size: 18pt; text-decoration: none;" class="mr-3">
                                                    <i class="fas fa-pen-square"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn-delete-faq" style="font-size: 18pt; text-decoration: none; color:red;">
                                                    <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- modal tambah produk -->
                    <div class="modal fade" id="tambahProduk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Berita</h5>
                                    <button class="close btn-close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">


                                    <form id="form-tambah-produk">

                                        <label for="judulBerita">Nama</label>
                                        <input type="text" class="form-control" name="nama">

                                        <label for="deskripsi" class="mt-2">Harga</label>
                                        <input type="text" class="form-control" name="harga">

                                        <div class="form-group mt-3">
                                            <label for="file" class="mt-2">Gambar</label>
                                            <input id="gambar" type="file" accept="image/*" aria-describedby="inputGroupFileAddon01">
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary btn-close" type="button" data-dismiss="modal">Cancel</button>
                                            <input type="submit" class="btn btn-primary" value="Submit">
                                        </div>

                                    </form>

                                </div>
                                
                            </div>
                        </div>
                    </div>

@endsection
@section('js')
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('body').on('click', '#btn-tambah', function(e) {
        e.preventDefault();
        $("#tambahProduk").modal("show");
    });

    $('body').on('submit', '#form-tambah-produk', function(e) {
        e.preventDefault();
        var formData = new FormData();
        var nama = $('[name=nama]').val();
        var harga = $('[name=harga]').val();
        var gambar = $('#gambar')[0].files[0];

        formData.append('nama', nama);
        formData.append('harga', harga);
        formData.append('gambar', gambar);

        $.ajax({
            type: 'POST',
            url: '/admin/katalog',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if(data.success == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Berhasil Menambahkan Produk',
                        timer: 1200,
                        showConfirmButton: false
                    });
                    $("#tambahProduk").modal("hide");
                    $("#form-tambah-produk").trigger("reset");
                    location.reload();
                } else if(data.success == false) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: '' + data.message,
                        timer: 1200,
                        showConfirmButton: false
                    });
                }
            }
        });
    });

});
</script>
@endsection