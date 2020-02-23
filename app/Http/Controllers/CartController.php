<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Lesson;
use App\UserLesson;
use App\Wishlist;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use App\Mentor;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = [];
        $items = \Cart::session(Auth::id())->getContent();
        $cart = [
            'items' => $items,
            'total' => \Cart::getTotal()
        ];
        return view('website.carts')->with('cart',$cart);
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
        $mentor = Mentor::find($request->cartable_id);
        $conditions = [];

        \Cart::session(Auth::id());
        if (empty(\Cart::get($request->cartable_id))){
            \Cart::add([
                'id' => $request->cartable_id,
                'name' => $mentor->user->name,
                'price' => $mentor->price,
                'quantity' => 1,
                'attributes' => [
                    'cardable_id' => $request->cartable_id,
                    'cardable_type' => $request->cartable_type,
                    'img_url' => $mentor->getFirstMediaUrl('primary-photo') ?: asset('/img/mentor-img/mentor-image-small.png')
                ],
                'conditions' => $conditions
            ]);

            return response()->json(['status' => 200,'type' => 'success', 'message' => 'Kursus berhasil ditambah ke keranjang!\'']);
        }
        else{
            return response()->json(['status' => 406,'type' => 'error', 'message' => 'Kursus sudah berada didalam ke keranjang!\'']);
        }
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
        \Cart::session(Auth::id())->remove($id);
        return response()->json([
            'data' => [
                'total' => Helper::IDR(\Cart::getTotal())
            ],
            'status' => 200,
            'type' => 'success',
            'message' => 'Kursus berhasil dihapus dari keranjang!']);
    }

    public function clearAll(){
        \Cart::clear();
        \Cart::session(Auth::id())->clear();
        return redirect()->route('carts.index');
    }

    public function checkout(){
        \Cart::session(Auth::id());
        $items = \Cart::getContent();
        foreach ($items as $item){
            $mentor = Mentor::find($item->id);
            foreach ($mentor->lessons as $lesson){
                $userLesson = new UserLesson;
                $userLesson->user_id = Auth::id();
                $userLesson->lesson_id = $lesson->id;
                $userLesson->last_watch_tm = 0;
                $userLesson->watch_count = 0;
                $userLesson->buy_count = 1;
                $userLesson->expired_dt = '2030-12-01 00:00:00';
                $userLesson->save();
            }
            $wishlist = Wishlist::where('wishable_id',$item->id)
                ->where('wishable_type',Mentor::class)->first();
            if (!empty($wishlist))
                $wishlist->delete();
        };

        \Cart::clear();
        \Cart::session(Auth::id())->clear();
        return redirect()->route('users.mycourse');
    }
}