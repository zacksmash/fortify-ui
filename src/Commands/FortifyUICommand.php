<?php

namespace Zacksmash\FortifyUI\Commands;

use Illuminate\Console\Command;

class FortifyUICommand extends Command
{
    public $signature = 'fortify-ui';

    public $description = 'Setup Fortify UI routes and other junk';

    public function handle()
    {
        file_put_contents(
            base_path('routes/web.php'),
            "\nRoute::view('home', 'home')\n\t->name('home')\n\t->middleware(['auth', 'verified']);\n",
            FILE_APPEND
        );

        $this->comment('FortifyUI is now setup!');
    }
}
