<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'username')) {
                $table->string('username')->nullable()->unique()->after('registration');
            }
            if (!Schema::hasColumn('students', 'password')) {
                $table->string('password')->nullable()->after('username');
            }
        });

        // Populate existing students with username and hashed default password
        $students = DB::table('students')->get();
        foreach ($students as $student) {
            $username = $student->username;
            if (empty($username)) {
                $username = !empty($student->registration) 
                    ? strtolower(str_replace([' ', '-', '/'], '_', $student->registration)) 
                    : 'student_' . $student->id;
                
                // Ensure unique username
                $base = $username;
                $i = 1;
                while (DB::table('students')->where('username', $username)->where('id', '<>', $student->id)->exists()) {
                    $username = $base . '_' . $i++;
                }
            }

            $password = $student->password;
            if (empty($password)) {
                $defaultPass = !empty($student->registration) ? $student->registration : '123456';
                $password = Hash::make($defaultPass);
            }

            DB::table('students')->where('id', $student->id)->update([
                'username' => $username,
                'password' => $password,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'password')) {
                $table->dropColumn('password');
            }
            if (Schema::hasColumn('students', 'username')) {
                $table->dropColumn('username');
            }
        });
    }
};
