<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Position;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // 建立部門
        $management = Department::create([
            'name' => '管理部',
            'description' => '公司管理階層',
            'status' => 'active',
            'metadata' => [
                'color' => '#e74c3c',
                'icon' => 'management',
                'location' => '3F-A區',
            ],
        ]);

        $hr = Department::create([
            'name' => '人事部',
            'description' => '人力資源管理',
            'status' => 'active',
            'metadata' => [
                'color' => '#3498db',
                'icon' => 'users',
                'location' => '2F-B區',
            ],
        ]);

        $sales = Department::create([
            'name' => '業務部',
            'description' => '業務推廣與客戶服務',
            'status' => 'active',
            'metadata' => [
                'color' => '#2ecc71',
                'icon' => 'chart-line',
                'location' => '1F-A區',
            ],
        ]);

        $tech = Department::create([
            'name' => '技術部',
            'description' => '技術開發與維護',
            'status' => 'active',
            'metadata' => [
                'color' => '#9b59b6',
                'icon' => 'code',
                'location' => '4F-全層',
            ],
        ]);

        // 建立職位
        // 管理部職位
        Position::create([
            'name' => '總經理',
            'department_id' => $management->id,
            'description' => '公司最高管理者',
            'level' => 10,
        ]);

        Position::create([
            'name' => '副總經理',
            'department_id' => $management->id,
            'description' => '協助總經理管理公司',
            'level' => 9,
        ]);

        // 人事部職位
        Position::create([
            'name' => '人事經理',
            'department_id' => $hr->id,
            'description' => '人事部門主管',
            'level' => 7,
        ]);

        Position::create([
            'name' => '人事專員',
            'department_id' => $hr->id,
            'description' => '人事相關業務處理',
            'level' => 5,
        ]);

        // 業務部職位
        Position::create([
            'name' => '業務經理',
            'department_id' => $sales->id,
            'description' => '業務部門主管',
            'level' => 7,
        ]);

        Position::create([
            'name' => '業務專員',
            'department_id' => $sales->id,
            'description' => '業務推廣與客戶維護',
            'level' => 5,
        ]);

        // 技術部職位
        Position::create([
            'name' => '技術經理',
            'department_id' => $tech->id,
            'description' => '技術部門主管',
            'level' => 8,
        ]);

        Position::create([
            'name' => '資深工程師',
            'department_id' => $tech->id,
            'description' => '資深技術開發人員',
            'level' => 6,
        ]);

        Position::create([
            'name' => '工程師',
            'department_id' => $tech->id,
            'description' => '技術開發人員',
            'level' => 5,
        ]);

        Position::create([
            'name' => '初級工程師',
            'department_id' => $tech->id,
            'description' => '初級技術開發人員',
            'level' => 3,
        ]);
    }
}
