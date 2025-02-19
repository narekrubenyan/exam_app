<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ['title'];

    /**
     * Get all of the answers for the Question
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Get all of the statements for the Question
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statements(): HasMany
    {
        return $this->hasMany(Statement::class);
    }

    /**
     * The tests that belong to the Question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tests(): BelongsToMany
    {
        return $this->belongsToMany(Test::class, 'test_questions', 'question_id', 'test_id');
    }
}
