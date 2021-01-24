$(document).ready(function() {

    document.getElementById('chat-content').scrollTop = 9999;

})


$(document).on('pjax:success', function() {
    document.getElementById('chat-content').scrollTop = 9999;
})