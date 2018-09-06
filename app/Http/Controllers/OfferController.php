<?php

namespace App\Http\Controllers;

use App\models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Offers = Offer::with('buyer')->paginate(10);
        return $Offers;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $offer = new Offer();
        $offer->title = $request->input('title');
        $offer->content = $request->input('content');
        $offer->publishDate = $request->input('publishDate');
        $offer->expireDate = $request->input('expireDate');
        $offer->buyer()->associate($request->input('buyer_id'));
        $offer->category()->associate($request->input('category_id'));
        $offer->createDate = new \DateTime();

        try{
            $offer->save();
            return response()->json([
                'status' => '200',
                'message' => 'Offer created!'
            ],200);
        }
        catch (\Exception $e){
            return response()->json([
                'status' => '500',
                'message' => 'Could not create the offer!',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offer = Offer::with('category')->find($id);
        if (!$offer) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        // Return a single task
        return $offer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        if($request->input('title') != '')
        $offer->title = $request->input('title');

        if($request->input('content') != '')
        $offer->content = $request->input('content');

        if($request->input('publishDate') != '')
        $offer->publishDate = $request->input('publishDate');

        if($request->input('expireDate') != '')
        $offer->expireDate = $request->input('expireDate');

        if($request->input('category_id') != '')
        $offer->category()->associate($request->input('category_id'));
        try{
            $offer->save();
            return response()->json([
                'status' => '200',
                'message' => 'Offer updated!'
            ],200);
        }
        catch (\Exception $e){
            return response()->json([
                'status' => '500',
                'message' => 'Could not update the offer',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offer = Offer::find($id);
        if (!$offer) {
            return response()->json([
                'status' => '500',
                'message' => 'Buyer not found'
            ],404);
        }
        try{
            $offer->delete();
            return response()->json([
                'status' => '200',
                'message' => 'Offer deleted'
            ],200);
        }
        catch (\Exception $e){
            return response()->json([
                'status' => '500',
                'message' => 'Could not delete buyer',
                'error' => $e->getMessage()
            ]);
        }
    }
}
