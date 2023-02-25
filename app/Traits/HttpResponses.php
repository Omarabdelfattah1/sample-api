<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HttpResponses {
    protected function success($data, $message = null, $code = 200){
        return response()->json([
            'status' => 'Request was Successful.',
            'message' => $message,
            'date' => $data
        ], $code);
    }
    protected function error($data, $message = null, $code){
        return response()->json([
            'status' => 'Error had occurred...',
            'message' => $message,
            'date' => $data
        ], $code);
    }

    private function isNotAuthorized($user_type)
    {
        if(Auth::user()->id !== $user_type->user_id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }
    }

}
