<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Tampilkan dashboard admin: data menu dan pesanan masuk.
     */
    public function index()
    {
        $menus = Menu::orderBy('id', 'desc')->get();
        $pesanans = Pesanan::with(['user', 'menu'])->orderBy('id', 'desc')->get();

        // Statistik ringkas untuk dashboard
        $totalMenu = $menus->count();
        $pesananMenunggu = $pesanans->where('status', 'Menunggu Konfirmasi')->count();
        $pesananProses = $pesanans->whereIn('status', ['Sedang Dimasak', 'Siap Diambil'])->count();
        $totalPendapatan = $pesanans->where('status', 'Selesai')->sum('total_harga');

        return view('admin.dashboard', compact(
            'menus',
            'pesanans',
            'totalMenu',
            'pesananMenunggu',
            'pesananProses',
            'totalPendapatan'
        ));
    }

    /**
     * Simpan menu baru ke tabel menu.
     */
    public function storeMenu(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:50',
        ], [
            'nama_menu.required' => 'Nama menu wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'kategori.required' => 'Kategori menu wajib dipilih/diisi.',
        ]);

        Menu::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Update data menu di tabel menu.
     */
    public function updateMenu(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:50',
        ], [
            'nama_menu.required' => 'Nama menu wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'kategori.required' => 'Kategori menu wajib dipilih/diisi.',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Menu berhasil diperbarui!');
    }

    /**
     * Hapus menu dari tabel menu.
     */
    public function destroyMenu($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Menu berhasil dihapus!');
    }

    /**
     * Update status pesanan di tabel pesanan.
     */
    public function updateStatusPesanan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|max:100',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.dashboard')->with('success', "Status pesanan #{$id} berhasil diubah menjadi: {$request->status}");
    }
}
