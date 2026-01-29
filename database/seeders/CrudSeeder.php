<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CrudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedCrudInputTypes();
        $this->seedCrudValidation();
    }

    private function seedCrudInputTypes(): void
    {
        DB::table('crud_input_types')->insert([
            [
                'type' => 'input',
                'has_relation' => 0,
                'custom_value' => 0,
            ],
            [
                'type' => 'textarea',
                'has_relation' => 0,
                'custom_value' => 0,
            ],
            [
                'type' => 'select',
                'has_relation' => 1,
                'custom_value' => 0,
            ],
            [
                'type' => 'editor_wysiwyg',
                'has_relation' => 0,
                'custom_value' => 0,
            ],
            [
                'type' => 'email',
                'has_relation' => 0,
                'custom_value' => 0,
            ],
            [
                'type' => 'file',
                'has_relation' => 0,
                'custom_value' => 0,
            ],
            [
                'type' => 'file_multiple',
                'has_relation' => 0,
                'custom_value' => 0,
            ],
            [
                'type' => 'datetime',
                'has_relation' => 0,
                'custom_value' => 0,
            ],
            [
                'type' => 'date',
                'has_relation' => 0,
                'custom_value' => 0,
            ],
            [
                'type' => 'number',
                'has_relation' => 0,
                'custom_value' => 0,
            ],
            [
                'type' => 'yes_no',
                'has_relation' => 0,
                'custom_value' => 0,
            ],
            [
                'type' => 'time',
                'has_relation' => 0,
                'custom_value' => 0,
            ],
            [
                'type' => 'select_multiple',
                'has_relation' => 1,
                'custom_value' => 0,
            ],
            [
                'type' => 'checkboxes',
                'has_relation' => 1,
                'custom_value' => 0,
            ],
            [
                'type' => 'true_false',
                'has_relation' => 0,
                'custom_value' => 0,
            ],
            [
                'type' => 'radio',
                'has_relation' => 1,
                'custom_value' => 0,
            ],
            [
                'type' => 'custom_radio',
                'has_relation' => 0,
                'custom_value' => 1,
            ],
            [
                'type' => 'custom_checkbox',
                'has_relation' => 0,
                'custom_value' => 1,
            ],
            [
                'type' => 'custom_select_multiple',
                'has_relation' => 0,
                'custom_value' => 1,
            ],
            [
                'type' => 'custom_select',
                'has_relation' => 0,
                'custom_value' => 1,
            ],
        ]);
    }

    private function seedCrudValidation(): void
    {
        DB::table('crud_input_validations')->insert([
            [
                'validation' => 'required',
                'is_input_able' => false,
                'input_group' => 'input, file, number, text, datetime, select, password, email, editor, date, yes_no, time, year, select_multiple, radio, checkboxes, true_false, address_map, custom_radio, custom_checkbox, custom_select_multiple, custom_select, file_multiple, textarea',
                'input_placeholder' => '',
                'input_validation' => '',

            ],
            [
                'validation' => 'max',
                'is_input_able' => true,
                'input_group' => 'input, file, file_multiple, number, text, select, password, email, editor, yes_no, time, year, select_multiple, radio, checkboxes, address_map',
                'input_placeholder' => '',
                'input_validation' => 'numeric',
            ],
            [
                'validation' => 'min',
                'is_input_able' => true,
                'input_group' => 'input, file, file_multiple, number, text, select, password, email, editor, time, year, select_multiple, address_map',
                'input_placeholder' => '',
                'input_validation' => 'numeric',

            ],
            [
                'validation' => 'email',
                'is_input_able' => false,
                'input_group' => 'input, email',
                'input_placeholder' => '',
                'input_validation' => '',

            ],
            [
                'validation' => 'decimal',
                'is_input_able' => false,
                'input_group' => 'input, number, text, select',
                'input_placeholder' => '',
                'input_validation' => '',

            ],
            [
                'validation' => 'mimes',
                'is_input_able' => true,
                'input_group' => 'file, file_multiple',
                'input_placeholder' => 'ex : jpg,png,..',
                'input_validation' => 'required',

            ],
            [
                'validation' => 'url',
                'is_input_able' => false,
                'input_group' => 'input, text',
                'input_placeholder' => '',
                'input_validation' => '',

            ],
            [
                'validation' => 'date',
                'is_input_able' => false,
                'input_group' => 'input, datetime, date, text',
                'input_placeholder' => '',
                'input_validation' => '',

            ],
            [
                'validation' => 'numeric',
                'is_input_able' => false,
                'input_group' => 'input, text, number',
                'input_placeholder' => '',
                'input_validation' => '',
            ],
            [
                'validation' => 'ip',
                'is_input_able' => false,
                'input_group' => 'input, text',
                'input_placeholder' => '',
                'input_validation' => '',
            ],
        ]);
    }
}
