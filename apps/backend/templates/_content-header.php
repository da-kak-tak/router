
<?php slot('content-header') ?>

<?php if (isset($navigation)): ?>
<?php include_partial('global/menu', array(
  'class' => 'navigation',
  'items' => $navigation
)) ?>
<?php endif; ?>

<?php if (isset($title)): ?>
<h1><?php echo $sf_data->getRaw('title') ?></h1>
<?php endif; ?>

<?php if (isset($menu)): ?>
<?php include_partial('global/menu', array(
  'class' => 'sub-menu',
  'items' => $menu
)) ?>
<?php endif; ?>

<?php end_slot() ?>