
<?php include_partial('global/content-header', array(
  'title' => 'Профили'
)) ?>

<style type="text/css">
  ul.object {
    margin-bottom:1em;
    }
</style>
<div style="margin-bottom:1.5em;">
<a
  href="<?php echo url_for('@add_cf_profile') ?>"
  style="
    position:relative;
    left:-1em;
    padding:.5em 1em;
    -webkit-border-radius:.75em;
    background:#e6f3ff;
  "
>Создание нового профиля</a>
</div>

<div id="listProfiles">
<?php if (!sizeof($profiles)): ?>
Профили для контент-фильтрации еще не добавлены
<?php else: ?>

<?php foreach ($profiles as $itemProfile): ?>
<ul class="object">
  <li class="">
    <a
      href="<?php echo url_for('@cf_profile?id='.$itemProfile['name_en']) ?>"
      style="color:black;"
    ><?php echo $itemProfile['name'] ?></a>
    <div style="margin-top:.5em; font-size:80%;">
      По умолчанию: 
      <?php echo $itemProfile['is_def_allowed'] ? 'все разрешено' : 'доступ к любым сайтам запрещен' ?>
    </div>
  </li>
</ul>
<?php endforeach; ?>

<?php endif; ?>
</div>