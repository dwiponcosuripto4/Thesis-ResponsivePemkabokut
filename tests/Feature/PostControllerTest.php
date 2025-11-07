<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test dapat membuat post baru
     */
    public function test_dapat_membuat_post_baru()
    {
        // Buat category untuk relasi
        $category = Category::factory()->create();

        $postData = [
            'title' => 'Test Post Title',
            'description' => 'Test Post Description',
            'category_id' => $category->id,
            'published_at' => now(),
        ];

        // Simpan post ke database
        $post = Post::create($postData);

        // Cek apakah data tersimpan di database
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post Title',
            'description' => 'Test Post Description',
        ]);

        // Cek apakah post berhasil dibuat
        $this->assertNotNull($post);
        $this->assertEquals('Test Post Title', $post->title);
    }

    /**
     * Test dapat membaca post dari database
     */
    public function test_dapat_membaca_post_dari_database()
    {
        // Buat post menggunakan factory
        $post = Post::factory()->create([
            'title' => 'Test Read Post'
        ]);

        // Cari post dari database
        $foundPost = Post::find($post->id);

        // Cek apakah post ditemukan
        $this->assertNotNull($foundPost);
        $this->assertEquals('Test Read Post', $foundPost->title);
    }

    /**
     * Test dapat mengupdate post
     */
    public function test_dapat_mengupdate_post()
    {
        $post = Post::factory()->create();

        $updateData = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ];

        // Update post
        $post->update($updateData);

        // Cek apakah data terupdate di database
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
        ]);
    }

    /**
     * Test dapat menghapus post
     */
    public function test_dapat_menghapus_post()
    {
        $post = Post::factory()->create();
        $postId = $post->id;

        // Hapus post
        $post->delete();

        // Cek apakah post terhapus dari database
        $this->assertDatabaseMissing('posts', [
            'id' => $postId,
        ]);
    }

    /**
     * Test relasi post dengan category
     */
    public function test_relasi_post_dengan_category()
    {
        $category = Category::factory()->create(['title' => 'Test Category']);
        $post = Post::factory()->create(['category_id' => $category->id]);

        // Cek relasi
        $this->assertEquals('Test Category', $post->category->title);
    }
}
