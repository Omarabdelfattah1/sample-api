<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUserTypeRequest;
use App\Http\Requests\StoreUserTypeRequest;
use App\Http\Resources\UserTypesResource;
use App\Models\UserType;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTypeController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserTypesResource::collection(
            UserType::where('user_id', Auth::user()->id)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserTypeRequest $request)
    {
        $data = $request->validated();

        $user_type = UserType::create($data);

        return new UserTypesResource($user_type);
    }

    /**
     * Display the specified resource.
     *
     * @param  UserType $user_type
     * @return \Illuminate\Http\Response
     */
    public function show(UserType $user_type)
    {
        return $this->isNotAuthorized($user_type) ? $this->isNotAuthorized($user_type) : new UserTypesResource($user_type);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  UserType $user_type
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserTypeRequest $request, UserType $user_type)
    {
        $user_type->update($request->validated());

        return new UserTypesResource($user_type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UserType $user_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserType $user_type)
    {
        if ($this->isNotAuthorized($user_type)){
            return  $this->isNotAuthorized($user_type);
        }
        $user_type->delete();
        return $this->success([],'Record deleted successfully');
    }

}
