<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScheduleDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_plan_id',
        'employee_id',
        'shift_date',
        'shift_type_id',
        'start_time',
        'end_time',
        'duration_minutes',
        'notes',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'shift_date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'metadata' => 'array',
        ];
    }

    /**
     * 排班計劃
     */
    public function schedulePlan(): BelongsTo
    {
        return $this->belongsTo(SchedulePlan::class);
    }

    /**
     * 員工
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * 班別類型
     */
    public function shiftType(): BelongsTo
    {
        return $this->belongsTo(ShiftType::class);
    }

    /**
     * 時間段
     */
    public function timeSlots(): HasMany
    {
        return $this->hasMany(ScheduleTimeSlot::class);
    }

    /**
     * 計算工作時長（分鐘）
     */
    public function calculateDuration(): int
    {
        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);
        
        return $end->diffInMinutes($start);
    }

    /**
     * 檢查是否為加班
     */
    public function isOvertime(): bool
    {
        return $this->metadata['overtime'] ?? false;
    }
}
