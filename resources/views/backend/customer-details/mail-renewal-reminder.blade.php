<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>DDPU – Annual Membership Renewal</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; margin: 0; }
        .email-wrap { max-width: 640px; margin: 0 auto; background: #ffffff; border: 1px solid #e5e5e5; }
        .email-header { text-align: center; padding: 20px; background: #ffffff; border-bottom: 1px solid #eee; }
        .email-header img { max-width: 150px; }
        .email-body { padding: 25px 30px; color: #333; font-size: 14px; line-height: 1.75; }
        .email-body p { margin: 0 0 14px; }

        .section-heading {
            font-weight: bold;
            font-size: 14px;
            background: #f0f0f0;
            padding: 8px 12px;
            margin: 22px 0 10px;
            border-left: 4px solid #555;
            letter-spacing: 0.3px;
        }

        .dd-box {
            background: #f9f9f9;
            border: 1px solid #e0e0e0;
            padding: 14px 18px;
            margin: 10px 0 16px;
            font-size: 14px;
            line-height: 1.7;
        }
        .dd-box p      { margin: 0 0 8px; }
        .dd-box p:last-child { margin: 0; }
        .dd-label      { font-weight: bold; color: #444; margin-bottom: 4px; display: block; }

        .please-note-list { padding-left: 18px; margin: 5px 0 16px; }
        .please-note-list li { margin-bottom: 10px; font-size: 14px; line-height: 1.6; }

        .emergency-box {
            border: 1px solid #e0c48a;
            background: #fff9ec;
            padding: 12px 16px;
            margin: 18px 0;
            font-size: 14px;
            line-height: 1.6;
        }
        .emergency-box .lbl    { font-weight: bold; color: #444; }
        .emergency-box .number { color: #b45309; font-weight: bold; font-size: 15px; }

        .footer-info {
            padding: 15px 30px;
            font-size: 12px;
            color: #555;
            border-top: 1px solid #e5e5e5;
            line-height: 1.7;
        }
        .email-footer {
            text-align: center;
            padding: 12px 15px;
            font-size: 11px;
            color: #777;
            background: #f4f4f4;
            border-top: 1px solid #e5e5e5;
        }
        u { text-decoration: underline; }
    </style>
</head>
<body>
<div class="email-wrap">

    <div class="email-header">
        <img src="https://anvayafoundation.com/DDPU/frontend/assets/img/logo/ddpu-logo.jpg" alt="DDPU Logo">
    </div>

    <div class="email-body">

    @php
        /*
         | Next FastPay collection date
         | 10th of month; weekend → roll forward to Monday.
         | Example: start 23 Apr 2026 → May 10 Sun → Mon 11/05/2026.
         */
        $nextCollectionDate = null;
if (!empty($start)) {
    // Always the 10th of the NEXT month, regardless of start day
    $candidate = $start->copy()->addMonthNoOverflow()->setDay(10);

    // Skip Saturday/Sunday → roll forward to Monday
    while ($candidate->isWeekend()) {
        $candidate->addDay();
    }
    $nextCollectionDate = $candidate;
}

        // Period label e.g. "2026 - 2027" — covers the NEXT membership year
        $periodLabel = ($start && $end)
            ? $start->format('Y') . ' - ' . $end->format('Y')
            : null;

        // "Dear [TITLE] [SURNAME]" — falls back to full name if pieces missing
        $greetingName = trim(($salutationTitle ?? '') . ' ' . ($surname ?? ''));
        if ($greetingName === '') { $greetingName = $name; }
    @endphp

        <p>Dear <strong>{{ $greetingName }}</strong>,</p>

        <p>
            DDPU has successfully completed another year of service. Thank you for your
            confidence in us and we look forward to continuing this relationship.
        </p>

    @if($isMonthly)

        <p>
            We would like to remind you that your annual membership is due for renewal on
            <strong>{{ $renewalDate }}</strong>. We are pleased to be able to renew your
            annual membership for a fee of <strong>£{{ $totalAnnualAmount }}</strong> per
            annum to be paid by monthly direct debit.
        </p>

        <p>
            Provided that you are happy for the renewal to take place, you will not need to
            take any steps, as your membership will be renewed automatically.
        </p>

        <p>
            As you are paying by <u>monthly instalments</u>, the amounts to be collected by
            Direct Debit and the <u>collection schedule</u> for
            <strong>{{ $periodLabel ?? '—' }}</strong> will be as follows:
        </p>

        <div class="dd-box">
            <span class="dd-label">Annual Amount:</span>
            <p>£{{ $totalAnnualAmount }} per annum, broken up as follows:</p>
            <p style="margin-left: 14px;">
                • 12 monthly instalments of £{{ $monthlyAmount }}
                &nbsp;(£{{ $monthlyAmount }} &times; 12 = £{{ $totalAnnualAmount }})
            </p>
        </div>

        <div class="dd-box">
            <span class="dd-label">Collection Schedule:</span>
            <p>
                We plan to collect the first payment of <strong>£{{ $monthlyAmount }}</strong>
                on
                <strong>
                    {{ $nextCollectionDate ? $nextCollectionDate->format('d/m/Y') : '[DATE OF NEXT FASTPAY COLLECTION]' }}
                </strong>.
                The subsequent collections of £{{ $monthlyAmount }} will be on the 10th of
                each following month (or the first working day after the 10th if that happens
                to be a weekend or a bank holiday).
            </p>
        </div>

    @else

        <p>
            We would like to remind you that your annual membership is due for renewal on
            <strong>{{ $renewalDate }}</strong>. We are pleased to be able to renew your
            annual membership for a fee of <strong>£{{ $totalAnnualAmount }}</strong> per
            annum to be paid by annual direct debit.
        </p>

        <p>
            Provided that you are happy for the renewal to take place, you will not need to
            take any steps, as your membership will be renewed automatically.
        </p>

        <p>
            As you are paying by a <u>single annual instalment</u>, the amount to be
            collected by Direct Debit and the <u>collection schedule</u> for
            <strong>{{ $periodLabel ?? '—' }}</strong> will be as follows:
        </p>

        <div class="dd-box">
            <span class="dd-label">Annual Amount:</span>
            <p>£{{ $totalAnnualAmount }} per annum, collected in a single instalment.</p>
        </div>

        <div class="dd-box">
            <span class="dd-label">Collection Schedule:</span>
            <p>
                We plan to collect <strong>£{{ $totalAnnualAmount }}</strong> on
                <strong>
                    {{ $nextCollectionDate ? $nextCollectionDate->format('d/m/Y') : '[DATE OF NEXT FASTPAY COLLECTION]' }}
                </strong>
                (or the first working day thereafter if that happens to be a weekend or a
                bank holiday).
            </p>
        </div>

    @endif

        <div class="section-heading">Please Note:</div>

        <ul class="please-note-list">
            <li>Our collection dates as aforesaid cannot be varied.</li>
            <li>
                Kindly do not make changes to or cancel your Direct Debit instruction without
                prior notice to us, this results in penalties to DDPU which will then get
                passed on to you. Please let us know beforehand even if the intention is
                simply to change the direct debit mandate or frequency of payment.
            </li>
            <li>
                A failure to pay monthly Direct Debit will only incur a charge if there has
                been failure on 2 occasions, and the charge incurred will be limited to £5.
            </li>
            <li>
                Membership with DDPU is offered on an annual basis. By agreeing to the
                renewal terms, the member undertakes to pay the annual fee, detailed above,
                <u>in full</u>. In the event of a member terminating membership prior to the
                annual renewal, any outstanding fees will become due immediately; in the
                event that the full outstanding fee is not settled, DDPU may take
                appropriate action against the member.
            </li>
        </ul>

        <p>
            Our staff is available to assist you; if you need assistance please write back
            to us.
        </p>

        <p style="text-align:center; font-weight:bold; margin: 18px 0 6px;">
            ** Please use the following number for Emergency Advice only **
        </p>

        <div class="emergency-box">
            <span class="lbl">Emergency Advice:</span><br>
            <span class="number">07476 956818</span><br>
            <em>Only for urgent advice!</em>
        </div>

        <p>Best wishes,<br>
        <strong>DDPU Membership</strong></p>

    </div>

    <div class="footer-info">
        <strong>Doctors and Dentists Protection Union</strong><br>
        9 Belgrave Avenue, Urmston, Manchester M41 8SR
        &nbsp;|&nbsp; Tel: 0161 8702193<br>
        Email: <a href="mailto:membership@ddpu.co.uk"><u>membership@ddpu.co.uk</u></a>
        &nbsp;|&nbsp; Website: <a href="http://www.ddpu.co.uk"><u>www.ddpu.co.uk</u></a><br>
        <span style="color:#888; font-size:11px;">
            Doctors and Dentists Protection Union is a trading name of DDPU Ltd.<br>
            DDPU Ltd is registered with the Companies House. Registration No: 08711442
        </span>
    </div>

    <div class="email-footer">
        &copy; {{ date('Y') }} Doctors and Dentists Protection Union (DDPU). All rights reserved.
    </div>

</div>
</body>
</html>