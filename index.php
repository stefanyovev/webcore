<?php

      header( 'Cache-control: no-cache, no-store, must-revalidate' );
      header( 'Content-type: text/html; charset=UTF-8' );
         
      session_start();

      $s = & $_SESSION; 
      $p = & $_POST; if( get_magic_quotes_gpc() ) array_map( stripslashes, $p );
      $e = & $_SERVER;
      $f = & $_FILES;
      var_dump($e);exit;
      $base = trim( dirname( $e[PHP_SELF] ), '/' );
      $base0 = 'http' . ( $e[HTTPS] ? 's' : '' ) . '://' . $e[SERVER_NAME] . '/' . ( $base ? "$base/" : '' ); 

      function clamp( $x, $a, $b ){
         return ( $x < $a ? $a : ( $x > $b ? $b : $x ) ); }

      function valid( $type, $data ){}

      function esc( $data, $for = front ){ switch( $for ){
         case front: return htmlentities( $data, ENT_QUOTES, 'UTF-8' );
         case back: return addslashes( $data ); } }
      
      function redirect( $to = '' ){ global $base;
         header( 'Location: ' . $base0 . $to ); exit; }
         
      function tar( $x ){ $t = ''; foreach( explode( '/', $x ) as $y ) $t = $y;
         return $t; }

      function place( $x ){
         if( strlen( $x ) < 2 || strstr( $x, '/' ) === false ) return '';
         return substr( $x, 0, -1-strlen( tar( $x ) ) ); }

      function mem(){
         return json_decode( file_get_contents( 'data/memory.json' ), JSON_OBJECT_AS_ARRAY ); }

      function save(){ global $m;
         return file_put_contents( 'data/memory.json', json_encode( $m ) ); }

      function & m( $x = '' ){ global $m; $mm = & $m; if( !$x ) return $mm;
         if( strstr( $x, '/' ) === false ){ $mm = & $m[$x]; return $mm; }
         foreach( explode( '/', $x ) as $y ) $mm = & $mm[$y]; return $mm; }

      function val( $x ){ 
         return m( "$x/0" ); }

      function color( $x, $o=1, $q=1 ){ $r = array(
         hexdec( substr( $x, 1, 2 ) ), hexdec( substr( $x, 3, 2 ) ), hexdec( substr( $x, 5, 2 ) ), $o );
         if( $q != 1 ) $r = array(
            round( clamp( $r[0]+($q-1)*255, 0, 255 ) ),
            round( clamp( $r[1]+($q-1)*255, 0, 255 ) ),
            round( clamp( $r[2]+($q-1)*255, 0, 255 ) ),
                   clamp( $r[3]+ $q-1     , 0, 1 ) );
         return 'rgba( '.implode( ', ', $r ).')'; }

      function install(){ global $m; 
         if( !file_put_contents( '.htaccess', "RewriteRule (.*) index.php" ) ) die( 'CANNOT WRITE .HTACCESS' );
         if( !mkdir( 'data', 0777 ) ) die( 'CANNOT CREATE DIR' );
         mkdir( 'data/data', 0777 ); mkdir( 'data/cache', 0777 );
         $m = array(    
            type => dir,
            time => time(), 
            style_time => time(),
            lock => array(),
            apps => array( '', welcome, photoframe, calendar, contactme ),
            show => array( type => 'var/bit', 1 ),
            app => array( type => 'var/enum', '' ),
            pass => array( type => 'var/pass', '' ),
            lang => array( type => 'var/enum', 'en', af,sq,am,ar,hy,az,eu,be,bn,bs,bg,ca,ceb,ny,'zh-CN',co,hr,cs,da,nl,en,eo,et,tl,fi,fr,fy,gl,ka,de,el,gu,ht,ha,haw,iw,hi,hmn,hu,is,ig,id,ga,
                                                      it,ja,jw,kn,kk,km,ko,ku,ky,lo,la,lv,lt,lb,mk,mg,ms,ml,mt,mi,mr,mn,my,ne,no,ps,fa,pl,pt,pa,ro,ru,sm,gd,sr,st,sn,sd,si,sk,sl,so,es,su,
                                                      sw,sv,tg,ta,te,th,tr,uk,ur,uz,vi,cy,xh,yi,yo,zu ),
            title => array( type => 'var/text', 'untitled' ),    
            descr => array( type => 'var/text', 'new website' ), 
            icon => array( type => 'var/file', 'image/*' ),
            text_color => array( type => 'var/colors', '#000000' ),
            links_color => array( type => 'var/colors', '#0000d5' ),
            font => array( type => 'ui',
               size => array( type => 'var/num', 80, 50, 5, 150 ),
               file => array( type => 'var/file', 'font/*' ) ),
            logo => array( type => 'ui',
               image => array( type => 'var/file', 'image/*' ),
               size => array( type => 'var/num', 4, 1, 1, 10 ),
               radius => array( type => 'var/num', 0.2, 0, 0.1, 2 ),
               leftspace => array( type => 'var/num', 20, 0, 1, 50 ) ),
            menu => array( type => 'ui',
               color => array( type => 'var/colors', '#b9d5a8' ),
               padding => array( type => 'var/num', 2, 0, 0.5, 5 ),
               radius => array( type => 'var/num', 0.5, 0, 0.05, 5 ),
               opacity => array( type => 'var/num', 0.85, 0, 0.05, 1 ) ),
            items => array( type => 'ui',
               flow => array( type => 'var/enum', 'normal', horizontal, vertical, normal ),
               width => array( type => 'var/num', 10, 2, 2, 100 ),
               height => array( type => 'var/num', 10, 2, 2, 100 ),
               margin => array( type => 'var/num', 2, 0, 0.5, 5 ),
               radius => array( type => 'var/num', 0.2, 0, 0.05, 10 ) ),
            page => array( type => 'ui',
               color => array( type => 'var/colors', '#ebebeb' ),
               padding => array( type => 'var/num', 2, 0, 0.5, 5 ),
               radius => array( type => 'var/num', 0.5, 0, 0.05, 5 ),
               opacity => array( type => 'var/num', 0.95, 0, 0.05, 1 ) ),
            shadows => array( type => 'ui',
               size => array( type => 'var/num', 1, 0, 0.5, 5 ),
               color => array( type => 'var/colors', '#000000' ),
               opacity => array( type => 'var/num', 0.9, 0, 0.05, 1 ) ),
            background => array( type => 'ui',
               color => array( type => 'var/colors', '#338286' ),
               opacity => array( type => 'var/num', 1, 0, 0.01, 1 ),
               random_image => array( type => 'var/bit', 0 ),
               size => array( type => 'var/enum', 'cover', cover, contain ),
               image => array( type => 'var/file', 'image/*' ) ) );
         save(); }

      function root( $exit = false ){ global $m, $p;
         if( $m[lock][1] > time() && $m[lock][0] == session_id() ){
            if( $exit ) $m[lock] = false; else $m[lock][1] = time() + 600; save(); return true; }
         if( $m[lock][1] < time() && ( !$m[pass][0] || ( count( $p ) == 1 && $p[pass] == $m[pass][0] ) ) ){
            $m[lock] = array( session_id(), time() + 600 ); save(); return true; }
         return false; }

      function menu( $q, $x, $y = null ){ global $m; switch( $q ){
         case add: $m[menu][] = $x; break;
         case remove: for( $n = 0; isset( $m[menu][$n] ); $n++ ) if( $m[menu][$n] == $x ) unset( $m[menu][$n] ); break;
         case replace: for( $n = 0; isset( $m[menu][$n] ); $n++ ) if( $m[menu][$n] == $x ) $m[menu][$n] = $y; break;
         case moveup: $n = array_search( $x, $m[menu] ); $x = $m[menu][$n-1]; $m[menu][$n-1] = $m[menu][$n]; $m[menu][$n] = $x; break;
         case movedown: $n = array_search( $x, $m[menu] ); $x = $m[menu][$n+1]; $m[menu][$n+1] = $m[menu][$n]; $m[menu][$n] = $x; } }
         
      function find( $wask = array(), $loc = '', $care = false ){ $mm = & m( $loc ); $r = array();
         foreach( $mm as $k => $v ) if( is_array( $v ) ){ $id = ( $loc ? "$loc/$k" : $k );
            $ok = ( $care ? ( $v[show] && !$v[show][0] ? false : true ) : true );
            if( $ok ) foreach( $v as $ck => $cv ) foreach( $wask as $fk => $fv ){
               $fv2 = rtrim( $fv, '*' ); if( substr( $v[$fk], 0, strlen( $fv2 ) ) != $fv2 ) $ok = false; }
            if( $ok ) $r[] = $id; /* if( $v[type] == dir ) */ $r = array_merge( $r, find( $wask, $id, $care ) ); }
         return $r; }

