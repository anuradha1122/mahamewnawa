<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PDF</title>

  <style>
    body {
        font-family: 'Arial', sans-serif;
    }
    .center {
        text-align: center;
    }
    footer {
      position: fixed; 
      bottom: 0px; 
      left: 0px; 
      right: 0px;
      height: 80px; 
    }
  </style>
</head>
  <body>

    <div style="margin-top: -30px; margin-left: -10px; margin-right: -30px; border: 1px solid #00d9ff;">
      <table style="width: 100%; border-collapse: collapse;">
        <tr>
          <td style="vertical-align: middle;">
              <img src="{{ public_path('images/Mahmewnawa-Logo.png') }}" alt="Letter Head" width="100px">
          </td>
          <td style="vertical-align: middle; padding-left: 10px; text-align:center; padding: 5px;">
            <h3 style="margin: 0;">Mahamegha Dharma Yathra</h3>
            <span style="margin: 0;">228/1, New Kandy Road, Malabe, Sri Lanka.</span>
          </td>
          <td>
            <span>No: {{ $payment_id }}</span></br>
            <div style="">
              <span>Tel: 071 645 7000</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;071 931 7000</span>
            </div>
          </td>
        </tr>
      </table>
    </div>

    <div style="margin-top: -10px;">
      <h3 style="text-align: center;">Receipt</h3>
      <table style="width: 100%; border-collapse: collapse; margin-top: -15px;">
        <tbody>
          <tr>
            <td style="padding: 5px; width: 110px;">Name</td>
            <td style="padding: 5px; width: 344.5px;">: {{ $project_payments->name }}</td>
            <td style="padding: 5px;">Date</td>
            <td style="padding: 5px;">: {{ $project_payments->addedDate }}</td>
          </tr>
          <tr>
            <td style="padding: 5px;">Address</td>
            <td style="padding: 5px;">: {{ $project_payments->addressLine1 }},{{ $project_payments->addressLine1 }},{{ $project_payments->addressLine3 }}</td>
            <td style="padding: 5px;">Tel No</td>
            <td style="padding: 5px;">: {{ $project_payments->mobile1 }}</td>
          </tr>
          <tr>
            <td style="padding: 5px;" colspan="2"></td>
            <td style="padding: 5px;">NIC No</td>
            <td style="padding: 5px;">: {{ $project_payments->nic }}</td>
          </tr>
          <tr>
            <td>Tour Date</td>
            <td>: {{ $project_payments->startDate }}</td>
            <td style="text-align:center; border: 1px solid #00d9ff;" rowspan="5" colspan="2">Amount (LKR)</td>
          </tr>
          <tr>
            <td>Registration No</td>
            <td>: {{ $project_payments->project_id }} - {{ $project_payments->regId }}</td>
          </tr>
          
        </tbody>
      </table>

      <table style="width: 100%; border-collapse: collapse; margin-top: -14px;">
        <tbody>
          <tr>
            <td style="border-top: 1px solid #00d9ff; border-left: 1px solid #00d9ff; border-bottom: 1px solid #e1e1e1; padding-top: 5px; padding-bottom: 20px; width: 67.5%;"></td>
            <td style="border-top: 1px solid #00d9ff; border-left: 1px solid #00d9ff; border-right: 1px solid #00d9ff; border-bottom: 1px solid #e1e1e1; padding-top: 5px; text-align:right; padding-right: 5px;">{{ number_format($project_payments->amount,2) }}</td>
          </tr>
          <tr>
            <td style="border-left: 1px solid #00d9ff; border-bottom: 1px solid #e1e1e1; padding-top: 5px; padding-bottom: 20px;"></td>
            <td style="border-left: 1px solid #00d9ff; border-right: 1px solid #00d9ff; border-bottom: 1px solid #e1e1e1; padding-top: 5px;"></td>
          </tr>
          <tr>
            <td style="border-left: 1px solid #00d9ff; border-bottom: 1px solid #e1e1e1; padding-top: 5px; padding-bottom: 20px;"></td>
            <td style="border-left: 1px solid #00d9ff; border-right: 1px solid #00d9ff; border-bottom: 1px solid #e1e1e1; padding-top: 5px;"></td>
          </tr>
          <tr>
            <td style="border-left: 1px solid #00d9ff; border-bottom: 1px solid #00d9ff; padding: 5px;">Payment Method - 
              @if($project_payments->payment_method == 1)
                Bank
              @elseif($project_payments->payment_method == 2)
                Cash
              @endif
            </td>
            <td style="border-left: 1px solid #00d9ff; border-right: 1px solid #00d9ff; border-bottom: 1px solid #00d9ff; padding-top: 5px;"></td>
          </tr>
        </tbody>
      </table>

      <table style="width: 100%; border-collapse: collapse;">
        <tbody>
          <tr>
            <td style="padding-top: 5px; width: 18%; text-align: center; padding-top: 20px;">..................................</td>
            <td style="padding-top: 5px; width: 18%; text-align: center; padding-top: 20px;">..................................</td>
            <td style="padding-top: 5px; width: 16%; text-align: right;">Total (LKR)</td>
            <td style="border-left: 1px solid #00d9ff; border-right: 1px solid #00d9ff; border-bottom: 1px solid #00d9ff; padding-top: 5px; width: 25%; text-align:right; padding-right: 5px;">{{ number_format($project_payments->amount,2) }}</td>
          </tr>
          <tr>
            <td style="text-align: center;">Received By</td>
            <td style="text-align: center;">Approved By</td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;"></td>
          </tr>
        </tbody>
      </table>
    </div>
    
  </body>
</html>