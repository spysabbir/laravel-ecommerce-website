<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districts = [
            ['id' => '1', 'division_id' => '1', 'name' => 'Comilla'],
            ['id' => '2', 'division_id' => '1', 'name' => 'Feni'],
            ['id' => '3', 'division_id' => '1', 'name' => 'Brahmanbaria'],
            ['id' => '4', 'division_id' => '1', 'name' => 'Rangamati'],
            ['id' => '5', 'division_id' => '1', 'name' => 'Noakhali'],
            ['id' => '6', 'division_id' => '1', 'name' => 'Chandpur'],
            ['id' => '7', 'division_id' => '1', 'name' => 'Lakshmipur'],
            ['id' => '8', 'division_id' => '1', 'name' => 'Chattogram'],
            ['id' => '9', 'division_id' => '1', 'name' => 'Coxsbazar'],
            ['id' => '10', 'division_id' => '1', 'name' => 'Khagrachhari'],
            ['id' => '11', 'division_id' => '1', 'name' => 'Bandarban'],
            ['id' => '12', 'division_id' => '2', 'name' => 'Sirajganj'],
            ['id' => '13', 'division_id' => '2', 'name' => 'Pabna'],
            ['id' => '14', 'division_id' => '2', 'name' => 'Bogura'],
            ['id' => '15', 'division_id' => '2', 'name' => 'Rajshahi'],
            ['id' => '16', 'division_id' => '2', 'name' => 'Natore'],
            ['id' => '17', 'division_id' => '2', 'name' => 'Joypurhat'],
            ['id' => '18', 'division_id' => '2', 'name' => 'Chapainawabganj'],
            ['id' => '19', 'division_id' => '2', 'name' => 'Naogaon'],
            ['id' => '20', 'division_id' => '3', 'name' => 'Jashore'],
            ['id' => '21', 'division_id' => '3', 'name' => 'Satkhira'],
            ['id' => '22', 'division_id' => '3', 'name' => 'Meherpur'],
            ['id' => '23', 'division_id' => '3', 'name' => 'Narail'],
            ['id' => '24', 'division_id' => '3', 'name' => 'Chuadanga'],
            ['id' => '25', 'division_id' => '3', 'name' => 'Kushtia'],
            ['id' => '26', 'division_id' => '3', 'name' => 'Magura'],
            ['id' => '27', 'division_id' => '3', 'name' => 'Khulna'],
            ['id' => '28', 'division_id' => '3', 'name' => 'Bagerhat'],
            ['id' => '29', 'division_id' => '3', 'name' => 'Jhenaidah'],
            ['id' => '30', 'division_id' => '4', 'name' => 'Jhalakathi'],
            ['id' => '31', 'division_id' => '4', 'name' => 'Patuakhali'],
            ['id' => '32', 'division_id' => '4', 'name' => 'Pirojpur'],
            ['id' => '33', 'division_id' => '4', 'name' => 'Barisal'],
            ['id' => '34', 'division_id' => '4', 'name' => 'Bhola'],
            ['id' => '35', 'division_id' => '4', 'name' => 'Barguna'],
            ['id' => '36', 'division_id' => '5', 'name' => 'Sylhet'],
            ['id' => '37', 'division_id' => '5', 'name' => 'Moulvibazar'],
            ['id' => '38', 'division_id' => '5', 'name' => 'Habiganj'],
            ['id' => '39', 'division_id' => '5', 'name' => 'Sunamganj'],
            ['id' => '40', 'division_id' => '6', 'name' => 'Narsingdi'],
            ['id' => '41', 'division_id' => '6', 'name' => 'Gazipur'],
            ['id' => '42', 'division_id' => '6', 'name' => 'Shariatpur'],
            ['id' => '43', 'division_id' => '6', 'name' => 'Narayanganj'],
            ['id' => '44', 'division_id' => '6', 'name' => 'Tangail'],
            ['id' => '45', 'division_id' => '6', 'name' => 'Kishoreganj'],
            ['id' => '46', 'division_id' => '6', 'name' => 'Manikganj'],
            ['id' => '47', 'division_id' => '6', 'name' => 'Dhaka'],
            ['id' => '48', 'division_id' => '6', 'name' => 'Munshiganj'],
            ['id' => '49', 'division_id' => '6', 'name' => 'Rajbari'],
            ['id' => '50', 'division_id' => '6', 'name' => 'Madaripur'],
            ['id' => '51', 'division_id' => '6', 'name' => 'Gopalganj'],
            ['id' => '52', 'division_id' => '6', 'name' => 'Faridpur'],
            ['id' => '53', 'division_id' => '7', 'name' => 'Panchagarh'],
            ['id' => '54', 'division_id' => '7', 'name' => 'Dinajpur'],
            ['id' => '55', 'division_id' => '7', 'name' => 'Lalmonirhat'],
            ['id' => '56', 'division_id' => '7', 'name' => 'Nilphamari'],
            ['id' => '57', 'division_id' => '7', 'name' => 'Gaibandha'],
            ['id' => '58', 'division_id' => '7', 'name' => 'Thakurgaon'],
            ['id' => '59', 'division_id' => '7', 'name' => 'Rangpur'],
            ['id' => '60', 'division_id' => '7', 'name' => 'Kurigram'],
            ['id' => '61', 'division_id' => '8', 'name' => 'Sherpur'],
            ['id' => '62', 'division_id' => '8', 'name' => 'Mymensingh'],
            ['id' => '63', 'division_id' => '8', 'name' => 'Jamalpur'],
            ['id' => '64', 'division_id' => '8', 'name' => 'Netrokona'],
        ];

        DB::table('districts')->insert($districts);
    }
}
