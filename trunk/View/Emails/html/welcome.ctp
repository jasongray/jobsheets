<p><?php echo __('Hey');?></p>
<p><?php echo __('It\'s great to see you\'re interested in using JobSheets. Your free trial is activated and you can start using JobSheets as soon as you are ready. Your trial period for 14 days will start from the first time you log in.');?></p>
<p><?php echo __('To get started simply visit');?> <?php echo $this->Html->link($this->Html->url(array('controller' => 'users', 'action' => 'login'), true), array('controller' => 'users', 'action' => 'login', 'full_base' => true), array('escape' => false));?> <?php echo __('and use the following details to login.');?></p>
<ul>
<li><strong><?php echo __('Username');?></strong>: <?php echo $user['email'];?></li>
<li><strong><?php echo __('Password');?></strong>: <?php echo $user['password'];?></li>
</ul>
<p><?php echo __('Once you have logged in we suggest you change your password for security purposes.');?></p>
<p><?php echo __('Thanks for choosing to use JobSheets. We hope we can help your business grow and manage its workload easier. If you have any questions please feel free to contact us.');?></p>
<p><?php echo __('We\'ll be in touch soon!');?></p>
<p><?php echo __('The JobSheets team');?></p>