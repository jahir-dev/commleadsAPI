<?php

namespace App\Http\Controllers;

use App\models\Buyer;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buyers = Buyer::with('country')->paginate(10);
        return $buyers;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $buyer = new Buyer();
        $buyer->firstName = $request->input('firstName');
        $buyer->lastName = $request->input('lastName');
        $buyer->email = $request->input('email');
        $buyer->password = bcrypt($request->input('password'));
        $buyer->address = $request->input('address');
        $buyer->phone = $request->input('phone');
        $buyer->country()->associate($request->input('country_id'));

        //todo : make sure i'm admin for active and premium accounts

        ($request->input('isActive')) ? $buyer->isActive =($request->input('isActive')) : $buyer->isActive = false;
        ($request->input('isPremium')) ? $buyer->isPremium =($request->input('isPremium')) : $buyer->isPremium = false;
        ($request->input('isExpired')) ? $buyer->isExpired =($request->input('isExpired')) : $buyer->isExpired = false;
        $buyer->registrationDate = new \DateTime();
        $buyer->lastLoginDate = new \DateTime();
        $buyer->numberOfLogs = 0;

        try{
            $buyer->save();
            return response()->json([
                'status' => '200',
                'message' => 'Buyer created!'
            ],200);
        }
        catch (\Exception $e){
            return response()->json([
                'status' => '500',
                'message' => 'Could not create buyer',
                'error' => $e->getMessage()
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $buyer = Buyer::find($id);
        if (!$buyer) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        // Return a single task
        return $buyer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buyer $buyer)
    {
        
        if($request->input('firstName') != '')
        $buyer->firstName = $request->input('firstName');

        if($request->input('lastName') != '')
        $buyer->lastName = $request->input('lastName');

        if($request->input('password') != '')
        $buyer->password = $request->input('password');

        if($request->input('address') != '')
        $buyer->address = $request->input('address');

        if($request->input('phone') != '')
        $buyer->phone = $request->input('phone');

        if($request->input('isActive') != '')
        $buyer->isActive = $request->input('isActive');

        if($request->input('isPremium') != '')
        $buyer->isPremium = $request->input('isPremium');

        if($request->input('isExpired') != '')
        $buyer->isExpired = $request->input('isExpired');

        if($request->input('country_id') != '')
        $buyer->country()->associate($request->input('country_id'));

        // echo("country_id : " . $request->input('country_id'));
        // die($request->input('country_id'));

        try{
            $buyer->save();
            return response()->json([
                'status' => '200',
                'message' => 'Buyer updated!'
            ],200);
        }
        catch (\Exception $e){
            return response()->json([
                'status' => '500',
                'message' => 'Could not updated the buyer',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buyer = Buyer::find($id);
        if (!$buyer) {
            return response()->json([
                'status' => '500',
                'message' => 'Buyer not found'
            ]);
        }
        try{
            $buyer->delete();
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
