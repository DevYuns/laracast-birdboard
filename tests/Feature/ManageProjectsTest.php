<?php

namespace Tests\Feature;

use App\Project;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_a_user_can_create_a_project()
    {
        $this->SignIn(); // $this->actingAs(factory('App\User')->create()); 중복되는 것은 TestCase 부모클래스에 추가해서 사용함(protected)

        $this->get('projects/create')->assertStatus(200);

        $this->followingRedirects()
            ->post('/projects', $attributes = factory(Project::class)->raw())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    function test_tasks_can_be_included_as_part_a_new_project_creation()
    {
        $this->signIn();

        $attributes = factory(Project::class)->raw();

        $attributes['tasks'] = [
            ['body' => 'task 1'],
            ['body' => 'task 1']
        ];

        $this->post('/projects', $attributes);

        $this->assertCount(2, Project::first()->tasks);

    }

    public function test_a_user_can_see_all_projects_they_have_been_invited_to_on_their_dashboard()
    {
        $project = tap(ProjectFactory::create())->invite($this->signIn());

        $this->get('/projects')->assertSee($project->title);
    }

    public function test_guests_cannot_manage_project()
    {
        $project = factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get('/projects/edit')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }

    public function test_unauthorized_users_cannot_delete_projects()
    {
        $project = ProjectFactory::create();

        $this->delete($project->path())
            ->assertRedirect('/login');

        $user= $this->signIn();

        $this->delete($project->path())->assertStatus(403);

        $project->invite($user);

        $this->actingAs($user)->delete($project->path())->assertStatus(403);
    }

    public function test_a_user_can_delete_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    function test_a_user_can_update_a_project ()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = [
                'title' => 'changed',
                'description' => 'changed',
                'notes' => 'changed'
            ])
            ->assertRedirect($project->path());

        $this->get($project->path() . '/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes);

    }

    public function test_a_user_update_a_projects_general_notes()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = ['notes' => 'changed']);

        $this->assertDatabaseHas('projects', $attributes);

    }

    public function test_a_user_can_view_their_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    public function test_an_authenticated_user_cannot_view_the_project_of_others()
    {
        $this->SignIn();

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);

    }

    public function test_an_authenticated_user_cannot_update_the_project_of_others()
    {
        $this->withoutMiddleware();

        $this->SignIn();

        $project = factory('App\Project')->create();

        $this->patch($project->path(), [])->assertStatus(403);

    }

    public function test_a_project_requires_a_title()
    {
        $this->SignIn();

        $attributes = factory('App\Project')->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_a_description()
    {
        $this->SignIn();
//        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
