<?php

namespace App\Http\Controllers;

use App\Models\Send;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sends = Send::orderBy('number', 'desc')->paginate(20);

        return view('send.index', ['sends' => $sends]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('send.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //เพิ่มข้อมูล
        if (!$request->id) {
            // ตรวจสอบข้อมูล
            $request->validate([
                'date' => ['required'],
                'to' => ['required', 'string', 'max:100'],
                'topic' => ['required', 'string', 'max:255'],
                'urgency' => ['required']
            ]);
            //ดึงเลขทะเบียนล่าสุด
            $number = Send::select('number')
                ->whereYear('created_at', '=', date('Y'))
                ->max('number');
            $number += 1;
            //เพิ่มข้อมูล
            $send = new Send();
            $send->no = "กห 0483.21/" . $number;
            $send->date = dateeng($request->date);
            $send->to = arabicnum($request->to);
            $send->topic = arabicnum($request->topic);
            $send->urgency = $request->urgency;
            $send->number = $number;
            $send->user_id = auth()->user()->id;
            $send->save();

            return redirect()->route('send.upload', $send->id);
        }
        //upload file
        else {
            $send = Send::findOrFail($request->id);
            //เช็คไฟล์แนบ
            if (!empty($request->file)) {
                $filename = yearthai() . '_send_' . $send->number . '.' . $request->file('file')->extension();
                $path = Storage::putFileAs(yearthai() . '/send', $request->file, $filename);
                $send->file = $path;
                $send->save();
            }

            return redirect()->route('send.index')->with('register', $send->number);
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
        $send = Send::findOrFail($id);

        return view('send.show', ['send' => $send]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $send = Send::findOrFail($id);

        return view('send.edit', ['send' => $send]);
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
        // ตรวจสอบข้อมูล
        $request->validate([
            'date' => ['required'],
            'to' => ['required', 'string', 'max:100'],
            'topic' => ['required', 'string', 'max:255'],
            'urgency' => ['required']
        ]);
        //แก้ไขข้อมูล
        $send = Send::findOrFail($id);
        $send->date = dateeng($request->date);
        $send->to = arabicnum($request->to);
        $send->topic = arabicnum($request->topic);
        $send->urgency = $request->urgency;
        //เช็คไฟล์แนบ
        if (!empty($request->file)) {
            if ($send->file) {
                Storage::delete($send->file);
            }
            $filename = yearthai() . '_MOD0483.21_' . $send->number . '.' . $request->file('file')->extension();
            $path = Storage::putFileAs(yearthai() . '/send', $request->file, $filename);
            $send->file = $path;
        }
        //บันทึกลงฐานข้อมูล
        $send->save();

        return redirect()->route('send.index')->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $send = Send::findOrFail($id);
        if (!empty($send->file)) {
            Storage::delete($send->file);
        }
        $send->delete();

        return redirect()->route('send.index')->with('success', 'ลบข้อมูลเรียบร้อย');
    }

    public function upload($id)
    {
        $send = Send::findOrFail($id);

        return view('send.upload', ['send' => $send]);
    }

    public function homeSearch()
    {
        return view('send.search');
    }

    public function search(Request $request)
    {
        if (isset($request->no) || isset($request->date) || isset($request->to) || isset($request->topic)) {
            $sends = Send::where('no', 'LIKE', '%' . $request->no . '%')
            ->where('date', 'LIKE', '%' . dateeng($request->date) . '%')
            ->where('to', 'LIKE', '%' . $request->from . '%')
            ->where('topic', 'LIKE', '%' . $request->topic . '%')
            ->orderBy('id', 'desc')
            ->paginate(20);

            if ($sends->count() == 0) {
                return redirect()->route('send.search.home')->with('fail', 'ไม่พบข้อมูล');
            }

            return view('send.index', ['sends' => $sends]);
        } else {
            return redirect()->route('send.search.home')->with('fail', 'กรุณาใส่ข้อมูล');
        }
    }

    public function download($id)
    {
        $send = Send::findOrFail($id);

        if ($send->file) {
            try {
                return response()->file(Storage::path($send->file));
            } catch (\Throwable $e) {
                return 'ไม่พบไฟล์ หรือไฟล์อาจถูกลบ';
            }
        } elseif (!$send->file) {
            return "ไม่ได้แนบไฟล์";
        }
    }
}
