<?php

namespace WooNinja\IntercomSaloon\Interfaces;

use WooNinja\IntercomSaloon\Connectors\IntercomConnector;

interface Intercom
{
    public function connector(): IntercomConnector;
}