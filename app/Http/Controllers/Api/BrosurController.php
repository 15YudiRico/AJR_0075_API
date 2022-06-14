<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Brosur;
use Illuminate\Support\Facades\DB;

class BrosurController extends Controller
{
    public function index()
    {
        //this var to show all atribut from $brosur
        //$brosur=Brosur::all();

        //this var to show limited atribut from $brosur
        $brosur=DB::table('aset_mobil')->select('id_mobil', 'nama_mobil', 'tipe_mobil', 'jenis_transmisi', 'jenis_bahan_bakar', 'warna_mobil', 'volume_bagasi', 'fasilitas', 'harga_sewa_perhari', 'foto_mobil')->where('status_ketersediaan_mobil', 1)->where('status_mobil', 1)->get();

        if(count($brosur)>0) {
            return response([
                'message' => 'Retrieve All Success',
                'brosur' => $brosur
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'brosur' => null
        ], 400);
    }

    public function show($id_mobil)
    {
        $brosur=DB::table('aset_mobil')->select('nama_mobil', 'tipe_mobil', 'jenis_transmisi', 'jenis_bahan_bakar', 'warna_mobil', 'volume_bagasi', 'fasilitas', 'harga_sewa_perhari', 'foto_mobil')->where('status_ketersediaan_mobil', 1)->where('status_mobil', 1)->where('id_mobil', $id_mobil)->get();


        if(count($brosur)>0) {
            return response([
                'message' => 'Retrieve Mobil Success',
                'brosur' => $brosur
            ], 200);
        }

        return response([
            'message' => 'Mobil Not Found',
            'brosur' => null
        ], 404);
    }
}
