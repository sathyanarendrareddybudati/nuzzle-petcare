<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Message from Nuzzle</title>
    <style>
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        @media screen and (max-width: 600px) {
            .responsive-table {
                width: 100% !important;
            }
        }
    </style>
</head>
<body style="margin: 0 !important; padding: 20px; background-color: #f4f4f4;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" class="responsive-table">
                    <tr>
                        <td bgcolor="#ffffff" align="center" style="padding: 20px; border-radius: 10px 10px 0 0;">
                            <img src="<?= $_ENV['APP_URL'] ?>/assets/images/logo.jpg" alt="Nuzzle Logo" width="150">
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 20px 40px;">
                            <h1 style="font-size: 24px; font-family: Helvetica, Arial, sans-serif; color: #333333; margin-top: 0;">You have a new message</h1>
                            <p style="margin: 0; font-size: 16px; line-height: 24px; font-family: Helvetica, Arial, sans-serif; color: #666666;">
                                Hello <?= e($recipientName) ?>,
                            </p>
                            <p style="font-size: 16px; line-height: 24px; font-family: Helvetica, Arial, sans-serif; color: #666666;">
                                You have received a new message from <strong><?= e($senderName) ?></strong> regarding an ad. Here is the message:
                            </p>
                            <p style="background-color: #f8f8f8; padding: 15px; border-left: 4px solid #2e59d9; font-style: italic; font-family: Helvetica, Arial, sans-serif; color: #555555;">
                                "<?= nl2br(e($messageContent)) ?>"
                            </p>
                            <p style="font-size: 16px; line-height: 24px; font-family: Helvetica, Arial, sans-serif; color: #666666;">
                                Please log in to your dashboard to reply.
                            </p>
                            <a href="<?= e($loginLink) ?>" style="background-color: #2e59d9; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 5px; display: inline-block; font-family: Helvetica, Arial, sans-serif;">Reply Now</a>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="center" style="padding: 20px; border-radius: 0 0 10px 10px; font-family: Helvetica, Arial, sans-serif; color: #888888; font-size: 12px;">
                            This is an automated message. Please do not reply directly to this email.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>