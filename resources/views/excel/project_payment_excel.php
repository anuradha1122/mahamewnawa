<?php

//include the file that loads the PhpSpreadsheet classes
require '../vendor/autoload.php';

//include the classes needed to create and write .xlsx file
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
$spreadsheet = $reader->load(__DIR__."/ProjectPaymentReport.xlsx");


  $worksheet = $spreadsheet->getActiveSheet();
  
  $currentContentRow = 4;
  $serial_no = 1;
	foreach ($payment_report as $key => $payment) {
    
    $worksheet->insertNewRowBefore($currentContentRow+1,1);

    $worksheet->setCellValue('A'.$currentContentRow, $serial_no)
      ->setCellValue('B'.$currentContentRow, $payment->nameWithInitials)
      ->setCellValue('C'.$currentContentRow, $payment->amount)
      ->setCellValue('D'.$currentContentRow, $payment->addedDate)
      ->setTitle("Project Payment Report");
      $currentContentRow++;
      $serial_no++;
  }

  // redirect output to client browser
  header('Content-Type: application/vnd.ms-excel');
  header("Content-Disposition: attachment; filename= Project Payment Report.xlsx");
  header('Cache-Control: max-age=0');

  $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	$writer->save('php://output');
	
	?>