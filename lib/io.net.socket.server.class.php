<?php
error_reporting (E_ALL);

define('SOCKET_PORT',           '7920');
define('SOCKET_HOST',           '127.0.0.1');
define('SOCKET_WELCOME_MSG',    'Hello!\n');



class SocketServer {

    
    private static $socket = null;
    private static $m_socket = null;
    
    
    public static function start () {
        
        // check for configuration constants here
        
        if ( SOCKET_PORT == '' || SOCKET_HOST == '' ) {
            
            die ("<br/>No SocketServer configuration available (".SOCKET_PORT." ".SOCKET_HOST.")!
                  <br/>Stops system.");
        } else {
        
            self::connect();
        }
        
    }
    
    
    private static function connect () {
        
        // system is waiting
        
        set_time_limit (0);
        
        if((self::$socket = socket_create( AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
            
            echo "socket_create() fehlgeschlagen: Grund: " . socket_strerror(socket_last_error(self::$socket)) . "\n";
        } elseif ( socket_bind ( self::$socket, SOCKET_HOST, SOCKET_PORT) === false ) {
            
            echo "socket_bind() fehlgeschlagen: Grund: " . socket_strerror(socket_last_error(self::$socket)) . "\n";
            socket_close (self::$socket);
            //self::start();
        } elseif ( socket_listen ( self::$socket, 5 ) === false ) {
            
            echo "socket_listen() fehlgeschlagen: Grund: " . socket_strerror(socket_last_error(self::$socket)) . "\n";
        } else {
    
            self::shake_hand ();
            
        }
    }
    
    
    private static function shake_hand () {
        
        do {
            
            if ((self::$m_socket = socket_accept(self::$socket)) === false) {               
                
                echo "socket_accept() fehlgeschlagen: Grund: " . socket_strerror(socket_last_error(self::$socket)) . "\n";
                break;
            }
            
            /*echo "<pre>";
            print_r(self::$m_socket);
            echo "</pre>";*/
            
            //self::send ( "Welcome" );
            
            do {
                
                if (false === ($buf = socket_read (self::$m_socket, 2048, PHP_BINARY_READ))) {
            
                    echo "socket_read() fehlgeschlagen: Grund: " . socket_strerror(socket_last_error(self::$socket)) ." - ".$buf."\n";
                    break 2;
                }
        
                if( $buf == "close" ) {
                    
                    $response = self::on_receive( $buf );
                    self::send ( "sends: ".$response."\nshut down!" );
                    socket_close (self::$socket);
                }else{
                
                    $response = self::on_receive( $buf );
                    self::send ( $response );
                }
                
                
            } while(true);
            
            socket_close (self::$m_socket);
            
        } while(true);
        
        socket_close (self::$m_socket);
    }
    
    
    private static function listen () {
        
        if (false === ($buf = socket_read (self::$m_socket, 2048, PHP_BINARY_READ))) {
            
            echo "socket_read() fehlgeschlagen: Grund: " . socket_strerror(socket_last_error(self::$socket)) . "\n";
            break 2;
        }
        
        $response = self::on_receive( $buf );
        self::send ( $response );
    }
    
    private static function get_handshake () {
        
        $secKey = $headers['Sec-WebSocket-Key'];
        $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
        $upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "WebSocket-Origin: $host\r\n" .
            "WebSocket-Location: ws://$host:$port/deamon.php\r\n".
            "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
        
        return $upgrade;
    }
    
    
    public static function on_receive ( $_d = '' ) {
        
        return $_d;
    }
    
    
    public static function send ( $_d ) {
        
        socket_write (self::$m_socket, $_d, strlen ( $_d ));
    } 
    
    public static function stop () {
        
        socket_close (self::$socket);
    }
    

}
?>