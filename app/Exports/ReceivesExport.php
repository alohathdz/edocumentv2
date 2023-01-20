<?php

namespace App\Exports;

use App\Models\Receive;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReceivesExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function dateExport($dateFrom, $dateTo)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;

        return $this;
    }

    public function headings(): array
    {
        return [
            'ลงวันที่',
            'จาก',
            'เรื่อง',
        ];
    }

    public function query()
    {
        return Receive::query()
        ->select('date', 'from', 'topic')
        ->whereDate('created_at', '>=', $this->dateFrom)
        ->whereDate('created_at', '<=', $this->dateTo);
    }
}
