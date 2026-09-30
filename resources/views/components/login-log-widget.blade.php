@php
    $slug = request()->segment(1);
    if ($slug === 'finance') $slug = 'keuangan';
    $currentDiv = \App\Models\Division::whereRaw('LOWER(name) = ?', [$slug])->first();
    $targetDivId = $currentDiv ? $currentDiv->id : (Auth::user()->division_id ?? 0);

    // Ambil log login & logout dari user divisi ini PLUS super admin
    $recentActivities = \App\Models\ActivityLog::with('user')
        ->whereIn('action', ['login', 'logout'])
        ->whereHas('user', function($q) use ($targetDivId) {
            $q->where('division_id', $targetDivId)
              ->orWhere('role', 'admin');
        })
        ->latest()
        ->take(5)
        ->get();
@endphp
<div class="panel-card" style="margin-top: 24px; grid-column: 1 / -1;">
    <h3 class="panel-title" style="margin-top: 0; margin-bottom: 20px; color: #1e293b; font-size: 16px;">Aktivitas Terbaru</h3>
    
    @if($recentActivities->count() > 0)
        <div class="activity-list">
            @foreach($recentActivities as $activity)
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div class="activity-content">
                    @php
                        // Bersihkan prefix role lama dari log terdahulu agar tidak tercetak dobel (Backward Compatibility)
                        $desc = preg_replace('/^(Super Administrator|Admin [a-zA-Z\s]+)\s+/i', '', $activity->description);
                        $formattedText = '<span style="font-weight: 600;">' . e($activity->user->name ?? 'Sistem') . '</span> ' . e($desc);
                    @endphp
                    <p style="color: #374151; font-size: 14px; margin: 0;">{!! $formattedText !!}</p>
                    <small style="color: #9ca3af; margin-top: 4px; display: block; font-size: 13px;">{{ $activity->created_at->translatedFormat('d M Y, H:i') }} WIB ({{ $activity->created_at->diffForHumans() }})</small>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p style="color: #94a3b8; margin-top: 20px; text-align: center;">Belum ada aktivitas login.</p>
    @endif
</div>
