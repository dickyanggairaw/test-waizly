<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;

class PostControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $page = 1;
        $limit = 5;
        $response = $this->get('/api/posts?page='. $page .'&limit=' . $limit);
        $response->assertStatus(200);
        // $response->assertJson([
        //     'message' => 'create data post',
        //     'success' => true,
        //     'data' => [
        //         'current_page' => $limit,
        //         'data' => [
        //             "image" => "smartphone",
        //             "title" => "smartphone",
        //             "content" => "smartphone"
        //         ],
        //         'page' => $page
        //     ]
        // ]);
    }

    public function test_store_data() {
        $data = [
            "image" => "smartphone",
            "title" => "smartphone",
            "content" => "smartphone"
        ];
        $response = $this->json('POST', '/api/posts', $data);
        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'create data post',
            'success' => true,
            'data' => [
                "image" => "smartphone",
                "title" => "smartphone",
                "content" => "smartphone"
            ]
        ]);
    }

    public function test_store_data_with_null_data() {
        $data = [
            "image" => "",
            "title" => "smartphone",
            "content" => "smartphone"
        ];
        $response = $this->json('POST', '/api/posts', $data);
        $response->assertStatus(500);
    }

    public function test_update_data() {
        $data = [
            "image" => "iphone.jpg",
            "title" => "iphone 12",
            "content" => "Bionic A14"
        ];
        $response = $this->json('PUT', '/api/posts/1', $data);
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'create data post',
            'success' => true,
            'data' => [
                "image" => "iphone.jpg",
                "title" => "iphone 12",
                "content" => "Bionic A14"
            ]
        ]);
    }

    public function test_update_data_with_null_data() {
        $data = [
            "image" => "",
            "title" => "iphone 12",
            "content" => "Bionic A14"
        ];
        $response = $this->json('PUT', '/api/posts/1', $data);
        $response->assertStatus(500);
    }

    public function test_show_data() {
        $response = $this->json('GET', '/api/posts/1');
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'success get data',
            'success' => true,
            'data' => [
                "image" => "iphone.jpg",
                "title" => "iphone 12",
                "content" => "Bionic A14"
            ]
        ]);
    }

    public function test_show_data_with_not_found() {
        $response = $this->json('GET', '/api/posts/1000');
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'success get data',
            'success' => true,
            'data' => null
        ]);
    }

    // public function test_destroy_data() {
    //     $posts = Post::latest()->paginate(1);
    //     $response = $this->delete('/api/posts/' . $posts[0]->id);
    //     $response->assertStatus(200);
    //     $response->assertJson([
    //         'message' => 'success delete data',
    //         'success' => true,
    //         'data' => null
    //     ]);
    // }
}
