<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Services\QuestionService;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\QuestionRequest;

class QuestionController extends Controller
{
    public function __construct(
        private ?QuestionService $questionService = null,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::paginate(30);

        $currentPage = Paginator::resolveCurrentPage();
        if ($currentPage > $questions->lastPage()) {
            return redirect()->route('questions.index', ['page' => 1]);
        }

        return view('dashboard.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionRequest $request)
    {
        $data = $request->validated();

        $this->questionService->create($data);

        return redirect()->route('questions.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $question = Question::with('answers', 'statements')->find($id);

        return view('dashboard.questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionRequest $request, Question $question)
    {
        $data = $request->validated();

        $this->questionService->update($question, $data);

        return redirect()->route('questions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->questionService->delete($id);

        return redirect()->route('questions.index');
    }
}
