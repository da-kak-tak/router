<?php

class routerConfigsTask extends sfBaseTask
{
  protected function configure()
  {
    $this->namespace        = 'router';
    $this->name             = 'generate-all';
    $this->briefDescription = '';
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase('doctrine')->getConnection();

    //
    $q = Doctrine_Core::getTable('Identity')
      ->createQuery('i')
      ->leftJoin('i.InetChannel c')
      ->where('i.is_inet_allowed = true');
    $identities = $q->fetchArray();

    //
    $ipfilter_rules = array();
    $ipnat_rules = array();

    foreach ($identities as $itemIdentity)
    {
      switch ($itemIdentity['auth_type'])
      {
        default:
        {
          if (!$object = Doctrine_Core::getTable('WorkPlace')->find( $itemIdentity['id'] ))
          {
            continue;
          }
          $itemIdentity['ip'] = $object->getIP();
        }
      }

      if ($itemIdentity['profile_id'])
      {
        $ipnat_rules []= sprintf(
          'rdr eth0 %s/32 port 80 -> 127.0.0.1 port 3128',
          $itemIdentity['ip']
          );
      }
      else
      {
        $ipfilter_rules []= sprintf(
          'pass in quick on eth0 to %s:%s from %s/32 to any keep state',
          $itemIdentity['InetChannel']['iface'], $itemIdentity['InetChannel']['gw'], $itemIdentity['ip']
          );
      }
    }

    /**
     *
     */
    $acl_list = array();
    $http_access_list = array();

    $q = Doctrine_Core::getTable('CFProfile')
      ->createQuery('p')
      ->orderBy('p.name ASC');
    $profiles = $q->fetchArray();
    foreach ($profiles as $itemProfile)
    {
      /* Список правил */
      $rules = array();
      $q = Doctrine_Core::getTable('CFRule')
        ->createQuery('r')
        ->leftJoin('r.CFType t')
        ->where('r.profile_id = ?', $itemProfile['id'])
        ->orderBy('r.value');
      $allRules = $q->fetchArray();
      
      foreach ($allRules as $itemRule)
      {
        $rules[ $itemRule['CFType']['name'] ][ $itemRule['is_allowed'] ] []= $itemRule['value'];
      }

      foreach ($rules as $type => $typeItems)
      {
        foreach ($typeItems as $access => $accessItems)
        {
          $item = "$itemProfile[name_en]-$type-$access";
          $acl_list []= sprintf(
            'acl %s %s "%s"',
            "$item", $type, "/usr/local/etc/squid/lists/$item"
            );
          
          $http_access_list []= sprintf(
            'http_access %s %s %s',
            $access ? 'allow' : 'deny', "$itemProfile[name_en]-users", "$item"
            );
        }
      }
      //
      $http_access_list []= sprintf(
        'http_access %s %s',
        $itemProfile['is_def_allowed'] ? 'allow' : 'deny',  "$itemProfile[name_en]-users"
        );
    }

    print_r( $http_access_list );
  }
}
