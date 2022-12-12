<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function username_is_required()
    {
        $response = $this->post($this->url(), array_merge($this->userData(), ['username' => '']));
        $json = $response->json();
        $control = $this->ruleFailedControl($json['failed_parameters'], 'username', 'Required');
        $this->assertTrue($control);
    }

    /** @test */
    public function password_is_required()
    {
        $response = $this->post($this->url(), array_merge($this->userData(), ['password' => '']));
        $json = $response->json();
        $control = $this->ruleFailedControl($json['failed_parameters'], 'password', 'Required');
        $this->assertTrue($control);
    }

    /** @test */
    public function username_exists()
    {
        $response = $this->post($this->url(), array_merge($this->userData(), ['username' => 'invalid_username']));
        $json = $response->json();
        $control = $this->ruleFailedControl($json['failed_parameters'], 'username', 'Exists');
        $this->assertTrue($control);
    }

    /** @test */
    public function can_login_with_correct_parameters()
    {
        $this->addUser();
        $data = [
            'username' => 'nuralazmi',
            'password' => '123456',
        ];
        $response = $this->post($this->url(), $data);
        $response->assertStatus(200);
    }

    /** @test */
    public function cannot_login_with_incorrect_parameters()
    {
        $this->addUser();
        $data = [
            'username' => 'nuralazmi',
            'password' => '111',
        ];
        $response = $this->post($this->url(), $data);
        $response->assertStatus(400);
    }

    private function url(): string
    {
        return '/api/login';
    }
}
