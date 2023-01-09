<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./public/erykia/assets/css/app.css" rel="stylesheet">
    <title>Erykia</title>
</head>

<body>
<div class="container">
    <div class="header-ia">
        <div class="profile-img">
        </div>
        <div class="chat-name">
            <h3 class="title-chat">Erykia</h3>
            <i class="bi bi-circle-fill"> Online</i>
        </div>

        <button><i class="bi bi-three-dots-vertical"></i></button>
    </div>

    <div class="chatbot" id="chatScroll">
        <div id="chatErykia">

        </div>
        <div id="chatLoad">
            <div class='chatbot-response-ia' id='load-chat'>
                <div class='response-ia'>
                    <img class='load' src='./public/erykia/assets/img/loading-chat.gif'/>
                </div>
            </div>
        </div>
    </div>
    <div class="responsetext">
        <label>
            <input id="response" type="text" name="" placeholder="Aguardando resposta...">
        </label>
        <button id="send" type="button"><i class="bi bi-send"></i></button>
    </div>
</div>
<script type="module" src="./public/erykia/assets/js/app.js"></script>
</body>

</html>