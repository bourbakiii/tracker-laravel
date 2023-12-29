<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("INSERT INTO projects (name, description)
VALUES
('Проект 1', 'Описание проекта 1'),
    ('Проект 2', 'Описание проекта 2'),
    ('Проект 3', 'Описание проекта 3'),
    ('Проект 4', 'Описание проекта 4'),
    ('Проект 5', 'Описание проекта 5'),
    ('Проект 6', 'Описание проекта 6'),
    ('Проект 7', 'Описание проекта 7'),
    ('Проект 8', 'Описание проекта 8'),
    ('Проект 9', 'Описание проекта 9'),
    ('Проект 10', 'Описание проекта 10');");

    }
}
