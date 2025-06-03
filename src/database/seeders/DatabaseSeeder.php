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
            'name' => 'Sales A',
            'email' => 'sales@admin.com',
            'password' => bcrypt('password'),
        ]);
        $salesUser->assignRole('sales');

        $financeUser = User::firstOrCreate([
            'name' => 'Finance A',
            'email' => 'finance@admin.com',
            'password' => bcrypt('password'),
        ]);
        $financeUser->assignRole('finance');

        $clientUser = User::firstOrCreate([
            'name' => 'Client A',
            'email' => 'client@admin.com',
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
            'branch_id' => 1,
            'name' => 'Sales'
        ]);

        $financeDivision = Division::firstOrCreate([
            'branch_id' => 1,
            'name' => 'Finance'
        ]);

        // Employees

        $salesEmployee = Employee::create([
            'user_id' => $salesUser->id,
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'division_id' => $salesDivision->id,
            'phone' => '08123456789'
        ]);

        $financeEmployee = Employee::create([
            'user_id' => $financeUser->id,
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'division_id' => $financeDivision->id,
            'phone' => '08123456789'
        ]);

         // Clients
         Client::firstOrCreate([
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'division_id' => $salesDivision->id,
            'employee_id' => $salesEmployee->id,
            'name' => 'Client A',
            'phone' => '081234567890',
        ]);

        Client::firstOrCreate([
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'division_id' => $salesDivision->id,
            'employee_id' => $salesEmployee->id,
            'name' => 'Client B',
            'phone' => '081298765432',
        ]);
    }
}
