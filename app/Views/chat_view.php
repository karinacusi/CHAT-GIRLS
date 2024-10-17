<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Elegante Girls <3</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff0f6; /* Fondo rosado suave */
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #e07a9c; /* Tono rosado oscuro elegante */
            font-size: 2.5em;
            font-family: 'Dancing Script', cursive; /* Fuente cursiva elegante */
            margin-top: 20px;
        }

        #chat-container {
            width: 60%;
            margin: 20px auto;
            background-color: #f8d7da; /* Fondo suave rosado */
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        #chat {
            width: 100%;
            height: 350px;
            overflow-y: scroll;
            border-radius: 10px;
            padding: 20px;
            background-color: #ffffff; /* Fondo blanco dentro del chat */
            background-image: url('https://i.pinimg.com/564x/03/68/a1/0368a150137f1aa0e2cf12327e1b24d2.jpg'); /* Añadir la ruta de tu imagen de fondo */
            background-size: cover;
            box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.05);
        }

        /* Contenedor de los mensajes */
        .message-container {
            display: flex;
            margin: 10px 0;
            align-items: center;
            position: relative;
        }

        /* Mensajes recibidos (receptor) */
        .message.other {
            background-color: #ffe4e6; /* Color muy suave para los mensajes recibidos */
            color: #333;
            font-style: italic;
            border-radius: 12px;
            padding: 10px 15px;
            max-width: 70%;
            text-align: left;
        }

        /* Mensajes enviados (emisor) */
        .message.me {
            background-color: #f497da; /* Color rosa claro */
            color: #ffffff;
            font-weight: bold;
            border-radius: 12px;
            padding: 10px 15px;
            max-width: 70%;
            text-align: right;
            margin-left: auto;
        }

        /* Reacciones flotantes */
        .reactions {
            display: none;
            position: absolute;
            bottom: -40px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #fff;
            padding: 5px 10px;
            border-radius: 10px;
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .reactions button {
            border: none;
            background: none;
            font-size: 1.5em;
            cursor: pointer;
        }

        /* Mostrar reacciones seleccionadas */
        .reaction-display {
            font-size: 1.2em;
            position: absolute;
            bottom: -20px;
            right: 10px;
        }

        /* Estilos del input */
        #message {
            width: 80%;
            padding: 15px;
            border: 2px solid #e07a9c;
            border-radius: 10px;
            margin-right: 10px;
            font-size: 1em;
            background-color: #fce4ec;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease;
        }

        #message:focus {
            border-color: #ec4899; /* Cambio de color al enfocar */
            outline: none;
        }

        /* Estilos del botón */
        #send {
            padding: 15px 20px;
            background-color: #e07a9c; /* Botón en color rosado oscuro */
            border: none;
            color: white;
            font-size: 1em;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0px 5px 15px rgba(224, 122, 156, 0.4);
        }

        #send:hover {
            background-color: #d94677;
            box-shadow: 0px 8px 20px rgba(224, 122, 156, 0.6);
        }

        /* Estilo para emojis */
        .emoji-picker {
            font-size: 1.5em;
            margin: 10px 0;
            display: flex;
            justify-content: center;
        }

        .emoji-picker button {
            border: none;
            background: none;
            font-size: 1.5em;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Chat Elegante Girls <3 💬</h1>

    <div id="chat-container">
        <div id="chat"></div>
        <div class="emoji-picker">
            <button onclick="addEmoji('😊')">😊</button>
            <button onclick="addEmoji('💖')">💖</button>
            <button onclick="addEmoji('🎀')">🎀</button>
            <button onclick="addEmoji('🌸')">🌸</button>
        </div> <!-- Añadir emojis decorativos -->
        <input type="text" id="message" placeholder="Escribe un mensaje bonito...">
        <button id="send">Enviar</button>
    </div>

    <script>
        var conn = new WebSocket('ws://localhost:8081'); // Conectar al servidor WebSocket
        var chat = document.getElementById('chat');
        var sendButton = document.getElementById('send');
        var messageInput = document.getElementById('message');

        // Cuando se abre la conexión
        conn.onopen = function(e) {
            addMessage('Conexión establecida 💬', 'other');
        };

        // Cuando se recibe un mensaje del servidor
        conn.onmessage = function(e) {
            addMessage(e.data, 'other');
        };

        // Función para enviar mensajes
        function sendMessage() {
            var msg = messageInput.value;
            if (msg.trim() !== "") {
                addMessage(msg, 'me');
                conn.send(msg); // Enviar mensaje al servidor WebSocket
                messageInput.value = ''; // Limpiar el campo de texto
            }
        }

        // Al hacer clic en el botón enviar
        sendButton.onclick = sendMessage;

        // Enviar mensaje con la tecla ENTER
        messageInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        });

        // Función para añadir emojis
        function addEmoji(emoji) {
            messageInput.value += emoji;
            messageInput.focus();
        }

        // Función para añadir mensajes
        function addMessage(text, type) {
            var messageDiv = document.createElement('div');
            messageDiv.className = 'message-container';

            var messageBubble = document.createElement('div');
            messageBubble.className = 'message ' + type;
            messageBubble.textContent = text;

            // Agregar el menú de reacciones flotante al estilo WhatsApp
            var reactionsDiv = document.createElement('div');
            reactionsDiv.className = 'reactions';
            reactionsDiv.innerHTML = `
                <button onclick="react('❤️')">❤️</button>
                <button onclick="react('👍')">👍</button>
                <button onclick="react('😡')">😡</button>
                <button onclick="react('😂')">😂</button>
            `;

            // Mostrar la reacción seleccionada
            var reactionDisplay = document.createElement('span');
            reactionDisplay.className = 'reaction-display';

            messageDiv.appendChild(messageBubble);
            messageDiv.appendChild(reactionDisplay);
            messageDiv.appendChild(reactionsDiv);
            chat.appendChild(messageDiv);

            // Mostrar reacciones al hacer clic en el mensaje
            messageBubble.onclick = function() {
                reactionsDiv.style.display = 'flex';
            };

            chat.scrollTop = chat.scrollHeight; // Auto-scroll hacia abajo
        }

        // Función para manejar las reacciones
        function react(reaction) {
            var reactionDisplay = event.target.parentElement.parentElement.querySelector('.reaction-display');
            reactionDisplay.textContent = reaction; // Mostrar la reacción
            event.target.parentElement.style.display = 'none'; // Ocultar el menú de reacciones
        }
    </script>
</body>
</html>

