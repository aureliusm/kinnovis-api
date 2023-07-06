<?php

namespace App\Enums;

enum FilterType: string
{
    case FULLTEXT_SEARCH = 'fulltext-search';
    case MULTISELECT = 'multiselect';
}
