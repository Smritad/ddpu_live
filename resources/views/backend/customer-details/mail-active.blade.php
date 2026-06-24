<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>DDPU – Welcome to Membership</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
            margin: 0;
        }

        .email-wrap {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #e5e5e5;
        }

        .email-header {
            text-align: center;
            padding: 20px;
            background: #ffffff;
            border-bottom: 1px solid #eee;
        }

        .email-header img {
            max-width: 150px;
        }

        .email-body {
            padding: 25px 30px;
            color: #333;
            font-size: 14px;
            line-height: 1.8;
        }

        .email-body p {
            margin: 0 0 12px;
        }

        .section-heading {
            font-weight: bold;
            font-size: 14px;
            background: #f0f0f0;
            padding: 8px 12px;
            margin: 20px 0 10px;
            border-left: 4px solid #555;
            letter-spacing: 0.3px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0 15px;
        }

        .info-table td {
            padding: 6px 0;
            font-size: 14px;
            vertical-align: top;
        }

        .info-table td:first-child {
            font-weight: bold;
            width: 190px;
            color: #555;
        }

        .dd-box {
            background: #f9f9f9;
            border: 1px solid #e0e0e0;
            padding: 14px 18px;
            margin: 10px 0 15px;
            font-size: 14px;
            line-height: 1.7;
        }

        .dd-box p {
            margin: 0 0 8px;
        }

        .dd-box p:last-child {
            margin: 0;
        }

        .dd-label {
            font-weight: bold;
            color: #444;
            margin-bottom: 3px;
            display: block;
        }

        .notes-list {
            padding-left: 18px;
            margin: 5px 0 15px;
        }

        .notes-list li {
            margin-bottom: 8px;
            font-size: 14px;
            line-height: 1.6;
        }

        .contact-table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0 15px;
        }

        .contact-table td {
            padding: 6px 0;
            font-size: 14px;
            vertical-align: top;
            border-bottom: 1px solid #f0f0f0;
        }

        .contact-table td:first-child {
            font-weight: bold;
            width: 160px;
            color: #555;
        }

        .emergency-tag {
            color: #b45309;
            font-weight: bold;
        }

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

        u {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="email-wrap">

    <div class="email-header">
        <img src="https://anvayafoundation.com/DDPU/frontend/assets/img/logo/ddpu-logo.jpg" alt="DDPU Logo">
    </div>

    <div class="email-body">

@php

    $step1_data = is_array($member->step1)
        ? $member->step1
        : json_decode($member->step1, true);

    $fullName = trim(implode(' ', array_filter([
        data_get($step1_data, 'title'),
        data_get($step1_data, 'first_name'),
        data_get($step1_data, 'middle_name'),
        data_get($step1_data, 'last_name'),
    ])));

    $membershipNumber = $member->dd_reference ?? 'N/A';

    $certType = $type ?? 'status';

    if ($certType === 'renewal') {
        $coverStart = $member->start_date
            ? \Carbon\Carbon::parse($member->start_date)->addYear()->subDay()
            : \Carbon\Carbon::now();
    } else {
        $coverStart = $member->start_date
            ? \Carbon\Carbon::parse($member->start_date)
            : \Carbon\Carbon::now();
    }

    $coverEnd         = $coverStart->copy()->addYear()->subDay();
    $dateOfCoverStart = $coverStart->format('d.m.Y');
    $dateOfCoverEnd   = $coverEnd->format('d.m.Y');
    $issueDate        = \Carbon\Carbon::now()->format('d M Y');

@endphp


        <p>
            Dear <strong>{{ $name }}</strong>,
        </p>

        <p>
            It is with great pleasure that we welcome you as a member to
            Doctors and Dentists Protection Union.
        </p>

        <p>
            Please find attached your DDPU member certificate.
        </p>


        {{-- MEMBERSHIP DETAILS --}}
        <div class="section-heading">
            YOUR MEMBERSHIP DETAILS ARE:
        </div>

        <table class="info-table">

            <tr>
                <td>Membership number:</td>
                <td>{{ $membershipNumber }}</td>
            </tr>

            <tr>
                <td>Membership term:</td>
                <td>Annual membership</td>
            </tr>

            <tr>
                <td>Payment plan:</td>
                <td>{{ $paymentPlan ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td>Start date:</td>
                <td>{{ $start ? $start->format('d/m/Y') : 'N/A' }}</td>
            </tr>

            <tr>
                <td>Date of next renewal:</td>
                <td>{{ $end ? $end->format('d/m/Y') : 'N/A' }}</td>
            </tr>

        </table>


        {{-- DIRECT DEBIT COLLECTION DETAILS --}}
        <div class="section-heading">
            DIRECT DEBIT COLLECTION DETAILS:
        </div>


@if($isMonthly)

    {{--
        NOTE: $firstInstallments, $firstDebitAmount and $nextCollectionDate
        are all calculated in the controller (firstCollection helper) and
        passed in. This blade ONLY displays them — it never recalculates.
    --}}

    <div class="dd-box">

        <span class="dd-label">
            Annual Amount:
        </span>

        @if($firstInstallments == 2)

            <p>
                £{{ $totalAnnualAmount }} per annum with:
            </p>

            <p style="margin-left:14px;">

                • First collection:
                <strong>
                    £{{ number_format((float)$monthlyAmount * 2, 2) }}
                </strong>
                (2 instalments)

                <br>

                • Followed by 10 monthly instalments of
                £{{ $monthlyAmount }}

            </p>

        @else

            <p>
                £{{ $totalAnnualAmount }} per annum, with a first collection of
                £{{ $monthlyAmount }} (1 instalment), followed by 11 monthly
                instalments of £{{ $monthlyAmount }}.
            </p>

        @endif

    </div>


    <div class="dd-box">

        <span class="dd-label">
            Actual collection:
        </span>

        <p>

            We plan to collect the first payment of

            <strong>
                £{{ number_format((float)$firstDebitAmount, 2) }}
            </strong>

            @if($firstInstallments == 2)

                (covering <strong>2 instalments</strong>)

            @else

                (covering <strong>1 instalment</strong>)

            @endif

            on

            <strong>
                {{ $nextCollectionDate ? $nextCollectionDate->format('d/m/Y') : '[NEXT FASTPAY COLLECTION DATE]' }}
            </strong>.

            <br><br>

            The subsequent collections of
            £{{ $monthlyAmount }}
            will be on the 10th of each following month
            (or the first working day after the 10th if that
            happens to be a weekend or a bank holiday).

        </p>

    </div>

@else

    <div class="dd-box">

        <span class="dd-label">
            Actual collection:
        </span>

        <p>

            We plan to collect
            <strong>
                £{{ $annualFee }}
            </strong>

            on

            <strong>
                {{ $nextCollectionDate ? $nextCollectionDate->format('d/m/Y') : '[NEXT FASTPAY COLLECTION DATE]' }}
            </strong>

            (or the first working day thereafter if that happens
            to be a weekend or a bank holiday).

        </p>

    </div>

@endif


        {{-- NOTES --}}
        <ul class="notes-list">

            <li>
                A failure to pay monthly Direct Debit will only incur a charge
                if there has been failure on 2 occasions,
                and the charge incurred will be limited to £5.
            </li>

            <li>
                Membership with DDPU is offered on an annual basis.
                By agreeing to the terms, the member undertakes to pay
                the annual fee, detailed above, <u>in full</u>.

                In the event of a member terminating membership prior to
                the annual renewal, any outstanding fees will become due
                immediately; in the event that the full outstanding fee
                is not settled, DDPU may take appropriate action against
                the member.
            </li>

        </ul>


        <p>
            <strong>Please note:</strong><br>
            You do not have to take any action.
            We will be contacting the bank on your behalf.
        </p>


        {{-- CONTACT US --}}
        <div class="section-heading">
            CONTACT US:
        </div>

        <table class="contact-table">

            <tr>
                <td>Phone:</td>

                <td>
                    0161 870 2193<br>

                    <span style="color:#555;">
                        Working hours: weekdays, except bank holidays*
                    </span><br>

                    9 a.m. – 5 p.m.
                </td>
            </tr>

            <tr>
                <td>Emergency Advice:</td>

                <td>
                    <span class="emergency-tag">
                        07476 956818
                    </span><br>

                    <em>Only for urgent advice!</em>
                </td>
            </tr>

            <tr>
                <td>Email:</td>

                <td>

                    <a href="mailto:advisory@ddpu.co.uk">
                        advisory@ddpu.co.uk
                    </a>

                    <span style="color:#777;">
                        – For Advice
                    </span>

                    <br>

                    <a href="mailto:membership@ddpu.co.uk">
                        membership@ddpu.co.uk
                    </a>

                    <span style="color:#777;">
                        – For Membership information
                    </span>

                </td>
            </tr>

        </table>


        <p style="color:#555; font-size:13px;">
            * For out of hours calls, please leave your name,
            contact details and reason for your call.
        </p>

        <p style="font-size:13px;">
            Please note that any request for advice will,
            as far as practicable, be responded within
            1 working day.
        </p>

        <p style="font-size:13px;">
            Please note, the above arrangements are subject
            to change and we will update you if any of the
            contact details change.
        </p>


        <p>
            We thank you for giving DDPU the opportunity to serve you!
        </p>

        <p>
            Best wishes,<br>

            <strong>DDPU Membership</strong>
        </p>

    </div>


    <div class="footer-info">

        <strong>
            Doctors and Dentists Protection Union
        </strong><br>

        9 Belgrave Avenue, Urmston, Manchester M41 8SR
        &nbsp;|&nbsp;
        Tel: 0161 8702193
        <br>

        Email:
        <a href="mailto:membership@ddpu.co.uk">
            membership@ddpu.co.uk
        </a>

        &nbsp;|&nbsp;

        Website:
        <a href="http://www.ddpu.co.uk">
            www.ddpu.co.uk
        </a>

        <br>

        <span style="color:#888; font-size:11px;">

            Doctors and Dentists Protection Union
            is a trading name of DDPU Ltd.

            <br>

            DDPU Ltd is registered with Companies House.
            Registration No: 08711442

        </span>

    </div>


    <div class="email-footer">
        &copy; {{ date('Y') }}
        Doctors and Dentists Protection Union (DDPU).
        All rights reserved.
    </div>

</div>

</body>
</html>