
<?php include_partial('header', array(
  'profile' => $profile,
)) ?>

<style type="text/css">
  .objects li {
    margin-bottom:.75em;
    }
</style>
<ul class="objects">
<?php foreach ($rules as $itemRule): ?>

<?php $classes = array() ?>
<?php if (!$itemRule['is_enabled']) $classes []= 'disabled' ?>
<li class="<?php echo implode(' ', $classes) ?>">
  <input id="<?php echo "r$itemRule[id]" ?>" type="checkbox"/>
  <a
    href="<?php echo url_for('@cf_rule?profile='.$profile->getNameEn().'&rule='.$itemRule['id']) ?>"
  ><?php echo $isAllowedValues[ $itemRule['is_allowed'] ] ?> <?php echo $itemRule['value'] ?></a>
  &nbsp;
  <span style="font-size:80%; color:#999;"><?php echo $itemRule['CFType']['name'] ?></span>
</li>

<?php endforeach; ?>
</ul>