<?php

//include the file that loads the PhpSpreadsheet classes
require '../vendor/autoload.php';

//include the classes needed to create and write .xlsx file
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
$spreadsheet = $reader->load(__DIR__."/CrewListReport.xlsx");


  $worksheet = $spreadsheet->getActiveSheet();
  
  $currentContentRow = 4;
  $serial_no = 1;
	foreach ($results as $key => $result) {
    
    $worksheet->insertNewRowBefore($currentContentRow+1,1);

    $worksheet->setCellValue('A'.$currentContentRow, $serial_no)
      ->setCellValue('B'.$currentContentRow, $result->userName)
      ->setCellValue('C'.$currentContentRow, $result->nameWithInitials)
      ->setCellValue('D'.$currentContentRow, $result->nic)
      ->setCellValue('E'.$currentContentRow, $result->category)
      ->setCellValue('F'.$currentContentRow, $result->diabetes)
      ->setCellValue('G'.$currentContentRow, $result->highBloodPressure)
      ->setCellValue('H'.$currentContentRow, $result->asthma)
      ->setCellValue('I'.$currentContentRow, $result->apoplexy)
      ->setCellValue('J'.$currentContentRow, $result->heartDisease)
      ->setTitle("Crew List Report");
      $currentContentRow++;
      $serial_no++;
  }

  // redirect output to client browser
  header('Content-Type: application/vnd.ms-excel');
  header("Content-Disposition: attachment; filename= Crew List Report.xlsx");
  header('Cache-Control: max-age=0');

  $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	$writer->save('php://output');
	
	?>