<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleTimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_detail_id',
        'start_time',
        'end_time',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'metadata' => 'array',
        ];
    }

    /**
     * 排班明細
     */
    public function scheduleDetail(): BelongsTo
    {
        return $this->belongsTo(ScheduleDetail::class);
    }

    /**
     * 計算時間段長度（分鐘）
     */
    public function getDurationMinutes(): int
    {
        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);
        
        return $end->diffInMinutes($start);
    }
}
