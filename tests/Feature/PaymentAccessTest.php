<?php

use App\Models\Client;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('an agent can record a payment for a registered client', function () {
    $agent = User::factory()->agent()->create();
    $client = Client::factory()->create();

    $this->actingAs($agent)
        ->post(route('payments.store'), [
            'client_id' => $client->id,
            'invoice_number' => 'FAC-1001',
            'amount' => 125.50,
            'currency' => 'USD',
            'payment_method' => 'cash',
        ])
        ->assertRedirect(route('payments.index'));

    $this->assertDatabaseHas('payments', [
        'client_id' => $client->id,
        'agent_id' => $agent->id,
        'invoice_number' => 'FAC-1001',
        'payment_method' => 'cash',
    ]);
});

test('a client cannot open the payment creation form', function () {
    $clientUser = User::factory()->create();

    $this->actingAs($clientUser)
        ->get(route('payments.create'))
        ->assertForbidden();
});

test('a client only sees their own payment detail', function () {
    $clientUser = User::factory()->create();
    $client = Client::factory()->create(['user_id' => $clientUser->id]);
    $ownPayment = Payment::factory()->for($client)->create();
    $otherPayment = Payment::factory()->create();

    $this->actingAs($clientUser)
        ->get(route('payments.show', $ownPayment))
        ->assertSuccessful();

    $this->actingAs($clientUser)
        ->get(route('payments.show', $otherPayment))
        ->assertForbidden();
});
