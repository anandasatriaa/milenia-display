<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DisplayTGRController extends Controller
{
    public function index()
    {
        // Ambil data banner & video
        $banners = DB::table('banners')
            ->where('active', 1)
            ->where('type', 'tgr')
            ->orderBy('order')
            ->get()
            ->map(function ($banner) {
                $banner->image_url = asset('storage/' . $banner->image);
                return $banner;
            });

        $videos = DB::table('videos')
            ->where('active', 1)
            ->where('type', 'tgr')
            ->orderBy('order')
            ->get();

        // Ambil data keterlambatan dari database dbhrd
        $keterlambatan = DB::connection('dbhrd')
            ->table('absen_mesin')
            ->join('trkaryawan', 'absen_mesin.pin', '=', 'trkaryawan.IDMesin')
            ->where('trkaryawan.Cabang', 'TIGARAKSA')
            ->where('trkaryawan.Aktif', 1)
            ->whereRaw('TIME(absen_mesin.jam) > absen_mesin.jammasuk')
            ->whereDate('absen_mesin.tanggal', Carbon::today()->format('Y-m-d'))
            ->select('absen_mesin.tanggal', 'absen_mesin.jam', 'trkaryawan.Nama', 'trkaryawan.ID')
            ->get();

        // Set Carbon ke bahasa Indonesia
        Carbon::setLocale('id');

        // Format teks keterlambatan
        $textKeterlambatan = '';
        $hariIni = Carbon::today()->translatedFormat('l, j F Y'); // contoh: Jumat, 2 Mei 2025

        $clientIp = request()->ip();
        $baseUrl = (in_array($clientIp, ['127.0.0.1']) || Str::startsWith($clientIp, '192.168.0.'))
            ? 'http://192.168.0.8/hrd-milenia/foto/'
            : 'http://pc.dyndns-office.com:8001/hrd-milenia/foto/';

        if (count($keterlambatan) > 0) {
            $textKeterlambatan .= "⏰ Keterlambatan Hari {$hariIni}: ";

            foreach ($keterlambatan as $item) {
                $formattedFoto = str_pad($item->ID, 5, '0', STR_PAD_LEFT);
                $fotoUrl = $baseUrl . "{$formattedFoto}.JPG";

                $textKeterlambatan .= "<img src='{$fotoUrl}' alt='Foto {$item->Nama}' width='40' height='40' style='border-radius:50%; vertical-align:middle; margin-right:6px;'> ";
                $textKeterlambatan .= "{$item->Nama} ({$item->jam}) | ";
            }

            $textKeterlambatan = rtrim($textKeterlambatan, '| ') . " ⏰"; // Tambahkan ⏰ akhir
        }

        // Ambil data running text dari DB
        $runningTexts = DB::table('runningtexts')
            ->where('active', 1)
            ->where('type', 'tgr')
            ->orderBy('order')
            ->pluck('name')
            ->toArray();

        // Tambahkan emoji 📌 di awal dan akhir setiap item dari runningtexts
        $formattedRunningTexts = array_map(function ($text) {
            return "📌 {$text} 📌";
        }, $runningTexts);

        // Gabungkan semua teks menjadi satu string dengan jarak yang jauh
        $separatorGap = str_repeat('&nbsp;', 50) . '' . str_repeat('&nbsp;', 50); // Jarak panjang setelah keterlambatan
        $internalGap = str_repeat('&nbsp;', 50); // Jarak antar teks running
        $fullRunningText = $textKeterlambatan . $separatorGap . implode(" {$internalGap}{$internalGap} ", $formattedRunningTexts);

        return view('display-tgr', compact('banners', 'videos', 'fullRunningText'));
    }

    public function lastUpdate()
    {
        $bannerIds = DB::table('banners')
            ->where('active', 1)
            ->where('type', 'tgr')
            ->orderBy('order')
            ->pluck('id');

        $videoIds = DB::table('videos')
            ->where('active', 1)
            ->where('type', 'tgr')
            ->orderBy('order')
            ->pluck('id');

        $runningTextIds = DB::table('runningtexts')
            ->where('active', 1)
            ->where('type', 'tgr')
            ->orderBy('order')
            ->pluck('id');

        $lastBanner = DB::table('banners')
            ->where('active', 1)
            ->where('type', 'tgr')
            ->max('updated_at');

        $lastVideo = DB::table('videos')
            ->where('active', 1)
            ->where('type', 'tgr')
            ->max('updated_at');

        $lastRunningText = DB::table('runningtexts')
            ->where('active', 1)
            ->where('type', 'tgr')
            ->max('updated_at');

        // Ambil yang paling baru dari ketiganya
        $last = collect([$lastBanner, $lastVideo, $lastRunningText])
            ->filter()
            ->max();

        return response()->json([
            'banner_ids'        => $bannerIds,
            'video_ids'         => $videoIds,
            'runningtext_ids'   => $runningTextIds,
            'last_update'       => $last ? Carbon::parse($last)->timestamp : 0,
        ]);
    }
}
