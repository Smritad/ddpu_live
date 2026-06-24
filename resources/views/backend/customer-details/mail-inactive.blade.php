<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DDPU Membership Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        .email-wrap {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 6px;
            overflow: hidden;
        }
        .email-header {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid #eee;
        }
        .email-header img {
            max-width: 150px;
        }
        .email-body {
            padding: 25px;
            color: #333;
            line-height: 1.6;
        }
        .email-footer {
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #777;
            background: #f4f4f4;
        }
    </style>
</head>
<body>

<div class="email-wrap">

    <!-- Header -->
    <div class="email-header">
        <img src="https://anvayafoundation.com/DDPU/frontend/assets/img/logo/ddpu-logo.jpg" alt="DDPU Logo">
    </div>

    <!-- Body -->
    <div class="email-body">
        <p>Hello {{ $name }},</p>

        <p>Your membership with <strong>Doctors and Dentists Protection Union (DDPU)</strong> is currently <strong>INACTIVE</strong>.</p>

        <p>If this is unexpected or you would like to reactivate your membership, please contact our team.</p>

        <p>We are here to assist you.</p>

        <p>Thank you,<br>
        <strong>DDPU Team</strong></p>
    </div>

    <!-- Footer -->
    <div class="email-footer">
        &copy; {{ date('Y') }} Doctors and Dentists Protection Union (DDPU). All rights reserved.
    </div>

</div>

</body>
</html>