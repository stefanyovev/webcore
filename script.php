
   function log(x){console.log(x)}

   win = window;
   doc = win.document;
   
   zmax = 0;
   
   drag_target = drag_dx = drag_dy = drag_target_w = drag_target_h = null;

   function each( a, f ) { for( var i = 0, l = a.length; i < l; i++ ) f.call( a[i] ); }
   
   function is( x, y ){ return x.classList.contains( y ) }
   function set( x, y ){ x.classList.add( y ) }
   function unset( x, y ){ x.classList.remove( y ) }
   
   function one( x ){ return doc.querySelector( x ) }
   function all( x ){ return doc.querySelectorAll( x ) }

   function make( x, y, z, u ){
      y = doc.createElement( y );
      if( x ) y.id = x;
      if( z ) y.className = z;
      if( u ) y.style.cssText += u;
      return y; }

   function on( o, e, f ){
      return o.addEventListener( e,
         function( ev ){
            var target = ev.target;
            var you = o, x = ev.clientX, y = ev.clientY;
            f.call( you, target, x, y );
         }) }

   function enter( o, x, y ){
      if( this.style.zIndex != zmax )
         this.style.zIndex = ++zmax;
   }
   
   function down( o, x, y ){
      if( is( this, 'movable' ) && o == this || o.parentNode == this ){
         var rect = this.getBoundingClientRect();
         if( !( rect.bottom - y < 20 && rect.right - x < 20 ) ) {
            drag_target = this;
            drag_dx = x - rect.left;
            drag_dy = y - rect.top;
         }
      }
   }
   
   function move( o, x, y ){
      if( drag_target ){
         drag_target.style.cssText += 'background-position: ' + (((y-drag_dy)/win.innerHeight)*100)+'% '+(((x-drag_dx)/win.innerWidth)*100)+'%;' +
            'margin: ' + (((y-drag_dy)/win.innerHeight)*100)+'vh 0 0 '+(((x-drag_dx)/win.innerWidth)*100)+'vw;'
            + 'transform-origin: ' + (((x-drag_dx)/win.innerWidth)*100) + '% '+ (((y-drag_dy)/win.innerHeight)*100) +'% 0;';
      }
   }
   
   function up( o, x, y ){
      drag_target = null;
   }

   function call( x, data, callback ){
      r = win.XMLHttpRequest ? ( new XMLHttpRequest() ) : ( new ActiveXObject( 'Microsoft.XMLHTTP' ) );
      if( callback ) r.onload = function(){ callback( r.responseText ) };
      r.open( data ? 'POST' : 'GET', '/' + x?x:'', true );
      r.setRequestHeader( 'Accept', 'text/plain' );
      r.send( data ); // timeout ?
      return r; }

   function run( x ){
      var test = one( '#' + x );
      if( test ) enter( test );
      else{
         var div = make( x, 'div',
         'loading suspended movable sizable vslide rounded paint1 shadow1', 'z-Index:'+ ++zmax );
         on( div, 'mouseenter', enter );
         on( div, 'mousedown', down );
         on( div, 'mouseup', up );
         body.appendChild( div );
         div.offsetHeight;
         unset( div, 'suspended' );
         set( div, 'ready'  );
         call( x, null, function( resp ){
            div.insertAdjacentHTML( 'beforeend', resp );
            unset( div, 'loading' );
         });
      }
   }


   on( win, 'load', function(){ body = doc.body; forms = doc.forms;

      unset( body, 'loading' );
            
      each( all( '.suspended' ), function(){
         unset( this, 'suspended' );
         set( this, 'ready'  );
      } );
      
      each( all( '.movable' ), function(){ 
         on( this, 'mouseenter', enter );
         on( this, 'mousedown', down );
         on( this, 'mouseup', up );
      });

      each( all( '.autosave' ), function(){
         
      });

      on( body, 'mousemove', move );

      on( body, 'dblclick', function( o, x, y ){
         if( o == this )
            run( 'login' );
         else
            log( 'body got double click yeah. maybe do d ripple?!' );
      });
      
      
      
   });
