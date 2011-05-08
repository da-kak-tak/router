<?php

/**
 * Base project form.
 * 
 * @package    router
 * @subpackage form
 * @author     Your name here 
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class AddIdentityForm extends sfFormSymfony
{
  protected $types = array('по МАК адресу');
  

  public function configure()
  {
    $this->setWidgets(array(
      'name'        => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormInputText(),
      'type'        => new sfWidgetFormChoice(array(
        'choices' => $this->types,
        'expanded'
          => true,
      ))
    ));

    $this->setValidators(array(
      'name'        => new sfValidatorAnd(array(
        new sfValidatorRegex(array('pattern' => '/^[a-z0-9-]*$/')),
        new sfValidatorDoctrineUnique(array(
          'model'  => 'Identity',
          'column' => 'name'
        ))
      )),
      'description' => new sfValidatorString(array('required' => false)),
      'type'        => new sfValidatorChoice(array(
        'choices' => array_keys($this->types)))
    ));

    $this->setDefault('type', 0);

    $this->getWidgetSchema()->setNameFormat('form[%s]');
  }
}
