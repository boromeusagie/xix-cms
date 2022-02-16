<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
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
        $tags = Tag::orderBy('name', $sort)->paginate($ppg);
        
        $totalItems = Tag::all()->count();

        return view('xix-admin.tag',
            [
                'tags' => $tags,
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
                'tagName' => 'required|unique:tags,name|string',
                'description' => 'nullable|string'
            ], $customMessages
        );

        $tag = new Tag();
        $tag->name = $request->tagName;
        $tag->slug = str_slug($request->tagName, '-');
        $tag->description = $request->description;
        $tag->save();

        toastr()->success('Tag has been created');
        return redirect()->route('admin-tag');
    }

    public function show($id)
    {
        $user = Auth::user();
        $tag = Tag::findOrFail($id);
        return view('xix-admin.edit-tag', ['tag' => $tag, 'user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $customMessages = [
            'required' => 'Enter :attribute',
            'unique' => 'This :attribute has been used'
        ];

        $request->validate(
            [
                'tagName' => 'required|unique:tags,name,'.$id.'|string',
                'description' => 'nullable|string'
            ], $customMessages
        );

        $tag = Tag::findOrFail($id);

        if ($request->tagName === $tag->name && $request->description === $tag->description) {
            toastr()->info('No changes');
            return redirect()->route('admin-tag');
        }
        $tag->name = $request->tagName;
        $tag->slug = str_slug($request->tagName, '-');
        $tag->description = $request->description;
        $tag->save();

        toastr()->success('Tag has been updated');
        return redirect()->route('admin-tag');
    }

    public function destroy(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        toastr()->success('Tag has been deleted');
        return redirect()->route('admin-tag');
    }
}
