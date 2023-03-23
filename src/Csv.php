<?php


use Illuminate\Support\Facades\DB;

class Csv
{
    static function setTableCsv($table, $arrName, $path, $dir, $ignoreFirstRow = true, $separator = ';'): bool
    {
        $file = fopen("$dir/$path", 'r');
        $arr = [];
        $j = 0;

        while (($line = fgetcsv($file)) !== FALSE) {
            $row = explode($separator, current($line));

            if ($ignoreFirstRow) {
                $ignoreFirstRow = false;
                continue;
            }

            foreach ($arrName as $i => $value) {
                $rowValue = strtolower($row[$i]);
                $arr[$j][$value] = ($rowValue === "null") ? null : $rowValue;
            }
            $j++;
        }

        fclose($file);

        if (!empty($arr)) {
            DB::table($table)->insert($arr);
            return true;
        }

        return false;
    }

}