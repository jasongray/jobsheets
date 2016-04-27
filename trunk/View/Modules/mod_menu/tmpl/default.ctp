<?php $attr = array(); ?>
<?php $attr = !empty($m['idclass'])? array_merge(array('id' => $m['idclass']), $attr): $attr;?>
<?php $attr = !empty($m['class'])? array_merge(array('class' => $m['class']), $attr): $attr;?>
<?php if ($m['show_title']) { ?>
<?php $hdr = (!empty($m['header']))? $m['header']: 'h2';?>
<?php echo $this->Html->tag($hdr, $m['title'], $m['header_class']);?>
<?php } ?>
<?php $this->Menu->selected = $m['selected'];?>
<?php echo $this->Menu->create($m['menu_id'], $attr, 'ul', $m['dropclassul'], $m['dropclassli']);?>