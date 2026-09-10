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
                    <p style="color: #374151; font-size: 14px; margin: 0;"><span style="font-weight: 600;">{{ $activity->user->name ?? 'Unknown' }}</span> {{ $activity->description }}</p>
                    <small style="color: #9ca3af; margin-top: 4px; display: block; font-size: 13px;">{{ $activity->created_at->diffForHumans() }}</small>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p style="color: #94a3b8; margin-top: 20px; text-align: center;">Belum ada aktivitas login.</p>
    @endif
</div>
