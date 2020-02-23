<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SupportDesk;
use App\User;
use Auth;
class SupportDeskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supportDesks = SupportDesk::simplePaginate(10);
        return view('admin.support.index', compact('supportDesks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.support.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $user = Auth::user();
      $supportDesk = new SupportDesk;
      $supportDesk->title = $request->title;
      $supportDesk->topic = $request->topic;
      $supportDesk->slug = $request->slug;
      $supportDesk->content = $request->content;
      $supportDesk->author = $user->id;
      $supportDesk->save();

      return redirect()->route('support.index')->with('success', 'Article is successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $supportDesk = SupportDesk::find($id);
      $author_name = User::find($supportDesk->author);
      $supportDesk->author = $author_name;
      
      if ($supportDesk->topic == 'privacy_policy') {
        return view('website.privacy', compact('supportDesk'));
      } else if($supportDesk->topic == 'terms_and_conditions') {
        return view('website.terms', compact('supportDesk'));
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supportDesk = SupportDesk::where('id', $id)->first();
        return view('admin.support.edit', compact('supportDesk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $supportDesk = SupportDesk::find($id);
        $user = Auth::user();
        $supportDesk->title = $request->title;
        $supportDesk->topic = $request->topic;
        $supportDesk->content = $request->content;
        $supportDesk->author = $user->id;
        $supportDesk->save();

        return redirect()->route('support.index')->with('success', 'Article update success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supportDesk = SupportDesk::find($id);
        $supportDesk->delete();

        return redirect()->route('support.index')->with('success', 'Article deleted successfully');
    }
}
