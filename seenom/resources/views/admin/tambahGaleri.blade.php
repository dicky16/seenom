<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form class="" action="{{ url('admin/galeri-tambah') }}" method="post" enctype="multipart/form-data">
      Image : <input type="file" name="imageGaleri">
      <br>
      <input type="submit" name="submit" value="Tambah">
    </form>
  </body>
</html>
