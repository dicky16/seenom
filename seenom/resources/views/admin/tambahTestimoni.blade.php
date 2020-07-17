<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Testimoni</title>
  </head>
  <body>
    <form class="" action="{{ url('admin/testi-tambah') }}" method="post" enctype="multipart/form-data">
      Nama : <input type="text" name="keterangan" placeholder="Masukkan keterangan">
      <br>
      Image : <input type="file" name="imageTestimoni">
      <br>
      <input type="submit" name="submit" value="Tambah">
    </form>
  </body>
</html>
