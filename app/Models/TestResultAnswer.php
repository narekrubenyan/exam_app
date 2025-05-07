<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResultAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_result_id',
        'question_title',
        'statements',
        'possible_answers',
        'correct_answer',
        'selected_answer',
        'is_correct',
    ];

    protected $casts = [
        'statements' => 'array',
        'possible_answers' => 'array',
    ];
}
