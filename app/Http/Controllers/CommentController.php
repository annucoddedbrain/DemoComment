<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
 
    public function comment(Request $request): JsonResponse{
            $Comment = Comment::create([
                'message'=>$request->message,
                'user_id'=>$request->user_id,
                'post_id'=>$request->post_id,
               
            ]);
    
            return response()->json([
                "status" => true,
                "message" => "Comment Done.",
                "code"  => Response::HTTP_OK,
                "data" => $Comment
            ]);


    }


    public function delete(Request $request)
    {
        $result =comment::where('id',$request->id)->delete();
        return response()->json([
            "status" => true,
            "message" => "Comment Done.",
            "code"  => Response::HTTP_OK,
            "data" => [$result]
        ]);
    }
}
