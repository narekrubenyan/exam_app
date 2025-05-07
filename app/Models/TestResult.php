<?php

namespace App\Models;

use App\Models\Student;
use App\Models\TestResultAnswer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'category', 'option', 'score'];

    /**
     * Get the student that owns the TestResult
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get all of the answers for the TestResult
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(TestResultAnswer::class);
    }
}
