# WorkNest 排班系統 - 系統結構文檔

## 專案概述
WorkNest 是一個基於 Laravel 12 的企業排班管理系統，整合 Vue.js 前端，提供靈活的班別設定、人員管理和視覺化排班功能。

## 技術架構

### 技術棧
- **後端框架**: Laravel 12
- **前端框架**: Vue.js 3 (整合在 Laravel 中)
- **資料庫**: MariaDB
- **權限管理**: Spatie Laravel Permission
- **認證**: Laravel 內建認證
- **前端構建**: Vite
- **UI 框架**: Element Plus / Ant Design Vue
- **圖表組件**: Vue-Gantt (甘特圖排班視圖)

### 基礎設施
- **Web 服務器**: Nginx
- **容器化**: Docker (可選)
- **快取**: Redis (可選)

## 資料庫設計

### 核心資料表結構

#### 1. 用戶與權限管理 (使用 Spatie Laravel Permission)
```sql
-- 管理員用戶表
users
- id (主鍵)
- name (姓名)
- email (郵箱)
- email_verified_at
- password (密碼)
- status (狀態: active/inactive)
- metadata (JSON, 擴展資料)
- remember_token
- created_at, updated_at

-- Spatie Permission 相關表 (套件自動建立)
roles
- id, name, guard_name, created_at, updated_at

permissions  
- id, name, guard_name, created_at, updated_at

model_has_roles
- role_id, model_type, model_id

model_has_permissions
- permission_id, model_type, model_id

role_has_permissions
- permission_id, role_id
```

#### 2. 組織架構管理
```sql
-- 部門表
departments
- id (主鍵)
- name (部門名稱)
- description (部門描述)
- parent_id (上級部門ID, 支持層級結構)
- status (狀態: active/inactive)
- metadata (JSON, 擴展資料)
- created_at, updated_at

-- 職位表
positions
- id (主鍵)
- name (職位名稱)
- department_id (所屬部門)
- description (職位描述)
- level (職位等級)
- metadata (JSON, 擴展資料)
- created_at, updated_at

-- 員工表
employees
- id (主鍵)
- employee_code (員工編號)
- name (姓名)
- department_id (部門ID)
- position_id (職位ID)
- phone (電話)
- email (郵箱)
- hire_date (入職日期)
- status (狀態: active/inactive/leave)
- notes (備註)
- metadata (JSON, 擴展資料)
- created_at, updated_at
```

#### 3. 班別與時間設定
```sql
-- 班別設定表
shift_types
- id (主鍵)
- name (班別名稱: 早班/中班/晚班)
- start_time (開始時間)
- end_time (結束時間)
- is_active (是否啟用)
- metadata (JSON, 擴展資料: 顏色、圖示、特殊設定等)
- created_at, updated_at

-- 休息時間設定表
break_times
- id (主鍵)
- name (休息時間名稱)
- start_time (開始時間)
- end_time (結束時間)
- is_daily (是否每日)
- days_of_week (適用星期, JSON格式)
- metadata (JSON, 擴展資料)
- created_at, updated_at

-- 營業時間設定表
business_hours
- id (主鍵)
- day_of_week (星期幾: 0-6)
- open_time (營業開始時間)
- close_time (營業結束時間)
- is_closed (是否休息日)
- metadata (JSON, 擴展資料)
- created_at, updated_at
```

#### 4. 排班核心功能
```sql
-- 排班計劃表 (月度排班)
schedule_plans
- id (主鍵)
- name (排班計劃名稱)
- year (年份)
- month (月份)
- status (狀態: draft/published/archived)
- created_by (創建者)
- published_at (發布時間)
- metadata (JSON, 擴展資料)
- created_at, updated_at

-- 排班明細表 (具體排班記錄)
schedule_details
- id (主鍵)
- schedule_plan_id (排班計劃ID)
- employee_id (員工ID)
- shift_date (排班日期)
- shift_type_id (班別ID)
- start_time (實際開始時間)
- end_time (實際結束時間)
- duration_minutes (工作時長分鐘)
- notes (備註)
- metadata (JSON, 擴展資料)
- created_at, updated_at

-- 排班時間段表 (支持一個班次多個時間段)
schedule_time_slots
- id (主鍵)
- schedule_detail_id (排班明細ID)
- start_time (時間段開始)
- end_time (時間段結束)
- metadata (JSON, 擴展資料)
- created_at, updated_at
```

