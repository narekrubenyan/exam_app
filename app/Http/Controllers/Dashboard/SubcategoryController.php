<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Models\Subcategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\SubcategoryRequest;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FilterRequest $request)
    {
        $data = $request->validated();

        $categories = Category::select('id', 'name')->get();

        $query = Subcategory::with('category');

        if ($request->query('category_id')) {
            $query->where('category_id', $request->query('category_id'));
        }

        if ($request->query('table_search')) {
            $query->where('name', 'like', '%' . $request->query('table_search') . '%');
        }

        $subcategories = $query->paginate(30)->withQueryString();

        $currentPage = Paginator::resolveCurrentPage();
        if ($currentPage > $subcategories->lastPage() && $subcategories->lastPage() > 0) {
            return redirect()->route('subcategories.index', ['page' => 1]);
        }

        return view('dashboard.subcategories.index', compact('subcategories', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('dashboard.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubcategoryRequest $request)
    {
        $data = $request->validated();

        Subcategory::create($data);

        return redirect()->route('subcategories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $subcategory = Subcategory::findOrFail($id);

        return view('dashboard.subcategories.edit', compact('categories', 'subcategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubcategoryRequest $request, string $id)
    {
        $data = $request->validated();

        $subcategory = Subcategory::findOrFail($id);
        $subcategory->update($data);

        return redirect()->route('subcategories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Subcategory::destroy($id);

        return redirect()->route('subcategories.index');
    }
}
