<?php

/**
 * Base project form.
 * 
 * @package    router
 * @subpackage form
 * @author     Your name here 
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class WorkPlaceUpdateForm extends sfFormSymfony
{
  public function configure()
  {
    $this->setWidgets(array(
      'name'             => new sfWidgetFormInputText(),
      'description'      => new sfWidgetFormInputText(),
      'inet_channels_id' => new sfWidgetFormDoctrineChoice(array(
        'add_empty' => true,
        'model'     => 'InetChannel',
        'method'    => 'getName'
      )),
      'profile_id'       => new sfWidgetFormDoctrineChoice(array(
        'add_empty' => true,
        'model'     => 'CFProfile',
        'method'    => 'getName'
      )),
      'is_inet_allowed'  => new sfWidgetFormInputCheckbox(),
      'mac'              => new sfWidgetFormInputText(),
      'ip'               => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'name'             => new sfValidatorString(),
      'description'      => new sfValidatorString(array('required' => false)),
      'inet_channels_id' => new sfValidatorDoctrineChoice(array(
        'required' => false,
        'model'    => 'InetChannel',
        'column'   => 'id'
      )),
      'profile_id'       => new sfValidatorDoctrineChoice(array(
        'required' => false,
        'model'    => 'CFProfile',
        'column'   => 'id'
      )),
      'is_inet_allowed'  => new sfValidatorBoolean(),
      'mac'              => new sfValidatorRegex(array(
        'pattern' => '/^([0-9a-fA-F]{2}[:-]){5}[0-9a-fA-F]{2}$/i'
      )),
      'ip'               => new sfValidatorAnd(array(
        new sfValidatorInteger(array(
          'min' => 1,
          'max' => 210,
        ))
      )),
    ));


    $this->getWidgetSchema()->setNameFormat('form[%s]');
  }
}
