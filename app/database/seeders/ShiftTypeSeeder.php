<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShiftType;
use App\Models\BusinessHour;
use App\Models\BreakTime;

class ShiftTypeSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // 建立班別類型
        ShiftType::create([
            'name' => '早班',
            'start_time' => '08:00',
            'end_time' => '12:00',
            'is_active' => true,
            'metadata' => [
                'color' => '#f39c12',
                'icon' => 'sun',
                'description' => '早上班次',
                'requirements' => [
                    'min_staff' => 2,
                    'max_staff' => 5,
                ],
            ],
        ]);

        ShiftType::create([
            'name' => '中午班',
            'start_time' => '14:30',
            'end_time' => '18:00',
            'is_active' => true,
            'metadata' => [
                'color' => '#e67e22',
                'icon' => 'sun-o',
                'description' => '下午班次',
                'requirements' => [
                    'min_staff' => 3,
                    'max_staff' => 6,
                ],
            ],
        ]);

        ShiftType::create([
            'name' => '晚班',
            'start_time' => '18:30',
            'end_time' => '21:00',
            'is_active' => true,
            'metadata' => [
                'color' => '#2c3e50',
                'icon' => 'moon-o',
                'description' => '晚上班次',
                'requirements' => [
                    'min_staff' => 2,
                    'max_staff' => 4,
                ],
            ],
        ]);

        ShiftType::create([
            'name' => '全日班',
            'start_time' => '09:00',
            'end_time' => '18:00',
            'is_active' => true,
            'metadata' => [
                'color' => '#27ae60',
                'icon' => 'clock-o',
                'description' => '全日班次',
                'requirements' => [
                    'min_staff' => 1,
                    'max_staff' => 3,
                ],
                'break_rules' => [
                    'lunch_break' => '12:00-13:00',
                    'afternoon_break' => '15:00-15:15',
                ],
            ],
        ]);

        // 建立營業時間設定
        $businessHours = [
            ['day_of_week' => 1, 'open_time' => '08:00', 'close_time' => '21:00', 'is_closed' => false], // 星期一
            ['day_of_week' => 2, 'open_time' => '08:00', 'close_time' => '21:00', 'is_closed' => false], // 星期二
            ['day_of_week' => 3, 'open_time' => '08:00', 'close_time' => '21:00', 'is_closed' => false], // 星期三
            ['day_of_week' => 4, 'open_time' => '08:00', 'close_time' => '21:00', 'is_closed' => false], // 星期四
            ['day_of_week' => 5, 'open_time' => '08:00', 'close_time' => '21:00', 'is_closed' => false], // 星期五
            ['day_of_week' => 6, 'open_time' => '08:00', 'close_time' => '19:30', 'is_closed' => false], // 星期六
            ['day_of_week' => 0, 'open_time' => null, 'close_time' => null, 'is_closed' => true], // 星期日
        ];

        foreach ($businessHours as $hour) {
            BusinessHour::create($hour);
        }

        // 建立休息時間設定
        BreakTime::create([
            'name' => '午休時間',
            'start_time' => '12:00',
            'end_time' => '14:00',
            'is_daily' => true,
            'metadata' => [
                'description' => '每日午休時間',
                'type' => 'lunch',
            ],
        ]);

        BreakTime::create([
            'name' => '下午茶時間',
            'start_time' => '15:00',
            'end_time' => '15:15',
            'is_daily' => false,
            'days_of_week' => [1, 2, 3, 4, 5], // 週一到週五
            'metadata' => [
                'description' => '工作日下午茶時間',
                'type' => 'break',
            ],
        ]);
    }
}
