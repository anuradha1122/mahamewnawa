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

    if($result->genderId == 1){
      $gender = "Male";
    }
    elseif($result->genderId == 2)
      $gender = "Female";
    else{
      $gender = "";
    }
    
    $worksheet->insertNewRowBefore($currentContentRow+1,1);

    $worksheet->setCellValue('A'.$currentContentRow, $serial_no)
      ->setCellValue('B'.$currentContentRow, $result->userName)
      ->setCellValue('C'.$currentContentRow, $result->nameWithInitials)
      ->setCellValue('D'.$currentContentRow, $result->nic)
      ->setCellValue('E'.$currentContentRow, $result->category)
      ->setCellValue('F'.$currentContentRow, $result->email)
      ->setCellValue('G'.$currentContentRow, $result->addressLine1)
      ->setCellValue('H'.$currentContentRow, $result->addressLine2)
      ->setCellValue('I'.$currentContentRow, $result->addressLine3)
      ->setCellValue('J'.$currentContentRow, $result->district)
      ->setCellValue('K'.$currentContentRow, $result->mobile1)
      ->setCellValue('L'.$currentContentRow, $result->mobile2)
      ->setCellValue('M'.$currentContentRow, $result->race)
      ->setCellValue('N'.$currentContentRow, $result->religion)
      ->setCellValue('O'.$currentContentRow, $result->civilStatus)
      ->setCellValue('P'.$currentContentRow, $result->monastary)
      ->setCellValue('Q'.$currentContentRow, $result->birthDay)
      ->setCellValue('R'.$currentContentRow, $gender)
      ->setCellValue('S'.$currentContentRow, $result->guardian)
      ->setCellValue('T'.$currentContentRow, $result->guardianPhone)
      ->setCellValue('U'.$currentContentRow, $result->guardianEmail)
      ->setCellValue('V'.$currentContentRow, $result->birthPlace)
      ->setCellValue('W'.$currentContentRow, $result->occupation)
      ->setCellValue('X'.$currentContentRow, $result->previousAbroadName)
      ->setCellValue('Y'.$currentContentRow, $result->spouse)
      ->setCellValue('Z'.$currentContentRow, $result->spousebirthPlace)
      ->setCellValue('AA'.$currentContentRow, $result->spouseOccupation)
      ->setCellValue('AB'.$currentContentRow, $result->mother)
      ->setCellValue('AC'.$currentContentRow, $result->motherBirthPlace)
      ->setCellValue('AD'.$currentContentRow, $result->motherOccupation)
      ->setCellValue('AE'.$currentContentRow, $result->father)
      ->setCellValue('AF'.$currentContentRow, $result->fatherBirthPlace)
      ->setCellValue('AG'.$currentContentRow, $result->fatherOccupation)
      ->setCellValue('AH'.$currentContentRow, $result->passportValue)
      ->setCellValue('AI'.$currentContentRow, $result->passportNo)
      ->setCellValue('AJ'.$currentContentRow, $result->policeReportValue)
      ->setCellValue('AK'.$currentContentRow, $result->payment)
      ->setCellValue('AL'.$currentContentRow, $result->diabetes)
      ->setCellValue('AM'.$currentContentRow, $result->highBloodPressure)
      ->setCellValue('AN'.$currentContentRow, $result->asthma)
      ->setCellValue('AO'.$currentContentRow, $result->apoplexy)
      ->setCellValue('AP'.$currentContentRow, $result->heartDisease)
      ->setCellValue('AQ'.$currentContentRow, $result->otherIllness)
      ->setCellValue('AR'.$currentContentRow, $result->otherIllnessDescription)
      ->setCellValue('AS'.$currentContentRow, $result->heartOtherOperation)
      ->setCellValue('AT'.$currentContentRow, $result->artificialHandLeg)
      ->setCellValue('AU'.$currentContentRow, $result->mentalIllness)
      ->setCellValue('AV'.$currentContentRow, $result->forces)
      ->setCellValue('AW'.$currentContentRow, $result->forcesRemoval)
      ->setCellValue('AX'.$currentContentRow, $result->courtOrder)
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