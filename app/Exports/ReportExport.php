<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromCollection, WithHeadings
{
    protected $costs;
    protected $fabricUsages;

    public function __construct($costs, $fabricUsages)
    {
        $this->costs = $costs;
        $this->fabricUsages = $fabricUsages;
    }

    public function collection()
    {
        return collect([
            ['Biaya Penyimpanan dan Pemesanan'],
            ['Tanggal', 'Biaya Penyimpanan', 'Biaya Pemesanan'],
            ...$this->costs->map(fn($cost) => [$cost->date, $cost->holding_cost, $cost->order_cost]),
            [],
            ['Penggunaan Kain'],
            ['Tanggal', 'Nama Kain', 'Jumlah Digunakan', 'Stok Tersisa'],
            ...$this->fabricUsages->map(fn($usage) => [$usage->date, $usage->fabric->name, $usage->quantity_used, $usage->remaining_stock]),
        ]);
    }

    public function headings(): array
    {
        return [];
    }
}

