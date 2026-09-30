<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class LogHelper
{
    /**
     * Helper terpusat untuk mencatat log aktivitas
     *
     * @param \App\Models\User $user
     * @param string $actionType Kategori aksi (login, logout, access)
     * @param string $description Deskripsi aksi (misal: "beralih ke Dashboard Kesehatan")
     * @return \App\Models\ActivityLog
     */
    public static function record_activity($user, $actionType, $description)
    {
        // Simpan ke database
        return ActivityLog::create([
            'user_id' => $user->id,
            'action' => $actionType,
            'description' => $description,
        ]);
    }
}
