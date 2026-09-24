<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Web Guard Permissions (Superadmin / Admin Panel)
        $webPermissions = [
            'Academic - Subject' => [
                'academic.subject.view',
                'academic.subject.create',
                'academic.subject.edit',
                'academic.subject.delete',
            ],
            'Academic - Class' => [
                'academic.class.view',
                'academic.class.create',
                'academic.class.edit',
                'academic.class.delete',
            ],
            'Academic - Section' => [
                'academic.section.view',
                'academic.section.create',
                'academic.section.edit',
                'academic.section.delete',
            ],
            'Academic - Syllabus' => [
                'academic.syllabus.view',
                'academic.syllabus.create',
                'academic.syllabus.edit',
                'academic.syllabus.delete',
                'academic.syllabus.download',
            ],
            'Academic - Assignment' => [
                'academic.assignment.view',
                'academic.assignment.create',
                'academic.assignment.edit',
                'academic.assignment.delete',
            ],
            'User Management - Designation' => [
                'user.designation.view',
                'user.designation.create',
                'user.designation.delete',
            ],
            'User Management - Employee' => [
                'user.employee.view',
                'user.employee.create',
                'user.employee.edit',
                'user.employee.delete',
            ],
            'User Management - Student' => [
                'user.student.view',
                'user.student.create',
                'user.student.edit',
                'user.student.delete',
            ],
            'TimeTable' => [
                'timetable.view',
                'timetable.create',
                'timetable.edit',
                'timetable.delete',
            ],
            'Attendance' => [
                'attendance.employee.view',
                'attendance.employee.create',
                'attendance.student.view',
                'attendance.student.create',
            ],
            'Exam' => [
                'exam.view',
                'exam.create',
                'exam.edit',
                'exam.delete',
                'exam.schedule.view',
                'exam.schedule.create',
                'exam.schedule.edit',
                'exam.schedule.delete',
                'exam.result.view',
                'exam.result.create',
                'exam.result.edit',
                'exam.result.delete',
            ],
            'Student Payment' => [
                'payment.category.view',
                'payment.category.create',
                'payment.category.edit',
                'payment.category.delete',
                'payment.transaction.view',
                'payment.transaction.create',
                'payment.transaction.edit',
                'payment.transaction.delete',
                'payment.fee.view',
                'payment.fee.receive',
                'payment.tax.view',
                'payment.tax.create',
            ],
            'Finance Management' => [
                'finance.record.view',
                'finance.record.create',
                'finance.record.edit',
                'finance.record.delete',
                'finance.salary.view',
                'finance.salary.pay',
                'finance.salary.pdf',
            ],
            'Inventory' => [
                'inventory.category.view',
                'inventory.category.create',
                'inventory.category.delete',
                'inventory.subcategory.view',
                'inventory.subcategory.create',
                'inventory.subcategory.delete',
                'inventory.expense.view',
                'inventory.expense.create',
                'inventory.expense.edit',
                'inventory.expense.delete',
            ],
            'Reports' => [
                'report.admission.view',
                'report.result.view',
            ],
            'General & Notifications' => [
                'history.view',
                'notification.view',
                'notification.send',
                'balance_sheet.view',
            ],
        ];

        foreach ($webPermissions as $group => $permissions) {
            foreach ($permissions as $permissionName) {
                Permission::updateOrCreate(
                    ['name' => $permissionName, 'guard_name' => 'web'],
                    ['group_name' => $group]
                );
            }
        }

        // Create Super Admin role for web guard and assign all web permissions
        $superadminRole = Role::updateOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $superadminRole->syncPermissions(Permission::where('guard_name', 'web')->get());

        // 2. Employee Guard Permissions & Role
        $employeePermissions = [
            'Employee Portal' => [
                'employee.dashboard.view',
                'employee.profile.view',
                'employee.timetable.view',
                'employee.attendance.view',
                'employee.incentives.view',
                'employee.notifications.view',
                'employee.exam.manage',
                'employee.exam_schedule.manage',
                'employee.datesheet.manage',
                'employee.result.manage',
                'employee.assignment.manage',
                'employee.syllabus.manage',
            ],
        ];

        foreach ($employeePermissions as $group => $permissions) {
            foreach ($permissions as $permissionName) {
                Permission::updateOrCreate(
                    ['name' => $permissionName, 'guard_name' => 'employee'],
                    ['group_name' => $group]
                );
            }
        }

        $employeeRole = Role::updateOrCreate(['name' => 'employee', 'guard_name' => 'employee']);
        $employeeRole->syncPermissions(Permission::where('guard_name', 'employee')->get());

        // 3. Student Guard Permissions & Role
        $studentPermissions = [
            'Student Portal' => [
                'student.dashboard.view',
                'student.profile.view',
                'student.timetable.view',
                'student.attendance.view',
                'student.result.view',
                'student.fee.view',
                'student.notifications.view',
                'student.history.view',
            ],
        ];

        foreach ($studentPermissions as $group => $permissions) {
            foreach ($permissions as $permissionName) {
                Permission::updateOrCreate(
                    ['name' => $permissionName, 'guard_name' => 'student'],
                    ['group_name' => $group]
                );
            }
        }

        $studentRole = Role::updateOrCreate(['name' => 'student', 'guard_name' => 'student']);
        $studentRole->syncPermissions(Permission::where('guard_name', 'student')->get());

        // Assign superadmin role to superadmin user
        $superadminUser = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'usertype' => 'superadmin',
                'password' => Hash::make('password'),
            ]
        );
        $superadminUser->assignRole($superadminRole);
    }
}
