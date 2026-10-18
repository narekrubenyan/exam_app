<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class StudentFilter extends AbstractFilter
{
    const NAME = 'name';

    protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, 'name']
        ];
    }

    public function name(Builder $builder, $value)
    {
        $builder->where(function ($query) use ($value) {
            $query->where('name', 'like', "%$value%")
                ->orWhere('surname', 'like', "%$value%");
        });;
    }
}
