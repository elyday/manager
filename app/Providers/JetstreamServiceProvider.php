<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\UpdateTeamName;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);

        $this->callAfterResolving(
            BladeCompiler::class,
            function () {
                Blade::component(
                    'components.custom.action-section',
                    'manager-action-section'
                );
            }
        );
    }

    /**
     * Configure the roles and permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['view']);

        Jetstream::role(
            'admin',
            'Administrator',
            [
                'create',
                'view',
                'update',
                'delete',
            ]
        )->description('Administratoren können alles.');

        Jetstream::role(
            'editor',
            'Editor',
            [
                'view',
                'create',
                'update',
            ]
        )->description(
            'Editor können Bankkonten und Kontostände sehen, neue Kontostände erfassen und neue Bankkonten erstellen.'
        );

        Jetstream::role(
            'viewer',
            'Viewer',
            [
                'view'
            ]
        )->description(
            'Viewer können nur Bankkonten und die Kontostände sehen. Sie können nichts bearbeiten oder löschen.'
        );
    }
}
