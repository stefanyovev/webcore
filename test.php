

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

empty( p( Cfile ) ) -> True
len( p( Bdir ) ) -> 3
p( Bdir )[0] -> 'file'
p( Bdir )[1] -> 'content of Afile'

*/

$M =

[dir,
   [background, id => background],
   [dir, id => Adir],
   [dir, id => Bdir,
      [file, id => Afile, ctime => '2018', 'content of Afile'],
      [file, id => Bfile], // empty Bfile
      'text' ], // text node in Bdir
   [file, id => Cfile] ];


   function ui( & $x, $l=0 ){
      $p = str_repeat( ' ', 3 + $l*3 ) . '-->';
      $sol = ( $l ? $p : '      ' );
      $eol = ( $l ? '<!--' : '' ) . "\n";
      if( is_string( $x ) ) { echo $sol . $x . $eol; return; }
      $a = ''; foreach( $x as $k => $v ) if( $k && is_string( $k ) ) $a .= ' ' . $k . '="' . $v . '"';
      echo $sol . "<{$x[0]}$a";
      if( !isset( $x[1] ) ) echo " /><!--\n";
      else{ echo "><!--\n";
         for( $i=1; isset( $x[$i] ); $i++ ) ui( $x[$i], $l+1 );
         echo "$p</{$x[0]}>" . $eol; } }

   function & p( $x = '' ){ global $M; $p = & $M; if( $x ){
      foreach( explode( '/', $x ) as $id ){ $found = false;
         for( $i=1; isset( $p[$i] ); $i++ ) if( isset( $p[$i][id] ) && $p[$i][id] == $id )
            { $p = & $p[$i]; $found = true; break; }
         if( !$found ) return NULL; } }
      return $p; }

   function newid( $x ){ $y = 2; while( p( $x ) ) $x .= $y;
      return $x; }

   function valid( $data, $type ){ switch( $type ){      
      case id: return $data && is_string( $data ) && $data[0] != '-' && $data[0] != '_' &&
         !preg_match( '/\A[0-9\-_]+\z/', $data ) && preg_match( '/\A[a-z0-9\-_]+\z/', $data ); }
      return false; }

//var_dump( preg_match( '/\A[0-9_]\z/', 'asd' ) );

//foreach( ['a_66_hhh','66_ways','66-way','5','55','-55','-_','_-','asd','-rr-'] as $x ) echo ( valid( $x, id ) ? 'Y' : '-' ) . " '$x' \n";
//var_dump( newid( 'Bdir/Bfile' ) );
ui($M);
 ?>
