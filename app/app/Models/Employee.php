<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_code',
        'name',
        'department_id',
        'position_id',
        'phone',
        'email',
        'hire_date',
        'status',
        'notes',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'hire_date' => 'date',
            'metadata' => 'array',
        ];
    }

    /**
     * 所屬部門
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * 職位
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * 排班明細
     */
    public function scheduleDetails(): HasMany
    {
        return $this->hasMany(ScheduleDetail::class);
    }

    /**
     * 檢查是否為啟用狀態
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * 檢查是否已離職
     */
    public function hasLeft(): bool
    {
        return $this->status === 'leave';
    }
}
