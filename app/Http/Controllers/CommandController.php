<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\CommandDepartment;
use App\Models\CommandUser;
use App\Models\Department;
use App\Models\Folder;
use Illuminate\Http\Request;
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
        $commands = Command::orderBy('number', 'desc')->paginate(20);

        return view('command.index', ['commands' => $commands]);
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
                $filename = "คำสั่ง ม.พัน.28 พล.ม.1 ที่ " . $command->number . "." . (date("Y", strtotime($command->date)) + 543) . "." . $request->file('file')->extension();
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

        return view('command.edit', ['command' => $command, 'DeptList' => $DeptList]);
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
            'department' => ['required']
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
            $filename = "คำสั่ง ม.พัน.28 พล.ม.1 ที่ " . $command->number . "." . (date("Y", strtotime($command->date)) + 543) . "." . $request->file('file')->extension();
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

        return redirect()->route('command.show', $command->id)->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $command = Command::findOrFail($id);
        if ($command->file) {
            Storage::delete($command->file);
        }
        $command->delete();

        return redirect()->route('command.index')->with('success', 'ลบข้อมูลเรียบร้อย');
    }

    public function upload($id)
    {
        $command = Command::findOrFail($id);
        $departments = Department::all();

        return view('command.upload', ['command' => $command, 'departments' => $departments]);
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
                return "ไม่พบไฟล์ หรือไฟล์อาจถูกลบ";
            }
        } elseif (!$command->file) {
            return "ไม่ได้แนบไฟล์";
        }
    }

    public function folder(Request $request)
    {
        Command::findOrFail($request->command)->update(['folder_id' => $request->folder]);

        return redirect()->route('command.show', $request->command)->with('success', 'จัดเก็บเอกสารเข้าแฟ้มเรียบร้อย');
    }
}
