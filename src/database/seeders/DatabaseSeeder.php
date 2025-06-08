<?php

namespace Database\Seeders;

use App\Models\{User, Company, Branch, Bank, Division, Employee, Client, Product, Period, Order, Target};
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Carbon\CarbonPeriod;

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
        $company = Company::firstOrCreate([
            'name' => 'PT LAPI Laboratories', 
            'address' => 'Jl. Gedong Panjang No.32',
            'email' => 'ptlapi@admin.com',
            'contact'=> '',
            'logo' => ''
        ]);

        $bank = Bank::firstOrCreate(['company_id' => 1, 'name' => 'BCA', 'rekening' => '123456']);

        // Branch
        $branch = Branch::firstOrCreate([
            'company_id' => 1,
            'name' => 'Cabang',
            'location' => 'Jakarta'
        ]);

        $branch = Branch::firstOrCreate([
            'company_id' => 2,
            'name' => 'Cabang',
            'location' => 'Bogor'
        ]);

        $branch = Branch::firstOrCreate([
            'company_id' => 3,
            'name' => 'Cabang',
            'location' => 'Tangerang'
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
            'name' => 'Asep',
            'user_id' => 2,
            'company_id' => 1,
            'branch_id' => 1,
            'division_id' => 1,
            'phone' => '08123456789'
        ]);

        $salesEmployee = Employee::create([
            'name' => 'Jimmy',
            'user_id' => 2,
            'company_id' => 1,
            'branch_id' => 2,
            'division_id' => 1,
            'phone' => '08123456789'
        ]);

        $salesEmployee = Employee::create([
            'name' => 'Marvel',
            'user_id' => 2,
            'company_id' => 1,
            'branch_id' => 3,
            'division_id' => 1,
            'phone' => '08123456789'
        ]);

        $financeEmployee = Employee::create([
            'name' => 'Ilsa',
            'user_id' => 3,
            'company_id' => 1,
            'branch_id' => 1,
            'division_id' => 2,
            'phone' => '08123456789'
        ]);

         // Clients
         $clientA = Client::firstOrCreate([
            'name' => 'Apotek Harapan Indah',
            'user_id' => 4,
            'company_id' => 1,
            'branch_id' => 1,
            'division_id' => 1,
            'employee_id' => 1,
            'address' => '',
            'phone' => '081234567890',
        ]);

        $clientB = Client::firstOrCreate([
            'name' => 'Apotek Jantung Siloam',
            'user_id' => 5,
            'company_id' => 1,
            'branch_id' => 1,
            'division_id' => 1,
            'employee_id' => 1,
            'address' => '',
            'phone' => '081234567890',
        ]);

        // Product
        $product = Product::firstOrCreate([
            'image' => '',
            'name' => 'ALERHIS',
            'price' => 100000,
            'stock' => 10
        ]);

        $product = Product::firstOrCreate([
            'image' => '',
            'name' => 'EYEVIT GUMMY',
            'price' => 70000,
            'stock' => 10
        ]);

        $product = Product::firstOrCreate([
            'image' => '',
            'name' => 'EYEVIT SIRUP',
            'price' => 55000,
            'stock' => 10
        ]);

        $product = Product::firstOrCreate([
            'image' => '',
            'name' => 'FULAZ',
            'price' => 70000,
            'stock' => 10
        ]);

        // Order

        $order = Order::firstOrCreate([
            'status' => 'SO',
            'order_code' => 'SO-123',
            'product_id' => 1,
            'employee_id' => 1,
            'client_id' => 1,
            'qty'=> 1,
            'grand_total' => 135000
        ]);

        // Period
        $period = CarbonPeriod::create('2025-01-01', '1 month', '2025-12-01');

        foreach ($period as $date) {
            Period::firstOrCreate([
               'year' => $date->year,
                'month' => $date->month,
            ], [
                'name' => $date->format('F Y'),
            ]);
        }

        // Target
        $company = Company::all();
        $period = Period::all();
        $branch = Branch::all();
        $product = Product::all();

        if ($company->isEmpty() || $period->isEmpty() || $branch->isEmpty() || $product->isEmpty()) {
            $this->command->info('Please make sure Company, Period, Branch and Product tables have data.');
            return;
        }

        for ($i = 0; $i < 12; $i++) {
            $randomProduct = $product->random();
            $targetQty = rand(10, 100);
            $totalPrice = $targetQty * $randomProduct->price;
        
            Target::firstOrCreate([
                'company_id' => $company->random()->id,
                'period_id' => $period->random()->id,
                'branch_id' => $branch->random()->id,
                'product_id' => $randomProduct->id,
                'targetprod' => $targetQty,
                'total' => $totalPrice,
            ]);
        }
    }
}
