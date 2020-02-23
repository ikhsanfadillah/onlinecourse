<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Wishlist;
use App\Lesson;
use App\Mentor;
use App\User;
use Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->id;
        $wishlists = Wishlist::with('wishable')->where('user_id', '=', $user)->get();
        
        return view('website.allWishlist')->with('wishlists',$wishlists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * $user_id
     * $lesson_id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user()->id;
        $wishlist = Wishlist::where('wishable_id',$request->wishable_id)
            ->where('wishable_type',$request->wishable_type)
            ->first();
        if (empty($wishlist)){
            $wishlist = new Wishlist;
            $wishlist->user_id = $user;
            $wishlist->wishable_id = $request->wishable_id;
            $wishlist->wishable_type = $request->wishable_type;
            $wishlist->save();
        }
        return redirect()->route('wishlists.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 
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
    public function update(Request $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $product_id)
    {
        $wishlists = Wishlist::where('user_id', $user_id);
        $wishlists->delete();
    }

    public function cart(Request $request) {
      if (Session::get('cart')) {
        $cart = Session::get('cart');
        return view('website.cart');
      }
    }
    public function remove($id){

        $wishlist = Wishlist::find($id);
        DB::transaction(function () use ($wishlist) {
            $wishlist->delete();
        });
        return redirect()->route('wishlists.index');
    }
}
