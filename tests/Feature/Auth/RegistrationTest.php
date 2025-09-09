<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(404); // Registration not available
});
