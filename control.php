<?php

   if( $data ){
      foreach( $data as $x => $y )
         conf( $x, $y );
      if( $short )
         exit;
   }


?>

   <h1>website<?php if( $conf[pass] ) echo '<a href="/logout">logout</a>'; ?></h1>

   <form action="/control" method="post">
      <div class="rounded shadow0"><label for="name">name<span>·</span></label><input tabindex="1" type="text" name="name" placeholder="name" value="<?php echo htmlentities( $conf[name], ENT_QUOTES, 'UTF-8' ) ?>" ></div>
      <div><input class="rounded paint2 shadow1" type="reset" value="Undo" ><input class="rounded paint2 shadow1" type="submit" value="Save" ></div>
   </form>

   <form action="/control" method="post">
      <div class="rounded shadow0"><label for="pass">pass<span>·</span></label><input tabindex="2" type="password" name="pass" placeholder="pass" onfocus="this.type='text'" onblur="this.type='password'" value="<?php echo htmlentities( $conf[pass], ENT_QUOTES, 'UTF-8' ) ?>" ></div>
      <div><input class="rounded paint2 shadow1" type="reset" value="Undo" ><input class="rounded paint2 shadow1" type="submit" value="Save" ></div>
   </form>

   <h2>html</h2>

   <form action="/control" method="post">   
      <div class="rounded shadow0"><label for="lang">lang<span>·</span></label><input tabindex="3" type="text" name="lang" placeholder="lang" value="<?php echo $conf[lang] ?>" ></div>
      <div><input class="rounded paint2 shadow1" type="reset" value="Undo" ><input class="rounded paint2 shadow1" type="submit" value="Save" ></div>
   </form>

   <h2>database <span><?php echo $db ? 'ok' : 'invalid' ?></span></h2>

   <form name="db" action="/control" method="post" enctype="multipart/form-data">      
      <div class="rounded shadow0"><label for="db_host">host<span>·</span></label><input tabindex="4" type="text" name="db_host" placeholder="HOST" value="<?php echo htmlentities( $conf[db_host], ENT_QUOTES, 'UTF-8' ) ?>"></div>
      <div class="rounded shadow0"><label for="db_user">user<span>·</span></label><input tabindex="5" type="text" name="db_user" placeholder="USER" value="<?php echo htmlentities( $conf[db_user], ENT_QUOTES, 'UTF-8' ) ?>"></div>
      <div class="rounded shadow0"><label for="db_pass">pass<span>·</span></label><input tabindex="6" type="text" name="db_pass" placeholder="PASS" value="<?php echo htmlentities( $conf[db_pass], ENT_QUOTES, 'UTF-8' ) ?>"></div>
      <div><input class="rounded paint2 shadow1" type="reset" value="Undo" ><input class="rounded paint2 shadow1" type="submit" value="Save" ></div>
   </form>

   <h2>Some</h2>
   <form action="/control" method="post">
      <div class="rounded shadow0"><label for="some111">some111<span>·</span></label><input tabindex="1" type="text" some111="some111" placeholder="some111" value="<?php echo htmlentities( $conf[some111], ENT_QUOTES, 'UTF-8' ) ?>" ></div>
      <div class="rounded shadow0"><label for="some">some<span>·</span></label><textarea tabindex="7" name="some" placeholder="some" value="<?php echo $conf[some] ?>" ></textarea></div>
      <div><input class="rounded paint2 shadow1" type="reset" value="Undo" ><input class="rounded paint2 shadow1" type="submit" value="Save" ></div>
   </form>
   