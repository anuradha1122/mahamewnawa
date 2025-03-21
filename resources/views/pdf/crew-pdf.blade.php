<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PDF</title>

  <style>
    .center {
        text-align: center;
    }
    footer {
      position: fixed; 
      bottom: 0px; 
      left: 0px; 
      right: 0px;
      height: 50px; 
    }
  </style>
</head>
  <body>

    <div style="border-bottom: 1px solid #7c0404;">
      <img src="{{ public_path("images/letter-head.png") }}" alt="Letter Heaad" width="100%">
    </div>

    <footer>
      <img src="{{ public_path("images/footer.png") }}" alt="Footer" width="100%">
    </footer>

    <main>
      <div class="center">
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
          <tbody style="font-size: 12px;">
            <tr>
              <td style="padding: 5px; width: 30%;">Name</td>
              <td style="padding: 5px;">: {{ $crew->name }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Name with Initials</td>
              <td style="padding: 5px;">: {{ $crew->nameWithInitials }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">NIC</td>
              <td style="padding: 5px;">: {{ $crew->nic }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Email</td>
              <td style="padding: 5px;">: {{ $crew->email }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Address Line 1</td>
              <td style="padding: 5px;">: {{ $crew->addressLine1 }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Address Line 2</td>
              <td style="padding: 5px;">: {{ $crew->addressLine2 }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Address Line 3</td>
              <td style="padding: 5px;">: {{ $crew->addressLine3 }}</td>
            </tr>
            @if(!empty($crew->districtId))
            <tr>
              <td style="padding: 5px;">District</td>
              <td style="padding: 5px;">: {{ $crew->district }}</td>
            </tr>
            @endif
            <tr>
              <td style="padding: 5px;">Mobile</td>
              <td style="padding: 5px;">: {{ $crew->mobile1 }}</td>
              <td style="padding: 5px;">Whatapp</td>
              <td style="padding: 5px;">: {{ $crew->mobile2 }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Race</td>
              <td style="padding: 5px;">: {{ $crew->race }}</td>
              <td style="padding: 5px;">Birth Religion</td>
              <td style="padding: 5px;">: {{ $crew->religion }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Civil Status</td>
              <td style="padding: 5px;">: {{ $crew->civilStatus }}</td>
              @if(!empty($crew->monasteryId))
              <td style="padding: 5px;">Nearest Mahamewnawa Monastery</td>
              <td style="padding: 5px;">: {{ $crew->monastary }}</td>
              @endif
            </tr>      
            <tr>
              <td style="padding: 5px;">Birth Day</td>
              <td style="padding: 5px;">: {{ $crew->birthDay }}</td>
              <td style="padding: 5px;">Gender</td>
              <td style="padding: 5px;">: {{ $crew->gender }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Guardian</td>
              <td style="padding: 5px;">: {{ $crew->guardian }}</td>
              <td style="padding: 5px;">Guardian Phone</td>
              <td style="padding: 5px;">: {{ $crew->guardianPhone }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Guardian Email</td>
              <td style="padding: 5px;">: {{ $crew->guardianEmail }}</td>
              <td style="padding: 5px;">Birth Place</td>
              <td style="padding: 5px;">: {{ $crew->birthPlace }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Occupation</td>
              <td style="padding: 5px;">: {{ $crew->occupation }}</td>
              <td style="padding: 5px;">Previous Abroad</td>
              <td style="padding: 5px;">: {{ $crew->previousAbroadName }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Spouse</td>
              <td style="padding: 5px;">: {{ $crew->spouse }}</td>
              <td style="padding: 5px;">Spouse BirthPlace</td>
              <td style="padding: 5px;">: {{ $crew->spousebirthPlace }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Spouse Occupation</td>
              <td style="padding: 5px;">: {{ $crew->spouseOccupation }}</td>
              <td style="padding: 5px;">Mother</td>
              <td style="padding: 5px;">: {{ $crew->mother }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Mother Birth Place</td>
              <td style="padding: 5px;">: {{ $crew->motherBirthPlace }}</td>
              <td style="padding: 5px;">Mother Occupation</td>
              <td style="padding: 5px;">: {{ $crew->motherOccupation }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Father</td>
              <td style="padding: 5px;">: {{ $crew->father }}</td>
              <td style="padding: 5px;">Father Birth Place</td>
              <td style="padding: 5px;">: {{ $crew->fatherBirthPlace }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Father Occupation</td>
              <td style="padding: 5px;">: {{ $crew->fatherOccupation }}</td>
              <td style="padding: 5px;">Passport</td>
              <td style="padding: 5px;">: {{ $crew->passportValue }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Passport No</td>
              <td style="padding: 5px;">: {{ $crew->passportNo }}</td>
              <td style="padding: 5px;">Police Report</td>
              <td style="padding: 5px;">: {{ $crew->policeReportValue }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Payment</td>
              <td style="padding: 5px;">: {{ $crew->payment }}</td>
              <td style="padding: 5px;">Diabetes</td>
              <td style="padding: 5px;">: {{ $crew->diabetes }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">High Blood Pressure</td>
              <td style="padding: 5px;">: {{ $crew->highBloodPressureValue }}</td>
              <td style="padding: 5px;">Asthma</td>
              <td style="padding: 5px;">: {{ $crew->asthmaValue }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Apoplexy</td>
              <td style="padding: 5px;">: {{ $crew->apoplexyValue }}</td>
              <td style="padding: 5px;">Heart Disease</td>
              <td style="padding: 5px;">: {{ $crew->heartDiseaseValue }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Other Illness</td>
              <td style="padding: 5px;">: {{ $crew->otherIllnessValue }}</td>
              <td style="padding: 5px;">Other Illness Description</td>
              <td style="padding: 5px;">: {{ $crew->otherIllnessDescription }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Heart or Other Operation</td>
              <td style="padding: 5px;">: {{ $crew->heartOtherOperationValue }}</td>
              <td style="padding: 5px;">Artificial Hand/Leg</td>
              <td style="padding: 5px;">: {{ $crew->artificialHandLegValue }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Mental Illness</td>
              <td style="padding: 5px;">: {{ $crew->mentalIllnessValue }}</td>
              <td style="padding: 5px;">Forces</td>
              <td style="padding: 5px;">: {{ $crew->forcesValue }}</td>
            </tr>
            <tr>
              <td style="padding: 5px;">Forces Removal</td>
              <td style="padding: 5px;">: {{ $crew->forcesRemovalValue }}</td>
              <td style="padding: 5px;">Court Order</td>
              <td style="padding: 5px;">: {{ $crew->courtOrderValue }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>
    
  </body>
</html>