<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\CertificateType;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
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
        $certificates = Certificate::orderBy('number', 'desc')->get();
        $folders = Folder::where('user_id', auth()->user()->id)->get();

        return view('certificate.index', compact('certificates', 'folders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $certificateTypes = CertificateType::all();

        return view('certificate.create', ['certificateTypes' => $certificateTypes]);
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
                'ctype' => ['required'],
                'name' => ['required', 'string', 'max:50'],
            ]);
            $number = Certificate::select('number')->whereYear('created_at', '=', date('Y'))->max('number');
            $number += 1;
            //เพิ่มข้อมูล
            $cert = new Certificate();
            $cert->no = $number . "/" . (date("Y") + 543);
            $cert->date = dateeng($request->date);
            $cert->certificate_type_id = $request->ctype;
            $cert->name = $request->name;
            $cert->number = $number;
            $cert->user_id = auth()->user()->id;
            $cert->save();

            return redirect()->route('certificate.upload', $cert->id);
        } else {
            $cert = Certificate::findOrFail($request->id);
            //เช็คไฟล์แนบ
            if (!empty($request->file)) {
                $filename = yearthai() . '_certificate_' . $cert->number . '.' . $request->file('file')->extension();
                $path = Storage::putFileAs(yearthai() . '/certificate', $request->file, $filename);
                $cert->file = $path;
                $cert->save();
            }

            return redirect()->route('certificate.index')->with('register', $cert->number);
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
        $cert = Certificate::findOrFail($id);
        $folders = Folder::where('user_id', auth()->user()->id)->get();

        if (!empty($cert->folder_id)) {
            $employee = Folder::findOrFail($cert->folder_id);

            return view('certificate.show', compact('cert', 'folders', 'employee'));
        }

        return view('certificate.show', compact('cert', 'folders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Certificate::where('id', $id)->where('user_id', Auth::id())->first() || Auth::user()->role == 1) {
            $cert = Certificate::findOrFail($id);
            $ctypes = CertificateType::all();
    
            return view('certificate.edit', compact('cert', 'ctypes'));
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
        $request->validate([
            'date' => ['required'],
            'ctype' => ['required'],
            'name' => ['required', 'string', 'max:50'],
        ]);
        //เพิ่มข้อมูล
        $cert = Certificate::findOrFail($id);
        $cert->date = dateeng($request->date);
        $cert->certificate_type_id = $request->ctype;
        $cert->name = $request->name;
        //เช็คไฟล์แนบ
        if (!empty($request->file)) {
            if ($cert->file) {
                Storage::delete($cert->file);
            }
            $filename = yearthai() . '_certificate_' . $cert->number . '.' . $request->file('file')->extension();
            $path = Storage::putFileAs(yearthai() . '/certificate', $request->file, $filename);
            $cert->file = $path;
        }
        //บันทึกลงฐานข้อมูล
        $cert->save();

        return redirect()->route('certificate.index')->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Certificate::where('id', $id)->where('user_id', Auth::id())->first() || Auth::user()->role == 1) {
            $cert = Certificate::findOrFail($id);
            if ($cert->file) {
                Storage::delete($cert->file);
            }
            $cert->delete();
    
            return redirect()->route('certificate.index')->with('success', 'ลบข้อมูลเรียบร้อย');
        } else {
            abort(403);
        }
    }

    public function upload($id)
    {
        if (Certificate::where('id', $id)->where('user_id', Auth::id())->first() || Auth::user()->role == 1) {
            $cert = Certificate::findOrFail($id);

            return view('certificate.upload', compact('cert'));
        } else {
            abort(403);
        }
    }

    public function homeSearch()
    {
        $certificateTypes = CertificateType::all();

        return view('certificate.search', ['certificateTypes' => $certificateTypes]);
    }

    public function search(Request $request)
    {
        if (isset($request->no) || isset($request->date) || isset($request->ctype) || isset($request->name)) {
            $certificates = certificate::where('no', 'LIKE', '%' . $request->no . '%')
                ->where('date', 'LIKE', '%' . dateeng($request->date) . '%')
                ->where('certificate_type_id', 'LIKE', '%' . $request->ctype . '%')
                ->where('name', 'LIKE', '%' . $request->name . '%')
                ->orderBy('id', 'desc')
                ->paginate(20);

            if ($certificates->count() == 0) {
                return redirect()->route('certificate.search.home')->with('fail', 'ไม่พบข้อมูล');
            }

            return view('certificate.index', ['certificates' => $certificates]);
        } else {
            return redirect()->route('certificate.search.home')->with('fail', 'กรุณาใส่ข้อมูล');
        }
    }

    public function download($id)
    {
        $cert = Certificate::findOrFail($id);

        if ($cert->file) {
            try {
                return response()->file(Storage::path($cert->file));
            } catch (\Throwable $e) {
                return 'ไม่พบไฟล์ หรือไฟล์อาจถูกลบ';
            }
        } elseif (!$cert->file) {
            return "ไม่ได้แนบไฟล์";
        }
    }

    public function folder(Request $request)
    {
        Certificate::findOrFail($request->certificate)->update(['folder_id' => $request->folder]);

        return redirect()->back()->with('success', 'จัดเก็บเอกสารเข้าแฟ้มเรียบร้อย');
    }
}
