<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PeopleController extends Controller
{
    function fetchAll()
    {
        $people = People::all();

        $response = array();
        $response['status'] = 1;
        $response['http_code'] = 1;
        $response['data_length'] = count($people);
        $response['data'] = $people;

        return response()->json([
            'message' => "Unauthorized, Api Key Mismatch",
            'http_response' => 401,
            'status_code' => 0,
        ], 401);
    }


    function changePassword(Request $request)
    {
        $user_id = $request->people_id;

        $this->validate($request, [
            'people_id' => 'required',
            'new_password' => 'required|min:6',
            'old_password' => 'required|min:6'
        ]);

        $user = People::findOrFail($user_id);
        $hasher = app('hash');

        //If Password Sesuai
        if (!$hasher->check($request->old_password, $user->password)) {
            return response()->json([
                'http_response' => 400,
                'status' => 0, 
                'message_id' => 'Password Lama Tidak Sesuai',
                'message' => 'Old Password did not match',
            ]);
        } else {
            $user->password = Hash::make($request->new_password);
            $user->save();

            if ($user) {
                return response()->json([
                    'http_response' => 200,
                    'status' => 1,
                    'message_id' => 'Password Berhasil Diupdate',
                    'message' => 'Password updated',
                ]);
            } else {
                return response()->json([
                    'http_response' => 400,
                    'status' => 0,
                    'message_id' => 'Password Gagal Diupdate',
                    'message' => 'Password Update Failed',
                ]);
            }
        }

     
    }



    function updatePassword()
    {
        $people = People::all();

        $response = array();
        $response['status'] = 1;
        $response['http_code'] = 1;
        $response['data_length'] = count($people);
        $response['data'] = $people;

        return response()->json([
            'message' => "Unauthorized, Api Key Mismatch",
            'http_response' => 401,
            'status_code' => 0,
        ], 401);
    }

    /**
     * store the request sell
     *id	nama	username	email	nik 	password	jk	no_telp	photo_path	remember_token	created_at	updated_at	
     */
    public function store(Request $request)
    {
        $rules = [
            'nama' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'jk' => 'required',
            'no_telp' => 'required',
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute terlebih dahulu'
        ];

        $this->validate($request, $rules, $customMessages);

        $object = new People();
        $object->nama = $request->nama;
        $object->username = $request->username;
        $object->email = $request->email;
        $object->password = $request->password;
        $object->jk = $request->jk;
        $object->no_telp = $request->no_telp;

        $object->save();


        if ($object) {
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'message_id' => 'Registrasi Berhasil, Silakan Login Menggunakan Akun Anda',
                'message' => 'Registration Success',
            ]);
        } else {
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message_id' => 'Registrasi Gagal',
                'message' => 'Registration Failed',
            ]);
        }
    }

    //Login via API

    public function login(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute terlebih dahulu'
        ];

        $this->validate($request, $rules, $customMessages);

        if (Auth::guard('people')->attempt(
            [
                'username' => $request->username,
                'password' => $request->password
            ],
            $request->get('remember')
        )) {
            $id = Auth::guard('people')->id();
            $people = People::findOrFail($id);
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'message_id' => 'Login Berhasil',
                'message' => 'Login Successfull',
                'people' => $people,
            ]);
        } else {
            return response()->json([
                'http_response' => 400,
                'status' => 0,
                'message_id' => 'Login Gagal',
                'message' => 'Login Failed',
            ]);
        }
        return back()->withInput($request->only('nisn', 'remember'));
    }
}