## 專案目錄結構

### Laravel 整合專案結構
```
/home/user/SideProjects/worknest/app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── UserController.php
│   │   │   │   └── RoleController.php
│   │   │   ├── Organization/
│   │   │   │   ├── DepartmentController.php
│   │   │   │   ├── PositionController.php
│   │   │   │   └── EmployeeController.php
│   │   │   ├── Schedule/
│   │   │   │   ├── ShiftTypeController.php
│   │   │   │   ├── BusinessHourController.php
│   │   │   │   ├── SchedulePlanController.php
│   │   │   │   └── ScheduleDetailController.php
│   │   │   └── DashboardController.php
│   │   ├── Middleware/
│   │   │   ├── CheckRole.php
│   │   │   └── CheckPermission.php
│   │   ├── Requests/
│   │   │   ├── Employee/
│   │   │   ├── Schedule/
│   │   │   └── Organization/
│   │   └── Resources/
│   │       ├── EmployeeResource.php
│   │       ├── ScheduleResource.php
│   │       └── DepartmentResource.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Department.php
│   │   ├── Position.php
│   │   ├── Employee.php
│   │   ├── ShiftType.php
│   │   ├── BusinessHour.php
│   │   ├── BreakTime.php
│   │   ├── SchedulePlan.php
│   │   ├── ScheduleDetail.php
│   │   └── ScheduleTimeSlot.php
│   ├── Services/
│   │   ├── AuthService.php
│   │   ├── EmployeeService.php
│   │   ├── ScheduleService.php
│   │   └── ReportService.php
│   └── Repositories/
│       ├── EmployeeRepository.php
│       ├── ScheduleRepository.php
│       └── DepartmentRepository.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000000_create_users_table.php
│   │   ├── 2024_01_02_000000_create_permission_tables.php
│   │   ├── 2024_01_03_000000_create_departments_table.php
│   │   ├── 2024_01_04_000000_create_positions_table.php
│   │   ├── 2024_01_05_000000_create_employees_table.php
│   │   ├── 2024_01_06_000000_create_shift_types_table.php
│   │   ├── 2024_01_07_000000_create_business_hours_table.php
│   │   ├── 2024_01_08_000000_create_break_times_table.php
│   │   ├── 2024_01_09_000000_create_schedule_plans_table.php
│   │   ├── 2024_01_10_000000_create_schedule_details_table.php
│   │   └── 2024_01_11_000000_create_schedule_time_slots_table.php
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── UserSeeder.php
│   │   ├── RolePermissionSeeder.php
│   │   ├── DepartmentSeeder.php
│   │   └── ShiftTypeSeeder.php
│   └── factories/
│       ├── UserFactory.php
│       ├── EmployeeFactory.php
│       └── ScheduleFactory.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   └── auth.blade.php
│   │   ├── auth/
│   │   │   ├── login.blade.php
│   │   │   └── register.blade.php
│   │   ├── dashboard/
│   │   │   └── index.blade.php
│   │   ├── schedule/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   └── edit.blade.php
│   │   ├── employee/
│   │   │   ├── index.blade.php
│   │   │   └── manage.blade.php
│   │   └── settings/
│   │       ├── shifts.blade.php
│   │       ├── business-hours.blade.php
│   │       └── system.blade.php
│   ├── js/
│   │   ├── components/
│   │   │   ├── common/
│   │   │   │   ├── Layout.vue
│   │   │   │   ├── Sidebar.vue
│   │   │   │   └── Header.vue
│   │   │   ├── schedule/
│   │   │   │   ├── ScheduleCalendar.vue
│   │   │   │   ├── ScheduleGantt.vue
│   │   │   │   ├── ShiftEditor.vue
│   │   │   │   └── TimeSlotPicker.vue
│   │   │   ├── employee/
│   │   │   │   ├── EmployeeList.vue
│   │   │   │   ├── EmployeeForm.vue
│   │   │   │   └── EmployeeCard.vue
│   │   │   └── organization/
│   │   │       ├── DepartmentTree.vue
│   │   │       └── PositionManager.vue
│   │   ├── pages/
│   │   │   ├── Dashboard.vue
│   │   │   ├── ScheduleIndex.vue
│   │   │   ├── EmployeeIndex.vue
│   │   │   └── Settings.vue
│   │   ├── stores/
│   │   │   ├── auth.js
│   │   │   ├── employee.js
│   │   │   ├── schedule.js
│   │   │   └── settings.js
│   │   ├── services/
│   │   │   ├── api.js
│   │   │   ├── auth.js
│   │   │   ├── employee.js
│   │   │   └── schedule.js
│   │   ├── utils/
│   │   │   ├── date.js
│   │   │   ├── time.js
│   │   │   └── validation.js
│   │   └── app.js
│   ├── css/
│   │   └── app.css
│   └── sass/
│       └── app.scss
├── routes/
│   ├── web.php
│   └── api.php
├── config/
│   ├── permission.php
│   └── app.php
├── public/
├── storage/
├── tests/
├── vendor/
├── .env
├── composer.json
├── package.json
├── vite.config.js
└── artisan
```

