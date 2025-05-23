<?php

namespace App\Http\Controllers\Admin\PB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Admin\Banner;

class BannerPBController extends Controller
{
    public function index()
    {
        // Ambil semua data banner dengan tipe 'pb', urut berdasarkan 'order'
        $banners = DB::table('banners')
            ->where('type', 'pb')
            ->orderBy('order')
            ->get();

        return view('admin.pb.banner', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        // Upload image
        $imagePath = $request->file('image')->store('pb/banners', 'public');

        // Generate custom ID
        $prefix = 'BNRPB';

        // Ambil ID terakhir berdasarkan angka yang diambil dari bagian setelah prefix
        $lastId = DB::table('banners')
            ->where('type', 'pb')
            ->where('id', 'like', "$prefix%")
            ->orderByRaw("CAST(SUBSTRING(id, " . (strlen($prefix) + 1) . ") AS UNSIGNED) DESC")
            ->value('id');

        $lastNumber = $lastId ? (int) substr($lastId, strlen($prefix)) : 0;
        $nextNumber = $lastNumber + 1;
        $customId = $prefix . $nextNumber;

        // Get latest order
        $lastOrder = DB::table('banners')
            ->where('type', 'pb')
            ->max('order');
        $newOrder = $lastOrder ? $lastOrder + 1 : 1;

        // Insert data
        DB::table('banners')->insert([
            'id' => $customId,
            'name' => $request->input('title'),
            'image' => $imagePath,
            'active' => 1,
            'order' => $newOrder,
            'type' => 'pb',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Banner berhasil ditambahkan!');
    }

    public function updateOrder(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:banners,id', // Pastikan ID yang dikirim ada di tabel banners
        ]);

        // Update urutan banner berdasarkan ID
        foreach ($request->order as $index => $bannerId) {
            Banner::where('id', $bannerId)->update(['order' => $index + 1]); // Menyimpan urutan baru
        }

        // Respons sukses
        return response()->json(['status' => 'success']);
    }

    public function toggleStatus(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'id' => 'required|string|exists:banners,id',
        ]);

        // Cari banner berdasarkan ID
        $banner = Banner::find($request->id);

        // Toggle status aktif
        $banner->active = !$banner->active;
        $banner->save();

        // Respons sukses dengan status baru
        return response()->json([
            'status' => 'success',
            'active' => $banner->active,
        ]);
    }

    public function edit($id)
    {
        // Ambil data banner berdasarkan ID
        $banner = Banner::findOrFail($id);

        // Kembalikan data banner dalam format JSON untuk digunakan di frontend
        return response()->json($banner);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240', // Maksimal 10MB
        ]);

        $banner = Banner::findOrFail($id); // Cari banner berdasarkan ID

        // Update title
        $banner->name = $request->input('title');

        // Jika ada gambar baru, proses uploadnya
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if (Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            // Upload gambar baru
            $imagePath = $request->file('image')->store('pb/banners', 'public');
            $banner->image = $imagePath;
        }

        // Simpan perubahan
        $banner->save();

        return redirect()->back()->with('success', 'Banner berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $banner = Banner::find($id);

        if ($banner) {
            // Path yang disimpan sudah relatif terhadap 'public' disk
            if (Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            $banner->delete();

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error'], 404);
    }
}
