<?php

namespace App\Http\Controllers\Admin\PB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Admin\Video;

class VideoPBController extends Controller
{
    public function index()
    {
        // Ambil semua data video dengan tipe 'pb', urut berdasarkan 'order'
        $videos = DB::table('videos')
            ->where('type', 'pb')
            ->orderBy('order')
            ->get();

        return view('admin.pb.video', compact('videos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:307200', // 300MB max
        ]);

        // Upload video
        $videoPath = $request->file('video')->store('pb/videos', 'public');

        // Generate custom ID
        $prefix = 'VDOPB';
        // Ambil ID terakhir dengan urutan numerik yang benar
        $lastId = DB::table('videos')
            ->where('type', 'pb')
            ->where('id', 'like', "$prefix%")
            ->orderByRaw("CAST(SUBSTRING(id, " . (strlen($prefix) + 1) . ") AS UNSIGNED) DESC")
            ->value('id');

        // Tentukan angka berikutnya
        $lastNumber = $lastId ? (int) substr($lastId, strlen($prefix)) : 0;
        $nextNumber = $lastNumber + 1;
        $customId = $prefix . $nextNumber;

        // Get latest order
        $lastOrder = DB::table('videos')
            ->where('type', 'pb')
            ->max('order');
        $newOrder = $lastOrder ? $lastOrder + 1 : 1;

        // Insert data
        DB::table('videos')->insert([
            'id' => $customId,
            'name' => $request->input('title'),
            'video' => $videoPath,
            'active' => 1,
            'order' => $newOrder,
            'type' => 'pb',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Video berhasil ditambahkan!');
    }

    public function updateOrder(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:videos,id', // Pastikan ID yang dikirim ada di tabel videos
        ]);

        // Update urutan video berdasarkan ID
        foreach ($request->order as $index => $videoId) {
            Video::where('id', $videoId)->update(['order' => $index + 1]); // Menyimpan urutan baru
        }

        // Respons sukses
        return response()->json(['status' => 'success']);
    }

    public function toggleStatus(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'id' => 'required|string|exists:videos,id',
        ]);

        // Cari video berdasarkan ID
        $video = Video::find($request->id);

        // Toggle status aktif
        $video->active = !$video->active;
        $video->save();

        // Respons sukses dengan status baru
        return response()->json([
            'status' => 'success',
            'active' => $video->active,
        ]);
    }

    public function edit($id)
    {
        // Ambil data video berdasarkan ID
        $video = Video::findOrFail($id);

        // Kembalikan data video dalam format JSON untuk digunakan di frontend
        return response()->json($video);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:307200', // max 300MB
        ]);

        $video = Video::findOrFail($id); // Cari video berdasarkan ID

        // Update title
        $video->name = $request->input('title');

        // Jika ada gambar baru, proses uploadnya
        if ($request->hasFile('video')) {
            // Hapus gambar lama
            if (Storage::disk('public')->exists($video->video)) {
                Storage::disk('public')->delete($video->video);
            }

            // Upload gambar baru
            $videoPath = $request->file('video')->store('pb/videos', 'public');
            $video->video = $videoPath;
        }

        // Simpan perubahan
        $video->save();

        return redirect()->back()->with('success', 'Video berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $video = Video::find($id);

        if ($video) {
            // Path yang disimpan sudah relatif terhadap 'public' disk
            if (Storage::disk('public')->exists($video->video)) {
                Storage::disk('public')->delete($video->video);
            }

            $video->delete();

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error'], 404);
    }
}
