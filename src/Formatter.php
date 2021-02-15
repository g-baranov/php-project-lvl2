<?php

namespace Differ\Render;

use function Funct\Strings\strip;

use const Differ\DiffGenerator\TYPE_ADD;
use const Differ\DiffGenerator\TYPE_EQUAL;
use const Differ\DiffGenerator\TYPE_REMOVE;

const TEMPLATE = '  %s %s: %s';

const SYMBOL_ADDED = '+';
const SYMBOL_REMOVED = '-';
const SYMBOL_EQUAL = ' ';



function render(array $diff, string $format): string
{
    $result = array_map(static fn(array $row): string => renderDiffRow($row), $diff);

    return "{\n" . implode("\n", $result) . "\n}";
}
function renderDiffRow(array $diffRow): string
{
    return sprintf(TEMPLATE, getSymbolByType($diffRow['type']), $diffRow['key'], prepareValue($diffRow['value']));
}

function getSymbolByType(string $type): string
{
    switch ($type) {
        case TYPE_ADD:
            return SYMBOL_ADDED;
        case TYPE_REMOVE:
            return SYMBOL_REMOVED;
        case TYPE_EQUAL:
            return SYMBOL_EQUAL;
        default:
            throw new \InvalidArgumentException("Type '$type' is not supports");
    }
}

function prepareValue($value): string
{
    if (is_array($value)) {
        //todo
    }
    return strip(json_encode($value), '"');
}