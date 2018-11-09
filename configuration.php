<?php

/** @var \Icinga\Application\Modules\Module $this */

$this->providePermission(
    'vspheredb/admin',
    $this->translate('Allow to configure vCenter connections')
);

$section = $this->menuSection(N_('Virtualization (VMware)'))
    ->setIcon('cloud')
    ->setUrl('vspheredb/vcenters')
    ->setPriority(70);
// $section->add(N_('VCenters'))
//     ->setUrl('vspheredb/vcenters')
//     ->setPriority(10);
$section->add(N_('Virtual Machines'))
    ->setUrl('vspheredb/vms')
    ->setPriority(20);
$section->add(N_('Hosts'))
    ->setUrl('vspheredb/hosts')
    ->setPriority(30);
$section->add(N_('Datastores'))
    ->setUrl('vspheredb/datastores')
    ->setPriority(40);
// $section->add(N_('Anomalies'))
//     ->setUrl('vspheredb/anomalies')
//     ->setPriority(45);
$section->add(N_('Event History'))
    ->setUrl('vspheredb/events/heatmap')
    ->setPriority(49);
$section->add(N_('Alarm History'))
    ->setUrl('vspheredb/alarms/heatmap')
    ->setPriority(49);
// $section->add(N_('Performance Counter'))
//     ->setUrl('vspheredb/configuration/counters')
//     ->setPriority(60);
// $section->add(N_('Top VMs'))
//     ->setUrl('vspheredb/top/vms')
//     ->setPriority(70);
