<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Database\TruncateTable;
/**
 * Class DatabaseSeeder.
 */
class DatabaseSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->truncateMultiple(['sessions']);

        $this->call(AccessTableSeeder::class);
        $this->call(HistoryTypeTableSeeder::class);

        Model::reguard();
    }
}
