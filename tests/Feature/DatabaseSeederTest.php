<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_imports_snapshot_and_inventory_data(): void
    {
        $this->seed();

        $this->assertDatabaseHas('settings', [
            'key' => 'batas_jam_kembali',
            'value' => '15:00',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'abdullohrezapermana@gmail.com',
            'role' => 'siswa',
        ]);

        $this->assertGreaterThan(0, Alat::count());
        $this->assertGreaterThan(0, Unit::count());
        $this->assertGreaterThan(0, Peminjaman::count());
        $this->assertGreaterThan(0, ActivityLog::count());
    }
}
