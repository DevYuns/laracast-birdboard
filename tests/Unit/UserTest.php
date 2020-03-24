<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Facades\Tests\Setup\ProjectFactory;
use App\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_has_projects()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    public function test_a_user_has_accessible_projects()
    {
        $dean = $this->signIn();

        ProjectFactory::ownedBy($dean)->create();

        $this->assertCount(1, $dean->accessibleProjects());

        $yun = factory(User::class)->create();
        $army = factory(User::class)->create();

        $project = tap(ProjectFactory::ownedBy($yun)->create())->invite($army);

        $this->assertCount(1, $dean->accessibleProjects());

        $project->invite($dean);

        $this->assertCount(2, $dean->accessibleProjects());

    }

}
