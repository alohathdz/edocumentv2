<?php

namespace App\Http\Controllers;

use App\Models\CommandDepartment;
use App\Models\DepartmentPresent;
use Illuminate\Support\Facades\DB;

class CopyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $dept = auth()->user()->department_id;

        $copys = DB::table(DB::raw("(SELECT no, topic, (SELECT initial FROM departments d WHERE c.department_id = d.id) as dept, cd.created_at
        FROM commands c, command_department cd
        WHERE c.id = cd.command_id
        AND cd.department_id = '$dept'
        UNION
        SELECT no, topic, (SELECT initial FROM departments d WHERE p.department_id = d.id) as dept, dp.created_at
        FROM presents p, department_present dp
        WHERE p.id = dp.present_id
        AND dp.department_id = '$dept') a"))
            ->orderBy('created_at', 'DESC')
            ->paginate(20);
    }

    #สำเนาหนังสือนำเรียน
    public function presents()
    {
        $presents = DepartmentPresent::select('present_id', 'topic', 'initial', 'no', 'department_present.created_at')
            ->where('department_present.department_id', auth()->user()->department_id)
            ->join('presents', 'department_present.present_id', '=', 'presents.id')
            ->join('departments', 'department_present.department_id', '=', 'departments.id')
            ->orderBy('department_present.created_at', 'DESC')
            ->paginate(20);

        return view('copy.present', compact('presents'));
    }

    #สำเนาคำสั่ง
    public function commands()
    {
        $commands = CommandDepartment::select('command_id', 'topic', 'initial', 'no', 'command_department.created_at')
            ->where('command_department.department_id', auth()->user()->department_id)
            ->join('commands', 'command_department.command_id', '=', 'commands.id')
            ->join('departments', 'command_department.department_id', '=', 'departments.id')
            ->orderBy('command_department.created_at', 'DESC')
            ->paginate(20);

        return view('copy.command', compact('commands'));
    }
}
