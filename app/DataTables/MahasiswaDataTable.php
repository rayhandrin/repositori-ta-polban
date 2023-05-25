<?php

namespace App\DataTables;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MahasiswaDataTable extends DataTable
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
            ->setRowId('nim')
            ->addColumn('program_studi', function ($row) {
                return $row->programStudi->nama;
            })
            ->addColumn('status_aktif', function ($row) {
                $class = ($row->status_aktif) ? 'text-bg-success' : 'text-bg-warning';
                $text = ($row->status_aktif) ? 'Aktif' : 'Tidak Aktif';
                $badge = "<span class='badge rounded-pill $class'>$text</span>";

                return $badge;
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<a href="' . route('admin.mahasiswa.show', $row->nim) . '" class="btn btn-info me-2">Detail</a>';
                $btn .= '<a href="' . route('admin.mahasiswa.edit', $row->nim) . '" class="btn btn-warning me-1 disabled">Ubah</a>';
                $btn .= '<form action="' . route('admin.mahasiswa.destroy', $row->nim) . '" method="post" class="d-inline">
                            ' . csrf_field() . '
                            <input type="hidden" name="_method" value="delete">
                            <button type="submit" class="btn btn-danger delete">Hapus</button>
                        </form>';

                return $btn;
            })
            ->rawColumns(['aksi', 'status_aktif']);;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Mahasiswa $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Mahasiswa $model): QueryBuilder
    {
        return $model->with('programStudi:nomor,nama')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('mahasiswa-table')
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
            Column::make('nim')->title('NIM'),
            Column::make('nama'),
            Column::make('program_studi'),
            Column::computed('status_aktif'),
            Column::computed('aksi')->addClass('text-center')->width('25%'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Mahasiswa_' . date('YmdHis');
    }
}
