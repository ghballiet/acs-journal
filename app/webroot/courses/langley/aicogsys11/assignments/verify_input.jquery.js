function check_field(field) {
    var contents = $(field).val();
    if(contents == "" || contents == null)
	return "<li><strong>Required field is empty:</strong> " + field.replace('#','')
    + "</li>\r\n";
    else
	return "";
}

function check_radio(name) {
    var contents = $('input:radio[name=' + name + ']:checked').val();
    if(contents == "" || contents == null)
	return "<li><strong>Required field is empty:</strong> " + name + "</li>\r\n";
    else
	return "";
}
