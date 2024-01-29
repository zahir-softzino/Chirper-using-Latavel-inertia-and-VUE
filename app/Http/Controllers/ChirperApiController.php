<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;

class ChirperApiController extends Controller
{
    public function index(){
        $chirps = Chirp::all();
        $data = [
            'status' => 200,
            'chirps' => $chirps,
        ];
        return response()->json($data, 200);
    }


    public function store(Request $request){
        // return $request;
        $validator = Validator::make($request->all(),
        [
            // 'message' => 'nullable',
            'message' => 'required',
        ]);

        if($validator->fails())
        {

            $data = [
                'status' => 422,
                'message' => $validator->messages(),
            ];
            return response()->json($data, 422);
        }
        else
        {
            $chirp = new Chirp;
            $chirp -> message = $request->message;
            $chirp -> user_id = Auth::user()->id;

            return $chirp;
            $chirp -> save();

            $data = [
                'status' => 200,
                'message' => 'Message Created Successfully.',
            ];

            return response()->json($data, 200);
        }
    }
}
