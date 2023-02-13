<?php
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Location" content="#">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kinde Authenticate Response</title>
</head>
<body>
    <div id="response-page">
        <div class="section-content">
            <div class="response-page-content">
                <h1 class="response-content-title">Kinde Authenticate Response</h1>
                <div class="response-content-detail">
                   <p>
                        <span>Your Access Token: <?php echo esc_html(substr($accessToken, 0, 30)) ?>...</span>
                    </p>
                    <?php if ($user) { ?>
                        <p>Your Email: <?php echo esc_html($user['preferred_email']) ?></p>
                        <p>Your Name: <?php echo esc_html($user['first_name']." ".$user['last_name']) ?></p>
                    <?php } else { ?>
                        <p>Your Profile: Not yet provider for this authenticate</p>
                    <?php } ?>
                </div>
                <div class="response-content-button-back">
                    <a class="go-back" href="/" title="Go back home">Go Back Home</a>
                    <a class="go-back" href="/kinde-authenticate/logout" title="Log Out">Log Out</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<style>
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

    #response-page {
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

    .response-page-content {
        border: 1px solid #e7e7e7;
        margin: 20% 0;
        background-color: #ffffff;
    }

    .response-page-content h1{
        font-size: 2.5rem;
        display: inline-block;
        padding-right: 12px;
        animation: type .5s alternate infinite;
        color: #000000;
        font-weight: bold;
        font-family: inherit;
    }

    .response-content-detail {
        padding: 40px 3rem;
        background-color: #fafafa;
        color: #4caf50;
        font-size: 1.2rem;
        font-family: inherit;
        font-weight: bold;
    }

    .response-content-button-back {
        position: relative;
        display: flex;
        justify-content: center;
        padding: 20px;
    }

    .response-content-button-back a {
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
        width: 25%;
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
        display: none;
    }
</style>