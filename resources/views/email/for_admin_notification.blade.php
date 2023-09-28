<!DOCTYPE html>
<html lang="en">

    <head>
        <title>{{ $subject }}</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            /* Reset CSS */
            body,
            p {
                margin: 0;
                padding: 0;
            }

            /* Container */
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                font-family: Arial, sans-serif;
            }

            /* Header */
            .header {
                background-color: #5d5d5d;
                color: #fff;
                text-align: center;
                padding: 20px;
            }

            /* Content */
            .content {
                padding: 20px;
                background-color: #f7f7f7;
            }

            /* Button */
            .btn {
                display: inline-block;
                background-color: #5d5d5d;
                color: #fff;
                padding: 10px 20px;
                text-decoration: none;
                margin-top: 10px;
            }

            /* Footer */
            .footer {
                background-color: #5d5d5d;
                color: #fff;
                text-align: center;
                padding: 10px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="header">
                <h1>{{ $subject }}</h1>
            </div>
            <div class="content">
                <p>{{ $body }}</p>
            </div>
        </div>
    </body>

</html>
