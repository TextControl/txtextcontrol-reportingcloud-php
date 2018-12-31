<?php
declare(strict_types=1);

namespace TxTextControlTest\ReportingCloud\Filter\TestAsset;

use TxTextControl\ReportingCloud\Filter\AbstractFilter;

class ConcreteFilter extends AbstractFilter
{
    public function filter($value)
    {
        return '';
    }
}
