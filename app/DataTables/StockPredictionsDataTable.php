<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StockPredictionsDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->collection($query)
            ->addColumn('action', 'stock_predictions.action');
    }

    public function query()
    {
        return $this->data;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('stockpredictions-table')
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
            Column::make('Produk')->title('Nama Produk'),
            Column::make('PrediksiQty')->title('Prediksi Jumlah Stok'),
            Column::make('StokAman')->title('Rekomendasi Stok Aman'),
        ];
    }

    protected function filename(): string
    {
        return 'StockPredictions_' . date('YmdHis');
    }

}