//######################################################################################################################################################################################

      function newname( $x ){ $mm = & m( place( $x ) ); $x = tar( $x ); $y = '';
         if( isset( $mm[$x] ) ){ for( $y = 2; isset( $mm[ "$x-$y" ] ); $y++ ); $x .= $y ? "-$y" : ''; }
         return $x; }

      function make( $type, $x, $mime=null ){ global $m; $loc = place( $x ); $mm = & m( $loc ); $x = newname( $x );
         $id = 'data/data/' . ( $loc ? "$loc/$x" : $x );
         mkdir( $id );
         $mm[$x] = array(                  
            type => $type,                           
            time => time(),                                  
            show => array( type => 'var/bit', $mm[show][0] ),
            title => array( type => 'var/text', $x ),
            descr => array( type => 'var/text', $x ),
            background => array( type => 'ui',
               color => $mm[background][color],
               opacity => $mm[background][opacity],
               size => array( type => 'var/enum', 'cover', cover, contain ),
               image => array( type => 'var/file', 'image/*' ) ) );
         if( $type == dir ){
            $mm[$x][background][random_image] = array( type => 'var/bit', 0 );
            $mm[$x][items] = array( type => 'ui',
               flow => array( type => 'var/enum', 'normal', horizontal, vertical, normal ),
               width => array( type => 'var/num', 10, 2, 2, 100 ),
               height => array( type => 'var/num', 10, 2, 2, 100 ),
               margin => array( type => 'var/num', 2, 0, 0.5, 5 ),
               radius => array( type => 'var/num', 0.2, 0, 0.05, 10 ) );
            $mm[$x][app] = array( type => 'var/enum', '' ); }
         if( $type == file ){
            $mm[$x][mime] = $mime;
            if( place( $mime ) == text )
               file_put_contents( "$id/content", 'textextex' ); }
         return $x; }
         
      function del( $x ){ global $m; $loc = place( $x ); $mm = & m( $loc ); $id = $x; $x = tar( $x );
         menu( remove, $id );
         foreach( $mm[$x] as $key => $val ) del( "$id/$key" );
         if( $mm[$x][cache] ) foreach( array_keys( $mm[$x][cache] ) as $n )
            unlink( "data/cache/$id-$n" );
         if( $mm[$x][type] == 'var/file' ){
            unset( $mm[$x][time] );
            $m[style_time] = time(); }
         else{
            rmdir( "data/data/$id" );
            unset( $mm[$x] ); }; }

      function ren( $x, $y ){ $loc = place( $x ); $mm = & m( $loc );
         $oldname = tar( $x ); $oldid = ( $loc ? "$loc/$oldname" : $oldname );
         $newname = newname( $loc ? "$loc/$y" : $y ); $newid = ( $loc ? "$loc/$newname" : $newname );
         menu( replace, $oldid, $newid );
         if( $mm[$oldname][cache] ){
            foreach( array_keys( $mm[$oldname][cache] ) as $n )
               rename( "data/cache/$oldid-$n", "data/cache/$newid-$n" );
            rename( "data/cache/$oldid", "data/cache/$newid" ); }
         rename( "data/data/$oldid", "data/data/$newid" );
         $mm[$newname] = $mm[$oldname];
         unset( $mm[$oldname] ); 
         if( $mm[$newname][title][0] == $oldname ) $mm[$newname][title][0] = $newname;
         return $newname; }
               
