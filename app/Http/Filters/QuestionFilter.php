<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class QuestionFilter extends AbstractFilter
{
    const TITLE = 'title';
    const CATEGORY = 'category';

    protected function getCallbacks(): array
    {
        return [
            self::TITLE => [$this, 'title'],
            self::CATEGORY => [$this, 'category'],
        ];
    }

    public function title(Builder $builder, $value)
    {
        $builder->where('title', 'like', "%$value%");
    }

    public function category(Builder $builder, $value)
    {
        $builder->where('category_id', $value);
    }
}
