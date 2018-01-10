

      // con, win, doc, log, dpr, byid, bytag, is, each, make, bind
      
      con = console;      function log( x )  { con.log( x ); }
      win = window;       function dpr()     { return win.devicePixelRatio; }
      doc = win.document; function byid( x ) { return doc.getElementById( x ); }

      Object.prototype.byclass = function( x ){ return this.getElementsByClassName(x); }
      Object.prototype.bytag   = function( x ){ return this.getElementsByTagName(x); }
      
      function is( x, y ){ return x.classList.contains( y ); }
      function each( x, f ) { for( var i = 0, l = x.length; i < l; i++ ) f.call( x[i] ); }
      
      function make( x, y, z, u ){
         y = doc.createElement( y );
         if( x ) y.id = x;
         if( z ) y.className = z;
         if( u ) y.style.cssText += u;
         return y; }

      function bind( x, e, h ){
         return x.addEventListener( e, function( ev ){
            var initiator = ev.target, ex = ev.clientX, ey = ev.clientY;
            h.call( x, ex, ey, initiator ); })}


      // upload, imagecache, sizeimg, sizeimgs

      function upload( url, mime, name ){
         f = make( null, 'form', null, 'display: none' ); f.method = 'post'; f.action = url; f.enctype = 'multipart/form-data';
         ff = make( null, 'input' ); ff.type = 'file'; if( name ) ff.name = name; else { ff.name = 'files[]'; ff.multiple = true; } ff.accept = mime;
         f.appendChild( ff ); ff.onchange = function(){ f.submit(); }; body.appendChild( f );
         ff.click(); }

      function imagecache( i ){
         if( !i.hasAttribute( 'data-cache' ) ) return null;
         return i.getAttribute( 'data-cache' ) .split( ',' ) .map( function( x ){
            return x.split('x'); } ); }

      function sizeimg( i, upgrade ){
         var iw = parseFloat( i.getAttribute( 'data-width' ) ); 
         var ih = parseFloat( i.getAttribute( 'data-height' ) ); 
         var j = i.parentNode;
         var jw = j.offsetWidth * dpr();
         var jh = j.offsetHeight * dpr();
         var fat = jw/jh >= iw/ih ;
         var contain = is( i, 'contain' ); 
         var H = ( ( contain && fat ) || ( !contain && !fat ) );
         var q = ( H ? jh/ih : jw/iw );
         i.style.width = ( H ? 'auto' : '100%' );
         i.style.height = ( H ? '100%' : 'auto' );
         if( fat ) i.style.top = -Math.round( ( ih*q-jh )/2 ) + 'px';
         else i.style.left = -Math.round( ( iw*q-jw )/2 ) + 'px' ;
         if( q <= 1 ){ i.style.filter = 'none'; return; }
         i.style.filter = 'blur( ' + (q-1)*2 + 'px )';
         i.offsetHeight;
         var cache = imagecache( i );
         if( upgrade && cache && !i.hasAttribute( 'data-upgrade-width' ) && iw != cache[0][0] ){
            log( 'upgrade' );
            var n = cache.length-1;
            for( ; n> 0 && cache[n][ H ? 1 : 0 ] < ( H ? jh : jw ) ; n-- );
            i.setAttribute( 'data-upgrade-width', cache[n][0] );
            i.setAttribute( 'data-upgrade-height', cache[n][1] );
            i.style.transition = 'filter 1s';                     
            bind( i, 'load', function(){
               this.setAttribute( 'data-width', this.getAttribute( 'data-upgrade-width' ) );
               this.setAttribute( 'data-height', this.getAttribute( 'data-upgrade-height' ) );
               this.removeAttribute( 'data-upgrade-width' );
               this.removeAttribute( 'data-upgrade-height' );
               bind( this, 'transitionend', function(){
                  this.style.transition = 'none';
                  log( 'upgrade end' ); } );
               sizeimg( this, false ); } );
            var y = i.src.split('cache/'); y[1] = y[1].split('/')[1];
            i.src = y[0] + 'cache/' + n + '/' + y[1]; } }
      
      function sizeimgs( upgrading ){
         each( body.bytag( 'img' ), function(){
            if( is( this, 'cover' ) || is( this, 'contain' ) )
               sizeimg( this, upgrading ); } ); }


      // sizemenu, togglemenumenu

      function sizemenu(){
         var m = byid( 'menu' );
         if( m.children[1].children[1].children[0].offsetWidth >= m.children[1].children[1].offsetWidth )
            m.children[2].style.display = 'inline-block';
         else m.children[0].style.display = m.children[2].style.display = 'none'; }
         
      function togglemenumenu(){
         var m = byid( 'menu-menu' );
         m.style.display = ( m.style.display == 'inline-block' ? 'none' : 'inline-block' ); }


      // main      
      
      resizing = false;
      bind( win, 'resize', function(){
         if( !resizing ) log( 'resize' );
         else win.clearTimeout( resizing );
         resizing = win.setTimeout( function(){
            log( 'resize end' );
            resizing = false;
            sizeimgs( true ); }, 1000 );
         sizeimgs( false ); 
         sizemenu(); } );
         
         
