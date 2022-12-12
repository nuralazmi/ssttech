<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function list_page_required()
    {
        $response = $this->get($this->url() . '/?limit=' . $this->data()['limit']);
        $json = $response->json();
        $control = $this->ruleFailedControl($json['failed_parameters'], 'page', 'Required');
        $this->assertTrue($control);
    }

    /** @test */
    public function list_page_integer()
    {
        $response = $this->get($this->url() . '/?limit=' . $this->data()['limit'] . '&page=invalid_page');
        $json = $response->json();
        $control = $this->ruleFailedControl($json['failed_parameters'], 'page', 'Integer');
        $this->assertTrue($control);
    }

    /** @test */
    public function list_limit_required()
    {
        $response = $this->get($this->url() . '/?page=' . $this->data()['page']);
        $json = $response->json();
        $control = $this->ruleFailedControl($json['failed_parameters'], 'limit', 'Required');
        $this->assertTrue($control);
    }

    /** @test */
    public function list_limit_integer()
    {
        $response = $this->get($this->url() . '/?page=' . $this->data()['page'] . '&limit=invalid_limit');
        $json = $response->json();
        $control = $this->ruleFailedControl($json['failed_parameters'], 'limit', 'Integer');
        $this->assertTrue($control);
    }

    /** @test */
    public function contact_list_with_correct_parameters()
    {
        Company::factory()->count(20)->create();
        Contact::factory()->count(10)->create();

        $response = $this->get($this->url() . '/?page=' . $this->data()['page'] . '&limit='.$this->data()['limit'].'');
        $response->assertStatus(200);
    }

    private function url(): string
    {
        return '/api/contacts';
    }

    private function data(): array
    {
        return [
            'page' => 0,
            'limit' => 10,
        ];
    }
}
