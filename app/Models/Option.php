<?php

namespace App\Models;

use App\Models\Test;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

    /**
     * Get all of the tests for the TestOption
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }
}