//######################################################################################################################################################################################

      function cache( $x ){ $loc = place( $x ); $tt = & m( $x ); $x = tar( $x );
         $id = 'data/data/' . ( $loc ? "$loc/$x" : $x );
         $twin = 'data/cache' . ( $loc ? "/$loc" : '' ); if( !is_dir( $twin ) ) mkdir( $twin, 0777, true ); $twin .= "/$x";
         $tt[cache] = array(); $type = tar( $tt[mime] );
         $i = $type == jpeg ? imagecreatefromjpeg( $id ) : imagecreatefrompng( $id );
         $iw = $tt[width] = imagesx( $i ); $ih = $tt[height] = imagesy( $i );
         for( $jw = $iw, $jh = $ih, $n = 0; $jw > 50 && $jh > 50; $jw = intval( $jw/1.5 ), $jh = intval( $jh/1.5 ), $n++ ){
            $tt[cache][$n] = array( width => $jw, height => $jh );
            $j = imagecreatetruecolor( $jw, $jh );
            imagecopyresized( $j ,$i, 0, 0, 0, 0, $jw, $jh, $iw, $ih );
            if( $type == jpeg ) imagejpeg( $j, "$twin-$n", 90 );
            else imagepng( $j, "$twin-$n", 8, PNG_ALL_FILTERS );
            imagedestroy( $j ); } }

      function cached( $x, $to, $w, $h ){ $tt = & m( $x ); $maxn = max( array_keys( $tt[cache] ) );
         $H = ( $to == contain && $w / $h >= $tt[width] / $tt[height] ) || ( $to == cover && $w / $h < $tt[width] / $tt[height] );
         for( $n = $maxn; $tt[cache][$n][ $H ? height : width ] < ( $H ? $h : $w ) && $n > 0; $n-- ); return $n; }

      function dropimg( $t, $to =null, $w =null, $h =null, $o =1 ){ $tt = & m( $t );
         if( $tt[type] == dir ){
            $l = find( array( type => file, mime => 'image/*' ), $t, true );
            if( !$l ) return;
            $t = $l[ round( rand( 0, max( array_keys( $l ) ) ) ) ];
            $tt = & m( $t ); }
         if( !$tt[time] ) return;
         if( $tt[cache] ){
            if( $to && $w && $h ) $n = cached( $t, $to, $w, $h );
            else $n = max( array_keys( $tt[cache] ) );
            $t .= '/cache/' . $n; }
         else $t .= '/original';
         $t .= '/' . $tt[time];
         echo '<img src="' . $t ;
         if( $tt[cache] ){
            echo '" width="'.$tt[cache][$n][width]
               .'" height="'.$tt[cache][$n][height]
               .'" data-width="'.$tt[cache][$n][width]
               .'" data-height="'.$tt[cache][$n][height]
               .'" data-cache="'.implode( ',', array_map( function( $_ ){ return implode( 'x', $_ ); } ,$tt[cache] ) ); }
         if( $to ) echo '" class="'.$to;
         if( $o < 1 ) echo '" style=" opacity: '.$o;
         echo '">'; }

      function upload( $d ){ global $f; $mm = & m( $d );
         foreach( $f[files][tmp_name] as $n => $x ) if( !$f[files][error][$n] ){ $id = $f[files][name][$n];
            $id = ( $d ? "$d/" : '' ) . newname( ( $d ? "$d/" : '' ) . ( strstr( $id, '.' ) === false ? $id : substr( $id, 0, -strlen( strrchr( $id, '.' ) ) ) ) );
            $t = tar( $id );
            move_uploaded_file( $x, 'data/data/' . $id );
            $mm[$t][type] = file;                                                                                                #########################
            $mm[$t][time] = time();                                                                                              #########################
            $mm[$t][mime] = $f[files][type][$n];                                                                                     #########################
            $mm[$t][show] = array( type => 'var/bit', ( $d ? $mm[show][0] : 1 ) );                                                      #########################
            $mm[$t][title] = array( type => 'var/text', $t );                                                                         #########################
            $mm[$t][size] = $f[files][size][$n];                                                                                     #########################
            if( in_array( tar( $mm[$t][mime] ), array( jpeg, png ) ) )
               cache( $id ); } }
               
      function setup( $t ){ global $m, $p, $f; $tt = & m( $t );
         foreach( $tt as $x => $y ) if( place( $tt[$x][type] ) == 'var' ) switch( tar( $tt[$x][type] ) ){
            default: if( isset( $p[$x] ) ) $tt[$x][0] = $p[$x]; break;
            case 'colors': if( is_array( $p[$x] ) ) foreach( $p[$x] as $n => $color ) $tt[$x][$n] = $color; break;
            case 'bit': if( $p ){
               if( $x !== show ) $tt[$x][0] = $p[$x] ? 1 : 0;
               else foreach( find( array( type => 'var/bit' ), $t ) as $z ) if( tar( $z ) == show ){ 
                  $cval = & m( "$z/0" );
                  $cval = ( $p[$x] ? 1 : 0 ); 
                  if( !$cval ) menu( remove, place( $z ) ); } } 
               break;
            case 'file': if( $f[$x] && !$f[$x][error] ){
               $id = 'data/data' . ( $t ? "/$t" : '' ); if( !is_dir( $id ) ) mkdir( $id, 0777, true ); $id .= "/$x";
               move_uploaded_file( $f[$x][tmp_name], $id );
               $tt[$x][mime] = $f[$x][type];
               $tt[$x][size] = $f[$x][size];
               $tt[$x][time] = time();
               if( in_array( tar( $tt[$x][mime] ), array( jpeg, png ) ) )
                  cache( $t ? "$t/$x" : $x ); } } }