## 核心功能模組

### 1. 認證與權限管理模組 (使用 Spatie Laravel Permission)
- 管理員登入/登出
- 角色管理 (超級管理員、部門主管、HR等)
- 權限分配 (查看排班、編輯排班、管理員工等)
- 用戶管理

### 2. 組織架構管理模組
- 部門層級管理 (支持多層級結構)
- 職位設定與管理
- 員工資料管理 (含 metadata 擴展欄位)
- 員工狀態追蹤

### 3. 班別設定模組
- 自定義班別時間
- 營業時間設定 (每日可不同)
- 休息時間配置 (支持複雜規則)
- metadata 支持顏色、圖示等擴展設定

### 4. 排班核心模組 (重點)
- 月度排班計劃建立與管理
- 甘特圖式排班界面
- 拖拽式時間調整
- 半小時為單位的精確排班
- 多人同班次支持 (時間段分割)
- 排班衝突檢測與警告
- 排班狀態管理 (草稿/已發布/已歸檔)

### 5. 報表與統計模組
- 員工工時統計
- 班別分布報表
- 排班完成度分析
- 部門工時分析

## Metadata 設計規範

### 各表 metadata 欄位用途說明

#### users.metadata
```json
{
  "avatar": "path/to/avatar.jpg",
  "preferences": {
    "theme": "dark",
    "language": "zh-TW"
  },
  "contact": {
    "phone": "+886-xxx-xxx-xxx",
    "emergency_contact": "xxx"
  }
}
```

#### departments.metadata
```json
{
  "color": "#3498db",
  "icon": "department-icon",
  "location": "3F-A區",
  "manager_id": 123,
  "budget": 1000000
}
```

#### employees.metadata
```json
{
  "avatar": "path/to/avatar.jpg",
  "skills": ["PHP", "Vue.js", "管理"],
  "certifications": ["勞安證照"],
  "emergency_contact": {
    "name": "緊急聯絡人",
    "phone": "+886-xxx-xxx-xxx"
  },
  "work_preferences": {
    "preferred_shifts": ["morning", "afternoon"],
    "unavailable_days": [0, 6]
  }
}
```

#### shift_types.metadata
```json
{
  "color": "#e74c3c",
  "icon": "morning-icon",
  "description": "早班詳細說明",
  "requirements": {
    "min_staff": 2,
    "max_staff": 5,
    "required_skills": ["收銀", "清潔"]
  },
  "break_rules": {
    "break_duration": 30,
    "break_times": ["10:00", "15:00"]
  }
}
```

#### schedule_plans.metadata
```json
{
  "template_id": 123,
  "approval_status": "pending",
  "approver_id": 456,
  "notes": "特殊節日排班",
  "statistics": {
    "total_hours": 2400,
    "total_staff": 50,
    "coverage_rate": 0.95
  }
}
```

#### schedule_details.metadata
```json
{
  "overtime": true,
  "overtime_hours": 2,
  "replacement_for": 789,
  "special_notes": "代班",
  "cost_center": "A001",
  "performance_bonus": 500
}
```

## 路由設計

### Web 路由 (routes/web.php)
```php
// 認證路由
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // 儀表板
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // 員工管理
    Route::middleware('permission:manage-employees')->group(function () {
        Route::resource('employees', EmployeeController::class);
    });
    
    // 排班管理
    Route::middleware('permission:manage-schedules')->group(function () {
        Route::resource('schedules', SchedulePlanController::class);
        Route::post('schedules/{schedule}/publish', [SchedulePlanController::class, 'publish']);
    });
    
    // 系統設定
    Route::middleware('permission:manage-settings')->group(function () {
        Route::resource('departments', DepartmentController::class);
        Route::resource('positions', PositionController::class);
        Route::resource('shift-types', ShiftTypeController::class);
        Route::resource('business-hours', BusinessHourController::class);
    });
    
    // 用戶管理
    Route::middleware('permission:manage-users')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
    });
});
```

