<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Tampilkan katalog menu dan riwayat status pesanan siswa.
     */
    public function index()
    {
        $userId = session('user_id');
        $menus = Menu::orderBy('nama_menu', 'asc')->get();
        $pesanans = Pesanan::with('menu')
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();

        $kategoriList = Menu::select('kategori')->distinct()->pluck('kategori');

        return view('siswa.dashboard', compact('menus', 'pesanans', 'kategoriList'));
    }

    /**
     * Proses pemesanan menu (insert ke tabel pesanan).
     */
    public function pesan(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menu,id',
            'jumlah' => 'required|integer|min:1',
        ], [
            'menu_id.required' => 'Menu harus dipilih.',
            'menu_id.exists' => 'Menu tidak valid.',
            'jumlah.required' => 'Jumlah pesanan wajib diisi.',
            'jumlah.min' => 'Jumlah minimal 1 porsi.',
        ]);

        $menu = Menu::findOrFail($request->menu_id);
        $totalHarga = $menu->harga * $request->jumlah;

        Pesanan::create([
            'user_id' => session('user_id'),
            'menu_id' => $menu->id,
            'jumlah' => $request->jumlah,
            'total_harga' => $totalHarga,
            'status' => 'Menunggu Konfirmasi',
        ]);

        return redirect()->route('siswa.dashboard')->with('success', "Pesanan {$menu->nama_menu} x{$request->jumlah} berhasil dibuat!");
    }

    /**
     * Endpoint API JSON untuk melihat status pesanan secara real-time.
     */
    public function statusRealtime()
    {
        $userId = session('user_id');
        $pesanans = Pesanan::with('menu')
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($pesanans);
    }
}