//######################################################################################################################################################################################

      $m = mem() or install();

      $args = array_map( urldecode, explode( '/', substr( str_replace( "?{$e[QUERY_STRING]}", '', $e[REQUEST_URI] ), $base ? strlen( $base )+1 : 0 ) ) ); if( $args[0] === '' ) array_shift( $args );
      $loc = '';
      $mm = & $m; while( $args && isset( $mm[$args[0]] ) && isset( $mm[$args[0]][type] ) ){ $x = array_shift( $args ); $mm = & $mm[$x];
         $loc .= $loc ? "/$x" : $x; }
      $dir = $loc ? $loc : '.';
      $l1 = strstr( $loc, '/' ) === false;
      $a = array(); while( $args && $args[0] !== '' ) $a[] = array_shift( $args );      
         array_shift( $args );
      $q = array_shift( $args ); 
      $short = strstr( $e[HTTP_ACCEPT], 'text/plain' ) === false ? false : true;

      function locargs(){ global $loc, $args;
         return $loc . ( $loc && $args ? '/' : '' ) . implode( '/', $args ); }

      switch( $q ){      
         case 'dump':
            if( root() ){ echo '<pre>'; var_export( $mm ); echo '</pre>'; exit; }
            break;
         case 'style':
            header( 'Content-type: text/css; charset=UTF-8' );
            header( 'Cache-control: max-age=10'); header_remove( Expires ); header_remove( Pragma );
            require 'style.php';
            exit;
         case 'script': 
            header( 'Content-type: text/javascript; charset=UTF-8' );
            header( 'Cache-control: max-age=10'); header_remove( Expires ); header_remove( Pragma );
            require 'script.php';
            exit;
         case 'exit':
            if( root( true ) && $short ) die( ok ); elseif( $short ) die( error );
            redirect( $loc ); }
            
      // serve file
      if( in_array( $mm[type], array( 'file', 'var/file' ) ) && $mm[time]
         && ( $a[0] == 'original' || ( $a[0] == 'cache' && $mm[cache][$a[1]] ) )
         && ( $mm[type] == 'var/file' || $mm[show][0] || root() ) ){
         header( 'Content-type: ' . $mm[mime] );
         header( 'Cache-control: max-age=' . round( ( time()-$mm[time] )/2 ) ); header_remove( Expires ); header_remove( Pragma );
         if( $a[0] == 'original' ){ readfile( "data/data/$loc" ); exit; }
         else{ readfile( "data/cache/$loc-{$a[1]}" ); exit; } }

      function vars( $t ){ global $m, $loc; $mm = & m( $t ); $rel = $loc ? substr( $t, strlen( $loc )+1 ) : $t; $dir = $t ? $t : '.'; 
         $act = ( $loc ? "$loc" : '.' ) . '///setup' . ( $rel ? "/$rel" : '' );
         echo "\n".'<form  method="post" action="'.$act.'" enctype="multipart/form-data" class="wide"><h2> '.( $t == $loc ? 'Settings' : tar( $t ) ).' </h2> <input type="submit" value=" Save " ><input type="reset" value=" Reset " ><br><table class="wide">' . "\n";
         foreach( $mm as $x => $y ) if( substr( $y[type], 0, 3 ) == 'var' ){
            $label = $y[type] == 'var/file' && $y[time] ? ( '<a href="' . ( $t ? "$t/$x" : $x ) . ( $y[cache] ? '/original' : '' ) . '">' . $x . '</a>' ) : $x;
            echo "<tr><td> $label </td><td>"; switch( tar( $y[type] ) ){
               case 'bit': echo "<input type=\"checkbox\" name=\"$x\" value=\"".( $y[0] ? 'yes" checked ' : 'no" ' )." >"; break;
               case 'pass': echo "<input type=\"password\" name=\"$x\" placeholder=\"$x\" value=\"{$y[0]}\" onfocus=\"this.type='text'\" onblur=\"this.type='password'\" >"; break;
               case 'text': echo "<input type=\"text\" name=\"$x\" placeholder=\"$x\" value=\"{$y[0]}\" >"; break;
               case 'enum': echo "<select name=\"$x\">"; $opts = null; if( $x == app ) $opts = $m[apps]; else $opts = $y; $sel = $y[0]; for( $n = ( $x == app ? 0 : 1 ); isset( $opts[$n] ); $n++ ) echo '<option '.( $opts[$n] == $sel ? 'selected ' : '' )."value=\"{$opts[$n]}\">{$opts[$n]}</option>"; echo '</select>'; break;
               case 'num': echo "<input type=\"range\" name=\"$x\"  min=\"{$y[1]}\" step=\"{$y[2]}\" max=\"{$y[3]}\" value=\"{$y[0]}\">"; break;
               case 'colors': for( $n = 0; isset( $y[$n] ); $n++ ) echo "<input type=\"color\" name=\"{$x}[]\" value=\"{$y[$n]}\" >"; break;
               case 'file': echo "<a href=\"#\" onclick=\"upload('$act','" . $y[0] . "','$x'); return false;\" > ".( $y[time] ? 're' : '' )."set </a>"; if( $y[time] ) echo ' <a href="'.( $loc ? "$loc" : '.' ) . '///del/' . ( $rel ? "$rel/$x" : $x ).'"> unset </a>'; }
            echo "</td></tr>\n"; }
         echo '</table></form>' . "\n"; } 
         
      ob_start(); // edit layer -------------------------------------------------------------------------

      $edit = false;
            
      if( $q === '' )
         if( !root() ){ ?>
            <div id="__upload" class="layer"><!--
            --><div><!--
               --><div class="sh">
                     <form method="post" action="">
                        <input autofocus type="password" name="pass" placeholder="password"><br>
                        <input type="submit" value=" login " > 
                     </form>
                  </div><!--
            --></div><!--
         --></div><?php }
         else{
            if( $q = array_shift( $args ) ){        
               switch( $q ){
                  case 'setup': setup( locargs() ); $m[style_time] = time(); break;
                  case 'upload': upload( locargs() ); break;
                  case 'del': del( locargs() ); $m[style_time] = time(); break;
                  case 'ren': $newname = array_shift( $args ); ren( locargs(), $newname ); $m[style_time] = time(); break;
                  case 'menu': menu( array_shift( $args ), locargs() ); break;
                  case 'make': $type = array_shift( $args ); $dir = locargs(); if( $type == text ) make( file, ( $dir ? "$dir/" : '' ) . 'newtext', 'text/html' ); else make( $type, ( $dir ? "$dir/" : '' ) . "new$type" ); break;
                  case 'save': if( place( $mm[mime] ) == text ){ $mm[time] = time(); file_put_contents( 'data/data/' . $loc . '/content', $p[page] ); } }
               save(); if( $short ) die( ok ); else redirect( $loc ? "$loc//" : '/' ); }
            $edit = true; ?>
            <div id="__setup" class="right layer"><!--
            --><div><!--
               --><div class="sh">
                  <?php vars( $loc );
                     foreach( $mm as $x => $y ) if( $y[type] == 'ui' )
                        { echo '<br><br>'; vars( $loc ? "$loc/$x" : $x ); } ?>
                  </div><!--
            --></div><!--
         --></div>
            <div id="__upload" class="layer"><!--
            --><div><!--
               --><div class="sh">
                     <?php
                        if( $loc && !$l1 ) echo '<a href="' . ( $l1 ? '.' : place( $loc ) ) . '//"> ← </a>';
                        if( $loc ) echo '<a href=".//"> ⌂ </a> ';
                        echo '<h1> ' . ( $loc ? tar( $loc ) : 'Home' ) . ' </h1>';
                        if( $m[pass][0] ) echo " <a href=\"$dir//exit\" > exit </a>";
                        echo '<br>';
                        switch( $mm[type] ){
                           case 'file':
                              switch( place( $mm[mime] ) ){
                                 default:
                                    echo "<br> type: {$mm[mime]}<br>size: ".round($mm[size]/(1024*1024),2)."mb<br>time: ".date( 'Y-m-d H:i:s', $mm[time] ).'<br><br>'
                                       .'<a href="'.$dir.'/original">original</a><br>';
                                    break;
                                 case text:
                                    echo "<br><form  method=\"post\" action=\"$dir///save\" >";
                                    echo '<textarea class="page" name="page" rows="10" cols="50">'.esc( file_get_contents( "data/data/$loc/content" ) ).'</textarea><br>';
                                    echo '<input type="submit" value="Save" ></form><br>'; }
                              break;
                           case 'dir':
                              echo "<a href=\"$dir///make/dir\"> +dir </a>";
                              echo " <a href=\"#\" onclick=\"upload('$dir///upload','*/*'); return false;\"> +files </a>";
                              echo " <a href=\"$dir///make/text\"> +text </a>"; 
                              echo '<br><br>';
                              echo '<table id="dirtable" class="wide">';
                              foreach( $mm as $x => $y )
                                 if( in_array( $y[type], array( dir, file ) ) ){
                                    $id = $loc ? "$loc/$x" : $x;
                                    $n = ( $y[show][0] ? array_search( $id, $m[menu] ) : null );
                                    echo "<tr><td>".( $y[type] == file ? place( $y[mime] ) : $y[type] )."</td><td><a href=\"$id//\"> $x </a></td><td>";
                                    if( $y[show][0] ){
                                       if( $n === false ) echo "<a href=\"$dir///menu/add/$x\"> list </a> ";
                                       else echo "<a href=\"$dir///menu/remove/$x\"> unlist </a> ";
                                       echo '</td><td>';
                                       if( $n ) echo "<a href=\"$dir///menu/moveup/$x\"> ↑ </a> ";
                                       if( $n && $n != max( array_keys( $m[menu] ) ) ) echo "<a href=\"$dir///menu/movedown/$x\"> ↓ </a> "; }
                                    else echo '&nbsp;</td><td>&nbsp;';
                                    echo "</td><td><a href=\"#\" onclick=\"var x = prompt( 'New (URL) Name ?', '$x' ); if( x ){ this.href= '$dir///ren/'+x+'/$x' ; return true; } return false;\"> ren </a></td>";
                                    echo "<td><a href=\"$dir///del/$x\"> x </a></td></tr>"; }
                              echo '</table>'; } ?>
                  </div><!--
            --></div><!--
         --></div> <?php }

      ob_start(); // dir layer -------------------------------------------------------------------------

      if( $mm[type] == 'dir' && $mm[show][0] ){ ?>
         <div class=" dir layer <?php
            if( in_array( $mm[items][flow][0], array( horizontal, vertical ) ) )
               echo $mm[items][flow][0][0];
            echo '" ';
            if( $loc ) echo 'id="' . str_replace( '/', '_', $loc ); ?>" ><!--
         --><span>&nbsp;</span><!--
         --><div><?php foreach( $mm as $x => $y ) if( in_array( $y[type], array( dir, file ) ) && $y[show][0] ){ $id = ( $loc ? "$loc/$x" : $x ); ?><!--
            --><a href="<?php echo $id ?>" id="<?php echo str_replace( '/', '_', $id ) ?>" class="<?php if( $y[type] == file ) echo file ?> sh" ><!--
               --><div class="layer"><!--
                  --><span>&nbsp;</span><!--
                  --><?php if( $y[type] == file && place( $y[mime] ) == image ) dropimg( $id, contain, 50, 50 );
                           elseif( $y[background] && $y[background][random_image][0] ) dropimg( $id, cover, 50, 50, $y[background][opacity][0] );
                           elseif( $y[background] && $y[background][image][time] ) dropimg( "$id/background/image", cover, 50, 50, $y[background][opacity][0] ); ?><!--
               --></div><!--
               --><div class="layer second"><!--
                  --><span>&nbsp;</span><!--
                  --><?php echo $y[title][0] ?><!--
               --></div><!--
            --></a><?php } ?><!--
         --></div><!--
      --></div> <?php }

      ob_start(); // social layer -------------------------------------------------------------------------
      
      ?>
         <div id="social" class="right layer"><!--
         --><span>&nbsp;</span><!--
         --><div class=" bottom "><!--
            --><span>&nbsp;</span><!--
            --><a href="#" class="sh"><!--
               --><svg viewBox="0 0 300 300" >
                     <path d="M100 113 L200 113 L150 200 Z" ></path>
                  </svg><!--
            --></a><!--
            --><a href="#" class="sh"><!--
               --><svg viewBox="0 0 300 300" >
                     <path d="M100 113 L200 113 L150 200 Z" ></path>
                  </svg><!--
            --></a><!--
         --></div><!--
      --></div>
      <?php

      ob_start(); // page layer -------------------------------------------------------------------------

      if( $mm[type] == 'file' && $mm[show][0] )
         switch( place( $mm[mime] ) ){
         
            case 'image': ?>
               <div class="layer" ><!--
               --><span>&nbsp;</span><!--
               --><?php dropimg( $loc, contain, 500, 500 ) ?><!--
            --></div> <?php
               break;
               
            case 'text': ?>
               <div class=" page layer "><!--
               --><span>&nbsp;</span><!--
               --><div><!--
                  --><div class="sh">
                        <?php readfile( "data/data/$loc/content" ) ?>
                     </div><!--
               --></div><!--
            --></div> <?php }