### API 路由 (routes/api.php)
```php
Route::middleware('auth:sanctum')->group(function () {
    // 員工 API
    Route::apiResource('employees', EmployeeController::class);
    
    // 排班 API
    Route::apiResource('schedules', SchedulePlanController::class);
    Route::get('schedules/{schedule}/gantt', [SchedulePlanController::class, 'getGanttData']);
    Route::post('schedules/batch-update', [ScheduleDetailController::class, 'batchUpdate']);
    
    // 班別設定 API
    Route::apiResource('shift-types', ShiftTypeController::class);
    Route::apiResource('business-hours', BusinessHourController::class);
    
    // 組織架構 API
    Route::apiResource('departments', DepartmentController::class);
    Route::apiResource('positions', PositionController::class);
});
```

## 開發階段規劃

### Phase 1: 專案初始化與基礎架構 (1-2週)
1. Laravel 專案建立與環境設定
2. 安裝 spatie/laravel-permission
3. 資料庫遷移檔案建立
4. 基礎 Model 建立 (含 metadata 支持)
5. 認證系統實作
6. 基礎權限設定

### Phase 2: 組織管理功能 (1-2週)
1. 部門管理 CRUD (支持層級結構)
2. 職位管理功能
3. 員工管理功能 (含 metadata 擴展)
4. 權限控制實作
5. 基礎 Vue 組件開發

### Phase 3: 班別與時間設定 (1週)
1. 班別類型管理 (含 metadata 設定)
2. 營業時間設定功能
3. 休息時間配置
4. 前端設定界面開發

### Phase 4: 排班核心功能 (3-4週) - 重點階段
1. 排班計劃 CRUD 功能
2. 甘特圖組件整合與開發
3. 拖拽排班功能實作
4. 時間衝突檢測邏輯
5. 多人同班次時間段分割
6. 排班狀態管理
7. 批量操作功能

### Phase 5: 優化與完善 (1-2週)
1. 報表功能開發
2. 性能優化 (查詢優化、快取)
3. 用戶體驗改善
4. 測試與 Bug 修復
5. 部署準備

## 技術重點與挑戰

### 1. Metadata JSON 欄位處理
- Laravel Model 中使用 `$casts` 自動轉換
- 前端 Vue 組件動態渲染 metadata 內容
- 搜尋與篩選 JSON 欄位的優化

### 2. 甘特圖排班界面
- Vue-Gantt 組件整合或自定義開發
- 支持拖拽調整時間
- 半小時精度的時間控制
- 多人同時段排班的視覺化顯示
- 即時衝突檢測與提示

### 3. 複雜時間計算邏輯
- 時間重疊檢測算法
- 跨日班次處理
- 工時統計與加班計算
- 休息時間自動扣除

### 4. 權限控制整合
- Spatie Permission 與 Vue 前端整合
- 動態權限檢查
- 角色基礎的功能顯示/隱藏

### 5. 資料庫性能優化
- 大量排班資料的查詢優化
- JSON 欄位索引策略
- 適當的資料庫索引設計
- 分頁與快取策略

## 必要套件清單

### Composer 套件
```json
{
  "spatie/laravel-permission": "^6.0",
  "laravel/sanctum": "^4.0",
  "spatie/laravel-query-builder": "^5.0"
}
```

### NPM 套件
```json
{
  "vue": "^3.3.0",
  "@vitejs/plugin-vue": "^4.0.0",
  "element-plus": "^2.4.0",
  "vue-gantt": "^1.0.0",
  "axios": "^1.6.0",
  "pinia": "^2.1.0",
  "vue-router": "^4.2.0"
}
```

這個調整後的結構文檔整合了你的需求：
- 統一的 Laravel 專案結構 (不分離前後端)
- 使用 spatie/laravel-permission 處理權限
- 所有資料表都加入 metadata JSON 欄位
- 移除班別的 color 欄位，改用 metadata 存儲
- 完整的開發階段規劃和技術挑戰分析

這樣的結構更適合快速開發，同時保持了足夠的靈活性來應對未來的需求變化。
