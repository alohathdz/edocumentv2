<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role', '!=', 0)->get();
        $pre_users = User::where('role', '=', 0)->get();

        return view('user.index', ['users' => $users, 'pre_users' => $pre_users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $depts = Department::all();

        return view('user.create', ['depts' => $depts]);
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'department' => ['required'],
            'role' => ['required'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department_id' => $request->department,
            'role' => $request->role,
        ]);

        return redirect()->route('user.index')->with('success', 'เพิ่มข้อมูลเรียบร้อย');
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
        $user = User::findOrFail($id);
        $depts = Department::all();

        return view('user.edit', ['user' => $user, 'depts' => $depts]);
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'department' => ['required'],
            'role' => ['required'],
        ]);

        User::findOrFail($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department,
            'role' => $request->role,
        ]);

        if (!empty($request->password)) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            User::findOrFail($id)->update([
                'password' => $request->password,
            ]);
        }

        return redirect()->route('user.index')->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('user.index')->with('success', 'ลบข้อมูลเรียบร้อย');
    }

    public function confirm(Request $request, $id)
    {
        User::findOrFail($id)->update(['role' => $request->role]);
    }

    public function profile($id)
    {
        if (auth()->user()->id == $id) {
            $user = User::findOrFail($id);
            $depts = Department::all();

            return view('user.profile', ['user' => $user, 'depts' => $depts]);
        } else {
            return abort(404);
        }
    }

    public function profileUpdate(Request $request, $id)
    {
        if (auth()->user()->id == $id) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
            ]);

            User::findOrFail($id)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if (!empty($request->password)) {
                $request->validate([
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);

                User::findOrFail($id)->update([
                    'password' => $request->password,
                ]);
            }

            return redirect()->route('user.profile', $id)->with('success', 'แก้ไขข้อมูลเรียบร้อย');
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }
}
