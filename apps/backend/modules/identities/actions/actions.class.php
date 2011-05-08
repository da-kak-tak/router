<?php

/**
 * identities actions.
 *
 * @package    router
 * @subpackage identities
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class identitiesActions extends sfActions
{
  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex()
  {
    
  }

  /**
   *
   */
  public function executeIdentities()
  {
    $q = Doctrine_Core::getTable('Identity')
      ->createQuery('i')
      ->leftJoin('i.InetChannel c')
      ->leftJoin('i.CFProfile p')
      ->orderBy('i.name');
    $this->identities = $q->fetchArray();
  }

  /**
   *
   */
  public function executeAdd()
  {
    $this->form = new AddIdentityForm();

    if ($this->request->isMethod('POST'))
    {
      $this->form->bind( $this->request->getParameter('form') );
      if ($this->form->isValid())
      {
        switch ($this->form->getValue('type'))
        {
          default:
          {
            $identity = new WorkPlace();
          }
        }
        $identity->fromArray( $this->form->getValues() );
        $identity->save();

        $this->getUser()->setFlash('notice', '');
        $this->redirect('@identity?id='.$identity->getName());
      }
    }
  }

  /**
   *
   */
  public function executeIdentity()
  {
    $this->config = sfFactoryConfigHandler::getConfiguration( $this->getContext()->getConfiguration()->getConfigPaths('config/app.yml') );

    $this->forward404Unless(
      $identity = Doctrine_Core::getTable('Identity')->findOneByName(
        $this->request->getParameter('id')
        )
      );

    switch ($identity->getAuthType())
    {
      default:
      {
        $this->identity = Doctrine_Core::getTable('WorkPlace')->find( $identity->getId() );
      }
    }

    $this->form = new WorkPlaceUpdateForm( $this->identity->toArray() );
    if ($this->identity->getIP())
    {
      list( $o1, $o2, $o3, $o4 ) = explode('.', $this->identity->getIP());
      $this->form->setDefault('ip', $o4);
    }

    if ($this->request->isMethod('POST'))
    {
      $this->form->bind( $this->request->getParameter('form') );
      if ($this->form->isValid())
      {
        $this->identity->fromArray( $this->form->getValues() );

        $ip = $this->config['router']['local_network'].$this->form->getValue('ip');
        $this->identity->setIP($ip);

        if ($this->form->getValue('inet_channels_id') === null
          && $this->form->getValue('is_inet_allowed'))
        {
          $this->identity->setIsInetAllowed(false);
        }
        
        $this->identity->save();

        $this->getUser()->setFlash('notice', '');
        $this->redirect('@identity?id='.$this->identity->getName());
      }
    }
  }

}
