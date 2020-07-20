<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
      return view('admin/index');
    }

    public function coba()
    {
      return view('admin/coba');
    }

    public function getTambahKatalog()
    {
      return view('admin/tambahKatalog');
    }

    public function tambahKatalog(Request $request)
    {
      $this->validate($request, [
        'nama' => 'required',
        'harga' => 'required'
      ]);

      $response = null;
      // $user = (object) ['image' => ""];
      if($request->hasFile('imageKatalog')) {
        $file = $request->file('imageKatalog');
        $fileName = $file->getClientOriginalName();
        $fileNameArr = explode('.', $fileName);
        $file_ext = end($fileNameArr);
        $destinationPath = './assets/seenom/';
        // dd($destinationPath);
        $image = 'katalog-' . time() . '.' . $file_ext;

        if($file->move($destinationPath, $image)) {
          $this->compressImage($image, 'assets/seenom/');
          $insertKatalog = DB::table('katalog')->insert([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'img_path' => $image,
          ]);
          if($insertKatalog) {
            $request->session()->flash('status', 'Suskes upload katalog!');
            return redirect('admin');
          } else {
            $request->session()->flash('status', 'Gagal upload katalog!');
            return redirect('admin/katalog-tambah');
          }
        } else {
          $request->session()->flash('status', 'Gagal upload katalog!');
          return redirect('admin/katalog-tambah');
        }

      } else {
        $request->session()->flash('status', 'Tidak ada image!');
        return redirect('admin/katalog-tambah');
      }

    }

    //testi
    public function getTambahTesti()
    {
      return view('admin/tambahTestimoni');
    }

    public function tambahTesti(Request $request)
    {
      $this->validate($request, [
        'keterangan' => 'required',
      ]);

      $response = null;
      // $user = (object) ['image' => ""];
      if($request->hasFile('imageTestimoni')) {
        $file = $request->file('imageTestimoni');
        $fileName = $file->getClientOriginalName();
        $fileNameArr = explode('.', $fileName);
        $file_ext = end($fileNameArr);
        $destinationPath = './assets/seenom/testi';
        // dd($destinationPath);
        $image = 'testi-' . time() . '.' . $file_ext;

        if($file->move($destinationPath, $image)) {
          $this->compressImage($image, 'assets/seenom/testi');
          $insertKatalog = DB::table('testimoni')->insert([
            'keterangan' => $request->keterangan,
            'img_path' => $image,
          ]);
          if($insertKatalog) {
            $request->session()->flash('status', 'Sukses upload katalog!');
            return redirect('admin/testi-tambah');
          } else {
            $request->session()->flash('status', 'Gagal upload katalog!');
            return redirect('admin/testi-tambah');
          }
        } else {
          return redirect()->back()->with('status', 'gagal upload katalog');
        }

      } else {
        return redirect()->back()->with('status', 'tidak ada image');
      }

    }

    //galeri
    public function getTambahGaleri()
    {
      return view('admin/tambahGaleri');
    }

    public function tambahGaleri(Request $request)
    {
      if($request->hasFile('imageGaleri')) {
        $file = $request->file('imageGaleri');
        $fileName = $file->getClientOriginalName();
        $fileNameArr = explode('.', $fileName);
        $file_ext = end($fileNameArr);
        $destinationPath = './assets/seenom/galeri';
        // dd($destinationPath);
        $image = 'galeri-' . time() . '.' . $file_ext;

        if($file->move($destinationPath, $image)) {
          $this->compressImage($image, 'assets/seenom/galeri/');
          $insertKatalog = DB::table('galeri')->insert([
            'img_path' => $image,
          ]);
          if($insertKatalog) {
            $request->session()->flash('status', 'Sukses upload katalog!');
            return redirect('admin/galeri-tambah');
          } else {
            $request->session()->flash('status', 'Gagal upload katalog!');
            return redirect('admin/galeri-tambah');
          }
        } else {
          $request->session()->flash('status', 'Gagal upload katalog!');
          return redirect('admin/galeri-tambah');
        }

      } else {
        $request->session()->flash('status', 'Gagal upload katalog!');
        return redirect('admin/galeri-tambah');
      }

    }

    public function getCountViews()
    {
      $count = DB::table('count_views')
      ->select('views')->get();
      dd($count);
    }

    function compressImage($source, $path)
    {
      $filepath = public_path($path.$source);
      $mime = mime_content_type($filepath);
      $output = new \CURLFile($filepath, $mime, $source);
      $data = ["files" => $output];

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'http://api.resmush.it/?qlty=70');
      curl_setopt($ch, CURLOPT_POST,1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      $result = curl_exec($ch);
      if (curl_errno($ch)) {
          $result = curl_error($ch);
      }
      curl_close ($ch);

      $arr_result = json_decode($result);

      // store the optimized version of the image
      $ch = curl_init($arr_result->dest);
      $fp = fopen($filepath, 'wb');
      curl_setopt($ch, CURLOPT_FILE, $fp);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_exec($ch);
      curl_close($ch);
      fclose($fp);
    }
}
