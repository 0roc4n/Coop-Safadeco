<?php

namespace Database\Seeders;

use App\Models\Clientele;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClienteleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 50 sample clients
        for ($i = 1; $i <= 50; $i++) {
            $clientCode = 'CL' . str_pad($i, 8, '0', STR_PAD_LEFT);
            $gender = rand(0, 1);
            $firstName = $gender ? fake()->firstNameMale() : fake()->firstNameFemale();
            
            DB::table('clienteles')->insert([
                'ClientCode' => $clientCode,
                'CenterGrpKey' => 'CG' . str_pad(rand(1, 10), 3, '0', STR_PAD_LEFT),
                'LastName' => fake()->lastName(),
                'FirstName' => $firstName,
                'MiddleName' => Str::substr(fake()->lastName(), 0, 1) . '.',
                'DateOfMembership' => fake()->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                'ClientType' => rand(1, 3), // 1: Regular, 2: Associate, 3: Honorary
                'ClientClass' => rand(1, 3),
                'EmployeeType' => rand(1, 4),
                'Addr1' => fake()->streetAddress(),
                'Addr2' => fake()->city(),
                'Addr3' => fake()->state(),
                'TelNum' => fake()->phoneNumber(),
                'PlBirth' => fake()->city(),
                'DtBirth' => fake()->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
                'Sex' => $gender,
                'SpouseName' => rand(0, 1) ? fake()->name() : null,
                'EduAtt' => fake()->randomElement([1, 2, 3, 4]), // 1: High School, 2: College, 3: Masters, 4: PhD
                'CivStatus' => fake()->randomElement([1, 2, 3, 4]), // 1: Single, 2: Married, 3: Widowed, 4: Divorced
                'DtOfTerminate' => fake()->optional(0.1, null)->date('Y-m-d'),
                'UserRefCD' => 'USR' . str_pad(rand(1, 100), 3, '0', STR_PAD_LEFT),
                'MonthlySalary' => fake()->numberBetween(15000, 100000),
                'SpouseOcc' => rand(0, 1) ? Str::limit(fake()->jobTitle(), 50, '') : null,
                'SpouseMonSal' => rand(0, 1) ? fake()->numberBetween(15000, 100000) : null,
                'MemberType' => rand(1, 3),
                'Occupation' => Str::limit(fake()->jobTitle(), 50, ''),
                'Office' => Str::limit(fake()->company(), 10, ''),
                'Department' => fake()->randomElement(['IT', 'HR', 'FIN', 'OPS', 'MKT']),
                'MFee_amt' => fake()->numberBetween(500, 2000),
                'BankAcctNo' => fake()->numerify('###########'),
                'BankBranch' => Str::limit(fake()->city() . ' Branch', 18, ''),
                'EmploymentDate' => fake()->dateTimeBetween('-10 years', '-1 year')->format('Y-m-d'),
                'ResignationDate' => fake()->optional(0.1, null)->date('Y-m-d'),
                'MaxShareCapital' => fake()->numberBetween(10000, 1000000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
