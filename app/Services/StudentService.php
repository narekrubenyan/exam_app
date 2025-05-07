<?php

namespace App\Services;

use App\Models\Student;

/**
 * Class StudentService.
 */
class StudentService
{
    public function deactivate($studentId, $length = 10): void
    {
        try {
            $student = Student::findOrFail($studentId);

            do {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=';
                $code = substr(str_shuffle(str_repeat($characters, $length)), 0, $length);
            } while (Student::where('login_code', $code)->exists());
    
            $student->update([
                'login_code' => $code,
                'test_id' => null
            ]);
        } catch (\Exception $e) {
            report($e);
        }
       
    }
}
