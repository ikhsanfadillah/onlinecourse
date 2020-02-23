<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Lesson;
use App\Mentor;
use App\UserLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->isAdminPage()) {
            return view('admin.lesson.list');
        }
        return view('website.lessons');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Mentor $mentor, Lesson $lesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        //
    }

    // search

    public function search() {
      return view('website.search');
    }

    public function sendComment(Request $request,$username)
    {
        $mentor = Mentor::getMentorByUsername($username);
        $request['user_id'] = Auth::id();
        $validatedData = $request->validate(Comment::$createRules);

        // prevent comment 1 menit sekali

        $comment = Comment::findOrNew($request->comment_id);
        $comment->user_id = $validatedData['user_id'];
        $comment->parent_id = $validatedData['parent_id'];
        $comment->text = $validatedData['text'];

        DB::transaction(function () use ($comment, $mentor, $request){
            $comment->save();
            $mentor->comments()->save($comment);

            // Send Notification
            // Send to mentor and parent comment owner

            echo json_encode(['status' => 'success', 'msg' => "Successfully ". $request->comment_id == 0 ? 'send' : 'update' ." comment"]); die();
        });
    }

    public function enroll(Request $request, $username){
        $mentor = Mentor::getMentorByUsername($username);
        $lessons = $mentor->lessons();
        $user = Auth::user();
        foreach ($lessons as $lesson){
            $userLesson = UserLesson::where('user_id',$user->id)->find();
            $currentDate = date('Y-m-d H:i:s');
            if (empty($userLesson)){
                $userLesson = new UserLesson();
                $userLesson->last_watch_tm = time();
            }else{
                $currentDate = $userLesson->expired_dt > $currentDate ? $userLesson->expired_dt : $currentDate;
            }
            $days = 30;
            $userLesson->user_id = $user->id;
            $userLesson->buy_count++;
            $userLesson->expired_dt = date("Y-m-d H:i:s", strtotime($currentDate." +".$days." days"));
            $userLesson = 1;

        }
    }
}
