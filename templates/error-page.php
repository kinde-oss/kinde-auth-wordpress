<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Location" content="#">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kinde Authenticate Error</title>
</head>
<body>
    <div id="error-page">
        <div class="section-content">
            <div class="error-page-content">
                <h1 class="error-content-title">Kinde Authenticate Error</h1>
                <div class="error-content-detail">
                    <?php
                        $message_field = sanitize_text_field($_GET['message'] ?? '');
                        if (!empty($message_field)) {
                    ?>
                        <p><?php echo esc_html(urldecode($message_field)) ?></p>
                    <?php
                        }
                    ?>
                </div>
                <div class="error-content-button-back">
                    <a class="go-back" href="/" title="Go back">Go Back Home</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<style>
    body #error-page,
    body #error-page div {
        display: block !important;
    }
    body div {
        display: none;
    }
    *{
        transition: all 0.6s;
    }

    html {
        height: 100%;
    }

    body{
        color: #888;
        margin: 0;
    }

    #error-page {
        display: table;
        width: 100%;
        height: 100vh;
        text-align: center;
        background-color: #fafafa;
    }

    .section-content{
        max-width: 45rem;
        width: 100%;
        grid-template-rows: 1fr auto;
        gap: 1.5rem;
        margin-inline: auto;
        display: grid;
    }

    .error-page-content {
        border: 1px solid #e7e7e7;
        margin: 20% 0;
        background-color: #ffffff;
    }

    .error-page-content h1{
        font-size: 2.5rem;
        display: inline-block;
        padding-right: 12px;
        animation: type .5s alternate infinite;
        color: #000000;
        font-weight: bold;
        font-family: inherit;
    }

    .error-content-detail {
        padding: 40px 3rem;
        background-color: #fafafa;
        color: #ff5722;
        font-size: 1.2rem;
        font-family: inherit;
    }

    .error-content-button-back {
        height: 100px;
        position: relative;
    }

    .error-content-button-back a {
        position: inherit;
        display: block;
        background-color: #000000;
        padding: 15px 30px;
        color: #ffffff;
        border-radius: 16px;
        font-weight: bold;
        text-transform: uppercase;
        text-decoration: none;
        font-size: 1rem;
        font-family: inherit;
        width: 32%;
        text-align: center;
        margin: 0 auto;
        margin-top: 20px;
    }

    @keyframes type{
        from{box-shadow: inset -3px 0px 0px #888;}
        to{box-shadow: inset -3px 0px 0px transparent;}
    }
    body .wp-site-blocks,
    body header,
    body body,
    body footer {
        display: none !important;
    }
</style>