$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function() {
    $("#modal-btn").click(function() {
      $("#modal-container").modal('show');
    });
  });
