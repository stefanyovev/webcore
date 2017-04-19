<?php

      header( 'Cache-control: no-cache, no-store, must-revalidate' );

      if( !( $conf = file( 'conf', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES ) ) )
         if( file_put_contents( 'conf', " lang = en \n mysql_host = localhost " ) === false )
            exit( 'NO CONFIGURATION !  and  NO WRITE ACCESS !  to the file system' );
         else     
            $conf = array( 'lang' => 'en', 'db_host' => 'localhost' );
      else
         foreach( $conf as $n => $l )
            if( $x = strstr( $l, '=', true ) )
               $conf[trim($x)] = trim(substr($l,strlen($x)+1));

      function conf( $k, $v ){ global $conf; $buf = ''; $found = false;
         foreach( file( 'conf', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES ) as $l ){
            if( ( $x = strstr( $l, '=', true ) ) && trim( $x ) == $k ){
               $found = true; $buf .= " $k = $v\n";
            }else $buf .= "$l\n"; }
         if( !$found ) $buf .= " $k = $v\n";
         if( file_put_contents( 'conf', $buf ) !== false ){
            $conf[$k] = $v;return true;
         }
         echo 'error: no write access to the file system';
         return false;
      }

      if( $conf[db_host] && $db = mysql_connect( $conf[db_host], $conf[db_user], $conf[db_pass] ) )
         mysql_query( 'set names utf8' );

      session_start();
      
      $sess = & $_SESSION;

      if( !$conf[pass] )
         $sess[control] = true;

      $env = & $_SERVER;      

      $loc = trim( str_replace( "?{$env[QUERY_STRING]}", '', $env[REQUEST_URI] ), '/' ); $loc = $loc ? explode( '/', $loc ) : false;
      $post = $env[REQUEST_METHOD] == 'POST';
      $data = empty( $_POST ) ? false : ( get_magic_quotes_gpc() ? array_map( 'stripslashes', $_POST ) : $_POST  );

      $apps = $conf[apps] ? explode( ',', $conf[apps] ) : false;

      $short = strstr( $env[HTTP_ACCEPT], 'text/plain' ) === false ? false : true;

      if( $short ) header( 'Content-type: text/plain; charset=UTF-8' );
      
      ob_start();
         
      if( $loc ){
      
         $app = $loc[0];
         
         if( $app == 'logout' && $conf[pass] ){
         
            $sess[control] = false;
            if( $short ) exit( 'ok' );
            header( 'Location: /' );
            exit;
            
         }elseif( $app == 'login' && $conf[pass] ){
         
            $sess[control] = false;
            if( $post && $data && $data[pass])
               if( $data[pass] != $conf[pass] ){
                  echo "login error\n";
                  if( $short ) exit;
               }else{
                  $sess[control] = true;
                  if( $short ) exit;
                  header( 'Location: /control' );
                  exit;
               }
            
         }elseif( $app == 'control' ){
         
            if( !$sess[control]  ){
               header( 'Location: /login' );
               exit;
            }

         }elseif( $app == 'script' ){
            header( 'Content-type: text/javascript; charset=UTF-8' );
            require 'script.php';
            exit;

         }elseif( $app == 'style' ){
            header( 'Content-type: text/css; charset=UTF-8' );
            require 'style.php';
            exit;

         }else
            $app = false;
      }

      if( ob_get_length() )
         if( $short )
            exit;
         else{
            $console = ob_get_contents();
            ob_clean();
         }

      if( $app )
         require $app.'.php';

      elseif( $apps && $loc && in_array( $loc[0], $apps ) ){
         $app = $loc[0];
         require "apps/$app/main.php";
         
      }elseif( $apps ){
         $app = $apps[0];
         require "apps/$app/main.php";
      }

      if( $app )
         if( $short )
            exit;
         else{
            $content = ob_get_contents();
            ob_clean();
         }
         
      elseif( $short )
         exit( 'not found error' );

      elseif( $loc )
         $console .= "\"{$loc[0]}\" Not Found";

      elseif( $sess[control] ){
         header( 'Location: /control' );
         exit;
      }

      header( 'Content-type: text/html; charset=UTF-8' );

?><!doctype html>
<html lang="<?php echo $conf[lang] ?>">
   <head>
      <title><?php echo $conf[name] ?></title>
      <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
      <link rel="stylesheet" type="text/css" href="/style">
      <script type="text/javascript" src="/script"></script>
   </head>
   <body class="loading horizontal window paint0 shadow0">
      <h1>asdad</h1>
      <?php
      
         $Z = 0;
         $appclass = 'suspended vertical movable sizable rounded paint1 shadow1';
         
         function div( $x=null, $y=null, $z=null, $u=null ){ global $Z; echo
            '<div'.($x?" id=\"$x\"":'').($y?" class=\"$y\"":'')." style=\"z-index:$Z;$z\">$u</div>\n";
            $Z -= 1; }

         if( $console )
            div( 'console', $appclass, null,
               str_replace( "\n", '<br>', $console ) . '<br><button tabindex="1" onclick="this.parentNode.style.display=\'none\'"> OK </button>' );

         if( $app )
            if( $app == 'login' )
               div( 'login', $appclass, null, $content );

            elseif( $app == 'control' )
               div( 'control', $appclass, null, $content );
               
            else
               div( $app, $appclass, null, $content );
            
      ?>
   </body>
</html>