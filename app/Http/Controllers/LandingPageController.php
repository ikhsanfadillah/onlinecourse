<?php

namespace App\Http\Controllers;

use App\LandingPage;
use App\Lesson;
use App\Mentor;
use App\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $data = [];
        $data['mentors'] =  Mentor::orderBy('rating_avg', 'desc')->take(9)->get();
        $data['mentorCount'] =  DB::table('mentors')->count();
        $data['lessonCount'] =  DB::table('lessons')->count();
        $data['testimonials'] =  Testimonial::orderBy('created_at', 'desc')->take(3)->get();
        return view('website.landing-page')->with('data',$data);
    }

    public function searchMentor(){
        $text = "%{$_POST['text']}%";
        $qMentor = DB::select('SELECT users.id, users.name, users.username, mentors.profesi
            FROM mentors
            JOIN users on mentors.mentor_id = users.id
            WHERE mentors.profesi like ?
            OR users.name like ?
            ORDER BY users.name
        ',[$text,$text]);
        foreach ($qMentor as $key => $mentor){
            $mMentor = Mentor::find($mentor->id);
            $mentor->img_url = $mMentor->getFirstMediaUrl('primary-photo') ?: asset('/img/mentor-img/mentor-image-small.png');
            $qMentor[$key] = $mentor;
        }

        $qLesson = DB::select('SELECT users.id, users.name, mentors.profesi, lessons.title, lessons.desc
            FROM lessons
            JOIN mentors ON lessons.mentor_id = mentors.mentor_id
            JOIN users on mentors.mentor_id = users.id
            WHERE lessons.title like ?
            ORDER BY users.name, lessons.title
        ',[$text]);

        echo json_encode(["mentor" => $qMentor,"lesson" => $qLesson]);
    }
}
