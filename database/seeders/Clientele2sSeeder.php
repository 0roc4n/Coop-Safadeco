<?php

namespace Database\Seeders;

use App\Models\Clientele;
use App\Models\Clientele2;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Clientele2sSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all client codes from the clienteles table
        $clientCodes = Clientele::pluck('ClientCode');

        foreach ($clientCodes as $clientCode) {
            // Get the client's details to match some data
            $client = Clientele::where('ClientCode', $clientCode)->first();
            
            // Generate membership dates that make sense with the client's DateOfMembership
            $membershipDate = new \DateTime($client->DateOfMembership);
            $preOrientationDate = (clone $membershipDate)->modify('-7 days');
            
            // Calculate reasonable dates for approvals
            $dateApproved = (clone $membershipDate)->modify('+1 day');

            // Generate realistic height and weight based on gender
            $height = $client->Sex ? 
                fake()->numberBetween(160, 185) :  // Male
                fake()->numberBetween(150, 170);   // Female
            $weight = $client->Sex ?
                fake()->numberBetween(60, 90) :    // Male
                fake()->numberBetween(45, 75);     // Female

            DB::table('clientele2s')->insert([
                'ClientCode' => $clientCode,
                'MembershipEntry' => fake()->randomElement(['WI', 'REF', 'OA', 'ER']), // WI=Walk-in, REF=Referral, OA=Online Application, ER=Employee Referral
                'PreOrientationDate' => $preOrientationDate->format('Y-m-d'),
                'MembershipOrientationConductedby' => fake()->name(),
                'Height' => $height,
                'Weight' => $weight,
                'SSS' => fake()->numerify('##-#######-#'),
                'TIN' => fake()->numerify('###-###-###-###'),
                'Shift' => fake()->randomElement(['AM', 'PM', 'NIGHT', 'FLEX']),
                'DepartmentOrArea' => $client->Department ?? fake()->randomElement([
                    'OPS',
                    'HR',
                    'FIN',
                    'IT',
                    'MKT',
                    'SALES',
                    'CS',
                    'ADMIN'
                ]),
                'LocalNo' => fake()->numerify('Local ###'),
                'Degree' => fake()->randomElement([
                    'BSBA',
                    'BSIT',
                    'BSA',
                    'BAC',
                    'BSE',
                    'BEED',
                    'BSED',
                    'AD'
                ]),
                'SpouseContactNo' => $client->SpouseName ? fake()->phoneNumber() : null,
                'SpouseBirthday' => $client->SpouseName ? 
                    fake()->dateTimeBetween('-60 years', '-20 years')->format('Y-m-d') : null,
                'SpouseEducationalAttaintment' => $client->SpouseName ? 
                    fake()->randomElement(['High School', 'College', 'Masters', 'PhD']) : null,
                'SpouseDegree' => $client->SpouseName ? fake()->randomElement([
                    'BSN',
                    'BSED',
                    'BSBA',
                    'BAP'
                ]) : null,
                'SpouseEmployer' => $client->SpouseOcc ? Str::limit(fake()->company(), 64, '') : null,
                'SpouseOfficeAddress' => $client->SpouseOcc ? Str::limit(fake()->address(), 64, '') : null,
                
                // Family Information
                'FatherName' => fake()->name('male'),
                'FatherOcc' => fake()->jobTitle(),
                'FatherBirthday' => fake()->dateTimeBetween('-80 years', '-50 years')->format('Y-m-d'),
                'FatherOfficeAddress' => fake()->optional()->passthrough(Str::limit(fake()->address(), 64, '')),
                'MotherName' => fake()->name('female'),
                'MotherOcc' => fake()->jobTitle(),
                'MotherBirthday' => fake()->dateTimeBetween('-80 years', '-50 years')->format('Y-m-d'),
                
                // Employment and Office Information
                'MembershipStatus' => $client->DtOfTerminate ? 'TERM' : 
                    fake()->randomElement(['ACT', 'ACT', 'ACT', 'INAC']), // Weight towards Active
                'EmployerName' => Str::limit($client->Office ?? fake()->company(), 30, ''),
                'OfficeAddress' => Str::limit(fake()->address(), 100, ''),
                'OfficeZip' => fake()->postcode(),
                'OfficePhone' => fake()->phoneNumber(),
                
                // Additional Income Information
                'OtherSourceOfIncome' => fake()->optional(0.3)->randomElement([
                    'Business',
                    'Rental Property',
                    'Investments',
                    'Part-time Work',
                    'Online Selling'
                ]),
                'OtherSourceMonthlyIncome' => fake()->optional(0.3)->numberBetween(5000, 50000),
                
                // Membership and Financial Information
                'BODResNo' => 'BOD-' . fake()->numerify('####-###'),
                'DateApproved' => $dateApproved->format('Y-m-d'),
                'InitCapSubs' => fake()->numberBetween(1000, 5000),
                'NoOfShares' => ($noOfShares = fake()->numberBetween(10, 100)),
                'amountSubs' => $noOfShares * 100, // 100 pesos per share
                'ReligionAffiliation' => fake()->randomElement([
                    'Roman Catholic',
                    'Protestant',
                    'Islam',
                    'Iglesia ni Cristo',
                    'Seventh Day Adventist',
                    'Born Again Christian',
                    'Buddhist',
                    'Others'
                ]),
                'BodResNoTerminate' => $client->DtOfTerminate ? 
                    'TERM-' . fake()->numerify('####-###') : null,
                
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
