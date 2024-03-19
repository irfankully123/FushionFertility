<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prescription</title>

    <style type="text/css">
        @page {
            margin: 0px;
        }

        body {
            margin: 0px;
        }

        * {
            font-family: sans-serif;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        .information {
            background-color: #68d0be;
            color: #FFF;
        }

        .information .logo {
            margin: 5px;
            border-radius: 50%;
            background: #e0e0e0;
            box-shadow: 8px 8px 16px #bababa,
            -8px -8px 16px #ffffff;
        }

        .information table {
            padding: 10px;
        }

        .custom-row::after {
            content: "";
            display: table;
            clear: both;
        }

        .custom-col {
            float: left;
            width: 100%;
            box-sizing: border-box;
        }
        .custom-col-6 {
            width: 50%;
        }


    </style>

</head>
<body>

<div class="information">
    <table style="margin: 0px auto;">
        <tr>
            <td align="left" style="width: 35%;">
                <img src="{{ public_path('web/pdf-logo.png') }}" alt="Logo" width="130" class="logo"/>
            </td>
            <td align="center" style="width: 300px">
                <h1 style="text-align: center; font-weight: bold; font-size: 30px;">FUSION FERTILITY</h1>
                <p>The ultimate path for successful care</p>
            </td>
            <td align="right" style="width: 35%;
            ">
                <img src="{{ public_path('fusion-fertility-qr-code.png') }}" alt="qr-code" width="130"/>
            </td>
        </tr>
    </table>
</div>


<br/>

<div class="prescription">
    <div class="wrapper">

        <div class="custom-row" style="margin: 30px 100px;">
            <div class="custom-col custom-col-6">
                <span>Patient Name. <span style="color: cadetblue;">{{ $prescription['patient_name'] }}</span></span>
            </div>
            <div class="custom-col custom-col-6">
                <span style="float:right;">Doctor Name. <span style="color: cadetblue;">{{ $prescription['doctor_name'] }}</span></span>
            </div>
        </div>

        <div style="margin: 0px 100px; border: 1px solid black; ">
            <div style="margin: 30px 25px;">
                <div style="padding: 5px">
                    <h2>Medications:-</h2>
                    <p>{{ $prescription['medication'] }}</p>
                </div>
                <div style="padding: 5px">
                    <h2>Dosage:-</h2>
                    <p>{{ $prescription['dosage'] }}</p>
                </div>
                <div style="padding: 5px">
                    <h2>Duration:-</h2>
                    <p>{{ $prescription['duration'] }}</p>
                </div>
                <div style="padding: 5px">
                    <h2>Frequency:-</h2>
                    <p>{{ $prescription['frequency'] }}</p>
                </div>
                <div style="padding: 5px">

                    <h2>Instructions:-</h2>
                    <p>{{ $prescription['instructions'] }}</p>
                </div>
            </div>
        </div>

        <div style="margin: 20px 80px;">
            <span style="float: right;">Date: {{ $prescription['date'] }}</span>
        </div>
    </div>
</div>

<div class="information"
     style="position: absolute; bottom: 0; width: 100%;">
    <table style="width: 100%">
        <tr>
            <td align="left" style="width: 50%;">
                &copy; {{ date('Y') }} {{ config('app.url') }} - All rights reserved.
            </td>
            <td align="right" style="width: 50%;">
                <a href="https://fusionfertility.co.uk/terms">Terms & Conditions</a>
            </td>
        </tr>

    </table>
</div>
</body>
</html>
