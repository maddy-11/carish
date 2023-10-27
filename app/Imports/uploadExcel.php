<?php

namespace App\Imports;

use App\Coupon;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class uploadExcel implements ToModel, WithStartRow
{
    /**
    * @param model
    */
    public function __construct()
    {
    }

    public function model(array $row)
    {
    	return new Coupon([
			'product_id'     => 1,
			'code'           => $row[0],
			'discount_type'  => $row[1], 
			'usage_limit'    => $row[2], 
			'date_expired'   => $row[3], 
			'individual_use' => 'yes', 
			'updated_at'     => Carbon::now(),
        ]);
        
    }

    public function startRow():int
    {
        // TODO: Implement startRow() method.
        return 2;
    }
}
