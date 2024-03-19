<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointment Reminder</title>
    <style>
        /* Reset styles to ensure consistent rendering */
        body, p, h1, h2, h3, h4, h5, h6, td {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333333;
        }

        /* Main container */
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-image: url('https://fusionfertility.co.uk/web/assets/img/mobile-banner.png');
            background-size: cover;
            background-position: center;
        }

        /* Heading styles */
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Button styles */
        .button {
            display: inline-block;
            margin-top: 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
        }

        /* Zoom meeting link styles */
        .zoom-link {
            margin-top: 20px;
        }

        .zoom-link a {
            color: white;
            text-decoration: none;
        }
        .card {
            padding: 25px;
            border-radius: 20px;
            box-shadow: 2.5px 3.5px 7.6px 1.5px black;
        }
        .image-div{
            width: 100%;
            background: white;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="image-div" style="border-radius: 30px;">
        <img src="https://fusionfertility.co.uk/web/assets/img/logo-hd.png" style="width: 65%; margin: 20px auto;"/>
    </div>
    <div class="card" style="background: white; color: black; border: 1px solid black; margin-top: 25px;">
    <h1>Appointment Reminder</h1>
    <p>Dear {{ $appointment->patient->user->name }}!</p>
    <p>This is a reminder for your upcoming doctor appointment with {{ $appointment->doctor->user->name }} . Please make sure to join the Zoom meeting at the scheduled time.</p>
    <p>Date: {{ $appointment->appointment_date }}</p>
    <p>Time: {{ $appointment->appointment_time }}</p>
    <p>We look forward to seeing you soon!</p>
    <div class="zoom-link">
        <a class="button" href="{{$appointment->zoom_join_url}}">Join Zoom Meeting</a>
    </div>
    </div>
</div>
<div style="height: 150px; width: 100%; background: white; padding: auto 0px">
    <p style="text-align: center;">&copy; copyright <a href="https://fusionfertility.co.uk">www.fusionfertility.co.uk</a></p>
</div>
</body>
</html>



