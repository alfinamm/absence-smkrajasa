<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PermissionsRoleUserSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['name' => 'Akun Pengguna', 'description' => 'Melihat akun pengguna', 'action' => 'read', 'subject' => 'user'],
            ['name' => 'Akun Pengguna', 'description' => 'Membuat akun pengguna', 'action' => 'create', 'subject' => 'user'],
            ['name' => 'Akun Pengguna', 'description' => 'Mengubah akun pengguna', 'action' => 'update', 'subject' => 'user'],
            ['name' => 'Akun Pengguna', 'description' => 'Menghapus akun pengguna', 'action' => 'delete', 'subject' => 'user'],

            ['name' => 'Peran', 'description' => 'Melihat peran', 'action' => 'read', 'subject' => 'role'],
            ['name' => 'Peran', 'description' => 'Membuat peran', 'action' => 'create', 'subject' => 'role'],
            ['name' => 'Peran', 'description' => 'Mengubah peran', 'action' => 'update', 'subject' => 'role'],
            ['name' => 'Peran', 'description' => 'Menghapus peran', 'action' => 'delete', 'subject' => 'role'],

            ['name' => 'Izin', 'description' => 'Melihat izin', 'action' => 'read', 'subject' => 'permission'],

            ['name' => 'Tahun Ajaran', 'description' => 'Melihat tahun ajaran', 'action' => 'read', 'subject' => 'academic_year'],
            ['name' => 'Tahun Ajaran', 'description' => 'Membuat tahun ajaran', 'action' => 'create', 'subject' => 'academic_year'],
            ['name' => 'Tahun Ajaran', 'description' => 'Mengubah tahun ajaran', 'action' => 'update', 'subject' => 'academic_year'],
            ['name' => 'Tahun Ajaran', 'description' => 'Menghapus tahun ajaran', 'action' => 'delete', 'subject' => 'academic_year'],

            ['name' => 'Kelas', 'description' => 'Melihat kelas', 'action' => 'read', 'subject' => 'class'],
            ['name' => 'Kelas', 'description' => 'Membuat kelas', 'action' => 'create', 'subject' => 'class'],
            ['name' => 'Kelas', 'description' => 'Mengubah kelas', 'action' => 'update', 'subject' => 'class'],
            ['name' => 'Kelas', 'description' => 'Menghapus kelas', 'action' => 'delete', 'subject' => 'class'],

            ['name' => 'Siswa', 'description' => 'Melihat siswa', 'action' => 'read', 'subject' => 'student'],
            ['name' => 'Siswa', 'description' => 'Membuat siswa', 'action' => 'create', 'subject' => 'student'],
            ['name' => 'Siswa', 'description' => 'Mengubah siswa', 'action' => 'update', 'subject' => 'student'],
            ['name' => 'Siswa', 'description' => 'Menghapus siswa', 'action' => 'delete', 'subject' => 'student'],

            ['name' => 'Absensi Siswa', 'description' => 'Melihat absensi siswa', 'action' => 'read', 'subject' => 'student_attendance'],
            ['name' => 'Absensi Siswa', 'description' => 'Membuat absensi siswa', 'action' => 'create', 'subject' => 'student_attendance'],
            ['name' => 'Absensi Siswa', 'description' => 'Mengubah absensi siswa', 'action' => 'update', 'subject' => 'student_attendance'],
            ['name' => 'Absensi Siswa', 'description' => 'Menghapus absensi siswa', 'action' => 'delete', 'subject' => 'student_attendance'],

            ['name' => 'Absensi Siswa By Id', 'description' => 'Melihat absensi siswa berdasarkan id', 'action' => 'read', 'subject' => 'student_attendance_ById'],

            ['name' => 'Pegawai', 'description' => 'Melihat pegawai', 'action' => 'read', 'subject' => 'employee'],
            ['name' => 'Pegawai', 'description' => 'Membuat pegawai', 'action' => 'create', 'subject' => 'employee'],
            ['name' => 'Pegawai', 'description' => 'Mengubah pegawai', 'action' => 'update', 'subject' => 'employee'],
            ['name' => 'Pegawai', 'description' => 'Menghapus pegawai', 'action' => 'delete', 'subject' => 'employee'],
        ];
        $roles = [
            ['name' => 'Admin', 'description' => 'Peran administrator dengan izin penuh', 'subject' => 'admin'],
            ['name' => 'Teacher', 'description' => 'Peran Guru Pengajar', 'subject' => 'teacher'],
            ['name' => 'Viewer', 'description' => 'Peran penonton dengan izin untuk kehadiran siswa saja', 'subject' => 'viewer'],
        ];

        // Create permissions
        foreach ($permissions as $permissionData) {
            Permission::create($permissionData);
        }

        // Create roles and assign permissions
        foreach ($roles as $roleData) {
            $role = Role::create($roleData);
            if ($role->subject == 'admin') {
                // Assign all permissions to Admin role
                $role->permissions()->attach(Permission::all());
                User::query()->upsert([
                    'name' => 'Admin',
                    'email' => 'admin@absence.com',
                    'password' => Hash::make('12345678'),
                    'role_id' => $role->id,
                    'email_verified_at' => now(),

                ], ['email'], ['role_id', 'name']);
            } elseif ($role->subject == 'teacher') {
                // Assign specific permissions to Teacher role
                $teacherPermissions = Permission::where(function ($query) {
                    $query->where('subject', 'student')
                        ->where('action', 'read');
                })->orWhere(function ($query) {
                    $query->where('subject', 'student_attendance')
                        ->whereIn('action', ['read', 'update']);
                })->get();
                $role->permissions()->attach($teacherPermissions);
                User::query()->upsert([
                    'name' => 'Guru',
                    'email' => 'guru@absence.com',
                    'password' => Hash::make('12345678'),
                    'role_id' => $role->id,
                    'email_verified_at' => now(),
                ], ['email'], ['role_id', 'name']);
            } elseif ($role->subject == 'viewer') {
                // Assign specific permissions to Viewer role
                $viewerPermissions = Permission::where(function ($query) {
                    $query->where('subject', 'student')
                        ->where('action', 'read');
                })->orWhere(function ($query) {
                    $query->where('subject', 'student_attendance_ById')
                        ->whereIn('action', ['read']);
                })->get();
                $role->permissions()->attach($viewerPermissions);
                User::query()->upsert([
                    'name' => 'Wali Murid',
                    'email' => 'wali@absence.com',
                    'password' => Hash::make('12345678'),
                    'role_id' => $role->id,
                    'email_verified_at' => now(),
                ], ['email'], ['role_id', 'name']);
            }
        }
    }
}
