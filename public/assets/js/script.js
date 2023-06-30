$( document ).ready(function() {
    $("#driver_edit :input").prop("disabled", true);

    $( ".make_edit" ).click(function() {
        $("#driver_edit :input").prop("disabled", false);
    });
});

<!--   Fill Upload  -->
(function($) {
    'use strict';
    $(function() {
        $('.file-upload-browse').on('click', function() {
            var file = $(this).parent().parent().parent().find('.file-upload-default');
            file.trigger('click');
        });
        $('.file-upload-default').on('change', function() {
            $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
        });
    });
})(jQuery);

<!--   Fill Upload change image  -->
function previewFile() {
    var preview = document.querySelector('#image');
    var file    = document.querySelector('#img').files[0];
    var reader  = new FileReader();

    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}
<!-- Flash Message timout -->

$("document").ready(function(){
    setTimeout(function(){
        $('div.flash').removeClass().addClass('card-header bg-white').fadeIn(550);
        $('.fl_message').fadeOut();
    }, 4000 ); // 5 secs

});
<!-- Flash Message timout  End-->










