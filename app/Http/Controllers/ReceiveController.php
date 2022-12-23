<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Folder;
use App\Models\Receive;
use App\Models\ReceiveUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class ReceiveController extends Controller
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
        $receives = Receive::where('department_id', '=', auth()->user()->department_id)->orderBy('number', 'desc')->get();
        $folders = Folder::where('user_id', auth()->user()->id)->get();

        return view('receive.index', compact('receives', 'folders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $depts = Department::where('name', 'NOT LIKE', 'กองร้อย%')->get();

        return view('receive.create', compact('depts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        # ตรวจสอบข้อมูล
        $request->validate([
            'no' => ['required', 'string', 'max:50'],
            'date' => ['required'],
            'from' => ['required', 'string', 'max:100'],
            'topic' => ['required', 'string', 'max:255'],
            'urgency' => ['required'],
            'department' => ['required']
        ]);
        #ดึงเลขทะเบียนล่าสุด
        $number = Receive::select('number')
            ->whereYear('created_at', '=', date('Y'))
            ->max('number');
        $number += 1;
        #เพิ่มข้อมูล
        $receive = new Receive();
        $receive->no = arabicnum($request->no);
        $receive->date = dateeng($request->date);
        $receive->from = arabicnum($request->from);
        $receive->topic = arabicnum($request->topic);
        $receive->urgency = $request->urgency;
        $receive->number = $number;
        $receive->department_id = $request->department;
        $receive->user_id = auth()->user()->id;
        #เช็คไฟล์แนบ
        if (!empty($request->file)) {
            $filename = yearthai() . '_receive_' . $number . '.' . $request->file('file')->extension();
            $path = Storage::putFileAs(yearthai() . '/receive', $request->file, $filename);
            $receive->file = $path;
        }
        #บันทึกลงฐานข้อมูล
        $receive->save();
        #Line Notify
        try {
            if ($receive->department->line_token && $receive->file) {
                line("\nหนังสือรับ\nที่ : " . $receive->no . "\nเรื่อง : " . $receive->topic . "\nไฟล์ : " . $_SERVER['SERVER_NAME'] . "/receive/$receive->id", $receive->department->line_token);
            } elseif ($receive->department->line_token && !$receive->file) {
                line("\nหนังสือรับ\nที่ : " . $receive->no . "\nเรื่อง : " . $receive->topic . "\nไฟล์ : ไม่มีไฟล์แนบ", $receive->department->line_token);
            }
        } catch (\ErrorException $th) {
            if (env("LINE_TOKEN") != null) {
                line("ไม่สามารถส่งแจ้งเตือนไปยัง " . $receive->department->name . " ได้", env("LINE_TOKEN"));
            }
        }

        if ($receive->department_id == auth()->user()->department_id) {
            return redirect()->route('receive.index')->with([
                'register' => 'รับหนังสือสำเร็จ',
                'number' => $number,
                'date' => datethaitext($receive->created_at),
                'time' => date("H:i", strtotime($receive->created_at)),
            ]);
        } else {
            return redirect()->route('receive.saraban')->with([
                'register' => 'รับหนังสือสำเร็จ',
                'number' => $number,
                'date' => datethaitext($receive->created_at),
                'time' => date("H:i", strtotime($receive->created_at)),
            ]);
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
        $receive = Receive::findOrFail($id);
        $folders = Folder::where('user_id', auth()->user()->id)->get();
        $views = ReceiveUser::select('name', 'receive_user.created_at')->join('users', 'receive_user.user_id', '=', 'users.id')->where('receive_id', $id)->get();

        if (!empty($receive->folder_id)) {
            $employee = Folder::findOrFail($receive->folder_id);

            return view('receive.show', compact('receive', 'folders', 'views', 'employee'));
        }

        return view('receive.show', compact('receive', 'folders', 'views'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $depts = Department::all();

        if (Receive::where('id', $id)->where('user_id', Auth::id())->first() || Auth::user()->role == 1) {
            $receive = Receive::findOrFail($id);
            return view('receive.edit', compact('receive', 'depts'));
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
        #ตรวจสอบข้อมูล
        $request->validate([
            'no' => ['required', 'string', 'max:50'],
            'date' => ['required'],
            'from' => ['required', 'string', 'max:100'],
            'topic' => ['required', 'string', 'max:255'],
            'urgency' => ['required'],
            'department' => ['required']
        ]);

        $receive = Receive::findOrFail($id);
        $receive->no = arabicnum($request->no);
        $receive->date = dateeng($request->date);
        $receive->from = arabicnum($request->from);
        $receive->topic = arabicnum($request->topic);
        $receive->urgency = $request->urgency;
        $receive->department_id = $request->department;
        #เช็คไฟล์แนบ
        if (!empty($request->file)) {
            if ($receive->file) {
                Storage::delete($receive->file);
            }
            $filename = yearthai() . '_receive_' . $receive->number . '.' . $request->file('file')->extension();
            $path = Storage::putFileAs(yearthai() . '/receive', $request->file, $filename);
            $receive->file = $path;
        }
        #Line Notify
        try {
            if ($receive->department->line_token && $receive->file) {
                line("\nหนังสือรับ\nที่ : " . $receive->no . "\nเรื่อง : " . $receive->topic . "\nไฟล์ : " . $_SERVER['SERVER_NAME'] . "/receive/" . $receive->id, $receive->department->line_token);
            } elseif ($receive->department->line_token && !$receive->file) {
                line("\nหนังสือรับ\nที่ : " . $receive->no . "\nเรื่อง : " . $receive->topic . "\nไฟล์ : ไม่มีไฟล์แนบ", $receive->department->line_token);
            }
        } catch (\ErrorException $th) {
            if (env("LINE_TOKEN") != null) {
                line("ไม่สามารถส่งแจ้งเตือนไปยัง " . $receive->department->name . " ได้", env("LINE_TOKEN"));
            }
        }
        #บันทึกลงฐานข้อมูล
        $receive->save();
        #เช็คหนังสือที่ไม่ใช่แผนกตัวเอง
        if ($receive->department_id != auth()->user()->department_id) {
            return redirect()->route('receive.saraban')->with('success', 'แก้ไขข้อมูลเรียบร้อย');
        }

        return redirect()->route('receive.index')->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Receive::where('id', $id)->where('user_id', Auth::id())->first() || Auth::user()->role == 1) {
            $receive = Receive::findOrFail($id);

            if (!empty($receive->file)) {
                Storage::delete($receive->file);
            }

            $receive->delete();

            return redirect()->back()->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
        } else {
            abort(403);
        }
    }

    public function saraban()
    {
        $receives = Receive::where('user_id', '=', auth()->user()->id)->where('department_id', '!=', auth()->user()->department_id)->orderBy('number', 'desc')->get();

        return view('receive.saraban', compact('receives'));
    }

    public function view($id)
    {
        $receive = Receive::findOrFail($id);
        $views = ReceiveUser::select('users.name', 'receive_user.created_at', 'receives.from', 'receives.no', 'receives.date')
            ->where('receive_id', '=', $id)
            ->join('receives', 'receives.id', '=', 'receive_user.receive_id')
            ->join('users', 'users.id', '=', 'receive_user.user_id')
            ->get();

        return view('receive.view', compact('receive', 'views'));
    }

    public function download($id)
    {
        #ดึงข้อมูล
        $receive = Receive::findOrFail($id);
        if ($receive->file) {
            #ตรวจสอบคนดูไฟล์แนบ
            $checkview = ReceiveUser::where('receive_id', '=', $receive->id)->where('user_id', '=', auth()->user()->id);
            if (!$checkview->first()) {
                ReceiveUser::create([
                    'receive_id' => $id,
                    'user_id' => auth()->user()->id,
                ]);
            }
        }
        #เปิดไฟล์แนบ
        try {
            if ($receive->file) {
                #กำหนดข้อความ stamp
                $file = Storage::path($receive->file);
                $text1 = "ม.พัน.28 พล.ม.1";
                $text2 = "เลขที่รับ " . $receive->number;
                $text3 = "วันที่ " . datethaitext($receive->created_at);
                $text4 = "เวลา " . date('H:i', strtotime($receive->created_at));
                #สร้าง object pdf และตั้งค่า หน้าแรก
                $pdf = new Fpdi();
                $pagecount = $pdf->setSourceFile($file);
                $pdf->addPage();
                $tpl = $pdf->importPage(1);
                $pdf->useTemplate($tpl, 0, 0, null, null, true);
                $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
                $pdf->SetFont('THSarabunNew', '', 16);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetTextColor(0, 0, 255);
                $pdf->SetDrawColor(0, 0, 255);
                $pdf->SetXY(160, 5);
                $pdf->MultiCell(45, 5, iconv("UTF-8", "cp874", $text1 . "\n" . $text2 . "\n" . $text3 . "\n" . $text4), 1, "C", true);
                #วน loop เรียก pdf ทุกหน้า
                for ($i = 2; $i <= $pagecount; $i++) {
                    $tpl = $pdf->importPage($i);
                    $pdf->addPage();
                    $pdf->useTemplate($tpl, 0, 0, null, null, true);
                }

                return $pdf->Output('I', basename($file), true);
            } elseif (!$receive->file) {
                #Null
                return "ไม่ได้แนบไฟล์";
            }
        } catch (\Exception $e) {
            try {
                #Pdf < v1.3
                return response()->file(Storage::path($receive->file));
            } catch (\Throwable $th) {
                #File not found.
                return abort(403, 'File not found.');
            }
        }
    }

    public function folder(Request $request)
    {
        Receive::findOrFail($request->receive)->update(['folder_id' => $request->folder]);

        return redirect()->back()->with('success', 'จัดเก็บเอกสารเข้าแฟ้มเรียบร้อย');
    }

    ########## ยังไม่ได้ใช้ ###########
    public function homeSearch()
    {
        return view('receive.search');
    }

    public function search(Request $request)
    {
        if (isset($request->no) || isset($request->date) || isset($request->from) || isset($request->topic)) {
            $receives = Receive::where('no', 'LIKE', '%' . $request->no . '%')
                ->where('date', 'LIKE', '%' . dateeng($request->date) . '%')
                ->where('from', 'LIKE', '%' . $request->from . '%')
                ->where('topic', 'LIKE', '%' . $request->topic . '%')
                ->orderBy('id', 'desc')
                ->get();

            if ($receives->count() == 0) {
                return redirect()->route('receive.search.home')->with('fail', 'ไม่พบข้อมูล');
            }

            return view('receive.index', ['receives' => $receives]);
        } else {
            return redirect()->route('receive.search.home')->with('fail', 'กรุณาใส่ข้อมูล');
        }
    }
}
