<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form class="" action="{{ url('admin/katalog-tambah') }}" method="post" enctype="multipart/form-data">
      Nama : <input type="text" name="nama" placeholder="Masukkan nama produk">
      <br>
      Harga : <input type="text" name="harga" placeholder="Masukkan harga produk">
      <br>
      Image : <input type="file" name="imageKatalog">
      <br>
      <input type="submit" name="submit" value="Tambah">
    </form>
    <?php $status = null; ?>
    @if ($status == null)
      <script type="text/javascript">
      Swal.fire({
        icon: 'error',
        title: 'Tidak ada image',
        text: 'Silahkan pilih image untuk di upload!',
        })
      </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  </body>
</html>
