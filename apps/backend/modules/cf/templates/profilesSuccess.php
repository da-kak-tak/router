<?php use_helper('Text') ?>

<?php include_partial('global/content-header', array(
  'title' => 'Профили'
)) ?>

<style type="text/css">
  ul.object {
    margin-bottom:1.5em;
    }
</style>
<div style="margin-bottom:1.5em;">
<a
  href="<?php echo url_for('@add_cf_profile') ?>"
  style="
    position:relative;
    left:-.75em;
    padding:.35em .75em;
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
      href="<?php echo url_for('@cf_profile?id='.$itemProfile->getNameEn()) ?>"
      style="color:black;"
    ><?php echo $itemProfile->getName() ?></a>
    <div style="margin-top:.5em; font-size:80%;">
      По умолчанию: 
      <?php echo $itemProfile->getIsDefAllowed() ? 'все разрешено' : 'доступ к любым сайтам запрещен' ?>
    </div>
    <div style="margin-top:.5em; font-size:80%; color:#666;">
      <?php if (!sizeof($itemProfile->getCFRule())): ?>
        Правила не заданы.
      <?php else: ?>
        <?php echo different_end(sizeof($itemProfile->getCFRule()), array('правил', 'правило', 'правила')) ?>.
      <?php endif; ?>
      <?php if (sizeof($itemProfile->getIdentity())): ?>
        Указан для <?php echo different_end(sizeof($itemProfile->getIdentity()), array('пользователей', 'пользователя', 'пользователей')) ?>
      <?php endif; ?>
    </div>
  </li>
</ul>
<?php endforeach; ?>

<?php endif; ?>
</div>