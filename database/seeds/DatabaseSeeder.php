<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
    * usado para subir imagenes o archivos
    * relacionados con algun modelo.
    */
    protected $upload;

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->command->info("*** Empezando Migracion! ***");

        $this->truncateDb();

        // tablas secundarias
        $this->call(GenderTableSeeder::class);
        $this->call(NationalityTableSeeder::class);
        $this->call(StateTableSeeder::class);
        $this->call(TownTableSeeder::class);
        $this->call(ParishTableSeeder::class);
        $this->call(PeopleTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(SubCategoryTableSeeder::class);
        $this->call(MakerTableSeeder::class);
        $this->call(BankTableSeeder::class);
        $this->call(CardTypeTableSeeder::class);
        $this->call(PromoTypesTableSeeder::class);
        $this->call(QuantityTypeTableSeeder::class);

        // tablas primarias
        $this->call(ProviderTableSeed::class);
        $this->call(ProductTableSeeder::class);
        $this->call(BillingTableSeeder::class);
        $this->call(PurchaseTableSeeder::class);
        $this->call(VisitTableSeeder::class);
        $this->call(ProductProviderTableSeed::class);
        $this->call(PromotionTableSeeder::class);

        $this->command->info("*** Migracion terminada! ***");
    }

    protected function truncateDb()
    {
        $this->command->info("--- truncating! ---");

        // Truncate all tables, except migrations
        $tables = \DB::select('SHOW TABLES');

        $tablesInDb = "Tables_in_" . \Config::get('database.connections.mysql.database');

        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {
            switch ($table->$tablesInDb) {
                case 'migrations':
                case 'profiles':
                case 'users':
                    break;

                default:
                    \DB::table($table->Tables_in_orbiagro)->truncate();
                    break;
            }
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $this->command->info("--- truncate completado ---");
    }
}
