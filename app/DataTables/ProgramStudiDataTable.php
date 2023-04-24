<?php

namespace App\DataTables;

use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProgramStudiDataTable extends DataTable
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
            ->setRowId('nomor')
            ->addColumn('aksi', function ($row) {
                $btn = '<a href="' . route('admin.program-studi.edit', $row->nomor) . '" class="btn btn-warning">Ubah</a>';
                $btn .= '<form action="' . route('admin.program-studi.destroy', $row->nomor) . '" method="post" class="d-inline">
                            ' . csrf_field() . '
                            <input type="hidden" name="_method" value="delete">
                            <button type="submit" class="btn btn-danger delete">Hapus</button>
                        </form>';

                return $btn;
            })
            ->rawColumns(['aksi']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ProgramStudi $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ProgramStudi $model): QueryBuilder
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
            ->setTableId('programstudi-table')
            ->setTableAttribute('style', 'width:100%')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(0, 'asc')
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
            Column::make('nomor')->width('8%'),
            Column::make('nama')->width('27%'),
            Column::make('kode')->width('12%'),
            Column::make('jurusan')->width('25%'),
            Column::make('diploma')->width('8%'),
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
        return 'ProgramStudi_' . date('YmdHis');
    }
}
