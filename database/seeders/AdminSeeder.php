<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $div1 = \App\Models\Division::create(['name' => 'Perizinan']);
        $div2 = \App\Models\Division::create(['name' => 'Kesehatan']);
        $div3 = \App\Models\Division::create(['name' => 'Pendidikan']);
        $div4 = \App\Models\Division::create(['name' => 'Keuangan']);
        $div5 = \App\Models\Division::create(['name' => 'Pariwisata']);
        $div6 = \App\Models\Division::create(['name' => 'Infrastruktur']);

        $admin = \App\Models\User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@magelangkota.go.id',
            'password' => bcrypt('password'),
            'nip' => '198001012005011001',
            'role' => 'admin',
            'status' => 'aktif',
            'division_id' => null,
        ]);

        \App\Models\ActivityLog::create([
            'user_id' => $admin->id,
            'action' => 'setup',
            'description' => 'Sistem command center berhasil diinisialisasi.',
        ]);
    }
}
