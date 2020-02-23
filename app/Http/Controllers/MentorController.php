<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Lesson;
use App\Mentor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\MediaLibrary\Models\Media;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->isAdminPage()) {
            $mentors = Mentor::all();
            return view('admin.mentor.list',compact('mentors'));
        }else{
            $mentors = Mentor::orderBy('rating_avg', 'desc')->get();
            return view('website.mentors',compact('mentors'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.mentor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(Mentor::$createRules);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->gender = $validatedData['gender'];
        $user->password = Hash::make($validatedData['password']);

        $mentor = new Mentor();
        $mentor->profesi = $validatedData['profesi'];
        $mentor->desc = $validatedData['desc'];

        DB::transaction(function () use ($user, $mentor, $validatedData){
            $user->save();
            $user->assignRole('mentor');
            $mentor->mentor_id = $user->id;
            $mentor->save();

            $mentor->addMedia($validatedData['primary_photo'])
                ->toMediaCollection('primary-photo');
            $mentor->addMedia($validatedData['description_photo'])
                ->toMediaCollection('description-photo');
            $mentor->addMedia($validatedData['highlight_video'])
                ->toMediaCollection('highlight-video');

        });
        return redirect()->route('mentors.index')->with('success', 'Mentor is successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $this->model = Mentor::getMentorByUsername($username);
        $lessons = Lesson::where('mentor_id',$this->model->mentor_id)->get();
        if ($this->isAdminPage()) {
            return view('admin.mentor.show')->with('mentor',$this->model)->with('lessons',$lessons);
        }else{
            return view('website.mentor')->with('mentor',$this->model)->with('lessons',$lessons);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $this->model = Mentor::find($id);
        $user = User::find($this->model->mentor_id);
        $mentorMedia = [];
        $mentorMedia['avatarPhoto'] = $user->getFirstMediaUrl('avatar-photo');
        $mentorMedia['primaryPhoto'] = $this->model->getFirstMediaUrl('primary-photo');
        $mentorMedia['descriptionPhoto'] = $this->model->getFirstMediaUrl('description-photo');
        $mentorMedia['highlightVideo'] = $this->model->getFirstMediaUrl('highlight-video');
        return view('admin.mentor.edit')
            ->with('mentor',$this->model)
            ->with('mentorMedia',$mentorMedia);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $updateRules = Mentor::$updateRules;
        $updateRules['email'] .= ',id,' . $id;
        $updateRules['username'] .= ',id,' . $id;
        $validatedData = $request->validate($updateRules);

        $user = User::find($id);
        $user->name = $validatedData['name'] ?: $user->name ;
        $user->email = $validatedData['email'] ?: $user->email ;
        $user->username = $validatedData['username'] ?: $user->username ;
        $user->gender = $validatedData['gender'] ?: $user->gender ;

        $mentor = Mentor::find($id);
        $mentor->profesi = $validatedData['profesi'] ?: $mentor->profesi ;
        $mentor->desc = $validatedData['desc'] ?: $mentor->desc ;

        DB::transaction(function () use ($user ,$mentor, $validatedData){
            $user->save();
            $user->assignRole('mentor');
            $mentor->save();

            if (isset($validatedData['primary_photo']))
                $mentor->addMedia($validatedData['primary_photo'])->toMediaCollection('primary-photo');

            if (isset($validatedData['description_photo']))
                $mentor->addMedia($validatedData['description_photo'])->toMediaCollection('description-photo');

            if (isset($validatedData['highlight_video']))
                $mentor->addMedia($validatedData['highlight_video'])->toMediaCollection('highlight-video');
        });
        return redirect()->back()
            ->with('success', 'Mentor is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mentor $mentor)
    {
        //
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

}
