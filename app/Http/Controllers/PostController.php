<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
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
        $pages = Post::with(['owner'])->orderBy('title', $sort)->paginate($ppg);
        
        $totalItems = Post::all()->count();

        return view('xix-admin.post',
            [
                'pages' => $pages,
                'ppg' => $ppg,
                'sort' => $sort,
                'totalItems' => $totalItems,
                'user' => $user
            ]);
    }

    public function addNewPost(Request $request)
    {
        $user = Auth::user();
        return view('xix-admin.add-post', ['user' => $user]);
    }
}
