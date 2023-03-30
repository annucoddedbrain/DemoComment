<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Post;
use Faker\Test\Provider\Collection;

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

    
    public function getbyUserId(Request $request){
        // $post = Post::find($request->user_id);
        $search =  $request->get('user_id');
        $image = Post::where('user_id','LIKE', "%{$search}%")->Paginate();
    

        return response()->json([
            'code' => Response::HTTP_OK,
            'status' => true,
            "data" => [$image],
            "message" => ("by user post list")
        ], Response::HTTP_OK);
    }


    public function getData(Request $request){
        $name_id = $request->input('name_id', []);
$aussehen = $request->input('aussehen', []);

$query = Stufen::whereIn('name_id', array_unique($name_id))
                ->whereIn('stufe', array_unique($aussehen))
                ->get()
                ->indexBy('name_id');
$collection = [];
foreach ($name_id as $nameId) {
    $collection[] = $results[$nameId];
}
    }


    public function show($slug){
        $post = Post::whereSlug($slug)->first();
        
        return view('post.view',compact('posts'));
    }
}
