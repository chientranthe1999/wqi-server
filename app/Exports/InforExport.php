<?php

namespace App\Exports;

use App\Services\InforService;
use App\Services\RecordsService;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Excel;

class InforExport implements FromCollection, Responsable, WithHeadings, WithCustomCsvSettings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;

    protected $params;
    protected $recordService;
    private $fileName = '';
    private $writerType = Excel::CSV;
    private $headers = [
        'Content-Type' => 'text/csv',
    ];
    protected $param;

    public function __construct(InforService $inforService, $params)
    {
        $this->inforService = $inforService;
        $this->params = $params;
    }

    public function collection()
    {
        return $this->recordService->downloadCSV($this->params);
    }

    public function headings(): array
    {
        return [
            'Thiết bị',
            'Thời gian',
            'Nhiệt độ',
            'pH',
            'Turbidity',
            'Do',
            'Nh4',
            'Bod5',
            'Tss',
            'Coliform',
            'WQI',
        ];
    }

    public function map($row): array
    {
        return [
            $row->device_name,
            $row->time,
            $row->temperature,
            $row->ph,
            $row->turbidity,
            $row->do,
            $row->nh4,
            $row->bod5,
            $row->tss,
            $row->coliform,
            $row->wqi
        ];
    }

    public function getCsvSettings(): array
    {
        return [
            'use_bom' => true,
        ];
    }
}
