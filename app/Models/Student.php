<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use Filterable;
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ['name', 'surname', 'login_code', 'test_id'];

    /**
     * Get the test that owns the Student
     *
     * @return BelongsTo
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }
}
