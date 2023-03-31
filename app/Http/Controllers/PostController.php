<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function getAllPost() : JsonResponse{
        $post = Post::all();
        return response()->json([
            'code' => Response::HTTP_OK,
            'status' => true,
            "data" => [$post],
            "message" => ("all post list")
        ], Response::HTTP_OK);
    }

    public function createPost(Request $request) : JsonResponse{
        $post = Post::create([
            'image'=>$request->image,
            'title'=>$request->title,
            // 'username' => $username, 
            'slug'=>$request->slug,
            'user_id'=>$request->user_id,
            'body'=>$request->body,
        ]);

        return response()->json([
            "status" => true,
            "message" => "User has been registered successfully.",
            "code"  => Response::HTTP_OK,
            "data" => $post
        ]);

    }

    // get all perticulater profile post by user Id 
    // Request body
    // {
    //     "user_id":"1"
    // }
    
    public function getMyAllPosts(Request $request){
        $name_id = $request->input('user_id');
        $users = Post::where('user_id', $name_id)->get();
        return response()->json([
            'code' => Response::HTTP_OK,
            'status' => true,
            "data" => [ $users],
            "message" => ("by user post list")
        ], Response::HTTP_OK);
    }

    
}
