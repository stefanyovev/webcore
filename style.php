

      body, body * {
         margin: 0; padding: 0; top: 0; left: 0; right: 0; bottom: 0;
         box-sizing: border-box;
         background-color: transparent;
         background-repeat: no-repeat;
         background-position: center center;
         text-decoration: none;
         user-select: none;
         border: none;
         outline: none;
         cursor: default;
         line-height: 1em;
         letter-spacing: -0.03em;
         font-family: "Helvetica Neue", "Segoe UI", "Roboto", Arial, sans-serif;
      }
      
      body * { cursor: inherit }
      a, button, input[type="submit"], input[type="reset"]  { cursor: pointer }
      input[type="text"], input[type="password"], textarea { cursor: text }

      a:hover, button:hover, input[type="submit"]:hover, input[type="reset"]:hover { text-decoration: underline; }
      h1, h2, h3 { font-weight: normal } h1 span, h2 span, h3 span { opacity: .5 }
      h1 { z-index: 0; margin-top: 0 } h1 > figure, h1 > nav { height: 100%; }
      textarea { padding: .5em }
      label, input, button { padding: .5em; height: 2em  }
      button, input[type="submit"], input[type="reset"] { padding: .5em 1em }
      
      form { padding-bottom: 1em }
      form div { margin: .15em 0 }
      form div > * { display: inline-block }
      form div label { width: 40%; height: 2em; padding: .5em 0; text-align: center; vertical-align: top }
      form div label span { display: block; float: right; width: 2em; height: 2em; text-align: center; }
      form div input[type="text"], form div input[type="password"], form div textarea { width: 60%; }
      form div textarea { resize: vertical }
      form div input[type="submit"], form div input[type="reset"] { font-size: xx-small }
      form div:last-child { text-align: right }
      form div:last-child * { margin-left: .5em }
      form.autosave {}
      
      a { color: blue }
      .paint0 { color: black; background-color: rgba( 230, 230, 230, .99 ); }
      .paint1 { color: black; background-color: rgba( 255, 255, 255, .99 ); }
      .paint2 { color: black; background-color: rgba( 64, 32, 0, .1 ) }
      .shadow0 { box-shadow: inset 0.025em 0.025em 0.25em 0 rgba(0,0,0,0.18), inset 0.01em 0.01em 0.01em 0 rgba(0,0,0,0.2); }
      .shadow1 { box-shadow:  0 0 .438em 0 rgba( 0, 0, 0, .16 ), 0 0 0 .063em rgba( 0, 0, 0, .08 ); }
      .shadow1:hover { box-shadow: .07em .07em .438em 0 rgba( 0, 0, 0, .15 ), 0 0 0 .063em rgba( 0, 0, 0, .08 ); }
      .rounded { border-radius: 0.2em; }

      /* windows */

      body { 
         position: fixed;
         perspective: 150vw;
         overflow: hidden;
      }

      body > * {
         position: absolute; margin: auto;
         overflow: hidden;
         transition: transform 250ms ease, opacity 500ms ease, box-shadow 250ms ease; 
      }

      .vertical > .godown {}
      .vertical > .goup {}

      .horizontal > div { height: 100% }
      .horizontal > .goright { z-index: -2; margin-right: 0; width: 5em; height: 5em }
      .horizontal > .goleft { z-index: -2; margin-left: 0; width: 5em; height: 5em }

      #console, #login, #control {
         width: 20em;
         padding: 2em; }
      #console {
         z-index: 0;
         height: 10em;
      }
      #login {
         z-index: -1;
         height: 10em;
      }
      #control { height: 41em; z-index: -2; background-color: transparent; background-attachment: fixed; background-image: linear-gradient(45deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0.7) 47%, rgba(255,2552,255,1) 51%, rgba(255,255,255,0.7) 100%); }

      .loading { background-image: url(data:image/gif;base64,R0lGODlhEAAQAMQAAORHHOVSKudfOulrSOp3WOyDZu6QdvCchPGolfO0o/XBs/fNwfjZ0frl3/zy7////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAkAABAALAAAAAAQABAAAAVVICSOZGlCQAosJ6mu7fiyZeKqNKToQGDsM8hBADgUXoGAiqhSvp5QAnQKGIgUhwFUYLCVDFCrKUE1lBavAViFIDlTImbKC5Gm2hB0SlBCBMQiB0UjIQA7); }
         .loading > * { opacity: .1 }
      .suspended { transform: translateZ( -50em ) rotateX( -22deg ); }
         .ready { transform: translateZ( -2em ) rotateX( -5deg ); }
         .ready:hover { transform: translateZ( 0 ) rotateX( 0 ); }
      .movable { cursor: move; -ms-touch-action: none; }
      .sizable { resize: both; }
      
