<?php

namespace Tests\Feature\Admin;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HeroImageSettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_superadmin_can_upload_hero_image(): void
    {
        Storage::fake('public');

        $response = $this
            ->actingAs($this->createSuperAdmin())
            ->put('/admin/settings', [
                'group_name' => 'AMT Group',
                'group_hero_image' => UploadedFile::fake()->image('warehouse.jpg', 1600, 1200),
            ]);

        $response->assertRedirect('/admin/settings');

        $storedPath = Setting::get('group_hero_image');
        $this->assertNotNull($storedPath);
        Storage::disk('public')->assertExists($storedPath);
    }

    public function test_uploading_a_new_hero_image_deletes_the_old_one(): void
    {
        Storage::fake('public');
        $superAdmin = $this->createSuperAdmin();

        $this->actingAs($superAdmin)->put('/admin/settings', [
            'group_name' => 'AMT Group',
            'group_hero_image' => UploadedFile::fake()->image('first.jpg'),
        ]);
        $firstPath = Setting::get('group_hero_image');

        $this->actingAs($superAdmin)->put('/admin/settings', [
            'group_name' => 'AMT Group',
            'group_hero_image' => UploadedFile::fake()->image('second.jpg'),
        ]);

        Storage::disk('public')->assertMissing($firstPath);
        Storage::disk('public')->assertExists(Setting::get('group_hero_image'));
    }

    public function test_hero_image_must_be_an_image(): void
    {
        Storage::fake('public');

        $response = $this
            ->actingAs($this->createSuperAdmin())
            ->put('/admin/settings', [
                'group_name' => 'AMT Group',
                'group_hero_image' => UploadedFile::fake()->create('notes.pdf', 100, 'application/pdf'),
            ]);

        $response->assertSessionHasErrors('group_hero_image');
        $this->assertNull(Setting::get('group_hero_image'));
    }

    private function createSuperAdmin(): User
    {
        $user = User::factory()->create();
        // `role` is deliberately not mass-assignable, so it has to be set directly.
        $user->role = 'superadmin';
        $user->save();

        return $user;
    }
}
