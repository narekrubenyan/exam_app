<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Services\QuestionService;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\QuestionRequest;
use App\Models\Subcategory;

class QuestionController extends Controller
{
    public function __construct(
        private ?QuestionService $questionService = null,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(FilterRequest $request)
    {
        $data = $request->validated();

        $subcategories = Subcategory::select('id', 'name')->get();


        $query = Question::with('subcategory');

        if ($request->query('category_id')) {
            $query->where('subcategory_id', $request->query('category_id'));
        }

        if ($request->query('table_search')) {
            $query->where('title', 'like', '%' . $request->query('table_search') . '%');
        }

        $questions = $query->orderBy('id', 'desc')->paginate(30)->withQueryString();

        $currentPage = Paginator::resolveCurrentPage();
        if ($currentPage > $questions->lastPage()) {
            return redirect()->route('questions.index', ['page' => 1]);
        }

        return view('dashboard.questions.index', compact('questions', 'subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->get();

        return view('dashboard.questions.create', compact('categories'));
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
        $categories = Category::select('id', 'name')->get();

        return view('dashboard.questions.edit', compact('question', 'categories'));
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
