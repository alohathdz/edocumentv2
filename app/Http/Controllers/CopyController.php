<?php

namespace App\Http\Controllers;

use App\Models\CommandDepartment;
use App\Models\DepartmentPresent;
use App\Models\PresentUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CopyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $presents = DepartmentPresent::select('topic', 'initial', 'no')
            ->where('department_present.department_id', auth()->user()->department_id)
            ->join('presents', 'department_present.present_id', '=', 'presents.id')
            ->join('departments', 'department_present.department_id', '=', 'departments.id');

        $commands = CommandDepartment::select('topic', 'initial', 'no')
            ->where('command_department.department_id', auth()->user()->department_id)
            ->join('commands', 'command_department.command_id', '=', 'commands.id')
            ->join('departments', 'command_department.department_id', '=', 'departments.id')
            ->union($presents)
            ->paginate(20);

        $copys = DB::table(DB::raw('(select no, topic, cd.created_at from commands c, command_department cd
        WHERE c.id = cd.command_id AND cd.department_id = 1
        union
        select no, topic, dp.created_at from presents p, department_present dp
        WHERE p.id = dp.present_id AND dp.department_id = 1) a'))
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        #$result = $commands->union($presents);

        return view('copy.index', compact('copys'));
    }
}
