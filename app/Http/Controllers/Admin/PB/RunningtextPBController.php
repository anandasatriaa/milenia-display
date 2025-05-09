<?php

namespace App\Http\Controllers\Admin\PB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Admin\Runningtext;
use Illuminate\Support\Facades\Log;

class RunningtextPBController extends Controller
{
    public function index()
    {
        // Ambil data keterlambatan absensi dari absen_mesin dan trkaryawan (kedua tabel ada di dbhrd)
        $keterlambatan = DB::connection('dbhrd') // Koneksi ke database dbhrd
            ->table('absen_mesin')
            ->join('trkaryawan', 'absen_mesin.pin', '=', 'trkaryawan.IDMesin') // Tabel trkaryawan dari database dbhrd
            ->where('trkaryawan.Cabang', 'PEMBANGUNAN') // Tambahkan kondisi Cabang = PEMBANGUNAN
            ->where('trkaryawan.Aktif', 1)
            ->whereRaw('TIME(absen_mesin.jam) > absen_mesin.jammasuk') // Membandingkan jam masuk dengan jam yang diatur
            ->whereDate('absen_mesin.tanggal', '=', \Carbon\Carbon::today()->format('Y-m-d')) // Filter untuk hari ini
            ->select('absen_mesin.tanggal', 'absen_mesin.jam', 'trkaryawan.Nama', 'absen_mesin.pin', 'trkaryawan.ID')
            ->get();
    
        // Ambil semua data runningtext dengan tipe 'pb', urut berdasarkan 'order'
        $runningtexts = DB::table('runningtexts') // Menggunakan database default milenia_display
            ->where('type', 'pb')
            ->orderBy('order')
            ->get();
    
        return view('admin.pb.runningtext', compact('runningtexts', 'keterlambatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        // Generate custom ID
        $prefix = 'TXTPB';
        // Ambil ID terakhir dengan urutan numerik yang benar
        $lastId = DB::table('runningtexts')
            ->where('type', 'pb')
            ->where('id', 'like', "$prefix%")
            ->orderByRaw("CAST(SUBSTRING(id, " . (strlen($prefix) + 1) . ") AS UNSIGNED) DESC")
            ->value('id');

        // Tentukan angka berikutnya
        $lastNumber = $lastId ? (int) substr($lastId, strlen($prefix)) : 0;
        $nextNumber = $lastNumber + 1;
        $customId = $prefix . $nextNumber;

        // Get latest order
        $lastOrder = DB::table('runningtexts')
            ->where('type', 'pb')
            ->max('order');
        $newOrder = $lastOrder ? $lastOrder + 1 : 1;

        // Insert data
        DB::table('runningtexts')->insert([
            'id' => $customId,
            'name' => $request->input('name'),
            'active' => 1,
            'order' => $newOrder,
            'type' => 'pb',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Running Text berhasil ditambahkan!');
    }

    public function updateOrder(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:runningtexts,id', // Pastikan ID yang dikirim ada di tabel runningtexts
        ]);

        // Update urutan runningtext berdasarkan ID
        foreach ($request->order as $index => $runningtextId) {
            Runningtext::where('id', $runningtextId)->update(['order' => $index + 1]); // Menyimpan urutan baru
        }

        // Respons sukses
        return response()->json(['status' => 'success']);
    }

    public function toggleStatus(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'id' => 'required|string|exists:runningtexts,id',
        ]);

        // Cari runningtext berdasarkan ID
        $runningtext = Runningtext::find($request->id);

        // Toggle status aktif
        $runningtext->active = !$runningtext->active;
        $runningtext->save();

        // Respons sukses dengan status baru
        return response()->json([
            'status' => 'success',
            'active' => $runningtext->active,
        ]);
    }

    public function edit($id)
    {
        $runningtext = Runningtext::findOrFail($id);
        return response()->json($runningtext);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $runningtext = Runningtext::findOrFail($id);
        $runningtext->name = $request->name;
        $runningtext->save();

        return redirect()->back()->with('success', 'Running text berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $runningtext = Runningtext::find($id);

        if ($runningtext) {
            $runningtext->delete();
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error'], 404);
    }
}
