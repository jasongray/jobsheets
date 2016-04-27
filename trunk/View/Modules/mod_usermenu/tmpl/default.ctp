<ul class="nav navbar-nav pull-right toolbar">
    <li class="dropdown">
        <?php $_name = $this->Session->read('Auth.User.firstname') . ' ' . $this->Session->read('Auth.User.lastname');?>
        <?php if( empty($this->Session->read('Auth.User.avatar')) ) { $_img = 'avatar-1.jpg'; } else { $_img = $this->Session->read('Auth.User.avatar'); } ?>
        <?php echo $this->Html->link('<span class="hidden-xs">'.$_name.' <i class="fa fa-caret-down"></i></span>'.$this->Resize->image($_img, 30, 30, false, array('alt' => '')), array('controller' => 'users', 'action' => 'profile'), array('class' => 'dropdown-toggle username', 'data-toggle' => 'dropdown', 'escape' => false));?>
        </a>
        <ul class="dropdown-menu userinfo arrow">
            <li class="username">
                <a href="#">
                    <div class="pull-left"><?php echo $this->Resize->image($_img, 30, 30, false, array('alt' => ''));?></div>
                    <div class="pull-right"><h5><?php echo __('Howdy');?>, <?php echo $this->Session->read('Auth.User.firstname');?></h5><small>Logged in as <span><?php echo $this->Session->read('Auth.User.Role.name');?></span></small></div>
                </a>
            </li>
            <li class="userlinks">
                <?php echo $this->Menu->create($m['menu_id'], array('class' => 'dropdown-menu'), 'ul', '');?>
            </li>
        </ul>
    </li>
</ul>