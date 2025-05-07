<?php

namespace App\Services;

use App\Models\Student;

/**
 * Class StudentService.
 */
class StudentService
{
    public function updateLoginCode($studentId, $length = 10): void
    {
        try {
            $student = Student::findOrFail($studentId);

            do {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=';
                $code = substr(str_shuffle(str_repeat($characters, $length)), 0, $length);
            } while (Student::where('student_code', $code)->exists());
    
            $student->update([
                'student_code' => $code,
            ]);
        } catch (\Exception $e) {
            report($e);
        }
       
    }
}
