<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SalesPredictionsDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->collection($query)
            ->addColumn('action', 'sales_predictions.action');
    }

    public function query()
    {
        // Ambil data dari controller
        return $this->data;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('salespredictions-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>> .
                      'tr' .
                 <'row'<'col-md-5'i><'col-md-7 mt-2'p>>")
            ->orderBy(0)
            ->buttons(
                Button::make('excel')
                ->text('<i class="bi bi-file-earmark-excel-fill"></i> Excel'),
                Button::make('print')
                ->text('<i class="bi bi-printer-fill"></i> Print'),
                Button::make('reset')
                ->text('<i class="bi bi-x-circle"></i> Reset'),
                Button::make('reload')
                ->text('<i class="bi bi-arrow-repeat"></i> Reload')
            );
    }

    protected function getColumns()
    {
        return [
            Column::make('Waktu')->title('Bulan'),
            Column::make('SubTotal Penjualan')->title('Prediksi Penjualan'),
        ];
    }

    protected function filename(): string
    {
        return 'SalesPredictions_' . date('YmdHis');
    }
}

