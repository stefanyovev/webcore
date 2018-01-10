

      html{
         font-size: <?php echo val( 'font/size' ) ?>% }

      body {
         position: fixed;
         perspective: 150vw }

      body, body * {
         overflow: hidden;
         box-sizing: border-box; 
         margin: 0; padding: 0; 
         top: 0; left: 0; right: 0; bottom: 0;
         border: none; outline: none;
         cursor: default;                                /* -webkit-grab, -webkit-grabbing */
         user-select: none;
         text-align: center;
         text-decoration: none;
         font-size: 1em;
         line-height: 1em;
         letter-spacing: -0.01em;
         font-weight: normal;
         background-position: center center;
         background-size: cover;
         background-repeat: no-repeat;
         background-color: transparent }
      
      body * {
         display: inline-block;
         vertical-align: middle;
         position: relative;
         cursor: inherit;
         transform: translateZ(0) }
         
      /*------------------------------ ELEMENTS --- */
      
      a, button, input[type="submit"], input[type="reset"] {
         cursor: pointer !important;
         font: inherit; }

      input[type="text"], input[type="password"], textarea {
         cursor: text !important;
         font: inherit; }
      
      h1 { font-size: 2em }
      h2 { font-size: 1.5em }
      h3 { font-size: 1.25em }
      h4 { font-size: 1.125em }
      h5 { font-size: 1.0625em }
      h6 { font-size: 1.03125em }
      h7 { font-size: 1.015625em }
      
      script          { display: none }
      option          { display: block }
      table           { display: inline-table }
      tr              { display: table-row }
      thead           { display: table-header-group }
      tbody           { display: table-row-group }
      tfoot           { display: table-footer-group }
      col             { display: table-column }
      colgroup        { display: table-column-group }
      td, th          { display: table-cell }
      caption         { display: table-caption }
      td, th, tr      { vertical-align: inherit }
      textarea        { overflow-y: auto }

      /*------------------------------ modifiers */
      
      .left {
         text-align: left }
      .left > * {
         transform-origin: left }
         
      .right {
         text-align: right; }
      .right > * {
         transform-origin: right }
      
      .wide {
         width: 100% }
      .tall {
         height: 100% }
         
      .top {
         vertical-align: top;
         transform-origin: top }
         
      .bottom {
         vertical-align: bottom;
         transform-origin: bottom }
                     
      /*------------------------------------------------- layer --- */
      
      .layer {                       /* layer */
         position: absolute;
         pointer-events: none;
         white-space: nowrap }
         
      .layer > span {
         width: 0;
         height: 100% }
         
      .layer > div {                      /* rect */
         max-width: 100%;
         max-height: 100%;
         overflow-y: auto;
         pointer-events: all;
         white-space: normal }

      .layer > img{
         overflow: hidden }
      
      .layer > img.cover {
         max-width: none;
         max-height: none }
         
      .h.layer > div {
         overflow-y: hidden;
         overflow-x: scroll;
         white-space: nowrap; }

      .v.layer > div > div, .v.layer > div > a {
         display: block }

      /*---------------------------------------------------- .dir */
      
      .dir > div {
         padding: <?php echo val( 'shadows/size' ) ?>em }
      
      .dir > div > a {
         width: <?php echo val( 'items/width' ) ?>vw;
         height: <?php echo val( 'items/height' ) ?>vh;
         margin: <?php echo val( 'items/margin' ) ?>em;
         border-radius: <?php echo val( 'items/radius' ) ?>em;
         background-color: <?php echo color( val( 'menu/color' ), val( 'page/opacity' ) ) ?>; }

      .dir > div > a.file {
         background-color: <?php echo color( val( 'page/color' ), val( 'page/opacity' ) ) ?> }

      .dir > div > a:hover .second {
         background-color: rgba( 255,255,255,0.15 ); } 

         
<?php foreach( find( array( type => dir ) ) as $x ){ ?>

      #<?php echo str_replace( '/', '_', $x ) ?>.dir.layer > div > a {
         width: <?php echo val( "$x/items/width" ) ?>vw;
         height: <?php echo val( "$x/items/height" ) ?>vh;
         border-radius: <?php echo val( "$x/items/radius" ) ?>em } 

