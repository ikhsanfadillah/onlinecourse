<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Mentor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CommentController extends Controller
{
    //

    public function saveComment(Request $request,$username)
    {
        $mentor = Mentor::getMentorByUsername($username);
        $request['user_id'] = Auth::id();
        $validatedData = $request->validate(Comment::$createRules);
        $comment = new Comment();
        $comment->user_id = $validatedData['user_id'];
        $comment->text = $validatedData['text'];
        $comment->parent_id = $validatedData['parent_id'];

        DB::transaction(function () use ($comment, $mentor){
            $mentor->comments()->save($comment);
            if ($comment->parent_id > 0){
                $parent = Comment::find($comment->parent_id);
                echo json_encode([
                    "comment_id" => $parent->id,
                    "parent_id" => $parent->parent_id,
                    "comment_text" => $parent->text,
                    "updated_at" => $parent->updated_at,
                    "deleted_at" => $parent->deleted_at,
                    "child" => [
                        "comment_id" => $comment->id,
                        "parent_id" => $comment->parent_id,
                        "comment_text" => $comment->text,
                        "updated_at" => $comment->updated_at,
                        "deleted_at" => $comment->deleted_at,
                    ]
                ]);
            }
            die();
        });
    }

}
