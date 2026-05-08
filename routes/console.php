<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('seed:april-may', function () {
    $this->comment('Starting April/May completed patient records seeding...');
    $this->call('db:seed', ['--class' => 'AprilMayMedicalRecordsSeeder']);
    $this->comment('Completed seeding April/May patient records.');
})->purpose('Seed April/May realistic completed patient records');
