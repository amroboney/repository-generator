<?php

namespace AmroBoney\RepositoryGenerator;

use Illuminate\Support\ServiceProvider;
use AmroBoney\RepositoryGenerator\Commands\MakeRepositoryCommand;

class RepositoryGeneratorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            MakeRepositoryCommand::class,
        ]);
    }

    public function boot()
    {
        //
    }
}
