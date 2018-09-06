<?php

namespace App\Http\Controllers;

use App\models\ParentCategory;
use Illuminate\Http\Request;

class ParentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parentCat = ParentCategory::paginate(10);
        return $parentCat;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parentCategory = new ParentCategory();
        $parentCategory->title = $request->input('title');
        $parentCategory->numberOffers = $request->input('number_offers');

        try{
            $parentCategory->save();
            return response()->json($parentCategory);
        }
        catch (\Exception $e){
            return response()->json([
                'message' => 'Could not create parent category',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\ParentCategory  $parentCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parentCategory = ParentCategory::find($id);
        if (!$parentCategory) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        // Return a single task
        return $parentCategory;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\ParentCategory  $parentCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ParentCategory $parentCategory)
    {
        if($request->input('title') == '')
            return response()->json([
                'message' => 'Nothing to update',
                'Data' => $parentCategory
            ],200);

        $parentCategory->title = $request->input('title');
        try{
            $parentCategory->save();
            return response()->json([
                'message' => 'Parent Category Updated',
                'Data' => $parentCategory
            ],200);
        }
        catch (\Exception $e){
            return response()->json([
                'message' => 'Could not updated the parent category',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\ParentCategory  $parentCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parentCategory = ParentCategory::find($id);
        if (!$parentCategory) {
            return response()->json([
                'message' => 'Buyer not found'
            ]);
        }
        try{
            $parentCategory->delete();
            return response()->json($parentCategory);
        }
        catch (\Exception $e){
            return response()->json([
                'message' => 'Could not delete ParentCategory',
                'error' => $e->getMessage()
            ]);
        }
    }
}
