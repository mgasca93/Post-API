<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\API\V1\CategoryRegisterRequest;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    
    /**
     * @OA\Get(
     *      path="/categories",
     *      summary="Get all categories and paginate list",
     *      tags={"Categories"},
     *      operationId="findCategories",
     *      @OA\RequestBody(
     *          description="A JSON object containing categories information",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Categories retrieved successfully" 
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="Failed to get categories"
     *      )
     * )
     */
    public function index()
    {
        try{
            $categories = Category::paginate(10);

            return response()->json([
                'status' => 'success',
                'message' => 'Categories retrieved successfully',
                'data' => $categories
            ], Response::HTTP_OK);

        }catch( Exception $e ){
            return response()->json([
                'status'        => 'failed',
                'message'       => 'Failed to get categories'
            ], Response::HTTP_CONFLICT);
        }
    }

    /**
     * @OA\post(
     *      path="/category/create",
     *      summary="Store a new category",
     *      tags={"Categories"},
     *      operationId="addCategory",
     *      @OA\RequestBody(
     *          description="A JSON object containing category information",
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="name",
     *          description="Name of the catory",
     *          required=true,
     *          in="query",
     *          example="Tutorial",
     *          @OA\Schema(
     *              type="string"
     *          ), 
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Category created with success"
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="Failed to set category"
     *      ),
     * )
     */
    public function store(CategoryRegisterRequest $request)
    {
        try{
            $category = Category::create([
                'name'      => $request->name,
                'slug'      => Str::slug( $request->name ),
            ]);

            return response()->json([
                'status'        => 'success',
                'message'       => 'Category created with success',
                'data'          => $category,
            ], Response::HTTP_CREATED);
        }catch( Exception $e ){
            return response()->json([
                'status'        => 'failed',
                'message'       => 'Failed to create category'
            ], Response::HTTP_CONFLICT);
        }
    }

    /**
     * @OA\Get(
     *      path="/category/{slug}",
     *      summary="Get category with match slug",
     *      tags={"Categories"},
     *      operationId="findCategory",
     *      @OA\RequestBody(
     *          description="A JSON object containing category information",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          ),
     *      ),    
     *      @OA\Parameter(
     *          name="slug",
     *          description="Slug of the catory",
     *          required=true,
     *          in="path",
     *          example="peliculas",
     *          @OA\Schema(
     *              type="string"
     *          ), 
     *      ),  
     *      @OA\Response(
     *          response=200,
     *          description="Category retrieved successfully" 
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Failed to get category"
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="Failed to get category"
     *      ),
     * )
     */
    public function show( $slug = '' )
    {
        try{            
            $category = Category::where('slug', $slug)->first();
            if( isset( $category ) ) :
                return response()->json([
                    'status'        => 'success',
                    'message'       => 'Category retrieved successfully',
                    'data'          => $category,
                ], Response::HTTP_OK);
            endif;
            
            return response()->json([
                'status'        => 'failed',
                'message'       => 'Failed to get category',                
            ], Response::HTTP_NOT_FOUND);

        }catch( Exception $e )
        {
            return response()->json([
                'status'        => 'failed',
                'message'       => 'Failed to get category'
            ], Response::HTTP_CONFLICT);
        }
    }

    /**
     * @OA\put(
     *      path="/category/{slug}",
     *      summary="Update category with match slug",
     *      tags={"Categories"},
     *      operationId="updateCategory",
     *      @OA\RequestBody(
     *          description="A JSON object containing category updated information",
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="slug",
     *          description="Slug of the catory",
     *          required=true,
     *          in="path",
     *          example="peliculas",
     *          @OA\Schema(
     *              type="string"
     *          ), 
     *      ), 
     *      @OA\Parameter(
     *          name="name",
     *          description="Name of the catory",
     *          required=true,
     *          in="query",
     *          example="Tutorial",
     *          @OA\Schema(
     *              type="string"
     *          ), 
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Category updated with success"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Category not found"
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="Failed to update category"
     *      ),
     * )
     */
    public function update( CategoryRegisterRequest $request, $slug = '' )
    {
        try{       
                        
            $category = Category::where('slug', $slug)->first();
            if( isset( $category ) ) :
                $slug = Str::slug( $request->name );

                $category->update([
                    'name' => $request->name,
                    'slug' => $slug,
                ]);

                return response()->json([
                    'status'        => 'success',
                    'message'       => 'Category updated successfully',
                    'data'          => $category,
                ], Response::HTTP_OK);
            endif;

            return response()->json([
                'status'        => 'failed',
                'message'       => 'Failed to update category',
            ], Response::HTTP_NOT_FOUND);

        }catch( Exception $e )
        {
            return response()->json([
                'status'        => 'failed',
                'message'       => 'Failed to update category'
            ], Response::HTTP_CONFLICT);
        }
    }

    /**
     * @OA\Delete(
     *      path="/category/{slug}",
     *      summary="Delete category with match slug",
     *      tags={"Categories"},
     *      operationId="deleteCategory",
     *      @OA\RequestBody(
     *          description="A JSON object containing confirmation delete category",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          ),
     *      ),    
     *      @OA\Parameter(
     *          name="slug",
     *          description="Slug of the catory",
     *          required=true,
     *          in="path",
     *          example="peliculas",
     *          @OA\Schema(
     *              type="string"
     *          ), 
     *      ),  
     *      @OA\Response(
     *          response=200,
     *          description="Category deleted successfully" 
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Failed to delete category becasue not found"
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="Failed to delete category"
     *      ),
     * )
     */
    public function destroy( $slug = '' )
    {
        try{
            $category = Category::where('slug', $slug)->first();
            if( isset( $category ) ) :
                $category->delete();
                return response()->json([
                    'status'        => 'success',
                    'message'       => 'Category deleted successfully',
                    'data'          => $category
                ], Response::HTTP_OK);
            endif;

            return response()->json([
                'status'        => 'failed',
                'message'       => 'Failed to delete category becasue not found',
            ], Response::HTTP_NOT_FOUND);
        }catch( Exception $e )
        {
            return response()->json([
                'status'        => 'failed',
                'message'       => 'Failed to delete category',
            ], Response::HTTP_CONFLICT);
        }
    }
}
