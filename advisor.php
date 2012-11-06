<?php

$i=0;
foreach($_SESSION['adviseeNames'] as $key)
{

echo "<div>
<div>
<h1><a href='advisors_view.php?tN=$key&gN=".$_SESSION['advisees'][$i]."'>$key</a></h1>
</div>
</div>";

$i++;
}
echo '</div>';


?>

