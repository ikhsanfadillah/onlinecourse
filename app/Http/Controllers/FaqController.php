<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faq;
class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Faq::orderBy('order', 'ASC')->get();

        if ($this->isAdminPage()) {
            return view('admin.faq.list', compact('faqs'));
        } else {
            return view('website.faq')->with('faqs',$faqs);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (isset($request)) {
          $faq = new Faq;
          $faq->question = $request->question;
          $faq->answer = $request->answer;
          $faq->order = $request->order;
          $faq->save();
          $faqs = Faq::all();
          return view('admin.faq.list', compact('faqs'));
        } else {
          return back()->with('error','Failed to save data');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return view('admin.faq.list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faq = Faq::where('id',$id)->get();
        return view('admin.faq.edit')->with('faq', $faq);
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
      $faq = Faq::find($id);
      $faq->question = $request->question;
      $faq->answer = $request->answer;
      $faq->order = $request->order;
      $faq->save();
      $faqs = Faq::all();
      return view('admin.faq.list', compact('faqs'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq = Faq::find($id);
        $faq->delete();
        $faqs = Faq::all();
        return view('admin.faq.list', compact('faqs'));
    }
}
