<?php echo __('Hi there');?>

<?php echo __('A requested has been made to reset your password.');?>

<?php echo __('To reset your password follow this link');?> <?php echo $this->Html->link($this->Html->url(array('controller' => 'users', 'action' => 'reset', $user['User']['resetcode']), true), array('controller' => 'users', 'action' => 'reset', $user['User']['resetcode'], 'full_base' => true), array('escape' => false));?>

<?php echo __('If you did not request this change please ignore this email.');?>

<?php echo __('If you require any assistance please feel free to contact us.');?>

<?php echo __('The JobSheets team');?>