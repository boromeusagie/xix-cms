<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(
            [
                'perPage' => 'nullable|integer',
                'sort' => 'nullable|string'
            ]
        );

        $filter = $request->all();

        $user = Auth::user();

        $ppg = (int) ($filter['perPage'] ?? 5);
        $sort = $filter['sort'] ?? 'asc';
        $categories = Category::orderBy('name', $sort)->paginate($ppg);
        
        $totalItems = Category::all()->count();

        return view('xix-admin.category',
            [
                'categories' => $categories,
                'ppg' => $ppg,
                'sort' => $sort,
                'totalItems' => $totalItems,
                'user' => $user
            ]);
    }

    public function store(Request $request)
    {
        $customMessages = [
            'required' => 'Enter :attribute',
            'unique' => 'This :attribute has been used'
        ];

        $request->validate(
            [
                'categoryName' => 'required|unique:categories,name|string',
                'description' => 'nullable|string'
            ], $customMessages
        );

        $cat = new Category();
        $cat->name = $request->categoryName;
        $cat->slug = str_slug($request->categoryName, '-');
        $cat->description = $request->description;
        $cat->save();

        toastr()->success('New category has been created');
        return redirect()->route('admin-category');
    }

    public function show($id)
    {
        $user = Auth::user();
        $category = Category::findOrFail($id);
        return view('xix-admin.edit-category', ['category' => $category, 'user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $customMessages = [
            'required' => 'Enter :attribute',
            'unique' => 'This :attribute has been used'
        ];

        $request->validate(
            [
                'categoryName' => 'required|unique:categories,name,'.$id.'|string',
                'description' => 'nullable|string'
            ], $customMessages
        );

        $cat = Category::findOrFail($id);

        if ($request->categoryName === $cat->name && $request->description === $cat->description) {
            toastr()->info('No changes');
            return redirect()->route('admin-category');
        }
        $cat->name = $request->categoryName;
        $cat->slug = str_slug($request->categoryName, '-');
        $cat->description = $request->description;
        $cat->save();

        toastr()->success('Category has been updated');
        return redirect()->route('admin-category');
    }

    public function destroy(Request $request, $id)
    {
        $cat = Category::findOrFail($id);
        $cat->delete();

        toastr()->success('Category has been deleted');
        return redirect()->route('admin-category');
    }
}
