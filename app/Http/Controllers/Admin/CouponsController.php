<?php

namespace App\Http\Controllers\Admin;

use App\Coupon;
use App\Http\Controllers\Controller;
use App\Imports\uploadExcel;
use App\Imports\makesImport;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;

use App\Models\Cars\Make;
use App\Models\Cars\Carmodel;
use App\Models\Cars\Version;

class CouponsController extends Controller
{
    public function index()
    {
    	$coupons = Coupon::all();
        return view('admin.coupons.index',compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'discount_type' => 'required',
            'usage_limit' => 'required',
            'date_expired' => 'required'
        ]);
		
		$coupon                = new Coupon;
		$coupon->product_id    = 0;
		$coupon->code          = $request->code;
		$coupon->discount_type = $request->discount_type;
		$coupon->usage_limit   = $request->usage_limit;
		$coupon->date_expired  = $request->date_expired;
		$coupon->individual_use= 'yes';
		$coupon->updated_at    = Carbon::now();
        $coupon->save();

        return redirect()->route('list-coupons')->with('successmsg', 'New Coupon added successfully');
    }

    public function edit($id)
    {
    	$coupon = Coupon::find($id);
        return view('admin.coupons.edit',compact('coupon'));
    }

     public function update(Request $request, $id)
    {
    	// dd($request->all());
        $request->validate([
            'code' => 'required',
            'usage_limit' => 'required',
            'date_expired' => 'required',
        ]);

        // create new template //
        $coupon 			   = Coupon::findorfail($id);
        $coupon->code          = $request->code;
		$coupon->usage_limit   = $request->usage_limit;
		$coupon->date_expired  = $request->date_expired;
		$coupon->updated_at    = Carbon::now();
        $coupon->save();

        return redirect()->route('list-coupons')->with('successmsg', 'Coupon updated successfully');

    }

     public function uploadExcel(Request $request)
    {
        $path = $request->file('excel')->getRealPath();
        //makesImport
        //Excel::import(new makesImport, $path);
        // Excel::import(new uploadExcel,$path);


        $destinationPath = public_path('/spare-parts-ads/Book1.xlsx');
        
        $rows = array();
        $data = $this->csvToArray($path);
        foreach ($data as $values)
        {
            $rows[$values['Make']][$values['Model']][] =   array('label'=>$values['Label'],'details'=> $values['Details'],
            'from'=> $values['from'],'to'=> $values['to']); 
        }

        foreach($rows as $keys=> $row)
        { 
            $makes   = Make::where('title', $keys)->first();
            if($makes == null) { // insert MAKES
                $makes = Make::create(['title'=> $keys]);
            } 
            $make_id = $makes->id;

            foreach ($row as $model_keys => $models){ 

                $models_data =Carmodel::where('name', $model_keys)->where('make_id', $make_id)->first();
                if ($models_data == null) { // insert MODELS
                    $models_data = Carmodel::create(['name' => $model_keys, 'make_id'=> $make_id]);
                }
                $mode_id = $models_data->id;

                foreach($models as $versions) {

                    $version_data = Version::where('name', $versions['details'])->where('model_id', $mode_id)->first();
                    if ($version_data == null) { // insert MODELS
                        Version::create(['name' => $versions['details'], 'model_id' => $mode_id,
                        'label'=> $versions['label'], 'from_date'=> $versions['from'], 'to_date'=> $versions['to']]);
                    }
                    
                }// END OF Th
                

            }// END SECOND FOREACH

            
        }

        return redirect()->back()->with('successmsg', 'Excel Uploaded successfully');
    } 
    


    private function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }
}
