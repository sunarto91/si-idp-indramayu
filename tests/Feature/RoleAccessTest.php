<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Pastikan pengujian memakai SQLite.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->assertSame(
            'sqlite',
            config('database.default'),
            'Pengujian harus memakai database SQLite.'
        );

        $this->assertSame(
            ':memory:',
            config('database.connections.sqlite.database')
        );
    }

    /**
     * Membuat akun dummy dengan role tertentu.
     */
    private function makeUserWithRole(
        string $kode,
        bool $active = true
    ): User {
        $role = Role::create([
            'kode' => $kode,
            'nama' => ucfirst(str_replace('_', ' ', $kode)),
        ]);

        $user = User::factory()->create([
            'is_active' => $active,
        ]);

        $user->roles()->attach($role->id);

        return $user;
    }

    /**
     * Guest tidak boleh mengakses Master OPD.
     */
    public function test_guest_redirected_to_login(): void
    {
        $this->get('/opds')
            ->assertRedirect(route('login'));
    }

    /**
     * Super Admin boleh mengakses Master OPD.
     */
    public function test_super_admin_can_access_opd(): void
    {
        $user = $this->makeUserWithRole('super_admin');

        $this->actingAs($user)
            ->get('/opds')
            ->assertOk();
    }

    /**
     * Operator boleh mengakses Master OPD.
     */
    public function test_operator_can_access_opd(): void
    {
        $user = $this->makeUserWithRole('operator');

        $this->actingAs($user)
            ->get('/opds')
            ->assertOk();
    }

    /**
     * PNS tidak boleh mengakses Master OPD.
     */
    public function test_pns_cannot_access_opd(): void
    {
        $user = $this->makeUserWithRole('pns');

        $this->actingAs($user)
            ->get('/opds')
            ->assertForbidden();
    }

    /**
     * Akun aktif tanpa role juga harus ditolak.
     */
    public function test_user_without_role_cannot_access_opd(): void
    {
        $user = User::factory()->create([
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->get('/opds')
            ->assertForbidden();
    }

    /**
     * Akun yang dinonaktifkan saat sesi masih ada
     * harus dikeluarkan dari aplikasi.
     */

public function test_inactive_user_session_is_revoked(): void
{
    // Membuat akun Super Admin aktif.
    $user = $this->makeUserWithRole('super_admin');

    // Simulasikan pengguna sudah login.
    $this->actingAs($user);

    // Administrator menonaktifkan akun.
    // forceFill digunakan karena is_active
    // bukan atribut mass assignment biasa.
    $user->forceFill([
        'is_active' => false,
    ])->save();

    // Baca ulang data dari database.
    $user->refresh();

    // Pastikan status benar-benar nonaktif.
    $this->assertFalse($user->is_active);

    // Sesi yang sudah ada harus dicabut.
    $this->get('/dashboard')
        ->assertRedirect(route('login'));

    // Pengguna harus sudah logout.
    $this->assertGuest();
}

    /**
     * Akun nonaktif tidak bisa melakukan login baru.
     */
    public function test_inactive_user_cannot_login(): void
    {
        $user = User::factory()->create([
            'is_active' => false,
            'password' => 'PasswordDummy123!',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'PasswordDummy123!',
        ]);

        $response->assertSessionHasErrors('email');

        $this->assertGuest();
    }

/**
 * PNS tidak boleh melakukan operasi administratif OPD,
 * termasuk melalui permintaan HTTP langsung.
 */
public function test_pns_cannot_access_opd_administration(): void
{
    // Buat pengguna dummy dengan role PNS.
    $user = $this->makeUserWithRole('pns');

    // Login sebagai PNS.
    $this->actingAs($user);

    // GET: Form Tambah OPD.
    $this->get('/opds/create')
        ->assertForbidden();

    // POST: Simpan OPD.
    $this->post('/opds', [
        'kode_opd' => 'TEST001',
        'nama_opd' => 'OPD Pengujian',
        'singkatan' => 'TEST',
        'is_active' => 1,
    ])->assertForbidden();

    // GET: Form Import Excel.
    $this->get('/opds/import')
        ->assertForbidden();

    // POST: Konfirmasi Import.
    $this->post('/opds/import/confirm')
        ->assertForbidden();

    // GET: Export Excel.
    $this->get('/opds/export')
        ->assertForbidden();

    // Pastikan tidak ada data OPD yang dibuat.
    $this->assertDatabaseMissing('opds', [
        'kode_opd' => 'TEST001',
    ]);
}


/**
 * PNS tidak boleh mengedit, memperbarui,
 * atau menghapus data Master OPD.
 */
public function test_pns_cannot_edit_update_or_delete_opd(): void
{
    // Buat akun dummy dengan role PNS.
    $user = $this->makeUserWithRole('pns');

    // Buat satu OPD dummy di database testing.
    $opdId = \Illuminate\Support\Facades\DB::table('opds')
        ->insertGetId([
            'kode_opd' => 'TEST-RBAC-001',
            'nama_opd' => 'OPD Dummy Pengujian RBAC',
            'singkatan' => 'TEST',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    // Login sebagai PNS.
    $this->actingAs($user);

    // PNS tidak boleh membuka form Edit.
    $this->get("/opds/{$opdId}/edit")
        ->assertForbidden();

    // PNS tidak boleh mengubah data OPD.
    $this->put("/opds/{$opdId}", [
        'kode_opd' => 'TEST-RBAC-001',
        'nama_opd' => 'OPD Diubah Tanpa Izin',
        'singkatan' => 'TEST',
        'is_active' => 1,
    ])->assertForbidden();

    // PNS tidak boleh menghapus data OPD.
    $this->delete("/opds/{$opdId}")
        ->assertForbidden();

    // Pastikan data awal tetap ada.
    $this->assertDatabaseHas('opds', [
        'id' => $opdId,
        'kode_opd' => 'TEST-RBAC-001',
        'nama_opd' => 'OPD Dummy Pengujian RBAC',
    ]);

    // Pastikan perubahan ilegal tidak tersimpan.
    $this->assertDatabaseMissing('opds', [
        'id' => $opdId,
        'nama_opd' => 'OPD Diubah Tanpa Izin',
    ]);
}


}
