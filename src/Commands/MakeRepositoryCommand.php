<?php

namespace AmroBoney\RepositoryGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepositoryCommand extends Command
{

    protected $signature = 'make:repository {name}';

    protected $description = 'Create a new Interface, Eloquent Repository class, and Service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $this->createDirectories();
        $this->createBaseRepositoryInterface();
        $this->createBaseRepository();
        $this->createInterface($name);
        $this->createRepository($name);
        $this->createService($name);
        $this->bindInterfaceToRepository($name);
        $this->info("Repository for {$name} created and bound to interface successfully.");
    }

    protected function createDirectories()
    {
        File::ensureDirectoryExists(app_path('Repositories'));
        File::ensureDirectoryExists(app_path('Repositories/Interfaces'));
        File::ensureDirectoryExists(app_path('Repositories/Eloquent'));
    }

    protected function createBaseRepository()
    {
        $path = app_path('Repositories/Eloquent/BaseRepository.php');
        if (!File::exists($path)) {
            File::put($path, $this->getBaseRepositoryTemplate());
            $this->info("BaseRepository created successfully.");
        }
    }

    protected function createBaseRepositoryInterface()
    {
        $path = app_path('Repositories/Interfaces/BaseRepositoryInterface.php');
        if (!File::exists($path)) {
            File::put($path, $this->getBaseRepositoryInterfaceTemplate());
            $this->info("BaseRepositoryInterface created successfully.");
        }
    }

    protected function createInterface($name)
    {
        $path = app_path("Repositories/Interfaces/{$name}RepositoryInterface.php");
        File::ensureDirectoryExists(dirname($path));
        File::put($path, $this->getInterfaceTemplate($name));
    }

    protected function createRepository($name)
    {
        $path = app_path("Repositories/Eloquent/{$name}Repository.php");
        File::ensureDirectoryExists(dirname($path));
        File::put($path, $this->getRepositoryTemplate($name));
    }

    protected function createService($name)
    {
        $path = app_path("Services/{$name}Service.php");
        File::ensureDirectoryExists(dirname($path));
        File::put($path, $this->getServiceTemplate($name));
    }

    protected function bindInterfaceToRepository($name)
    {
        $providerPath = app_path('Providers/RepositoryServiceProvider.php');
        if (!File::exists($providerPath)) {
            $this->createServiceProvider();
        }

        $binding = "\$this->app->bind(\App\Repositories\Interfaces\\{$name}RepositoryInterface::class, \App\Repositories\Eloquent\\{$name}Repository::class);";
        $this->addBindingToServiceProvider($binding);
    }

    protected function createServiceProvider()
    {
        $providerPath = app_path('Providers/RepositoryServiceProvider.php');
        File::put($providerPath, $this->getServiceProviderTemplate());
        $this->info("RepositoryServiceProvider created successfully.");
    }

    protected function addBindingToServiceProvider($binding)
    {
        $providerPath = app_path('Providers/RepositoryServiceProvider.php');
        $content = File::get($providerPath);

        if (strpos($content, $binding) === false) {
            $content = str_replace(
                'public function register()
                {',
                "public function register()\n    {\n        {$binding}\n",
                $content
            );
            File::put($providerPath, $content);
            $this->info("Binding added to RepositoryServiceProvider.");
        }
    }


    protected function getBaseRepositoryInterfaceTemplate()
    {
        return <<<EOT
            <?php

            namespace App\Repositories\Interfaces;

            interface BaseRepositoryInterface
            {
                public function all();
                public function find(\$id);
                public function create(array \$attributes);
                public function update(\$id, array \$attributes);
                public function delete(\$id);
            }
            EOT;
    }


    protected function getBaseRepositoryTemplate()
    {
        return <<<EOT
<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\BaseRepositoryInterface;use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected \$model;

    public function __construct(Model \$model)
    {
        \$this->model = \$model;
    }

    public function all()
    {
        return \$this->model->all();
    }

    public function find(\$id)
    {
        return \$this->model->find(\$id);
    }

    public function create(array \$data)
    {
        return \$this->model->create(\$data);
    }

    public function update(\$id, array \$data)
    {
        \$record = \$this->model->find(\$id);
        if (\$record) {
            \$record->update(\$data);
            return \$record;
        }
        return null;
    }

    public function delete(\$id)
    {
        \$record = \$this->model->find(\$id);
        if (\$record) {
            return \$record->delete();
        }
        return false;
    }
}
EOT;
    }

    protected function getInterfaceTemplate($name)
    {
        return <<<EOT
        <?php

        namespace App\Repositories\Interfaces;

        use App\Repositories\Interfaces\BaseRepositoryInterface;

        interface {$name}RepositoryInterface extends BaseRepositoryInterface
        {

        }
        EOT;
    }

    protected function getRepositoryTemplate($name)
    {
        return <<<EOT
        <?php

        namespace App\Repositories\Eloquent;

        use App\Models\\{$name};
        use App\Repositories\Interfaces\\{$name}RepositoryInterface;
        use App\Repositories\Eloquent\BaseRepository;

        class {$name}Repository extends BaseRepository implements {$name}RepositoryInterface
        {
            public function __construct({$name} \$model)
            {
                parent::__construct(\$model);
            }


        }
        EOT;
    }

    protected function getServiceTemplate($name)
    {
        $lowercaseFirstName = lcfirst($name);

        return <<<EOT
        <?php

        namespace App\Services;

        use App\Repositories\Interfaces\\{$name}RepositoryInterface;

        class {$name}Service
        {
            public function __construct(protected {$name}RepositoryInterface \${$lowercaseFirstName}Repository){}


        }
        EOT;
    }


    protected function getServiceProviderTemplate()
    {
        return <<<EOT
        <?php

        namespace App\Providers;

        use Illuminate\Support\ServiceProvider;

        class RepositoryServiceProvider extends ServiceProvider
        {
            public function register()
            {
                // Bindings will be added here
            }

            public function boot()
            {
                //
            }
        }
        EOT;
    }

}
