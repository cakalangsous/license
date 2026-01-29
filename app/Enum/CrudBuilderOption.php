<?php

namespace App\Enum;

enum CrudBuilderOption: string
{
    case GENERATE_CRUD = 'generate_crud';
    case GENERATE_API = 'generate_api';
    case GENERATE_CRUD_API = 'generate_crud_api';
}
