<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');

        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(null, 'RestApi Personal Access Client', env('APP_URL'));

        DB::table('oauth_personal_access_clients')->insert(['client_id' => $client->id,]);
    }
}
