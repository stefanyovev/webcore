

<?php

/*

      <dir>    
         <background id="background" />    
         <dir id="Adir" />    
         <dir id="Bdir">    
            <file id="Afile" ctime="2018">    
               content of Afile    
            </file>    
            <file id="Bfile" />    
            text    
         </dir>    
         <file id="Cfile" />    
      </dir>

background
Adir
Bdir
Bdir/Afile
Bdir/Afile.ctime
Bdir/Bfile
Cfile

len( p( Bdir ) ) -> 3
p( Bdir )[0] -> 'file'
p( Bdir )[1] -> 'content of Afile'

*/

$M =

[dir,
   [background, id => background],
   [dir, id => Adir],
   [dir, id => Bdir,
      [file, id => Bfile, ctime => '2018', 'content of Afile'],
      [file, id => Bfile2],
      'text' ],
   [file, id => Cfile] ];


   function xml( & $x, $l=0 ){
      $p = str_repeat( ' ', 3 + $l*3 ) . '-->';
      $sol = ( $l ? $p : '      ' );
      $eol = ( $l ? '<!--' : '' ) . "\n";
      if( is_string( $x ) ) { echo $sol . $x . $eol; return; }
      $a = ''; foreach( $x as $k => $v ) if( $k && is_string( $k ) ) $a .= ' ' . $k . '="' . $v . '"';
      echo $sol . "<{$x[0]}$a";
      if( !isset( $x[1] ) ) echo " /><!--\n";
      else{ echo "><!--\n";
         for( $i=1; isset( $x[$i] ); $i++ ) xml( $x[$i], $l+1 );
         echo "$p</{$x[0]}>" . $eol; } }

   function & p( $x = '' ){ global $M; $p = & $M; if( $x ){
      foreach( explode( '/', $x ) as $id ){ $found = false;
         for( $i=1; isset( $p[$i] ); $i++ ) if( isset( $p[$i][id] ) && $p[$i][id] == $id )
            { $p = & $p[$i]; $found = true; break; }
         if( !$found ) return NULL; } }
      return $p; }

   function newid( $x ){ $n = 1; $r = $x; while( p( $r ) ) $r = $x . ++$n;
      return $r; }

   function valid( $data, $type ){ switch( $type ){      
      case id: return $data && is_string( $data ) && $data[0] != '-' && $data[0] != '_' &&
         !preg_match( '/\A[0-9\-_]+\z/', $data ) && preg_match( '/\A[a-z0-9\-_]+\z/', $data ); }
      return false; }


   p( Bdir )[] = [tag, 'text'];

   xml($M);

 ?>
