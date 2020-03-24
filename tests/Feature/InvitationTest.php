<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Tests\TestCase;
use function foo\func;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    function test_non_owners_may_not_invited_users()
    {
        $project = ProjectFactory::create();
        $user = factory(User::class)->create();

        $assertInvitationForbidden = function () use ($user, $project) {
            $this->actingAs($user)
                ->post($project->path() . '/invitations')
                ->assertStatus(403);
        };

        $assertInvitationForbidden();

        $project->invite($user);

        $assertInvitationForbidden();
    }

    function test_a_project_owner_can_invite_a_user()
    {
        $project = ProjectFactory::create();

        $userToInvite = factory(User::class)->create();

        $this->actingAs($project->owner)->post($project->path() . '/invitations', [
            'email' => $userToInvite->email
        ])
            ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    function test_the_email_address_must_be_associated_with_a_valid_birdboard_account()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
            'email' => 'notauser@example.com'
        ])->assertSessionHasErrors([
            'email' => 'The user you are inviting must be a BirdBoard account.'
            ], null, 'invitations');
    }

    function test_user_may_update_project_details()
    {
        $project = ProjectFactory::create();

        $project->invite($newUser = factory(User::class)->create());

        $this
            ->actingAs($newUser)
            ->post(action('ProjectTasksController@store', $project), $task = ['body' => 'foo task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
