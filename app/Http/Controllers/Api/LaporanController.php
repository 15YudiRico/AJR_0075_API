<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Transaksi;
use App\Models\Brosur;
use App\Models\Customer;
use App\Models\Driver;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index($pointer, $month, $year)
    {
        if($pointer == 1){

            $laporan = DB::table('transaksi_penyewaan_mobil')->select('nama_mobil', 'tipe_mobil', 'harga_sewa_perhari', DB::raw('COUNT(nama_mobil) "JUMLAH_PEMINJAMAN"'), DB::raw('SUM(DATE(TGL_WAKTU_SELESAI_SEWA)-DATE(TGL_WAKTU_MULAI_SEWA)) AS TOTAL_DURASI'), DB::raw('SUM(HARGA_SEWA_PERHARI*(DATE(TGL_WAKTU_SELESAI_SEWA)-DATE(TGL_WAKTU_MULAI_SEWA))) AS PENDAPATAN'))->join('aset_mobil', 'transaksi_penyewaan_mobil.id_mobil', '=', 'aset_mobil.id_mobil')->where('transaksi_penyewaan_mobil.status_transaksi', 'TRANSAKSI SELESAI')->whereBetween(DB::raw('DATE(transaksi_penyewaan_mobil.TGL_TRANSAKSI)'), [$year."-".$month."-1", $year."-".$month."-31"])->groupBy('nama_mobil')->orderByDesc('PENDAPATAN')->get();

            if(count($laporan)>0) {
                return response([
                    'message' => 'Retrieve All Report Success',
                    'laporan' => $laporan
                ], 200);
            }
    
            return response([
                'message' => 'Tidak Ada Data Pada Bulan Dan Tahun Ini',
                'laporan' => null
            ], 400);

        } else if ($pointer == 2){

            $laporan = DB::table('transaksi_penyewaan_mobil')->select('nama_customer', 'nama_mobil', 'jenis_transaksi', DB::raw('COUNT(id_transaksi) "JUMLAH_TRANSAKSI"'), DB::raw('SUM(total_pembayaran) AS TOTAL_PENDAPATAN_DARI_CUSTOMER'))->join('customer', 'transaksi_penyewaan_mobil.id_customer', '=', 'customer.id_customer')->join('aset_mobil', 'transaksi_penyewaan_mobil.id_mobil', '=', 'aset_mobil.id_mobil')->where('transaksi_penyewaan_mobil.status_transaksi', 'TRANSAKSI SELESAI')->whereBetween(DB::raw('DATE(transaksi_penyewaan_mobil.TGL_TRANSAKSI)'), [$year."-".$month."-1", $year."-".$month."-31"])->groupBy('nama_customer', 'nama_mobil', 'jenis_transaksi')->get();

            if(count($laporan)>0) {
                return response([
                    'message' => 'Retrieve All Report Success',
                    'laporan' => $laporan
                ], 200);
            }
    
            return response([
                'message' => 'Tidak Ada Data Pada Bulan Dan Tahun Ini',
                'laporan' => null
            ], 400);

        } else if($pointer == 3){

            $laporan = DB::table('transaksi_penyewaan_mobil')->select('format_id_driver', 'driver.id_driver','nama_driver', DB::raw('COUNT(id_transaksi) "JUMLAH_TRANSAKSI"'))->join('driver', 'transaksi_penyewaan_mobil.id_driver', '=', 'driver.id_driver')->where('transaksi_penyewaan_mobil.status_transaksi', 'TRANSAKSI SELESAI')->whereBetween(DB::raw('DATE(transaksi_penyewaan_mobil.TGL_TRANSAKSI)'), [$year."-".$month."-1", $year."-".$month."-31"])->groupBy('id_driver')->orderByDesc('jumlah_transaksi')->limit(5)->get();

            if(count($laporan)>0) {
                return response([
                    'message' => 'Retrieve All Report Success',
                    'laporan' => $laporan
                ], 200);
            }
    
            return response([
                'message' => 'Tidak Ada Data Pada Bulan Dan Tahun Ini',
                'laporan' => null
            ], 400);

        } else if($pointer == 4){

            $laporan = DB::table('transaksi_penyewaan_mobil')->select('format_id_driver', 'driver.id_driver','nama_driver', 'RERATA_RATING_DRIVER', DB::raw('COUNT(id_transaksi) "JUMLAH_TRANSAKSI"'))->join('driver', 'transaksi_penyewaan_mobil.id_driver', '=', 'driver.id_driver')->where('transaksi_penyewaan_mobil.status_transaksi', 'TRANSAKSI SELESAI')->whereBetween(DB::raw('DATE(transaksi_penyewaan_mobil.TGL_TRANSAKSI)'), [$year."-".$month."-1", $year."-".$month."-31"])->groupBy('id_driver')->orderByDesc('jumlah_transaksi')->limit(5)->get();

            if(count($laporan)>0) {
                return response([
                    'message' => 'Retrieve All Report Success',
                    'laporan' => $laporan
                ], 200);
            }
    
            return response([
                'message' => 'Tidak Ada Data Pada Bulan Dan Tahun Ini',
                'laporan' => null
            ], 400);
            
        } else if($pointer == 5) {

            $laporan = DB::table('transaksi_penyewaan_mobil')->select('nama_customer', DB::raw('COUNT(id_transaksi) "JUMLAH_TRANSAKSI"'))->join('customer', 'transaksi_penyewaan_mobil.id_customer', '=', 'customer.id_customer')->where('transaksi_penyewaan_mobil.status_transaksi', 'TRANSAKSI SELESAI')->whereBetween(DB::raw('DATE(transaksi_penyewaan_mobil.TGL_TRANSAKSI)'), [$year."-".$month."-1", $year."-".$month."-31"])->groupBy('nama_customer')->orderByDesc('jumlah_transaksi')->limit(5)->get();

            if(count($laporan)>0) {
                return response([
                    'message' => 'Retrieve All Report Success',
                    'laporan' => $laporan
                ], 200);
            }
    
            return response([
                'message' => 'Tidak Ada Data Pada Bulan Dan Tahun Ini',
                'laporan' => null
            ], 400);
        }

        return response([
            'message' => 'Empty',
            'laporan' => null
        ], 400);
    }
}
