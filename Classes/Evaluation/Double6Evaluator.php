<?php

namespace Clickstorm\GoMapsExt\Evaluation;

class Double6Evaluator
{
    public function returnFieldJS(): string
    {
        return 'return parseFloat(value).toFixed(6);';
    }

    public function evaluateFieldValue(string $value, string $is_in, bool &$set): string
    {
        return sprintf('%01.6f', $value);
    }
}
