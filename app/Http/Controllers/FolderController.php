<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Command;
use App\Models\Folder;
use App\Models\Present;
use App\Models\Receive;
use App\Models\Send;
use Illuminate\Http\Request;

class FolderController extends Controller
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
        $folders = Folder::where('user_id', auth()->user()->id)
        ->orderBy('name')
        ->get();

        return view('folder.index', compact('folders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('folder.create');
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
            'name' => 'required|string|max:50'
        ]);
        Folder::create([
            'name' => $request->name,
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->route('folder.index')->with('success', 'เพิ่มข้อมูลเรียบร้อย');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $folder = Folder::findOrFail($id);
        $receives = Receive::where('folder_id', $id)->get();
        $sends = Send::where('folder_id', $id)->get();
        $presents = Present::where('folder_id', $id)->get();
        $commands = Command::where('folder_id', $id)->get();
        $certificates = Certificate::where('folder_id', $id)->get();

        return view('folder.show', compact('folder', 'receives', 'sends', 'presents', 'commands', 'certificates'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Folder $folder)
    {
        return view('folder.edit', compact('folder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Folder $folder)
    {
        $request->validate([
            'name' => 'required|string|max:50'
        ]);

        $folder->update($request->all());

        return redirect()->route('folder.index')->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder)
    {
        $folder->delete();
        return redirect()->route('folder.index')->with('success', 'ลบข้อมูลเรียบร้อย');
    }
}