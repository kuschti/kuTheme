jQuery(document).ready(function($) {
    $('#colorpicker1').hide();
    $('#colorpicker1').farbtastic('#link-color');

    $('#link-color').click(function() {
        $('#colorpicker1').show();
    });

    $(document).mousedown(function() {
        $('#colorpicker1').each(function() {
            var display = $(this).css('display');
            if ( display == 'block' )
                $(this).hide();
        });
    });
});

jQuery(document).ready(function($) {
    $('#colorpicker3').hide();
    $('#colorpicker3').farbtastic('#specialbg-color');

    $('#specialbg-color').click(function() {
        $('#colorpicker3').show();
    });

    $(document).mousedown(function() {
        $('#colorpicker3').each(function() {
            var display = $(this).css('display');
            if ( display == 'block' )
                $(this).hide();
        });
    });
});
