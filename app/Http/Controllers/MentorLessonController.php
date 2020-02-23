<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Lesson;
use App\Mentor;
use App\Notifications\CommentNotification;
use App\User;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\Models\Media;

class MentorLessonController extends Controller
{
    public function show($mentor,$lesson){
        $mentor = Mentor::getMentorByUsername($mentor);
        $lesson = Lesson::where('slug',$lesson)->firstOrFail();
        if ($this->isAdminPage()) {
            return view('admin.lesson')->with('mentor', $mentor)->with('lesson',$lesson);
        }else{
            return view('website.lesson')->with('mentor', $mentor)->with('lesson',$lesson);
        }
    }

    public function create($username){
        $mentor = Mentor::getMentorByUsername($username);
        return view('admin.lesson.create')->with('mentor' ,$mentor);
    }

    public function edit($username, $id){
        $mentor = Mentor::getMentorByUsername($username);
        $lesson = Lesson::find($id)->firstOrFail();
        $lessonMedia = [];
        $lessonMedia['thumbnailPhoto '] = $this->model->getFirstMediaUrl('thumbnail-photo');
        $lessonMedia['lessonVideo'] = $this->model->getFirstMediaUrl('lesson-video');
        return view('admin.lesson.edit')
            ->with('mentor' ,$mentor)
            ->with('lesson',$lesson)
            ->with('lessonMedia',$lessonMedia);
    }

    public function store(Request $request,$username){
        $validatedData = $request->validate(Lesson::$createRules);
        $mentor = Mentor::getMentorByUsername($username);

        $lesson = new Lesson();
        $lesson->mentor_id = $mentor->mentor_id;
        $lesson->title = $validatedData['title'];
        $lesson->slug = $validatedData['slug'];
        $lesson->desc = $validatedData['desc'];
        $lesson->thumbnail_photo = 0;
        $lesson->desc = $validatedData['desc'];
        $lesson->lesson_video_url = $validatedData['lesson_video_url'];

//        if ((isset($validatedData['lesson_video']) && !empty($validatedData['lesson_video']))){
//            $lesson->lessonable_type = Media::class;
//            $lesson->lessonable_id = 0;
//        }
//        else{
//            // else ini sebetulnya untuk yang quiz
//            $lesson->lessonable_type = Media::class;
//            $lesson->lessonable_id = 0;
//        }

        $lesson->lessonable_type = Media::class;
        $lesson->lessonable_id = 0;
        // dd($lesson);
        DB::transaction(function () use ($lesson, $validatedData){
            $lesson->save();
            if (isset($validatedData['thumbnail_photo']) && !empty($validatedData['thumbnail_photo'])){
                $lesson->addMedia($validatedData['thumbnail_photo'])
                    ->toMediaCollection(Lesson::LESSON_MEDIA_THUMBNAIL);
                $lesson->thumbnail_photo = $lesson->media->last()->id;
            }
//            if (isset($validatedData['lesson_video']) && !empty($validatedData['lesson_video'])){
//                $lesson->addMedia($validatedData['lesson_video'])
//                    ->toMediaCollection(Lesson::LESSON_MEDIA_TYPE_VIDEO);
//                $lesson->lessonable_id = $lesson->media->last()->id;
//            }
            $lesson->save();;
        });

        return redirect()->route('mentors.show',$mentor->user->username)->with('success', 'Mentor is successfully saved');
    }
    public function destroy($username, $id){
        $mentor = Mentor::getMentorByUsername($username);
        DB::transaction(function () use ($username, $id) {
            $lesson = Lesson::find($id)->firstOrFail();
            $lesson->delete();

            $notification = CommentNotification::where($id)->get();
        });

        return redirect()->route('mentors.show',$mentor->user->username)->with('success', 'Lesson is successfully deleted');
    }

    public function fetchComment($mentor, $lessonId){
        $comments = DB::table('comments')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->leftJoin('media', function($join){
                $join->on('media.model_id', '=', 'users.id')
                    ->where('media.model_type','=', User::class)
                    ->where('media.collection_name','=', 'avatar-photo');
            })
            ->where('comments.commentable_id','=',$lessonId)
            ->where('comments.commentable_type','=',Lesson::class)
            ->get(['comments.*','users.name','users.username','media.id as media_id','media.file_name']);
        echo json_encode(['comments' => $comments, 'status' => 200]);
    }
    public function sendComment($mentor, $lessonId){
        DB::transaction(function () use ($mentor, $lessonId) {
            $comment = new Comment();
            $comment->user_id = Auth::id();
            $comment->parent_id = $_POST['parent_id'] == 0 ? $_POST['reply_to'] : $_POST['parent_id'];
            $comment->reply_to = $_POST['reply_to'];
            $comment->text = $_POST['text'];
            $comment->commentable_id = $lessonId;
            $comment->commentable_type = Lesson::class;
            $comment->save();

            $lesson = Lesson::find($lessonId);
            $notificationActionUrl = route('main.mentors.lessons.show',[
                'mentor' => $lesson->mentor->user->username,
                'lesson' => $lesson->slug
            ])."#comment-".$comment->id;
            $lesson->mentor->user->notify(new CommentNotification($comment, $notificationActionUrl));
            $parentComment = Comment::with('user')->find($comment->parent_id);
            $replyToComment = Comment::with('user')->find($comment->reply_to);

            $doNotNotifToUserId = [Auth::id()];
            if (!in_array($lesson->mentor->user->id, $doNotNotifToUserId)){
                $doNotNotifToUserId[] = $lesson->mentor->user->id;
            }
            if (!empty($parentComment) && !in_array($parentComment->user->id, $doNotNotifToUserId)){
                $parentComment->user->notify(new CommentNotification($comment, $notificationActionUrl));
                $doNotNotifToUserId[] = $parentComment->user->id;
            }
            if (!empty($replyToComment) && !in_array($replyToComment->user->id, $doNotNotifToUserId)) {
                $replyToComment->user->notify(new CommentNotification($comment, $notificationActionUrl));
                $doNotNotifToUserId[] = $replyToComment->user->id;
            }
            echo json_encode(['comments' => $comment, 'status' => 200]);
        });
    }
    public function editComment($mentor, $lessonId){
        $comment = Comment::findOrFail($_POST['id']);
        $comment->text = $_POST['text'];
        $comment->save();
        echo json_encode(['comments' => $comment, 'status' => 200]);
    }

    public function deleteComment($mentor, $lessonId){
        $comment = Comment::where('id',$_POST['id'])->first();
        $comment->delete();
        echo json_encode(['comments' => $comment, 'status' => 200]);
    }
}
