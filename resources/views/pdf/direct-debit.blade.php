<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Direct Debit Instruction</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header img { max-height: 50px; }
        .title { text-align: center; margin-bottom: 20px; }
        .section { margin-bottom: 15px; }
        .section strong { display: inline-block; width: 150px; }
        .border-box { border: 1px solid #000; padding: 10px; margin-top: 20px; }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('frontend/assets/img/DDPU-logo.png') }}" alt="DDPU Logo">
    <img src="{{ public_path('frontend/assets/img/direct-debit-logo.png') }}" alt="Direct Debit Logo">
</div>

<p><strong>Date:</strong> {{ $date }}</p>

<h2 class="title">Direct Debit Instruction</h2>

<div class="section">
    <strong>Name:</strong> {{ $accountHolder ?? $companyName }}<br>
    <strong>Account Number:</strong> {{ $accountNumber ?? '-' }}<br>
    <strong>Sort Code:</strong> {{ $sortCode ?? '-' }}<br>
    <strong>Bank:</strong> {{ $bankName ?? '-' }}<br>
    <strong>Branch:</strong> {{ $branchName ?? '-' }}<br>
    <strong>Service User Number:</strong> {{ $serviceNumber }}
</div>

<p>
    Please pay FastPay Ltd Re DDPU Ltd Direct Debits from the account detailed in this instruction subject to the safeguards assured by the Direct Debit Guarantee.
</p>

<div class="border-box">
    <h4>Direct Debit Guarantee</h4>
    <p>
        This Guarantee is offered by all Banks and Building Societies that accept instructions to pay Direct Debits.<br>
        If there are any changes to the amount, date or frequency of your Direct Debit, FastPay Ltd Re DDPU Ltd will notify you five working days in advance of your account being debited or as otherwise agreed. If you request FastPay Ltd Re DDPU Ltd to collect a payment, confirmation of the amount and date will be given to you at the time of the request.<br>
        If an error is made in the payment of your Direct Debit by FastPay Ltd Re DDPU Ltd or your Bank or Building Society, you are entitled to a full and immediate refund of the amount paid from your bank or building society.
    </p>
</div>

</body>
</html>
