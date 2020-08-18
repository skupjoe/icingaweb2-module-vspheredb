<?php

namespace Icinga\Module\Vspheredb\Web\Table;

use gipfl\IcingaWeb2\Table\ZfQueryBasedTable;
use Icinga\Module\Vspheredb\DbObject\HostSystem;
use Icinga\Module\Vspheredb\Format;
use ipl\Html\Html;

class HostPhysicalNicTable extends ZfQueryBasedTable
{
    protected $defaultAttributes = [
        'class' => 'common-table',
        'data-base-target' => '_next',
    ];

    /** @var HostSystem */
    protected $host;

    /** @var string */
    protected $moref;

    public function __construct(HostSystem $host)
    {
        $this->host = $host;
        $this->moref = $this->host->object()->get('moref');
        parent::__construct($host->getConnection());
    }

    public function getColumnsToBeRendered()
    {
        return [
            // TODO: no padding in th on our left!
            Html::tag('h2', [
                'class' => 'icon-sitemap',
                'style' => 'margin: 0;'
            ], $this->translate('Network')),
            ''
        ];
    }

    public function renderRow($row)
    {
        return $this::row([$this->formatSimple($row)]);
    }

    protected function formatSimple($row)
    {
        if ($row->link_speed_mb === null) {
            $speedInfo = $this->translate('Link is down');
        } else {
            $speedInfo = \sprintf(
                '%s %s',
                Format::linkSpeedMb($row->link_speed_mb),
                $row->link_duplex === 'y'
                    ? $this->translate('full duplex')
                    : $this->translate('half duplex')
            );
        }
        return Html::sprintf(
            '%s (%s: %s), %s, %s',
            Html::tag('strong', $row->device),
            $this->translate('driver'),
            $row->driver,
            $row->mac_address,
            $speedInfo
        );
    }

    public function prepareQuery()
    {
        $query = $this->db()->select()->from(
            ['hpn' => 'host_physical_nic'],
            [
                'hpn.nic_key',
                'hpn.auto_negotiate_supported',
                'hpn.device',
                'hpn.driver',
                'hpn.link_speed_mb',
                'hpn.link_duplex',
                'hpn.mac_address',
                'hpn.pci',
            ]
        )->where('hpn.host_uuid = ?', $this->host->get('uuid'))->order('hpn.device ASC');

        return $query;
    }
}