<?php } ?>


      /*---------------------------------------------------- .page */

      .page > div {
         padding: <?php echo val( 'shadows/size' ) ?>em }
         
      .page > div > div {
         padding: <?php echo val( 'page/padding' ) ?>em;
         border-radius: <?php echo val( 'page/radius' ) ?>em;
         background-color: <?php echo color( val( 'page/color' ), val( 'page/opacity' ) ) ?>; }
         
      /*---------------------------------------------------- menu */

      #menu * {
         overflow: hidden;
         white-space: nowrap; }

      #menu-menu {
         display: none;
         position: absolute;
         top: <?php echo val( 'logo/size' ) ?>em;
         left: 40%;
         bottom: auto;}
                     
      #menu-menu > a {
         padding: <?php echo val( 'logo/size' )/4 ?>em 0;
         display: block }

      #menu-button {
         display: none;
         cursor: pointer;
         position: absolute;
         height: <?php echo val( 'logo/size' ) ?>em;
         width: <?php echo val( 'logo/size' ) ?>em;
         left: auto }
         
      #menu-button > svg{
         height: 100% }

      #menu-button > svg{
         fill: <?php echo color( val( 'links_color' ) ) ?>;
         background-image: linear-gradient( to left, <?php echo color( val( 'menu/color' ), val( 'menu/opacity' ) ) ?> 50%, transparent ); }

      #menu-button > svg:hover {
         fill: <?php echo color( val( 'links_color' ), 1, 1.2 ) ?>;
         background-image: linear-gradient( to left, <?php echo color( val( 'menu/color' ), val( 'menu/opacity' ), 1.1 ) ?> 50%, transparent ) }

      #menu-left {
         width: <?php echo val( 'logo/leftspace' ) ?>%;
         min-width: <?php echo val( 'logo/size' ) ?>em; }

      #menu-left > a > img {
         height: <?php echo val( 'logo/size' ) ?>em;
         border-radius: <?php echo val( 'logo/radius' ) ?>em }
      
      #menu-right {
         width: <?php echo 100 -val( 'logo/leftspace' ) ?>% }

      #menu .sh {
         background-color: <?php echo color( val( 'menu/color' ), val( 'menu/opacity' ) ) ?> }

      #menu-right a:hover, #menu-menu a:hover {
         background-color: <?php echo color( val( 'menu/color' ), val( 'menu/opacity' ), 1.1 ) ?> }

      #menu-left, #menu-right {
         height: <?php echo val( 'logo/size' ) ?>em; }
      
      #menu-right > div {                        /* con */
         height: 100%;
         padding-right: <?php echo val( 'logo/size' ) ?>em; }

      #menu-right > div > a {
         line-height: <?php echo val( 'logo/size' ) ?>em;
         padding: 0 <?php echo val( 'logo/size' )/4 ?>em }


      /*---------------------------------------------------- social */

      #social * {
         overflow: hidden;
         white-space: nowrap; }

      #social > div {
         height: <?php echo val( 'logo/size' ) ?>em;
         padding-right: <?php echo val( 'logo/leftspace' ) ?>%;
         padding-left: <?php echo val( 'shadows/size' ) ?>em }
         
      #social > div > span {
         width: 0;
         height: 100% }

      #social > div > a {
         width: <?php echo val( 'logo/size' )*(3/5) ?>em;
         height: <?php echo val( 'logo/size' )*(3/5) ?>em;
         margin-right: <?php echo val( 'logo/size' )/5 ?>em;
         border-radius: <?php echo val( 'menu/radius' ) ?>em;
         background-color: <?php echo color( val( 'menu/color' ), val( 'menu/opacity' ) ) ?> }

      #social > div > a:hover {
         background-color: <?php echo color( val( 'menu/color' ), val( 'menu/opacity' ), 1.1 ) ?> }
         
      #social > div > a > svg {
         width: 100%;
         height: 100% }

      /*---------------------------------------------------- '/setup' */

      #__setup > div {
         padding: 0 0 <?php echo val( 'shadows/size' ) ?>em <?php echo val( 'shadows/size' ) ?>em }

      #__setup > div > div {
         padding: <?php echo val( 'menu/padding' ) ?>em;
         padding-top: <?php echo val( 'logo/size' )+val( 'menu/padding' ) ?>em;
         border-bottom-left-radius: <?php echo val( 'menu/radius' ) ?>em;
         background-color: <?php echo color( val( 'page/color' ), 1 ) ?> }

      /*---------------------------------------------------- '/upload' */

      #__upload > div {
         padding: 0 <?php echo val( 'shadows/size' ) ?>em <?php echo val( 'shadows/size' ) ?>em <?php echo val( 'shadows/size' ) ?>em }

      #__upload > div > div {
         padding: <?php echo val( 'menu/padding' ) ?>em;
         padding-top: <?php echo val( 'logo/size' )+val( 'menu/padding' ) ?>em;
         border-bottom-left-radius: <?php echo val( 'menu/radius' ) ?>em;
         border-bottom-right-radius: <?php echo val( 'menu/radius' ) ?>em;
         background-color: <?php echo color( val( 'page/color' ), 1 ) ?> }
         
      /*---------------------------------------------------- colors */
      
      body {
         color: <?php echo color( val( 'text_color' ) ) ?>;
         background-color: black;
          }   /* font-style: italic; */

      a, button, input[type="submit"], input[type="reset"] {
         color: <?php echo color( val( 'links_color' ) ) ?> }
         
      a:hover, button:hover, input[type="submit"]:hover, input[type="reset"]:hover {
         color: <?php echo color( val( 'links_color' ), 1, 1.2 ) ?> }

      input[type="text"], input[type="password"], select, textarea {
         box-shadow: inset 0 -0.3px <?php echo color( val( 'text_color' ) ) ?> }
         
      form :focus {
         box-shadow: inset 0 -1px <?php echo color( val( 'links_color' ), 1, 1.2 ) ?> }
      
      #background {
         background-color: <?php echo color( val( 'background/color' ), val( 'background/opacity' ) ) ?>; }

      .sh {
         box-shadow: 0 0 <?php echo val( 'shadows/size' ) ?>em -<?php echo val( 'shadows/size' )/5 ?>em <?php echo color( val( 'shadows/color' ), val( 'shadows/opacity' ) ) ?>; }
                  
