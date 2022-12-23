<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\CommandDepartment;
use App\Models\CommandUser;
use App\Models\Department;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommandController extends Controller
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
        $commands = Command::orderBy('number', 'desc')->get();
        $folders = Folder::where('user_id', auth()->user()->id)->get();

        return view('command.index', compact('commands', 'folders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('command.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->id) {
            //ตรวจสอบ
            $request->validate([
                'date' => ['required'],
                'topic' => ['required', 'string', 'max:255']
            ]);
            $number = Command::select('number')->whereYear('created_at', '=', date('Y'))->max('number');
            $number += 1;
            //เพิ่มข้อมูล
            $command = new Command();
            $command->no = $number . "/" . (date("Y") + 543);
            $command->date = dateeng($request->date);
            $command->topic = arabicnum($request->topic);
            $command->number = $number;
            $command->user_id = auth()->user()->id;
            $command->department_id = auth()->user()->department_id;
            $command->save();

            return redirect()->route('command.upload', $command->id);
        } else {
            $command = Command::findOrFail($request->id);
            //เช็คไฟล์แนบ
            if (!empty($request->file)) {
                $filename = yearthai() . '_command_' . $command->number . '.' . $request->file('file')->extension();
                $path = Storage::putFileAs(yearthai() . '/command', $request->file, $filename);
                $command->file = $path;
                $command->save();

                # สำเนาหนังสือ
                if (!empty($request->copy)) {
                    foreach ($request->copy as $key => $val) {
                        $copy = new CommandDepartment();
                        $copy->command_id = $request->id;
                        $copy->department_id = $val;
                        $copy->save();

                        $department = Department::select("name", "line_token")->where("id", "=", $val)->first();
                        if ($department->line_token != null) {
                            try {
                                line("\nสำเนาคำสั่ง\nที่ : " . $command->no . "\nเรื่อง : " . $command->topic . "\nไฟล์ : " . $_SERVER['SERVER_NAME'] . "/command/$command->id", $department->line_token);
                            } catch (\ErrorException $e) {
                                line("ไม่สามารถส่งแจ้งเตือนไปยัง $department->name ได้", env("LINE_TOKEN"));
                            }
                        }
                    }
                }
            }

            return redirect()->route('command.index')->with('register', $command->number);
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
        $command = Command::findOrFail($id);
        $folders = Folder::where('user_id', auth()->user()->id)->get();
        $views = CommandUser::select('name', 'command_user.created_at')->join('users', 'command_user.user_id', '=', 'users.id')->where('command_id', $id)->get();

        if (!empty($command->folder_id)) {
            $employee = Folder::findOrFail($command->folder_id);

            return view('command.show', compact('command', 'folders', 'employee', 'views'));
        }

        return view('command.show', compact('command', 'folders', 'views'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Command::where('id', $id)->where('user_id', Auth::id())->first() || Auth::user()->role == 1) {
            $command = Command::findOrFail($id);
            $DeptList = Department::all();
            $DeptListData = array();
            foreach ($DeptList as $key => $val) {
                $DeptListData[$key] = $val;
                $DeptDocCheck = CommandDepartment::where('command_id', $id)->where('department_id', $val['id'])->first();
                if (!empty($DeptDocCheck)) {
                    $DeptListData[$key]->checked = 'checked';
                } else {
                    $DeptListData[$key]->checked = '';
                }
            }

            return view('command.edit', compact('command', 'DeptList'));
        } else {
            abort(403);
        }
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
        //ตรวจสอบ
        $request->validate([
            'date' => ['required'],
            'topic' => ['required', 'string', 'max:255'],
        ]);
        //เพิ่มข้อมูล
        $command = Command::findOrFail($id);
        $command->date = dateeng($request->date);
        $command->topic = arabicnum($request->topic);
        //เช็คไฟล์แนบ
        if (!empty($request->file)) {
            if ($command->file) {
                Storage::delete($command->file);
            }
            $filename = yearthai() . '_command_' . $command->number . '.' . $request->file('file')->extension();
            $path = Storage::putFileAs(yearthai() . '/command', $request->file, $filename);
            $command->file = $path;
        }
        //บันทึกลงฐานข้อมูล
        $command->save();

        # สำเนาหนังสือ
        if (!empty($request->copy)) {
            CommandDepartment::where("command_id", $id)->delete();
            foreach ($request->copy as $key => $val) {
                $copy = new CommandDepartment();
                $copy->command_id = $command->id;
                $copy->department_id = $val;
                $copy->save();

                $department = Department::select("name", "line_token")->where("id", "=", $val)->first();
                if ($department->line_token != null) {
                    if ($command->file != null) {
                        try {
                            line("\nสำเนาคำสั่ง\nที่ : " . $command->no . "\nเรื่อง : " . $command->topic . "\nไฟล์ : " . $_SERVER['SERVER_NAME'] . "/command/$command->id", $department->line_token);
                        } catch (\ErrorException $e) {
                            line("ไม่สามารถส่งแจ้งเตือนไปยัง $department->name ได้", env("LINE_TOKEN"));
                        }
                    }
                }
            }
        } else {
            CommandDepartment::where("command_id",  $id)->delete();
        }

        return redirect()->route('command.index')->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Command::where('id', $id)->where('user_id', Auth::id())->first() || Auth::user()->role == 1) {
            $command = Command::findOrFail($id);
            if ($command->file) {
                Storage::delete($command->file);
            }
            $command->delete();

            return redirect()->route('command.index')->with('success', 'ลบข้อมูลเรียบร้อย');
        } else {
            abort(403);
        }
    }

    public function upload($id)
    {
        if (Command::where('id', $id)->where('user_id', Auth::id())->first() || Auth::user()->role == 1) {
            $command = Command::findOrFail($id);
            $departments = Department::all();

            return view('command.upload', ['command' => $command, 'departments' => $departments]);
        } else {
            abort(403);
        }
    }

    public function homeSearch()
    {
        return view('command.search');
    }

    public function search(Request $request)
    {
        if (isset($request->no) || isset($request->date) || isset($request->topic)) {
            $commands = Command::where('no', 'LIKE', '%' . $request->no . '%')
                ->where('date', 'LIKE', '%' . dateeng($request->date) . '%')
                ->where('topic', 'LIKE', '%' . $request->topic . '%')
                ->orderBy('id', 'desc')
                ->paginate(20);

            if ($commands->count() == 0) {
                return redirect()->route('command.search.home')->with('fail', 'ไม่พบข้อมูล');
            }

            return view('command.index', ['commands' => $commands]);
        } else {
            return redirect()->route('command.search.home')->with('fail', 'กรุณาใส่ข้อมูล');
        }
    }

    public function download($id)
    {
        $command = Command::findOrFail($id);

        if ($command->file) {
            //ตรวจสอบคนดูไฟล์แนบ
            $checkview = CommandUser::where('command_id', '=', $command->id)->where('user_id', '=', auth()->user()->id);
            if (!$checkview->first()) {
                CommandUser::create([
                    'command_id' => $id,
                    'user_id' => auth()->user()->id,
                ]);
            }
            try {
                return response()->file(Storage::path($command->file));
            } catch (\Throwable $e) {
                return abort(403, 'File not found.');
            }
        } elseif (!$command->file) {
            return abort(403, 'File not attached.');
        }
    }

    public function folder(Request $request)
    {
        Command::findOrFail($request->command)->update(['folder_id' => $request->folder]);

        return redirect()->back()->with('success', 'จัดเก็บเอกสารเข้าแฟ้มเรียบร้อย');
    }
}
