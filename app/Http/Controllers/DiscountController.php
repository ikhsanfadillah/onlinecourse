<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Helper;
use App\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discount::all();
        return view('admin.discount.list')
            ->with('discounts',$discounts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $discount = new Discount();
        return view('admin.discount.create')
            ->with('discount',$discount);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
        $discount = new Discount();
        $this->_save($discount,$request,Discount::$rules['create']);
        return redirect()->route('discounts.index')
            ->with('success', 'Discount is successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount)
    {
        return view('admin.discount.create')->with('discount',$discount);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        return view('admin.discount.edit')->with('discount',$discount);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discount $discount)
    {

        $rules = Discount::$rules['update'];
        $rules['code'] .= ',id,' . $discount->id;
        $this->_save($discount,$request,$rules);
        return redirect()->route('discounts.index')->with('success', 'Discount is successfully saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('discounts.index')->with('success', 'Discount is successfully remove');
    }

    private function _save($discount,$request,$rules){
        $validatedData = $request->validate($rules);
        $dateRange = explode(' - ',$validatedData['discount_date_range']);
        $discount->code = $validatedData['code'];
        $discount->desc = $validatedData['desc'];
        $discount->type = $validatedData['type'];
        if ($discount->type == Discount::DISCOUNT_TYPE_PRICE){
            $discount->value = $validatedData['price'];
            $discount->max_price = $validatedData['price'];
        } else if ($discount->type == Discount::DISCOUNT_TYPE_PERCENT){
            $discount->value = $validatedData['percent'];
            $discount->max_price = $validatedData['max_price'];
        }
        $discount->is_active = Helper::STATUS_YES;
        $discount->started_at = Helper::formatDate($dateRange[0],config('app.datetime_format'));
        $discount->ended_at = Helper::formatDate($dateRange[1],config('app.datetime_format'));
        DB::transaction(function () use ($discount){
            $discount->save();
            return redirect()->route('discounts.index');
        });
    }

    public function viewAssign($id){
        $discount = Discount::find($id);
        $mentors = Mentor::all();
        return view('admin.discount.assign')
            ->with('discount',$discount)
            ->with('mentors',$mentors);
    }
    public function doAssign(Request $request, $id){
        $validatedData = $request->validate([
            'mentors.*' => 'numeric|exists:mentors,mentor_id'
        ]);
        $discount = Discount::find($id);
        $discount->mentors()->sync($validatedData['mentors']);

        return redirect()->route('discounts.index');
    }
}
