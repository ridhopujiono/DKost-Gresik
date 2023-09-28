<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Pembayaran Kamar Diterima</title>
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
                <h1>Pemberitahuan Pengajuan Kamar Diterima</h1>
            </div>
            <div class="content">
                <p>Halo,</p>
                <p>Pembayaran <b> {{ $room_name ?? '' }} </b> yang anda unggah telah <b style='color: #337c68'>DITERIMA /
                        TERVERIFIKASI</b><br>
                    Terimakasih atas pembayaran yang anda lakukan. Mohon melengkapi data diri pada menu <b>Profile
                        Penghuni</b> apabila belum dilengkapi.
                </p>
                <br>
                <p>Silakan hubungi kami jika Anda memiliki pertanyaan atau memerlukan informasi tambahan.</p>
            </div>
            <div class="footer">
                <p>Terima kasih pembayaran kamar Anda.</p>
            </div>
        </div>
    </body>

</html>
