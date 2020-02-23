<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $user = User::findByUsername($username);
        if ($this->isAdminPage()) {
//            return view('admin.mentor.list')->with('user',$user) ;
        }else{
            return view('website.profile')->with('user',$user);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // all wishlist page

    public function indexAllWishlist () {
      return view('Website/allWishlist');
    }

    // all notification page

    public function indexAllNotification () {
        $unRead = auth()->user()->unreadNotifications;
        if (!empty($unRead))
            $unRead->markAsRead();
        return view('Website/allNotification')
            ->with(['notifications' => auth()->user()->notifications]);
    }

    // all purchases page

    public function indexAllPurchases () {
      return view('Website/allPurchases');
    }
}
