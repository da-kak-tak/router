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

    $config = sfFactoryConfigHandler::getConfiguration($this->configuration->getConfigPaths('config/app.yml'));

    /**
     *  dhcpd.conf
     */
    $dhcpd_config = '/www/router/tmp/dhcpd.conf';
    
    $q = Doctrine_Core::getTable('WorkPlace')
      ->createQuery('p')
      ->where('p.ip IS NOT NULL')
      ->andWhere('p.mac IS NOT NULL')
      ->orderBy('p.name');
    $items = $q->fetchArray();

    $hosts = array();
    foreach ($items as $itemHost)
    {
      $hosts []= sprintf(
        'host %s { hardware ethernet %s; fixed-address %s; }',
        $itemHost['name'], $itemHost['mac'], $itemHost['ip']
        );
    }

    file_put_contents(
      $dhcpd_config,
      str_replace(
        '#hosts',
        implode("\n", $hosts),
        file_get_contents('./data/config-templates/dhcpd.conf')
        )
      );

    
    /**
     *  ipf.rules & ipnat.rules
     */
    $ipf_config = '/www/router/tmp/ipf.rules';
    $ipnat_config = '/www/router/tmp/ipnat.rules';
    
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
          'rdr %s %s/32 port 80 -> 127.0.0.1 port 3128',
          $config['router']['local_iface'], $itemIdentity['ip']
          );
      }
      else
      {
        $ipfilter_rules []= sprintf(
          'pass in quick on %s to %s:%s from %s/32 to any keep state',
          $config['router']['local_iface'], $itemIdentity['InetChannel']['iface'], $itemIdentity['InetChannel']['gw'], $itemIdentity['ip']
          );
      }
    }

    file_put_contents(
      $ipf_config,
      str_replace(
        '#hosts',
        implode("\n", $ipfilter_rules),
        file_get_contents('./data/config-templates/ipf.rules')
        )
      );

    file_put_contents(
      $ipnat_config,
      str_replace(
        '#hosts-with-filtering',
        implode("\n", $ipnat_rules),
        file_get_contents('./data/config-templates/ipnat.rules')
      )
    );
    

    /**
     * squid
     */
    $squid_config = '/www/router/tmp/squid.config';
    $squid_lists_dir = '/www/router/tmp/lists';

    $acl = array();
    $http_access_list = array();

    $q = Doctrine_Core::getTable('CFProfile')
      ->createQuery('p')
      ->orderBy('p.name ASC');
    $profiles = $q->fetchArray();
    foreach ($profiles as $itemProfile)
    {
      // Клиенты
      $clients = array();
      $q = Doctrine_Core::getTable('WorkPlace')
        ->createQuery('p')
        ->where('p.profile_id = ?', $itemProfile['id']);

      $allClients = $q->fetchArray();
      foreach ($allClients as $itemClient)
      {
        $clients []= $itemClient['ip'];
      }
      $acl []= sprintf(
        'acl %s src "%s"',
        "$itemProfile[name_en]-clients", "$squid_lists_dir/$itemProfile[name_en]-clients"
        );
      file_put_contents("$squid_lists_dir/$itemProfile[name_en]-clients", implode("\n", $clients));

      // Список правил
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
          $acl []= sprintf(
            'acl %s %s "%s"',
            "$item", $type, "$squid_lists_dir/$item"
            );
          
          $http_access_list []= sprintf(
            'http_access %s %s %s',
            $access ? 'allow' : 'deny', "$itemProfile[name_en]-clients", "$item"
            );
        }
        file_put_contents("$squid_lists_dir/$item", implode("\n", $accessItems));
      }
      //
      $http_access_list []= sprintf(
        'http_access %s %s',
        $itemProfile['is_def_allowed'] ? 'allow' : 'deny',  "$itemProfile[name_en]-clients"
        );
    }

    $template = file_get_contents('./data/config-templates/squid.conf');
    $template = str_replace(
      '#acl',
      implode("\n", $acl),
      $template
      );
    $template = str_replace(
      '#http_access',
      implode("\n", $http_access_list),
      $template
      );
    file_put_contents($squid_config, $template);
  }
}
