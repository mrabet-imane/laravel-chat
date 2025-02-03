@extends('app')

@section('title', 'Chat Laravel')

@section('header')
    <h1>Chat Laravel Temps Réel</h1>
@endsection

@section('content')
    <div id="chat-box" style="border: 1px solid #ddd; padding: 10px; height: 300px; overflow-y: auto;">
        <!-- Les messages du chat s'afficheront ici -->
    </div>

    <form id="chat-form" style="margin-top: 10px;">
        <input type="text" id="message" placeholder="Tapez votre message" required>
        <button type="submit">Envoyer</button>
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
                document.getElementById('chat-box').innerHTML += `<p><strong>${event.user.name}</strong>: ${event.message}</p>`;
                document.getElementById('chat-box').scrollTop = document.getElementById('chat-box').scrollHeight;
            });

        // Charger les messages existants lors du chargement de la page
        fetch('{{ url('/get-messages') }}')
            .then(response => response.json())
            .then(messages => {
                let chatBox = document.getElementById('chat-box');
                messages.reverse().forEach(message => {
                    chatBox.innerHTML += `<p><strong>${message.user.name}</strong>: ${message.message}</p>`;
                });
                chatBox.scrollTop = chatBox.scrollHeight;
            });
    </script>
@endsection
