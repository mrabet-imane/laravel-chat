@extends('app')

@section('title', 'Chat Laravel')

@section('header')
    <h1>Chat Laravel Temps Réel</h1>
@endsection

@section('content')
    <div id="chat-box" class="chat-box">
        <!-- Les messages du chat s'afficheront ici -->
    </div>

    <form id="chat-form" class="chat-form">
        <input type="text" id="message" placeholder="Tapez votre message" class="message-input" required>
        <button type="submit" class="send-button">Envoyer</button>
    </form>

    <script>
        document.getElementById('chat-form').addEventListener('submit', function (e) {
            e.preventDefault();

            let message = document.getElementById('message').value;

            if (message.trim() === '') {
                return;
            }

            fetch('{{ url('/send-message') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    console.log('Message envoyé:', data.status);
                } else {
                    console.error('Erreur dans la réponse:', data);
                }
                document.getElementById('message').value = '';
            })
            .catch(error => {
                console.error('Erreur de communication:', error);
                alert('Une erreur est survenue lors de l\'envoi du message.');
            });
        });

        window.Echo.channel('chat-channel')
            .listen('message.sent', (event) => {
                console.log('Message reçu:', event.message);
                document.getElementById('chat-box').innerHTML += `<div class="chat-message"><strong>${event.user.name}</strong>: ${event.message}</div>`;
                document.getElementById('chat-box').scrollTop = document.getElementById('chat-box').scrollHeight;
            });

        // Charger les messages existants lors du chargement de la page
        fetch('{{ url('/get-messages') }}')
            .then(response => response.json())
            .then(messages => {
                let chatBox = document.getElementById('chat-box');
                messages.reverse().forEach(message => {
                    chatBox.innerHTML += `<div class="chat-message"><strong>${message.user.name}</strong>: ${message.message}</div>`;
                });
                chatBox.scrollTop = chatBox.scrollHeight;
            });
    </script>
@endsection

<style>
    .chat-box {
        border: 1px solid #ddd;
        padding: 10px;
        height: 300px;
        overflow-y: auto;
        background-color: #f9f9f9; /* Couleur de fond */
        display: flex;
        flex-direction: column;
    }

    .chat-message {
        background-color: #e1ffc7; /* Couleur de fond des messages */
        padding: 8px 12px;
        border-radius: 10px;
        margin-bottom: 10px;
        max-width: 70%;
        align-self: flex-start; /* Alignement à gauche des messages */
    }

    .chat-form {
        margin-top: 10px;
        display: flex;
    }

    .message-input {
        flex-grow: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 10px;
    }

    .send-button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 10px;
        margin-left: 10px;
        cursor: pointer;
    }

    .send-button:hover {
        background-color: #0056b3; /* Fond plus foncé au survol */
    }
</style>
