<?php

namespace App\DataTables;

use App\Models\TugasAkhir;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TugasAkhirDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->addColumn('aksi', function ($row) {
                $btn = '<a href="' . route('admin.tugas-akhir.show', $row->id) . '" class="btn btn-info">Detail</a>';
                $btn .= '<form action="' . route('admin.tugas-akhir.destroy', $row->id) . '" method="post" class="d-inline">
                            ' . csrf_field() . '
                            <input type="hidden" name="_method" value="delete">
                            <button type="submit" class="btn btn-danger delete">Hapus</button>
                        </form>';

                return $btn;
            })
            ->rawColumns(['aksi']);;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\TugasAkhir $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TugasAkhir $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('tugasakhir-table')
            ->setTableAttribute('style', 'width:100%')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->width('15%')->title('ID'),
            Column::make('judul'),
            Column::make('tahun')->width('8%'),
            Column::make('kata_kunci')->width('27%'),
            Column::computed('aksi')->addClass('text-center')->width('20%')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'TugasAkhir_' . date('YmdHis');
    }
}
