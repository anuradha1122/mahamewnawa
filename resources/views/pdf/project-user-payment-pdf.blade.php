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

    <div>
      <img src="{{ public_path("images/letter-head.png") }}" alt="Letter Heaad" width="100%">
    </div>

    <footer>
      <img src="{{ public_path("images/footer.png") }}" alt="Footer" width="100%">
    </footer>

    <main style="border-top: 1px solid #7c0404;">
      <div class="center">
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
          <thead>
            <tr>
              <td>#</td>
              <td>Name With Initials</td>
              <td>NIC</td>
              <td>Amount</td>
            </tr>
          </thead>
          <tbody style="font-size: 12px;">
            @if ($payment_report->isNotEmpty())
              @foreach ($payment_report as $index => $payment)
                <tr>
                  <td style="padding: 5px;">{{ $index+1 }}</td>
                  <td style="padding: 5px;">{{ $payment->nameWithInitials }}</td>
                  <td style="padding: 5px;">{{ $payment->nic }}</td>
                  <td style="padding: 5px;">{{ $payment->total_amount }}</td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </main>
    
  </body>
</html>