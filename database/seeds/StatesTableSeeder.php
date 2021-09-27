<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->insert([
			['name' => 'Andaman and Nicobar Islands',
			'code' => 'AN',
			'country_id' => 'IN'],
			
			['name' => 'Andhra Pradesh',
			'code' => 'AP',
			'country_id' => 'IN'],
			
			['name' => 'Arunachal Pradesh',
			'code' => 'AR',
			'country_id' => 'IN'],
			
			['name' => 'Assam',
			'code' => 'AS',
			'country_id' => 'IN'],
			
			['name' => 'Bihar',
			'code' => 'BR',
			'country_id' => 'IN'],
			
			['name' => 'Chandigarh',
			'code' => 'CH',
			'country_id' => 'IN'],
			
			['name' => 'Chattisgarh',
			'code' => 'CT',
			'country_id' => 'IN'],
			
			['name' => 'Dadra and Nagar Haveli',
			'code' => 'DN',
			'country_id' => 'IN'],
			
			['name' => 'Daman and Diu',
			'code' => 'DD',
			'country_id' => 'IN'],
			
			['name' => 'Delhi',
			'code' => 'DL',
			'country_id' => 'IN'],
			
			['name' => 'Goa',
			'code' => 'GA',
			'country_id' => 'IN'],
			
			['name' => 'Gujarat',
			'code' => 'GJ',
			'country_id' => 'IN'],
			
			['name' => 'Haryana',
			'code' => 'HR',
			'country_id' => 'IN'],
			
			['name' => 'Himachal Pradesh',
			'code' => 'HP',
			'country_id' => 'IN'],
			
			['name' => 'Jammu and Kashmir',
			'code' => 'JK',
			'country_id' => 'IN'],
			
			['name' => 'Jharkhand',
			'code' => 'JH',
			'country_id' => 'IN'],
			
			['name' => 'Karnataka',
			'code' => 'KA',
			'country_id' => 'IN'],
			
			['name' => 'Kerala',
			'code' => 'KL',
			'country_id' => 'IN'],
			
			['name' => 'Lakshadweep',
			'code' => 'LD',
			'country_id' => 'IN'],
			
			['name' => 'Madhya Pradesh',
			'code' => 'MP',
			'country_id' => 'IN'],
			
			['name' => 'Maharashtra',
			'code' => 'MH',
			'country_id' => 'IN'],
			
			['name' => 'Manipur',
			'code' => 'MN',
			'country_id' => 'IN'],
			
			['name' => 'Meghalaya',
			'code' => 'ME',
			'country_id' => 'IN'],
			
			['name' => 'Mizoram',
			'code' => 'MI',
			'country_id' => 'IN'],
			
			['name' => 'Nagaland',
			'code' => 'NL',
			'country_id' => 'IN'],
			
			['name' => 'Odisha',
			'code' => 'OR',
			'country_id' => 'IN'],
			
			['name' => 'Puducherry',
			'code' => 'PY',
			'country_id' => 'IN'],
			
			['name' => 'Punjab',
			'code' => 'PB',
			'country_id' => 'IN'],
			
			['name' => 'Rajasthan',
			'code' => 'RJ',
			'country_id' => 'IN'],
			
			['name' => 'Sikkim',
			'code' => 'SK',
			'country_id' => 'IN'],
			
			['name' => 'Tamil Nadu',
			'code' => 'TN',
			'country_id' => 'IN'],
			
			['name' => 'Telangana',
			'code' => 'TS',
			'country_id' => 'IN'],
			
			['name' => 'Tripura',
			'code' => 'TR',
			'country_id' => 'IN'],
			
			['name' => 'Uttar Pradesh',
			'code' => 'UP',
			'country_id' => 'IN'],
			
			['name' => 'Uttarakhand',
			'code' => 'UT',
			'country_id' => 'IN'],
			
			['name' => 'West Benga',
			'code' => 'WB',
			'country_id' => 'IN'],
			
		]);
    }
}
