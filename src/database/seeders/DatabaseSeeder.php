<?php

namespace Database\Seeders;

use App\Models\{User, Company, Branch, Bank, Division, Employee, Client};
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // $user = \App\Models\User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@admin.com',
        // ]);

        // $user->assignRole('super_admin');

       
            Role::firstOrCreate(['name' => 'super_admin']);
            Role::firstOrCreate(['name' => 'sales']);
            Role::firstOrCreate(['name' => 'finance']);
            Role::firstOrCreate(['name' => 'client']);

        $roles = Role::pluck('id', 'name');

        $adminUser = User::firstOrCreate([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);
        $adminUser->assignRole('super_admin');

        $salesUser = User::firstOrCreate([
            'name' => 'Ini Sales',
            'email' => 'sales@admin.com',
            'password' => bcrypt('password'),
        ]);
        $salesUser->assignRole('sales');

        $financeUser = User::firstOrCreate([
            'name' => 'Ini Finance',
            'email' => 'finance@admin.com',
            'password' => bcrypt('password'),
        ]);
        $financeUser->assignRole('finance');

        $clientUser = User::firstOrCreate([
            'name' => 'Ini Client A',
            'email' => 'client@admin.com',
            'password' => bcrypt('password'),
        ]);
        $clientUser->assignRole('client');

        $clientUser = User::firstOrCreate([
            'name' => 'Ini Client B',
            'email' => 'client1@admin.com',
            'password' => bcrypt('password'),
        ]);
        $clientUser->assignRole('client');



        // Company
        $company = Company::firstOrCreate(['name' => 'PT LAPI Laboratories', 'logo' => '']);

        $bank = Bank::firstOrCreate(['company_id' => 1, 'name' => 'BCA', 'rekening' => '123456']);

        // Branch
        $branch = Branch::firstOrCreate([
            'company_id' => 1,
            'name' => 'Cabang',
            'location' => 'Jakarta'
        ]);

        // Divisions
        $salesDivision = Division::firstOrCreate([
            'company_id' => 1,
            'branch_id' => 1,
            'name' => 'Sales'
        ]);

        $financeDivision = Division::firstOrCreate([
            'company_id' => 1,
            'branch_id' => 1,
            'name' => 'Finance'
        ]);

        // Employees

        $salesEmployee = Employee::create([
            'user_id' => 2,
            'company_id' => 1,
            'branch_id' => 1,
            'division_id' => 1,
            'phone' => '08123456789'
        ]);

        $financeEmployee = Employee::create([
            'user_id' => 3,
            'company_id' => 1,
            'branch_id' => 1,
            'division_id' => 2,
            'phone' => '08123456789'
        ]);

         // Clients
         $clientA = Client::firstOrCreate([
            'user_id' => 4,
            'company_id' => 1,
            'branch_id' => 1,
            'division_id' => 1,
            'employee_id' => 1,
            'phone' => '081234567890',
        ]);

        $clientB = Client::firstOrCreate([
            'user_id' => 5,
            'company_id' => 1,
            'branch_id' => 1,
            'division_id' => 1,
            'employee_id' => 1,
            'phone' => '081234567890',
        ]);
    }
}
