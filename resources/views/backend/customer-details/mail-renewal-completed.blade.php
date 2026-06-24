<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>DDPU – Membership Renewal</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: #ffffff; border: 1px solid #e5e5e5; }
        .header { text-align: center; padding: 20px; border-bottom: 1px solid #e5e5e5; }
        .header img { max-width: 140px; }
        .title { padding: 15px 20px; background: #f0f0f0; text-align: center; font-size: 18px; font-weight: bold; }
        .content { padding: 25px 30px; font-size: 14px; color: #333; line-height: 1.8; }
        .content p { margin: 0 0 12px; }
        .section-label { font-weight: bold; margin: 18px 0 6px; font-size: 14px; }
        .schedule-box { background: #f9f9f9; border: 1px solid #e0e0e0; padding: 15px 20px; margin: 15px 0; }
        .schedule-box table { width: 100%; border-collapse: collapse; }
        .schedule-box td { padding: 5px 0; vertical-align: top; font-size: 14px; }
        .schedule-box td:first-child { font-weight: bold; width: 180px; color: #555; }
        .notes-list { margin: 15px 0; padding-left: 20px; }
        .notes-list li { margin-bottom: 8px; font-size: 14px; line-height: 1.6; }
        .emergency-box { background: #fff8e1; border: 1px solid #ffe082; padding: 12px 18px; margin: 18px 0; font-size: 13px; text-align: center; }
        .emergency-box strong { display: block; font-size: 15px; margin-bottom: 4px; }
        .footer-info { padding: 15px 30px; font-size: 12px; color: #555; border-top: 1px solid #e5e5e5; line-height: 1.6; }
        .footer { text-align: center; font-size: 11px; color: #777; padding: 12px 15px; border-top: 1px solid #e5e5e5; background: #fafafa; }
        u { text-decoration: underline; }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <img src="https://anvayafoundation.com/DDPU/frontend/assets/img/logo/ddpu-logo.jpg" alt="DDPU Logo">
    </div>

    <div class="title">Membership Renewal Notice</div>

    <div class="content">
@php
    $renewalCarbon       = \Carbon\Carbon::parse($renewalDate);
    $yearRange           = $renewalCarbon->format('Y') . ' - ' . $renewalCarbon->copy()->addYear()->format('Y');
    $isMonthly           = str_contains(strtolower($paymentPlan ?? ''), 'month');
    $monthlyAmount       = number_format((float)($price ?? 0), 2);
    $totalAnnualAmount   = number_format((float)($price ?? 0) * 12, 2);
    $annualFee           = number_format((float)($price ?? 0), 2);

    $collectionDay = 11;
    if ($renewalCarbon->day < $collectionDay) {
        $nextCollectionDate = $renewalCarbon->copy()->setDay($collectionDay)->format('d/m/Y');
    } else {
        $nextCollectionDate = $renewalCarbon->copy()->addMonthNoOverflow()->setDay($collectionDay)->format('d/m/Y');
    }
@endphp

        <p>Dear <strong>{{ $name }}</strong>,</p>

       @if($isMonthly)
    <p>DDPU has successfully completed another year of service. Thank you for your confidence in us and we look forward to continuing this relationship.</p>

    <p>We would like to remind you that your annual membership is due for renewal on <strong>{{ $renewalCarbon->format('d F Y') }}</strong>. We are pleased to be able to renew your annual membership for a fee of <strong>£{{ $totalAnnualAmount }}</strong> per annum to be paid by monthly direct debit.</p>

    <p>Provided that you are happy for the renewal to take place, you will not need to take any steps, as your membership will be renewed automatically.</p>

    <p>As you are paying by <u>monthly instalments</u>, the amounts to be collected by Direct Debit and the <u>collection schedule</u> for [{{ $yearRange }}] will be as follows:</p>

    <div class="schedule-box">
        <div class="section-label">Annual Amount:</div>
        <table>
            <tr>
                <td>Payment Plan:</td>
                <td>Monthly</td>
            </tr>
            <tr>
                <td>Annual Fee:</td>
                <td>£{{ $totalAnnualAmount }} per annum, broken up as follows:</td>
            </tr>
            <tr>
                <td>Instalments:</td>
                <td>12 monthly instalments of £{{ $monthlyAmount }}</td>
            </tr>
        </table>

        <div class="section-label">Collection Schedule:</div>
        <p style="margin:0; font-size:14px;">
            We plan to collect the first payment of <strong>£{{ $monthlyAmount }}</strong> on
            <strong>{{ $nextCollectionDate ?? '[DATE OF NEXT FASTPAY COLLECTION]' }}</strong>.
            The subsequent collections of <strong>£{{ $monthlyAmount }}</strong> will be on the 10th of each following month
            (or the first working day after the 10th if that happens to be a weekend or a bank holiday).
        </p>
    </div>

@else
    <p>DDPU has successfully completed another year of service. Thank you for your confidence in us and we look forward to continuing this relationship.</p>

    <p>We would like to remind you that your annual membership is due for renewal on <strong>{{ $renewalCarbon->format('d F Y') }}</strong>. We are pleased to be able to renew your annual membership for a fee of <strong>£{{ $annualFee }}</strong> per annum to be paid by direct debit.</p>

    <p>Provided that you are happy for the renewal to take place, you will not need to take any steps, as your membership will be renewed automatically.</p>

    <p>As you are paying by <u>single instalment</u>, the amount to be collected by Direct Debit for [{{ $yearRange }}] will be as follows:</p>

    <div class="schedule-box">
        <table>
            <tr>
                <td>Payment Plan:</td>
                <td>Annual (Single Payment)</td>
            </tr>
            <tr>
                <td>Annual Fee:</td>
                <td>£{{ $annualFee }} per annum</td>
            </tr>
        </table>

        <div class="section-label">Collection Schedule:</div>
        <p style="margin:0; font-size:14px;">
            We plan to collect the annual payment of <strong>£{{ $annualFee }}</strong> on
            <strong>{{ $nextCollectionDate ?? '[NEXT FASTPAY COLLECTION DATE]' }}</strong>.
        </p>
    </div>
@endif

        <div class="section-label">Please Note:</div>
        <ul class="notes-list">
            <li>Our collection dates as aforesaid cannot be varied.</li>
            <li>Kindly do not make changes to or cancel your Direct Debit instruction without prior notice to us; this results in penalties to DDPU which will then get passed on to you. Please let us know beforehand even if the intention is simply to change the direct debit mandate or frequency of payment.</li>
            @if($isMonthly)
                <li>A failure to pay monthly Direct Debit will only incur a charge if there has been failure on 2 occasions, and the charge incurred will be limited to £5.</li>
            @else
                <li>A failure to pay a Direct Debit will only incur a charge if there has been failure on 2 occasions, and the charge incurred will be limited to £5.</li>
            @endif
            <li>Membership with DDPU is offered on an annual basis. By agreeing to the renewal terms, the member undertakes to pay the annual fee, detailed above, <u>in full</u>. In the event of a member terminating membership prior to the annual renewal, any outstanding fees will become due immediately; in the event that the full outstanding fee is not settled, DDPU may take appropriate action against the member.</li>
        </ul>

        @if(!$isMonthly)
            <p>Our staff is available to assist you; if you need assistance please write back to us.</p>

            <div class="emergency-box">
                <strong>** Please use the following number for Emergency Advice only **</strong>
                Emergency Advice: <strong>07476 956818</strong><br>
                <em>Only for urgent advice!</em>
            </div>
        @endif

        <p>Your updated membership certificate is attached with this email. Please keep it for your records.</p>

        <p>Best wishes,<br>
        <strong>DDPU Membership</strong></p>

    </div>

    <div class="footer-info">
        <strong>Doctors and Dentists Protection Union</strong><br>
        9 Belgrave Avenue, Urmston, Manchester M41 8SR
        &nbsp;|&nbsp; Tel: 0161 8702193<br>
        Email: <a href="mailto:membership@ddpu.co.uk">membership@ddpu.co.uk</a>
        &nbsp;|&nbsp; Website: <a href="http://www.ddpu.co.uk">www.ddpu.co.uk</a><br>
        <span style="color:#888; font-size:11px;">
            Doctors and Dentists Protection Union is a trading name of DDPU Ltd.<br>
            DDPU Ltd is registered with Companies House. Registration No: 08711442
        </span>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} DDPU. All rights reserved.
    </div>

</div>
</body>
</html>