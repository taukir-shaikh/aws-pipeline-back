<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
 
class DumpUserSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('seeders/users.json');
 
        if (!File::exists($jsonPath)) {
            $this->command->error("❌ JSON file not found at: $jsonPath");
            return;
        }
 
        $data = json_decode(File::get($jsonPath), true);
 
        if (!$data) {
            $this->command->error("❌ Failed to decode JSON data.");
            return;
        }
 
        DB::table('users')->truncate(); // optional, clears existing users
 
        DB::table('users')->insert($data);
 
        $this->command->info("✅ Inserted " . count($data) . " users successfully!");
    }
}