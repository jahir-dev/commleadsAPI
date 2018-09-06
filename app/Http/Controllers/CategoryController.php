<?php

namespace App\Http\Controllers;

use App\models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Categories = Category::all();
        return $Categories;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->title = $request->input('title');
        $category->isActive = $request->input('isActive');
        $category->parentCategory()->associate($request->input('parentCat_id'));
        try{
            $category->save();
            return response()->json($category);
        }
        catch (\Exception $e){
            return response()->json([
                'message' => 'Could not create category',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        // Return a single task
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if($request->input('title') != '')
        $category->title = $request->input('title');

        if($request->input('isActive') != '')
        $category->isActive = $request->input('isActive');

        if($request->input('parentCat_id') != '')
        $category->parentCategory()->associate($request->input('parentCat_id'));

        try{
            $category->save();
            return response()->json($category);
        }
        catch (\Exception $e){
            return response()->json([
                'message' => 'Could not create category',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Buyer not found'
            ]);
        }
        try{
            $category->delete();
            return response()->json($category);
        }
        catch (\Exception $e){
            return response()->json([
                'message' => 'Could not delete category',
                'error' => $e->getMessage()
            ]);
        }
    }
}
