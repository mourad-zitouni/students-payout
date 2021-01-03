<?php
namespace Payout;

class CsvReader {
    
    public function getData($fileName) {
        $header = NULL;
        $output = false;
        if (($handle = fopen($fileName, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (!$header)
                    $header = $data;
                else {
                    $output[$data[0]][] = array_combine($header, $data);
                }
            }
            fclose($handle);
        }

        return $output;
    }
    
}