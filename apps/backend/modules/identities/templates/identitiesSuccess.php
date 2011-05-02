
<?php include_partial('global/content-header', array(
  'title' => 'Учетные записи'
)) ?>

<div id="listIdentities">
<?php if (!sizeof($identities)): ?>
Пока не добавлены
<?php else: ?>

<table class="data">
<thead>
  <tr>
    <th
      width="30%"
    >
      Имя и описание
    </th>
    <th
      width=""
    >
      Интернет
    </th>
  </tr>
</thead>
<tbody>
<?php foreach ($identities as $itemIdentity): ?>
  <tr class="item">
    <td>
      <a
        href="<?php echo url_for('@identity?id='.$itemIdentity['name']) ?>"
        style="color:black;"
      ><?php echo $itemIdentity['name'] ?></a>
      <?php if ($itemIdentity['description']): ?>
      <div style="margin-top:.25em;"><?php echo $itemIdentity['description'] ?></div>
      <?php endif; ?>
    </td>
    <td style="font-size:80%;">
      <?php if (!$itemIdentity['is_inet_allowed']): ?>
      <span style="color:grey;">
        отключен
      </span>
      <?php else: ?>
      <span style="color:green;"><?php echo $itemIdentity['InetChannel']['name'] ?></span>
      <?php endif; ?>
    </td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>

<?php endif; ?>
</div>