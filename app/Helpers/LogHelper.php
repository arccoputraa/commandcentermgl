<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class LogHelper
{
    /**
     * Helper terpusat untuk mencatat log aktivitas
     *
     * @param \App\Models\User $user
     * @param string $actionVerb "login ke" atau "logout dari"
     * @param string $targetModule "Dashboard Kesehatan", dll
     * @return \App\Models\ActivityLog
     */
    public static function record_activity($user, $actionVerb, $targetModule)
    {
        // Tentukan Siapa
        $siapa = 'Super Administrator';
        
        if ($user->role === 'admin') {
            $siapa = 'Super Administrator';
        } else {
            // Ambil dari divisi jika ada
            if ($user->division) {
                // Menghindari redudansi kata Admin (hanya hapus kata 'admin ' di awal jika ada)
                $divName = preg_replace('/^admin\s+/i', '', $user->division->name);
                $siapa = 'Admin ' . ucwords(trim($divName));
            } else {
                // Fallback untuk role admin spesifik jika divisi tidak di-set tapi rolenya spesifik
                if ($user->role === 'admin_sig') {
                    $siapa = 'Admin SIG';
                } elseif ($user->role === 'admin_perhubungan') {
                    $siapa = 'Admin Perhubungan';
                } else {
                    $siapa = 'Admin Divisi'; // default generic
                }
            }
        }

        // Susun string log sesuai formula: {Siapa} {Melakukan Apa} {Di Mana}
        // Contoh: Super Administrator login ke Dashboard Kesehatan
        $description = trim("$siapa $actionVerb $targetModule");

        // Tentukan action (untuk field action DB yang sudah ada agar tidak error ENUM)
        $action = 'other';
        if (str_contains(strtolower($actionVerb), 'login')) {
            $action = 'login';
        } elseif (str_contains(strtolower($actionVerb), 'logout')) {
            $action = 'logout';
        }

        // Simpan ke database
        return ActivityLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'description' => $description,
        ]);
    }
}
