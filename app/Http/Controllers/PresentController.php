<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DepartmentPresent;
use App\Models\Folder;
use App\Models\Present;
use App\Models\PresentUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PresentController extends Controller
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
        $presents = Present::where('department_id', '=', auth()->user()->department_id)->orderBy('number', 'desc')->get();
        $folders = Folder::where('user_id', auth()->user()->id)->get();

        return view('present.index', compact('presents', 'folders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        
        return view('present.create', ['departments' => $departments]);
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
            $request->validate([
                'date' => ['required'],
                'topic' => ['required', 'string', 'max:255'],
                'urgency' => ['required'],
            ]);
            //ดึงเลขทะเบียน
            $number = Present::select('number')->whereYear('created_at', '=', date("Y"))->where('department_id', '=', auth()->user()->department_id)->max('number');
            $number += 1;
            //เพิ่มข้อมูล
            $present = new Present();
            $present->no = $number . "/" . (date("y") + 43);
            $present->date = dateeng($request->date);
            $present->topic = arabicnum($request->topic);
            $present->urgency = $request->urgency;
            $present->number = $number;
            $present->user_id = auth()->user()->id;
            $present->department_id = auth()->user()->department_id;
            $present->save();

            return redirect()->route('present.upload', $present->id);
        } else {
            $present = Present::findOrFail($request->id);
            //ไฟล์แนบ
            if (!empty($request->file)) {
                $filename = yearthai() . '_present_' . 'dept' . $present->department_id . '_' . $present->number . '.' . $request->file('file')->extension();
                $path = Storage::putFileAs(yearthai() . '/present', $request->file, $filename);
                $present->file = $path;
                $present->save();

                # สำเนาหนังสือ
                if (!empty($request->copy)) {
                    foreach ($request->copy as $key => $val) {
                        $copy = new DepartmentPresent();
                        $copy->present_id = $request->id;
                        $copy->department_id = $val;
                        $copy->save();

                        $department = Department::select("name", "line_token")->where("id", "=", $val)->first();
                        if ($department->line_token != null) {
                            try {
                                line("\nสำเนาหนังสือ\nที่ : " . $present->no . "\nเรื่อง : " . $present->topic . "\nไฟล์ : " . $_SERVER['SERVER_NAME'] . "/present/$present->id", $department->line_token);
                            } catch (\ErrorException $e) {
                                line("ไม่สามารถส่งแจ้งเตือนไปยัง $department->name ได้", env("LINE_TOKEN"));
                            }
                        }
                    }
                }
            }

            return redirect()->route('present.index')->with('register', $present->number);
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
        $present = Present::findOrFail($id);
        $folders = Folder::where('user_id', auth()->user()->id)->get();
        $views = PresentUser::select('name', 'present_user.created_at')->join('users', 'present_user.user_id', '=', 'users.id')->where('present_id', $id)->get();
 
        if (!empty($present->folder_id)) {
            $employee = Folder::findOrFail($present->folder_id);

            return view('present.show', compact('present', 'folders', 'employee', 'views'));
        }

        return view('present.show', compact('present', 'folders', 'views'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $present = Present::findOrFail($id);
        $DeptList = Department::all();
        $DeptListData = array();
        foreach ($DeptList as $key => $val) {
            $DeptListData[$key] = $val;
            $DeptDocCheck = DepartmentPresent::where('present_id', $id)->where('department_id', $val['id'])->first();
            if (!empty($DeptDocCheck)) {
                $DeptListData[$key]->checked = 'checked';
            } else {
                $DeptListData[$key]->checked = '';
            }
        }

        return view('present.edit', ['present' => $present, 'DeptList' => $DeptList]);
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
            'urgency' => ['required'],
        ]);
        //แก้ไข
        $present = Present::findOrFail($id);
        $present->date = dateeng($request->date);
        $present->topic = arabicnum($request->topic);
        $present->urgency = $request->urgency;
        //เช็คไฟล์แนบ
        if (!empty($request->file)) {
            if ($present->file) {
                Storage::delete($present->file);
            }
            $filename = yearthai() . '_present_' . 'dept' . $present->department_id . '_' . $present->number . '.' . $request->file('file')->extension();
            $path = Storage::putFileAs(yearthai() . '/present', $request->file, $filename);
            $present->file = $path;
        }
        //บันทึกลงฐานข้อมูล
        $present->save();

        # สำเนาหนังสือ
        if (!empty($request->copy)) {
            DepartmentPresent::where("present_id", $id)->delete();
            foreach ($request->copy as $key => $val) {
                $copy = new DepartmentPresent();
                $copy->present_id = $present->id;
                $copy->department_id = $val;
                $copy->save();

                $department = Department::select("name", "line_token")->where("id", "=", $val)->first();
                if ($department->line_token != null) {
                    if ($present->file != null) {
                        try {
                            line("\nสำเนาหนังสือ\nที่ : " . $present->no . "\nเรื่อง : " . $present->topic . "\nไฟล์ : " . $_SERVER['SERVER_NAME'] . "/present/$present->id", $department->line_token);
                        } catch (\ErrorException $e) {
                            line("ไม่สามารถส่งแจ้งเตือนไปยัง $department->name ได้", env("LINE_TOKEN"));
                        }
                    }
                }
            }
        } else {
            DepartmentPresent::where("present_id",  $id)->delete();
        }
        
        return redirect()->route('present.index')->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $present = Present::findOrFail($id);
        if ($present->file) {
            Storage::delete($present->file);
        }
        $present->delete();

        return redirect()->route('present.index')->with('success', 'ลบข้อมูลเรียบร้อย');
    }

    public function upload($id)
    {
        $present = Present::findOrFail($id);
        $departments = Department::all();

        return view('present.upload', ['present' => $present, 'departments' => $departments]);
    }

    public function homeSearch()
    {
        return view('present.search');
    }

    public function search(Request $request)
    {
        if (isset($request->no) || isset($request->date) || isset($request->topic)) {
            $presents = Present::where('no', 'LIKE', '%' . $request->no . '%')
                ->where('date', 'LIKE', '%' . dateeng($request->date) . '%')
                ->where('topic', 'LIKE', '%' . $request->topic . '%')
                ->orderBy('id', 'desc')
                ->get();

            if ($presents->count() == 0) {
                return redirect()->route('present.search.home')->with('fail', 'ไม่พบข้อมูล');
            }

            return view('present.index', ['presents' => $presents]);
        } else {
            return redirect()->route('present.search.home')->with('fail', 'กรุณาใส่ข้อมูล');
        }
    }

    public function download($id)
    {
        $present = Present::findOrFail($id);

        if ($present->file) {
            //ตรวจสอบคนดูไฟล์แนบ
            $checkview = PresentUser::where('present_id', '=', $present->id)->where('user_id', '=', auth()->user()->id);
            if (!$checkview->first()) {
                PresentUser::create([
                    'present_id' => $id,
                    'user_id' => auth()->user()->id,
                ]);
            }
            try {
                /*if (isMobile()) {
                    $url = "/pcru_edoc/storage/app/$present->file";
                    return redirect()->away('https://www.cavalry28.com' . $url);
                } else {
                    return response()->file(Storage::path($present->file));
                }*/
                return response()->file(Storage::path($present->file));
            } catch (\Throwable $e) {
                return "ไม่พบไฟล์ หรือไฟล์อาจถูกลบ";
            }
        } elseif (!$present->file) {
            return "ไม่ได้แนบไฟล์";
        }
    }

    public function folder(Request $request)
    {
        Present::findOrFail($request->present)->update(['folder_id' => $request->folder]);

        return redirect()->back()->with('success', 'จัดเก็บเอกสารเข้าแฟ้มเรียบร้อย');
    }
}
