<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index() : JsonResponse{
        $post = Post::all();
        return response()->json([
            'code' => Response::HTTP_OK,
            'status' => true,
            "data" => [$post],
            "message" => ("all post list")
        ], Response::HTTP_OK);
    }

    public function show($slug){
        $post = Post::whereSlug($slug)->first();
        
        return view('post.view',compact('posts'));
    }
}
