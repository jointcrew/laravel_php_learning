<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;
    /**
    * A basic feature test example.
    *
    * @return void 
    */
    public function testFetchBook()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/api/books');

        $response->assertStatus(200);
    }



    public function testCreateBook()
    {
        $response = $this->post('/api/books', [
            'title' => 'Laravel入門',
            'author' => 'Lara太郎',
            'description' => 'Laravel入門書です。'
        ]);
        $response->assertStatus(201);
    }
}
