<?php

namespace App\Services;

use App\Models\Question;
use App\Repositories\QuestionRepository;

/**
 * Class QuestionService.
 */
class QuestionService
{
    public function __construct(
        private ?QuestionRepository $questionRepository = null
    ) {}

    public function create($data)
    {
        return $this->questionRepository->create($data);
    }

    public function update($question, $data)
    {
        return $this->questionRepository->update($question, $data);
    }

    public function delete($id)
    {
        return $this->questionRepository->delete($id);
    }
}
