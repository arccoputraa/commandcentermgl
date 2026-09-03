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
        $divisionsList = [
            'Perizinan',
            'Kesehatan',
            'Pendidikan',
            'Keuangan',
            'Pariwisata',
            'Infrastruktur',
            'Perhubungan',
            'SIG',
            'Pembangunan',
            'Kepegawaian',
            'Kependudukan',
        ];

        $divisions = [];
        foreach ($divisionsList as $dName) {
            $divisions[$dName] = \App\Models\Division::firstOrCreate(['name' => $dName]);
        }

        $admin = \App\Models\User::updateOrCreate(
            ['email' => 'admin@magelangkota.go.id'],
            [
                'name' => 'Super Administrator',
                'password' => 'password',
                'nip' => '198001012005011001',
                'role' => 'admin',
                'status' => 'aktif',
                'division_id' => null,
            ]
        );

        $divisiAdmins = [
            'perhubungan'   => ['name' => 'Admin Perhubungan', 'div' => 'Perhubungan', 'nip' => '198503152010011002'],
            'sig'           => ['name' => 'Admin SIG', 'div' => 'SIG', 'nip' => '198707202011011003'],
            'pembangunan'   => ['name' => 'Admin Pembangunan', 'div' => 'Pembangunan', 'nip' => '198205102008011004'],
            'kepegawaian'   => ['name' => 'Admin Kepegawaian', 'div' => 'Kepegawaian', 'nip' => '198911252014012005'],
            'perizinan'     => ['name' => 'Admin Perizinan', 'div' => 'Perizinan', 'nip' => '198402182009011006'],
            'kesehatan'     => ['name' => 'Admin Kesehatan', 'div' => 'Kesehatan', 'nip' => '198608122010012007'],
            'keuangan'      => ['name' => 'Admin Keuangan', 'div' => 'Keuangan', 'nip' => '198304052007011008'],
            'kependudukan'  => ['name' => 'Admin Kependudukan', 'div' => 'Kependudukan', 'nip' => '198809302012011009'],
        ];

        foreach ($divisiAdmins as $key => $data) {
            \App\Models\User::updateOrCreate(
                ['email' => "admin_{$key}@magelangkota.go.id"],
                [
                    'name' => $data['name'],
                    'password' => 'password',
                    'nip' => $data['nip'],
                    'role' => 'admin',
                    'status' => 'aktif',
                    'division_id' => $divisions[$data['div']]->id,
                ]
            );
        }

        \App\Models\ActivityLog::create([
            'user_id' => $admin->id,
            'action' => 'setup',
            'description' => 'Sistem command center berhasil diinisialisasi.',
        ]);
    }
}
