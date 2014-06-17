<!-- Confirm Modal -->
$('#confirm-delete').on('show.bs.modal', function(e) {
    $message = $(e.relatedTarget).attr('data-message');
    $(this).find('.modal-body p').text($message);
    $title = $(e.relatedTarget).attr('data-title');
    $(this).find('.modal-title').text($title);
    $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
    //$('.debug-url').html('Delete URL: <strong>' + $(this).find('.danger').attr('href') + '</strong>');
})