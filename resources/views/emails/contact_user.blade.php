<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You for Your Enquiry</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f7f7f7; margin: 0; padding: 0; }
        .email-wrapper { max-width: 600px; margin: 20px auto; background: #fff; border-radius: 5px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .email-header { background: #0a3d62; padding: 20px; text-align: center; }
        .email-header img { max-width: 150px; }
        .email-body { padding: 20px; color: #333; line-height: 1.6; }
        .email-footer { background: #f1f1f1; padding: 15px; text-align: center; font-size: 12px; color: #777; }
        h2 { color: #0a3d62; }
    </style>
</head>
<body>
<div class="email-wrapper">

    <!-- Header -->
    <div class="email-header">
        <img src="https://anvayafoundation.com/DDPU/frontend/assets/img/logo/ddpu-logo.jpg" alt="DDPU Logo">
    </div>

    <!-- Body -->
    <div class="email-body">
        <h2>Thank You for Your Enquiry</h2>
        <p>Dear {{ $details['name'] }},</p>
        <p>Thank you for reaching out to Doctors and Dentists Protection Union (DDPU). We have received your enquiry and our team will get back to you shortly.</p>

       

        <p>Best regards,<br>Doctors and Dentists Protection Union (DDPU) Team</p>
    </div>

    <!-- Footer -->
    <div class="email-footer">
        &copy; {{ date('Y') }} Doctors and Dentists Protection Union (DDPU). All rights reserved.
    </div>
</div>
</body>
</html>
