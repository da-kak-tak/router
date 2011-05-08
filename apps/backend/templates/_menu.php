<?php if (sizeof($items)): ?>
<ul class="<?php if (isset($class)) echo $class ?>">
<?php foreach ($sf_data->getRaw('items') as $item): ?>
<li class="<?php if (url_is($item['route'])) echo 'selected' ?>">
<?php echo link_to($item['title'], $item['route']) ?>
<?php if (isset($item['items'])): ?>
<?php include_partial('global/menu', array('items' => $item['items'])) ?>
<?php endif; ?>
</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>