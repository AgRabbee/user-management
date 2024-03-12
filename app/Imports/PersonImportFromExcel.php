<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PersonImportFromExcel implements ToArray, WithHeadingRow
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
            foreach ($rowData as $singleIndex => $data) {
                if (is_string($singleIndex)) {
                    $formattedData = $this->formatData($singleIndex, $data);
                    $this->dataArr[$index][trim($singleIndex)] = $formattedData;
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

    protected function formatData($column, $data)
    {
        if ($column === 'dob' && empty($data)) return null;

        if ($column === 'dob') {
            if(is_numeric($data)){
                // Convert Excel numeric date to DateTime object
                $dateTime = Date::excelToDateTimeObject($data);

                $wrongDate = $dateTime->format('Y-m-d');    // d-> should m & m->should d
                $wrongDateArr = explode('-', $wrongDate);
                $date = null;
                if (count($wrongDateArr) === 3) {
                    if($wrongDateArr[2] < 13){
                        $date = $wrongDateArr[0] . '-' . $wrongDateArr[2] . '-' . $wrongDateArr[1];
                    }else{
                        $date = $wrongDateArr[0] . '-' . $wrongDateArr[1] . '-' . $wrongDateArr[2];
                    }
                }
                return $date;
            }
            else{
                $data = str_replace('/','-',$data);
                return date('Y-m-d', strtotime($data));
            }

        }

        return trim($data);
    }
}
