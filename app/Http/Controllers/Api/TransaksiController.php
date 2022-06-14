<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\User;
use App\Models\Transaksi;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Pegawai;
use App\Models\Promo;
use App\Models\Brosur;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index($id)
    {

        $customer=DB::table('transaksi_penyewaan_mobil')->select('format_id_transaksi', 'id_transaksi', 'tgl_transaksi', 'status_transaksi', 'nama_customer', 'nama_driver', 'nama_pegawai', 'kode_promo', 'nama_mobil')->leftJoin('customer', 'transaksi_penyewaan_mobil.id_customer', '=', 'customer.id_customer')->leftJoin('driver', 'transaksi_penyewaan_mobil.id_driver', '=', 'driver.id_driver')->leftJoin('pegawai', 'transaksi_penyewaan_mobil.id_pegawai', '=', 'pegawai.id_pegawai')->leftJoin('promo', 'transaksi_penyewaan_mobil.id_promo', '=', 'promo.id_promo')->leftJoin('aset_mobil', 'transaksi_penyewaan_mobil.id_mobil', '=', 'aset_mobil.id_mobil')->where('customer.id', $id)->where('transaksi_penyewaan_mobil.status_transaksi', 'TRANSAKSI SELESAI')->orWhere('transaksi_penyewaan_mobil.status_transaksi', 'DITOLAK')->get();

        $driver=DB::table('transaksi_penyewaan_mobil')->select('format_id_transaksi', 'id_transaksi', 'tgl_transaksi', 'status_transaksi', 'nama_driver', 'nama_customer', 'nama_pegawai', 'kode_promo', 'nama_mobil')->leftJoin('customer', 'transaksi_penyewaan_mobil.id_customer', '=', 'customer.id_customer')->leftJoin('driver', 'transaksi_penyewaan_mobil.id_driver', '=', 'driver.id_driver')->leftJoin('pegawai', 'transaksi_penyewaan_mobil.id_pegawai', '=', 'pegawai.id_pegawai')->leftJoin('promo', 'transaksi_penyewaan_mobil.id_promo', '=', 'promo.id_promo')->leftJoin('aset_mobil', 'transaksi_penyewaan_mobil.id_mobil', '=', 'aset_mobil.id_mobil')->where('driver.id', $id)->where('transaksi_penyewaan_mobil.status_transaksi', 'TRANSAKSI SELESAI')->orWhere('transaksi_penyewaan_mobil.status_transaksi', 'DITOLAK')->get();

        $customerCek=DB::table('customer')->select('id')->where('id', $id)->get();
        $driverCek=DB::table('driver')->select('id')->where('id', $id)->get();

        if(count($customerCek)>0) {
            return response([
                'message' => 'Retrieve All Success',
                'transaksi_penyewaan_mobil' => $customer,
                'temp' => 1
            ], 200);
        }else if(count($driverCek)>0) {
            return response([
                'message' => 'Retrieve All Success',
                'transaksi_penyewaan_mobil' => $driver,
                'temp' => 2
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'transaksi_penyewaan_mobil' => null
        ], 400);
    }
}
