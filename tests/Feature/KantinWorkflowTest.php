<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KantinWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        User::create([
            'username' => 'admin_kantin',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'budi_siswa',
            'password' => '123',
            'role' => 'siswa',
        ]);

        Menu::create([
            'nama_menu' => 'Nasi Goreng Spesial',
            'harga' => 15000,
            'kategori' => 'Makanan',
        ]);

        Menu::create([
            'nama_menu' => 'Es Teh Manis',
            'harga' => 4000,
            'kategori' => 'Minuman',
        ]);
    }

    public function test_login_page_is_accessible()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('BI Kantin Web');
    }

    public function test_admin_can_login_and_access_dashboard()
    {
        $response = $this->post('/login', [
            'username' => 'admin_kantin',
            'password' => 'admin123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertEquals('admin', session('role'));

        $dashResponse = $this->get('/admin/dashboard');
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Portal Admin');
    }

    public function test_siswa_can_login_and_access_dashboard()
    {
        $response = $this->post('/login', [
            'username' => 'budi_siswa',
            'password' => '123',
        ]);

        $response->assertRedirect(route('siswa.dashboard'));
        $this->assertEquals('siswa', session('role'));

        $dashResponse = $this->get('/siswa/dashboard');
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Portal Siswa');
    }

    public function test_siswa_cannot_access_admin_dashboard()
    {
        $this->withSession([
            'user_id' => 2,
            'username' => 'budi_siswa',
            'role' => 'siswa',
        ]);

        $response = $this->get('/admin/dashboard');
        $response->assertRedirect(route('siswa.dashboard'));
    }

    public function test_admin_cannot_access_siswa_dashboard()
    {
        $this->withSession([
            'user_id' => 1,
            'username' => 'admin_kantin',
            'role' => 'admin',
        ]);

        $response = $this->get('/siswa/dashboard');
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_siswa_order_flow_and_admin_status_update()
    {
        $menu = Menu::first();

        // 1. Siswa memesan menu
        $this->withSession([
            'user_id' => 2,
            'username' => 'budi_siswa',
            'role' => 'siswa',
        ]);

        $orderResponse = $this->post(route('siswa.pesan'), [
            'menu_id' => $menu->id,
            'jumlah' => 2,
        ]);

        $orderResponse->assertRedirect(route('siswa.dashboard'));

        $pesanan = Pesanan::where('user_id', 2)->latest('id')->first();
        $this->assertNotNull($pesanan);
        $this->assertEquals('Menunggu Konfirmasi', $pesanan->status);
        $this->assertEquals($menu->harga * 2, $pesanan->total_harga);

        // 2. Realtime status json
        $statusResponse = $this->get(route('siswa.status.realtime'));
        $statusResponse->assertStatus(200);
        $statusResponse->assertJsonFragment([
            'id' => $pesanan->id,
            'status' => 'Menunggu Konfirmasi',
        ]);

        // 3. Admin mengubah status menjadi "Siap Diambil"
        $this->withSession([
            'user_id' => 1,
            'username' => 'admin_kantin',
            'role' => 'admin',
        ]);

        $updateResponse = $this->post(route('admin.pesanan.status', $pesanan->id), [
            'status' => 'Siap Diambil',
        ]);

        $updateResponse->assertRedirect(route('admin.dashboard'));

        $pesanan->refresh();
        $this->assertEquals('Siap Diambil', $pesanan->status);
    }
}
