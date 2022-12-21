<?php

namespace App\Http\Controllers;

use App\Models\CertificateType;
use Illuminate\Http\Request;

class CertificateTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ctypes = CertificateType::all();

        return view('certificateType.index', ['ctypes' => $ctypes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('certificateType.create');
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
            'name' => ['required', 'string', 'max:50'],
        ]);

        CertificateType::create([
            'name' => $request->name,
        ]);

        return redirect()->route('certificateType.index')->with('success', 'เพิ่มข้อมูลเรียบร้อย');
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
        $ctype = CertificateType::findOrFail($id);

        return view('certificateType.edit', ['ctype' => $ctype]);
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
            'name' => ['required', 'string', 'max:50']
        ]);

        CertificateType::findOrFail($id)->update([
            'name' => $request->name
        ]);

        return redirect()->route('certificateType.index')->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CertificateType::findOrFail($id)->delete();

        return redirect()->route('certificateType.index')->with('success', 'ลบข้อมูลเรียบร้อย');
    }
}
