<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // 建立權限
        $permissions = [
            // 用戶管理
            'manage-users',
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            
            // 角色權限管理
            'manage-roles',
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',
            
            // 部門管理
            'manage-departments',
            'view-departments',
            'create-departments',
            'edit-departments',
            'delete-departments',
            
            // 員工管理
            'manage-employees',
            'view-employees',
            'create-employees',
            'edit-employees',
            'delete-employees',
            
            // 排班管理
            'manage-schedules',
            'view-schedules',
            'create-schedules',
            'edit-schedules',
            'delete-schedules',
            'publish-schedules',
            
            // 系統設定
            'manage-settings',
            'view-settings',
            'edit-shift-types',
            'edit-business-hours',
            
            // 報表
            'view-reports',
            'export-reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // 建立角色
        $superAdmin = Role::create(['name' => 'super-admin']);
        $admin = Role::create(['name' => 'admin']);
        $manager = Role::create(['name' => 'manager']);
        $hr = Role::create(['name' => 'hr']);
        $employee = Role::create(['name' => 'employee']);

        // 分配權限給角色
        // 超級管理員擁有所有權限
        $superAdmin->givePermissionTo(Permission::all());

        // 管理員權限
        $admin->givePermissionTo([
            'view-users', 'create-users', 'edit-users',
            'manage-departments', 'view-departments', 'create-departments', 'edit-departments',
            'manage-employees', 'view-employees', 'create-employees', 'edit-employees',
            'manage-schedules', 'view-schedules', 'create-schedules', 'edit-schedules', 'publish-schedules',
            'view-settings', 'edit-shift-types', 'edit-business-hours',
            'view-reports', 'export-reports',
        ]);

        // 部門主管權限
        $manager->givePermissionTo([
            'view-departments',
            'view-employees', 'edit-employees',
            'manage-schedules', 'view-schedules', 'create-schedules', 'edit-schedules',
            'view-reports',
        ]);

        // HR 權限
        $hr->givePermissionTo([
            'view-departments',
            'manage-employees', 'view-employees', 'create-employees', 'edit-employees',
            'view-schedules', 'create-schedules', 'edit-schedules',
            'view-reports',
        ]);

        // 一般員工權限
        $employee->givePermissionTo([
            'view-schedules',
        ]);

        // 建立預設超級管理員用戶
        $superUser = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@worknest.com',
            'password' => bcrypt('password'),
            'status' => 'active',
        ]);

        $superUser->assignRole('super-admin');
    }
}
