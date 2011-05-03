<?php

/**
 * Base project form.
 * 
 * @package    router
 * @subpackage form
 * @author     Your name here 
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class CFRuleForm extends sfFormSymfony
{
  public function configure()
  {
    $this->setWidgets(array(
      'profile_id' => new sfWidgetFormInputHidden(),
      'is_allowed' => new sfWidgetFormChoice(array('choices' => CFRule::getIsAllowedValues())),
      'type_id'    => new sfWidgetFormDoctrineChoice(array(
        'model'  => 'CFType',
        'method' => 'getName'
      )),
      'value'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'profile_id' => new sfValidatorChoice(array('choices' => array($this->getDefault('profile_id')))),
      'is_allowed' => new sfValidatorBoolean(),
      'type_id'    => new sfValidatorDoctrineChoice(array(
        'model'  => 'CFType',
        'column' => 'id',
      )),
      'value'      => new sfValidatorString(array(), array(
        'required' => 'Не указано правило'
      )),
    ));

    $this->getWidgetSchema()->setNameFormat('form[%s]');
  }
}
