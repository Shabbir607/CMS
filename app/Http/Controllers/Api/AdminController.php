<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;


class AdminController extends Controller
{
    //
    function login(Request $request)
    {

        $validate = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required",
        ]);

        if ($validate->fails()) {
            return response()->json(["status" => 422, "message" => $validate->errors()]);
        }
        $check=Admin::where("email",$request->email)->first();
        if(!$check){
            return  response()->json(["status"=>401,"message"=>"Email invalid"]);
        }
        if(!Hash::check($request->password,$check->password)){
            return  response()->json(["status"=>401,"message"=>"Password invalid"]);
        }
        if (!auth()->guard('admins')->attempt(['email' => $request->email, "password" => $request->password])) {
            return response()->json(["status" => 401, "message" => "invalid login detail"]);
        }
        $user = Auth::guard('admins')->user();
        $token = $user->createToken('Admins')->accessToken;

        return response()->json(['token' => $token, "user" => $user, "status" => 200]);;

    }


    function profile(Request $request)
    {
        $auth_id = auth()->guard('admin-api')->user()->id;
        $already = Rule::unique("admins", "email")->ignore($auth_id);
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => ["required", $already],
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }

        try {
            DB::beginTransaction();
            $profile = Admin::Find($auth_id);
            $profile->name = $request->name;
            $profile->email = $request->email;
            $profile->phone = $request->phone;
            if ($request->hasFile("image")) {
                $image = $request->file("image");

                $imageName = "profile_" . uniqid() . '.' . $image->extension();
                if ($profile->image_name) {
                    $imageDel = public_path("upload/profile/" . $profile->image_name);
                    if (file_exists($imageDel)) {
                        unlink($imageDel);
                    }
                }
                $image->move(public_path("upload/profile/"), $imageName);
                $imageUrl = asset('upload/profile/' . $imageName);
                $profile->image = $imageUrl;
                $profile->image_name = $imageName;
            }
            if ($profile->save()) {
                DB::commit();
                return response()->json(["status" => 200, "message" => "Profile Update Successfully"]);
            } else {
                DB::rollBack();
                throw  new \Exception("Error Update Profile");
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["status" => 500, "message" => $e->getMessage()]);
        }

    }

    function profile_get()
    {
        $auth_id = auth()->guard("admin-api")->user()->id;
        $profile = Admin::Find($auth_id);
        return response()->json(["status" => 200, "profile" => $profile]);
    }

    function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "old_password" => "required",
            "new_password" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(["status" => 422, "message" => $validator->errors()]);
        }
        $auth_id = auth()->guard("admin-api")->user()->id;
        $update = Admin::Find($auth_id);
        if (!Hash::check($request->old_password, $update->password)) {
            return response()->json(["status" => 404, "message" => "Old password incorrect"]);
        }
        $password = Hash::make($request->new_password);
        $update->password = $password;
        if ($update->save()) {
            return response()->json(["status" => 200, "message" => "Change Password Successfully"]);
        } else {
            return response()->json(["status" => 500, "message" => "Error"]);
        }


    }

    function logout()
    {
//        $accessToken = Auth:: guard('admin-api')->user()->token();
//        DB::table('oauth_refresh_tokens')
//            ->where('access_token_id', $accessToken->id)
//            ->update([
//                'revoked' => true
//            ]);
        $tokens = Auth::guard('admin-api')->user()->tokens->pluck('id');
        Token::whereIn('id', $tokens)->update(['revoked' => true]);
        RefreshToken::whereIn('access_token_id', $tokens)->update(['revoked' => true]);
        return response()->json(["stats" => 200, "message" => "You have been successfully logged out"]);
    }

}
