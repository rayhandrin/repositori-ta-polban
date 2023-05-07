<?php

namespace App\Imports;

use App\Models\ProgramStudi;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProgramStudiImport implements ToModel, WithStartRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ProgramStudi([
            'nomor' => $row[0],
            'nama' => $row[1],
            'kode' => $row[2],
            'jurusan' => $row[3],
            'diploma' => $row[4]
        ]);
    }

    public function startRow(): int
    {
        return 3;
    }

    public function rules(): array
    {
        return [
            '0' => 'required|integer|digits:4|unique:program_studi,nomor',
            '1' => 'required|regex:/^[a-zA-Z\s\'\/]*$/',
            '2' => 'required',
            '3' => 'required|regex:/^[a-zA-Z\s]*$/',
            '4' => [
                'required',
                Rule::in(['D3', 'D4'])
            ],
        ];
    }
}
