<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator, Auth;

class KatalogController extends Controller
{
    public function index()
    {
        $data = DB::table('katalog')->get();
        dd(Auth::user());
        return view('admin.katalog', compact('data'));
    }

    public function tes()
    {
        return view('admin.tambahKatalog');
    }

    public function tambahKatalog(Request $request)
    {
      $rules = [
        'nama' => 'required',
        'harga' => 'required',
        'gambar' => 'required'
      ];
      $validator = Validator::make($request->all(), $rules);
      if($validator->passes()) {
            $file = $request->file('gambar');
            $fileName = $file->getClientOriginalName();
            $fileNameArr = explode('.', $fileName);
            $file_ext = end($fileNameArr);
            $destinationPath = './assets/img/produk';
            $image = 'katalog-' . time() . '.' . $file_ext;
    
            $file->move($destinationPath, $image, "");
            //   $this->compressImage($image, 'assets/img/produk');
              $insertKatalog = DB::table('katalog')->insert([
                'nama' => $request->nama,
                'harga' => $request->harga,
                'img_path' => $destinationPath.'/'.$image,
              ]);
              if($insertKatalog) {
                return response()->json([
                    'success' => true,
                    'status' => 'validation_error',
                    'message' => $validator->errors()->first()
                  ]);
            }
      }

        return response()->json([
            'success' => false,
            'status' => 'validation_error',
            'message' => $validator->errors()->first()
          ]);      

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