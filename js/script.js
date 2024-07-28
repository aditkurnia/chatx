const socket = io('http://localhost:8080');

$('form').submit(function(e) {
    e.preventDefault();
    const message = $('#m').val();
    if (message.trim() !== '') {
        socket.emit('chat message', message);
        $('#m').val('');
    }
});

socket.on('chat message', function(msg) {
    $('#messages').append($('<li>').text(msg));
    $('#chatbox').scrollTop($('#chatbox')[0].scrollHeight); // Auto-scroll
});
