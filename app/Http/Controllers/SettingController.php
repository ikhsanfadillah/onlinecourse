<?php

namespace App\Http\Controllers;

use App\LandingPage;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index(){
        return view('admin.setting.index');
    }
    public function landingpage()
    {
        $landingpage = LandingPage::find(1);
        $landingpageMedia = ['previewPhoto' => null, 'previewVid' => null];
        if (empty($landingpage))
            $landingpage = new LandingPage();
        else{
            $landingpageMedia['previewPhoto'] = $landingpage->getFirstMediaUrl('preview-photo');
            $landingpageMedia['previewVideo'] = $landingpage->getFirstMediaUrl('preview-video');
        }
        return view('admin.setting.landingpage')
            ->with('landingpage',$landingpage)
            ->with('landingpageMedia',$landingpageMedia);
    }
    public function updatelandingpage(Request $request)
    {
        $validatedData = $request->validate(LandingPage::$rules);
        $landingpage = LandingPage::first();
        if (empty($landingpage))
            $landingpage = new LandingPage();
        $landingpage->trailer_desc = $validatedData['trailer_desc'];

        DB::transaction(function () use ($landingpage){
            $landingpage->save();
            if (isset($validatedData['trailer_photo']) && !empty($validatedData['trailer_photo'])){
                $landingpage->addMedia($validatedData['trailer_photo'])->toMediaCollection('preview-photo');
                $previewPhoto = $landingpage->getMedia('preview-photo');
                $landingpage->trailer_photo = $previewPhoto[count($previewPhoto) -1]->id;
            }
            if (isset($validatedData['trailer_video']) && !empty($validatedData['trailer_video'])){
                $landingpage->addMedia($validatedData['trailer_video'])->toMediaCollection('preview-video');
                $previewVideo = $landingpage->getMedia('preview-video');
                $landingpage->lessonable_id = $previewVideo[count($previewVideo) -1]->id;
            }
            $landingpage->save();

        });
        return redirect()->route('setting.landingpage');
    }
}
