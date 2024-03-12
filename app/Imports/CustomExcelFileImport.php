<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomExcelFileImport implements ToArray, WithHeadingRow
{
    public array $columns = [];
    public array $dataArr = [];

    public function array(array $rows)
    {
        if (empty($this->columns)) {
            $stringValues = array_filter(array_keys($rows[0]), 'is_string');
            $this->columns = array_values($stringValues);
        }

        foreach ($rows as $index => $rowData) {
            if (array_key_exists('mobile', $rowData)) {
                foreach ($rowData as $singleIndex => $data) {
                    if (is_string($singleIndex) && !empty($rowData['mobile'])) {
                        if ($singleIndex == 'mobile') {
                            $this->dataArr[$index][$singleIndex] = str_pad(substr($data, -10), 11, "0", STR_PAD_LEFT);
                        } else {
                            $this->dataArr[$index][$singleIndex] = $data;
                        }
                    }
                }
            }
        }
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getData(): array
    {
        return $this->dataArr;
    }
}
