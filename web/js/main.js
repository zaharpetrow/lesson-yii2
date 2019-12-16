(function () {

    $('table').on('mouseenter', 'tr.mylink', function (e) {
        var textLink = window.location.hostname + $(e.target).closest('tr').attr('href');
        var win = $(window);
        var hintLink = $('<div>', {class: 'hint-link', text: textLink});

        $('body').append(hintLink);
        hintLink.offset({top: win.height() + win.scrollTop() - hintLink.height()});
    });

    $('table').on('mouseleave', 'tr.mylink', function (e) {
        $('.hint-link').remove();
    });
    
    $('table').on('click', 'tr.mylink', function(e){
        location.href=$(this).closest('tr.mylink').attr('href');
    });

}());