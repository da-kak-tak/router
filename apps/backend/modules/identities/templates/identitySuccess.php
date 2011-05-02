
<?php include_partial('global/content-header', array(
  'navigation' => array(
    array(
      'route' => '@identities',
      'title' => 'Учетки'
    )
  ),
  'title' => 'Рабочее место'
)) ?>

<form
  action="<?php echo url_for('@identity?id='.$identity->getName()) ?>"
  method="post"
>

<?php echo $form->renderGlobalErrors() ?>
<?php echo $form->renderHiddenFields() ?>

<?php $field = $form['name'] ?>
<dl class="form-row">
  <dt>Имя учетной записи</dt>
  <dd>
<?php echo $field->render() ?>
<?php echo $field->renderError() ?>
  </dd>
</dl>

<?php $field = $form['description'] ?>
<dl class="form-row">
  <dt>Описание</dt>
  <dd>
<?php echo $field->render(array('style' => 'width:100%')) ?>
<?php echo $field->renderError() ?>
  </dd>
</dl>

<?php $field = $form['inet_channels_id'] ?>
<dl class="form-row" style="margin-bottom:.5em;"">
  <dt>Интернет канал</dt>
  <dd>
<?php echo $field->render() ?>
<?php echo $field->renderError() ?>
  </dd>
</dl>

<?php $field = $form['is_inet_allowed'] ?>
<dl class="form-row">
  <dt></dt>
  <dd>
<?php echo $field->render() ?>&nbsp;<label for="form_is_inet_allowed" style="font-size:90%;">Разрешить доступ в интернет</label>
<?php echo $field->renderError() ?>
  </dd>
</dl>

<?php $field = $form['mac'] ?>
<dl class="form-row">
  <dt>МАК</dt>
  <dd>
<?php echo $field->render() ?>
<?php echo $field->renderError() ?>
  </dd>
</dl>

<?php $field = $form['ip'] ?>
<dl class="form-row">
  <dt>АйПи адрес</dt>
  <dd>
192.168.17.<?php echo $field->render(array('style' => 'width:3em;')) ?>
<?php echo $field->renderError() ?>
  </dd>
</dl>

<div class="submit">
  <button type="submit">Внести изменения</button>
</div>

</form>