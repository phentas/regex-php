<?php

error_reporting (E_ALL);

include_once ('lib/string.pattern.class.php');


//$d = '321.3.127.1 23 - - "adasdsa das 3 / dsads.3" "ew" "adasdsa das (MS:t 9.0) 3 / dsads.3" 200';
//$d = '127.0.0.1 - frank [10/Oct/2000:13:55:36 -0700] "GET /apache_pb.gif HTTP/1.0" 200 2326 "http://www.example.com/start.html" "Mozilla/4.08 [en] (Win98; I ;Nav)"';

$d = 'In a typical client-server relationship a connection is established, page contents are transmitted, and the connection is terminated. Subsequent to that, any activity on the page is a client-side process. PHP embedded in a page should be viewed as an activity that is occurring before or during the preparation of the page, something that terminates when the transmission is complete? I sometimes use PHP to generate script attached to the page that accomplishes certain activities on the client side. Your question indicates that your perception of these relationships may not be entirely and correctly formed. You may wish to post back with more information or questions?';

preg_match_all(QUESTION_REGEX,$d,$m);

echo "<pre>";
print_r(StringPattern::get_parted ( $d, QUESTION_REGEX ));
echo "</pre>";

// eof
?>

<script type="application/javascript" >

    var socket = new WebSocket("ws://127.0.0.1:7920");
    socket.onopen = function () {
    
        console.log(socket.readyState);
        socket.send("hallo");
    };
    
    socket.onerror = function ( error ) {
    
        console.log( error );
    };
    
    //
    socket.onmessage = function ( msg ) {
        
        console.log( msg );
    }
    
    socket.onclose = function ( ) {
        
        console.log( this );
        window.clearInterval(iv_id);
    }
    
    var iv_id = window.setInterval(function(){
        console.log(socket);
    },3000);
</script>

