<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageDraft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
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
        $pages = Page::with(['owner'])->orderBy('title', $sort)->paginate($ppg);
        
        $totalItems = Page::all()->count();

        return view('xix-admin.page',
            [
                'pages' => $pages,
                'ppg' => $ppg,
                'sort' => $sort,
                'totalItems' => $totalItems,
                'user' => $user
            ]);
    }

    public function addNewPage(Request $request)
    {
        $user = Auth::user();
        return view('xix-admin.add-page', ['user' => $user]);
    }

    public function storePage(Request $request)
    {
        $customMessages = [
            'required' => 'Enter :attribute',
            'unique' => 'This :attribute has been used'
        ];

        $rules = [
            'title' => 'required|unique:pages,title|string',
            'content' => 'required|string'
        ];

        $validate =  Validator::make($request->all(),$rules,$customMessages);
 

        if($validate->fails()){
            return redirect()->back()->withErrors($validate->messages())->withInput();
        }

        $user = Auth::user();

        $page = new Page();
        $page->title = $request->title;
        $page->slug = str_slug($request->title, '-');
        $page->content = $request->content;
        $page->user_id = $user->id;
        $page->save();

        toastr()->success('Page has been created');
        return redirect()->route('admin-page');
    }

    public function storePageDraft(Request $request)
    {
        $customMessages = [
            'required' => 'Enter :attribute',
            'unique' => 'This :attribute has been used'
        ];

        $rules = [
            'title' => 'required|unique:pages,title|string',
            'content' => 'required|string'
        ];

        $validate =  Validator::make($request->all(),$rules,$customMessages);
 

        if($validate->fails()){
            return redirect()->back()->withErrors($validate->messages())->withInput();
        }

        $user = Auth::user();

        $page = new PageDraft();
        $page->title = $request->title;
        $page->slug = str_slug($request->title, '-');
        $page->content = $request->content;
        $page->user_id = $user->id;
        $page->save();

        toastr()->success('Page Draft has been saved');
        return redirect()->route('admin-page');
    }

    public function showPage(Request $request, $id)
    {
        $user = Auth::user();

        $page = Page::findOrFail($id);

        return view('xix-admin.edit-page', ['user' => $user, 'page' => $page]);
    }

    public function updatePage(Request $request, $id)
    {
        $customMessages = [
            'required' => 'Enter :attribute',
            'unique' => 'This :attribute has been used'
        ];

        $rules = [
            'title' => 'required|unique:pages,title,'.$id.'|string',
            'content' => 'required|string'
        ];

        $validate =  Validator::make($request->all(),$rules,$customMessages);
 

        if($validate->fails()){
            return redirect()->back()->withErrors($validate->messages())->withInput();
        }

        $user = Auth::user();

        $page = Page::findOrFail($id);

        if ($request->title === $page->title && $request->content === $page->content) {
            toastr()->info('No changes');
            return redirect()->route('admin-page');
        }

        $page->title = $request->title;
        $page->slug = str_slug($request->title, '-');
        $page->content = $request->content;
        $page->user_id = $user->id;
        $page->save();

        toastr()->success('Page has been updated');
        return redirect()->route('admin-page');
    }

    public function destroy(Request $request, $id)
    {
        $cat = Page::findOrFail($id);
        $cat->delete();

        toastr()->success('Page has been deleted');
        return redirect()->route('admin-page');
    }
}
