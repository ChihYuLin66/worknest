<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'is_daily',
        'days_of_week',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'is_daily' => 'boolean',
            'days_of_week' => 'array',
            'metadata' => 'array',
        ];
    }

    /**
     * 檢查指定星期是否適用此休息時間
     */
    public function isApplicableForDay(int $dayOfWeek): bool
    {
        if ($this->is_daily) {
            return true;
        }

        return in_array($dayOfWeek, $this->days_of_week ?? []);
    }
}
