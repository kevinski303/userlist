
function add_user() {
    var name = $( '#username' ).val();
    if(name.trim())
        $( "div#userlist" ).append("<input type=\"checkbox\" name=\"user_"+name+"\" checked><span style=\"color:#AA3300\">"+name+"</span><br>");
}

/*
function add_admin() {
    var name = $( '#adminname' ).val();
    if(name.trim())
        $( "div#adminlist" ).append("<input type=\"checkbox\" name=\"admin_"+name+"\" checked><span style=\"color:#AA3300\">"+name+"</span><br>");
}
*/
