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
  </style>
</head>
  <body>

    <div style="border: 1px solid #333; border-radius: 5px; text-align: center; padding: 10px;">
      <h1 style="font-size: 28px; font-weight: 700; line-height: 1.25rem;">Mahamewnawa</h1>
      <h1 style="font-size: 20px; font-weight: 700; line-height: 1.25rem;">Dambadiwa Crew List Report</h1>
    </div>

    <div class="center">
      <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <thead>
          <tr>
            <td style="border: 1px solid; padding: 5px; background: #cbcbcb;">#</td>
            <td style="border: 1px solid; padding: 5px; background: #cbcbcb;">Name</td>
            <td style="border: 1px solid; padding: 5px; background: #cbcbcb;">Name with Initials</td>
            <td style="border: 1px solid; padding: 5px; background: #cbcbcb;">NIC</td>
            <td style="border: 1px solid; padding: 5px; background: #cbcbcb;">Category</td>
            <td style="border: 1px solid; padding: 5px; background: #cbcbcb;">Diabetics</td>
            <td style="border: 1px solid; padding: 5px; background: #cbcbcb;">High Blood Pressure</td>
            <td style="border: 1px solid; padding: 5px; background: #cbcbcb;">Asthma</td>
            <td style="border: 1px solid; padding: 5px; background: #cbcbcb;">Apoplexy</td>
            <td style="border: 1px solid; padding: 5px; background: #cbcbcb;">Heart Disease</td>
            <td style="border: 1px solid; padding: 5px; background: #cbcbcb;">Other Illnesess</td>
            <td style="border: 1px solid; padding: 5px; background: #cbcbcb;">Heart or Other Operations</td>
            <td style="border: 1px solid; padding: 5px; background: #cbcbcb;">Artificial Hand or Leg</td>
            <td style="border: 1px solid; padding: 5px; background: #cbcbcb;">Mental Illness</td>
            <td style="border: 1px solid; padding: 5px; background: #cbcbcb;">Forces</td>
            <td style="border: 1px solid; padding: 5px; background: #cbcbcb;">Forces Removal</td>
            <td style="border: 1px solid; padding: 5px; background: #cbcbcb;">Court Order</td>
          </tr>
        </thead>
        <tbody>
          @php
            $serial_no = 0;
          @endphp
          @foreach ($results as $result)
            @php
              $serial_no ++;
            @endphp
            <tr>
              <td style="border: 1px solid; padding: 5px;">{{ $serial_no }}</td>
              <td style="border: 1px solid; padding: 5px;">{{ $result->userName }}</td>
              <td style="border: 1px solid; padding: 5px;">{{ $result->nameWithInitials }}</td>
              <td style="border: 1px solid; padding: 5px;">{{ $result->nic }}</td>
              <td style="border: 1px solid; padding: 5px;">{{ $result->category }}</td>
              <td style="border: 1px solid; padding: 5px;">{{ $result->diabetes }}</td>
              <td style="border: 1px solid; padding: 5px;">{{ $result->highBloodPressure }}</td>
              <td style="border: 1px solid; padding: 5px;">{{ $result->asthma }}</td>
              <td style="border: 1px solid; padding: 5px;">{{ $result->apoplexy }}</td>
              <td style="border: 1px solid; padding: 5px;">{{ $result->heartDisease }}</td>
              <td style="border: 1px solid; padding: 5px;">{{ $result->otherIllness }}</td>
              <td style="border: 1px solid; padding: 5px;">{{ $result->heartOtherOperation }}</td>
              <td style="border: 1px solid; padding: 5px;">{{ $result->artificialHandLeg }}</td>
              <td style="border: 1px solid; padding: 5px;">{{ $result->mentalIllness }}</td>
              <td style="border: 1px solid; padding: 5px;">{{ $result->forces }}</td>
              <td style="border: 1px solid; padding: 5px;">{{ $result->forcesRemoval }}</td>
              <td style="border: 1px solid; padding: 5px;">{{ $result->courtOrder }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    
  </body>
</html>