<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Wishlist;
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
        
        if (!Auth::check()) {
           return response()->json([
                'success' => false,
                'message' => trans('messages.login_failed'),
            ]); 
        }
        $user_id     = Auth::user()->id;
        $contentId   = $request->content_id;
        $contentType = $request->content_type;
        $wishList    = Wishlist::where('user_id',$user_id)
                      ->where('content_type',$contentType)
                      ->where('content_id',$contentId)->first();
        if ($wishList) {
            return response()->json([
                'success' => false,
                'message' => trans('messages.exist_wish_list'),
                'data'    => 1,
            ]);
        }
        try {
            $addWishlist = Wishlist::create([
                'user_id'      => $user_id,
                'content_type' => $contentType,
                'content_id'   => $contentId,
            ]);
            if ($addWishlist) {
                return response()->json([
                    'success' => true,
                    'message' => trans('messages.added_wish_list'),
                    'data'    => $addWishlist,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.added_failed'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors'  => 1,
                'message' => $e->getMessage(),
            ]);
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
    public function destroy(Request $request, $id)
    {
        //
        $wishListFind = Wishlist::find($id);
        if (!$wishListFind) {
           return response()->json([
                'success' => false,
                'message' => trans('messages.invalid_id'),
            ]); 
        }
        try {
            $wishListDelete = Wishlist::find($id)->delete($id);
            $listCount      = Wishlist::where('user_id', Auth::id())->count();
            if ($wishListDelete) {
                return response()->json([
                    'success' => true,
                    'message' => trans('messages.removed_wish_list_success'),
                    'dataCount'=> $listCount,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.removed_wish_list_failed'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors'  => 1,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
