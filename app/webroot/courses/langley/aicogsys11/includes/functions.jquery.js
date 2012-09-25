function add_names() {
    $('#schedule h1 > strong').each(function(index, element) {
        var date = $(this).html();
        date = date.toLowerCase().replace(' ','');
        $(this).before('<a name="' + date + '"></a>');
        $('#nav_left ul').append('<li><a href="#' + date + '">' + $(this).html() + '</a></li>');
    });
}

function add_blank_to_links() {
    $('#contents a').attr('target','_blank');
    $('#nav_left a').attr('target','');
}