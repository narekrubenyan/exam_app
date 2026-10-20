<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Filters\QuestionFilter;
use App\Http\Requests\Question\FilterQuestionRequest;
use App\Http\Requests\Question\StoreQuestionRequest;
use App\Models\Category;
use App\Models\Question;
use App\Models\Subcategory;
use App\Services\QuestionService;

class QuestionController extends Controller
{
    public function __construct(
        private ?QuestionService $questionService = null,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(FilterQuestionRequest $request)
    {
        $data = $request->validated();

        $subcategories = Subcategory::select('id', 'name')->get();

        $filter = app()->make(QuestionFilter::class, ['queryParams' => array_filter($data)]);

        $questions = Question::filter($filter)->latest()->paginate(30);

        return view('dashboard.questions.index', compact('questions', 'subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $subcategories = Subcategory::select('id', 'name', 'category_id')->get();

        return view('dashboard.questions.create', compact('categories', 'subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
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
        $categories = Category::select('id', 'name')->get();
        $subcategories = Subcategory::select('id', 'name', 'category_id')->get();


        return view('dashboard.questions.edit', compact('question', 'categories', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreQuestionRequest $request, Question $question)
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
