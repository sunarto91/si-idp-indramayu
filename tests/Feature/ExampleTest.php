<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Pengguna yang belum login diarahkan
     * ke halaman login saat membuka root.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('dashboard'));

        $response = $this->get('/dashboard');

        $response->assertRedirect(route('login'));
    }

    /**
     * Halaman login dapat dibuka oleh guest.
     */
    public function test_login_page_can_be_accessed(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * Halaman OPD hanya dapat diakses
     * oleh pengguna yang sudah login.
     */
    public function test_opd_page_requires_authentication(): void
    {
        $response = $this->get('/opds');

        $response->assertRedirect(route('login'));
    }

    /**
     * Export Excel tidak bisa diakses guest.
     */
    public function test_opd_export_requires_authentication(): void
    {
        $response = $this->get('/opds/export');

        $response->assertRedirect(route('login'));
    }
}