//######################################################################################################################################################################################

      //if( !ob_get_length() ) if( $loc || $a ) if( $short ) echo error; else redirect(); else echo 'empty';
      if( $short ) exit;
      
      $layers = array( ob_get_contents() );
      while( ob_end_clean() )
         $layers[] = ob_get_contents();
      $ob = implode( "\n\n", $layers );

?><!doctype html>
<html lang="<?php echo $m[lang][0] ?>">
   <head>
      <base href="/<?php echo $base ? "$base/" : '' ?>">
      <?php if( $m[icon][time] ) echo "<link rel=\"icon\" type=\"{$m[icon][mime]}\" href=\"icon/cover/1/1/{$m[icon][time]}\">\n" ?>
      <title><?php echo esc( $m[title][0] ) ?></title>
      <meta name="description" content="<?php echo esc( $m[descr][0] ) ?>">
      <link rel="stylesheet" type="text/css" href=".//style/<?php echo $m[style_time] ?>" >
      <script type="text/javascript" src=".//script" ></script>
   </head>
   <body>
      <script type="text/javascript">
         body = doc.body;
         forms = doc.forms;
      </script>

      <div id="background" class="layer" style=" background-color: <?php echo color( $mm[background][color][0], $mm[background][opacity][0] ) ?> " ><!--
      --><span>&nbsp;</span><!--
      --><?php dropimg(
            $mm[background][random_image][0] ? $loc : ( ( $loc ? "$loc/" :'' ) . 'background/image' ),
             $mm[background][size][0], 500, 500, $mm[background][opacity][0] );
         ?><!--
   --></div>

      <?php echo $ob ?>
      
      <?php $links = array();
         for( $n = 0; isset( $m[menu][$n] ); $n++ )
            $links[] = "<a href=\"{$m[menu][$n]}\">".esc( m( $m[menu][$n].'/title/0' ) )."</a> "; ?>
            
      <div id="menu" class="layer"><!--
      --><div id="menu-menu" class="sh"><!--
         --!><?php echo implode( "<!--\n             -->", $links ) ?><!--
      --></div><!--
      --><div class="wide sh"><!-- 
         --><div id="menu-left" class="right"><!--
            --><a href="."><!--
               --><?php if( $m[logo][image][time] ) echo '<img id="logo" src="logo/image/original/'.$m[logo][image][time].'" >' ?><!--
            --></a><!--
         --></div><!--
         --><div id="menu-right"><!--
            --><div><!--
               --><?php echo implode( "<!--\n                -->", $links ) ?><!--
            --></div><!--
         --></div><!--
      --></div><!--
      --><div id="menu-button" onclick="togglemenumenu();" ><!--
         --><svg viewBox="0 0 300 300">
               <path d="M100 113 L200 113 L150 200 Z" ></path>
            </svg><!--
      --></div><!--
   --></div>
            
      <script type="text/javascript">
         sizeimgs( true );
         <?php if( !$edit ){ ?>bind( body, 'dblclick', function(){ doc.location.href += '/' + ( doc.location.href.substr(-1) == '/' ? '' : '/' ); } );<?php } ?>
         <?php if( $m[logo][image][time] ){ ?> bind( byid('logo'), 'load', function(){ this.parentNode.parentNode.style.minWidth = this.offsetWidth + 'px';  } ); <?php } ?>
      </script>
   </body>
</html>