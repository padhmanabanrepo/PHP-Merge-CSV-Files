<?php

/**
 * padhmanaban.com
 * Merge multiple CSV files into one master CSV file 
 * Remove header line from individual file
 */

$directory = "FOLDERDIRECTORY/*"; // CSV Files Diectory Path

// Open and Write Master CSV File
$masterCSVFile = fopen('master-record.csv', "w+");

// Process each CSV file inside root directory
foreach(glob($directory) as $file) {

    $data = []; // Empty Data

    // Allow only CSV files
    if (strpos($file, '.csv') !== false) {

        // Open and Read individual CSV file
        if (($handle = fopen($file, 'r')) !== false) {
            // Collect CSV each row records
            while (($dataValue = fgetcsv($handle, 1000)) !== false) {
                $data[] = $dataValue;
            }
        }

        fclose($handle); // Close individual CSV file 
        
        unset($data[0]); // Remove first row of CSV, commonly tends to CSV header

        // Check whether record present or not
        if(count($data) > 0) {

            foreach ($data as $value) {
                try {
                // Insert record into master CSV file
                $val =  fputcsv($masterCSVFile, $value, ", ", "'");
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            
            }

        } else {
            echo "[$file] file contains no record to process.";
        }

    } else {
        echo "[$file] is not a CSV file.";
    }

}

// Close master CSV file 
fclose($masterCSVFile);

?>
