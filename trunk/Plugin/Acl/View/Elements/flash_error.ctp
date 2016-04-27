<div class="notification failure">
    <p><strong>ACL: </strong>
    	<?php
if(is_array($message))
{
    echo $this->Html->nestedList($message);
}
else
{
    echo $message;
}
?></p>
</div>
