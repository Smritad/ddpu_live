<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>DDPU Certificate</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            background: #fff;
        }

        .page {
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .certificate-box {
            border: 4px solid #e5533d;
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
            padding: 50px 60px;
            text-align: center;
            position: relative;
        }

        /* ── Logo ── */
        .logo-section {
            margin-bottom: 30px;
        }

        .logo-text {
            font-size: 38px;
            font-weight: 900;
            color: #1a3a5c;
            letter-spacing: 2px;
            line-height: 1;
        }

        .org-name {
            font-size: 14px;
            font-weight: bold;
            color: #1a3a5c;
            letter-spacing: 3px;
            margin-top: 6px;
            text-transform: uppercase;
        }

        /* ── Body text ── */
        .confirm-text {
            font-size: 13px;
            font-weight: bold;
            color: #333;
            margin: 30px 0 10px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .member-name {
            font-size: 36px;
            font-weight: 900;
            color: #1a3a5c;
            margin: 10px 0 20px 0;
            letter-spacing: 1px;
        }

        .is-member-of {
            font-size: 13px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .org-full-name {
            font-size: 13px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .tagline {
            font-size: 13px;
            font-weight: bold;
            color: #e5533d;
            margin-bottom: 30px;
        }

        /* ── Renewal badge ── */
        .renewal-badge {
            display: inline-block;
            background: #e5533d;
            color: #fff;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 5px 18px;
            border-radius: 3px;
            margin-bottom: 24px;
        }

        /* ── Bottom section ── */
        .bottom-section {
            display: table;
            width: 100%;
            margin-top: 24px;
        }

        .signature-side {
            display: table-cell;
            width: 50%;
            text-align: left;
            vertical-align: bottom;
        }

        .details-side {
            display: table-cell;
            width: 50%;
            text-align: right;
            vertical-align: bottom;
        }

        .signature-line {
            border-top: 2px solid #333;
            width: 220px;
            margin-top: 10px;
            padding-top: 6px;
            font-size: 13px;
            font-weight: bold;
            color: #333;
        }

        /* ── Right-side details ── */
        .membership-label {
            font-size: 12px;
            font-weight: bold;
            color: #e5533d;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .membership-number {
            font-size: 15px;
            font-weight: bold;
            color: #e5533d;
            margin-bottom: 14px;
        }

        .date-label {
            font-size: 12px;
            color: #555;
            margin-bottom: 2px;
        }

        .date-value {
            font-size: 13px;
            font-weight: bold;
            color: #333;
        }

        .issued-label {
            font-size: 11px;
            color: #888;
            margin-top: 10px;
            margin-bottom: 2px;
        }

        .issued-value {
            font-size: 12px;
            font-weight: bold;
            color: #555;
        }
    </style>
</head>
<body>
<div class="page">
    <div class="certificate-box">

        @php
            // ── Member full name ─────────────────────────────────────────────
            $step1_data = is_array($member->step1)
                ? $member->step1
                : json_decode($member->step1, true);

            $fullName = trim(implode(' ', array_filter([
                data_get($step1_data, 'title'),
                data_get($step1_data, 'first_name'),
                data_get($step1_data, 'middle_name'),
                data_get($step1_data, 'last_name'),
            ])));

            // ── Membership number ────────────────────────────────────────────
            $membershipNumber = $member->dd_reference ?? 'N/A';

            // ── Certificate type ─────────────────────────────────────────────
            // $type passed from controller:
            //   'status'  → onboarding/active cert  → cover starts from start_date
            //   'renewal' → renewal cert             → cover starts from start_date + 1 year
            $certType = $type ?? 'status';

            // ── Cover date calculation ───────────────────────────────────────
            if ($certType === 'renewal') {
                /**
                 * Renewal certificate cover period:
                 *
                 *   Onboarding:  start_date  →  start_date + 1 year - 1 day
                 *   Renewal:     start_date + 1 year  →  start_date + 2 years - 1 day
                 *
                 * Example:
                 *   start_date   = 09 Apr 2026
                 *   Renewal from = 09 Apr 2027  ← start_date + 1 year
                 *   Renewal to   = 08 Apr 2028  ← start_date + 2 years - 1 day
                 */
                $coverStart = $member->start_date
                    ? \Carbon\Carbon::parse($member->start_date)->addYear()
                    : \Carbon\Carbon::now();
            } else {
                // Onboarding/active certificate: cover starts from start_date
                $coverStart = $member->start_date
                    ? \Carbon\Carbon::parse($member->start_date)
                    : \Carbon\Carbon::now();
            }

            $coverEnd         = $coverStart->copy()->addYear()->subDay();
            $dateOfCoverStart = $coverStart->format('d.m.Y');
            $dateOfCoverEnd   = $coverEnd->format('d.m.Y');

            // ── Issue date (today) ───────────────────────────────────────────
            $issueDate = \Carbon\Carbon::now()->format('d M Y');
        @endphp

        <!-- Logo -->
        <div class="logo-section">
            <div class="logo-text">&#10022; DDPU</div>
            <div class="org-name">Doctors &amp; Dentists<br>Protection Union.</div>
        </div>

        <!-- Confirm -->
        <div class="confirm-text">This is to confirm that</div>

        <!-- Member Name -->
        <div class="member-name">{{ $fullName ?: 'Member Name' }}</div>

        <!-- Is a member of -->
        <div class="is-member-of">Is a member of</div>
        <div class="org-full-name">Doctors and Dentists Protection Union (DDPU Ltd)</div>
        <div class="tagline">DDPU provides support and defence in employment and regulatory matters.</div>

        <!-- Renewal badge — only on renewal certificates -->
        @if($certType === 'renewal')
            <div>
                <span class="renewal-badge">Renewal Certificate</span>
            </div>
        @endif

        <!-- Bottom: Signature + Details -->
        <div class="bottom-section">

            <div class="signature-side">
                <div style="height: 50px;"></div>
                <div class="signature-line">MR R CHAUDHARY</div>
            </div>

            <div class="details-side">

                <div class="membership-label">Membership Number</div>
                <div class="membership-number">{{ $membershipNumber }}</div>

                <div class="date-label">
                    @if($certType === 'renewal')
                        Renewed period of cover
                    @else
                        Date of cover
                    @endif
                </div>
                <div class="date-value">{{ $dateOfCoverStart }} – {{ $dateOfCoverEnd }}</div>

                <div class="issued-label">Issued on</div>
                <div class="issued-value">{{ $issueDate }}</div>

            </div>
        </div>

    </div>
</div>
</body>
</html>