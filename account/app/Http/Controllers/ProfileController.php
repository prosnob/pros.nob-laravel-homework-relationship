<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Profile::latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "user_id"=>"required",
            "image"=>"image|mimes: png,jpg,jpeg,gif|max:1999",
            "city"=>"required"
        ]);
        //move image to storage
        $request->file('image')->store('public/images');

        $profile = new Profile();
        $profile->user_id = $request->user_id;
        $profile->image = $request->file('image')->hashName();
        $profile->city = $request->city;
        $profile->save();
        return response()->json(["message"=>"created","profile"=>$profile],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Profile::findOrFail($id);
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
        $request->validate([
            "user_id"=>"required",
            "image"=>"image|mimes: png,jpg,jpeg,gif|max:1999",
            "city"=>"required"
        ]);
        //move image to storage
        $request->file('image')->store('public/images');

        $profile = Profile::findOrFail($id);
        $profile->user_id = $request->user_id;
        $profile->image = $request->file('image')->hashName();
        $profile->city = $request->city;
        $profile->save();
        return response()->json(["message"=>"updated","profile"=>$profile],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDelete = Profile::destroy($id);
        if($isDelete==1){
            return response()->json(["message"=>"deleted","profile_id"=>$id],200);
        }else{
            return response()->json(["message"=>"profile_id".$id."not found"],404);

        }
    }
}
