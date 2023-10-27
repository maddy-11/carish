<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\GeneralSetting;
use Illuminate\Support\Facades\Input;

class GeneralSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $settings = GeneralSetting::first(); 
        return view('admin.settings.generalSetting', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $carData = null;
        if ($request->get('car_number') != null) {
            $carData = $this->getCarData($request->get('car_number'));
        }
        return view('admin.settings.cardata', compact('carData'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $carData = null;
        if ($request->get('car_number') != null) {
            $carData = $this->getCarXMLData($request->get('car_number'), $endpoint = 'live');
        }
        return view('admin.settings.cardataxml', compact('carData'));
    }

    public function getCarInfo(Request $request)
    {
        $carData = null;
        if ($request->get('car_number') != null) {
            $carData = $this->getCarXMLData($request->get('car_number'), $endpoint = 'sandbox');
        }
        return view('admin.settings.cardataxml', compact('carData'));
    }

    private function getCarXMLData($number, $endpoint = 'sandbox')
    {
        if ($endpoint == 'live') {
            $url = "https://aris.mnt.ee/ark/andmevahetus/veh_service12?username=carish&password=R2ytrKpHtNb5HFRH&executor=14584163&regmark=" . $number;
        } else {
            $url = "https://aris-test.mnt.ee/ark/andmevahetus/veh_service12?username=carish&password=R2ytrKpHtNb5HFRH&executor=14584163&regmark=" . $number;
        }

        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //  curl_setopt($ch,CURLOPT_HEADER, false); 
        $output = curl_exec($ch);
        curl_close($ch);
        $ob           = simplexml_load_string($output);
        $json         = json_encode($ob);
        $configData   = json_decode($json, true);
        return $configData;
    }


    private function getCarData($number)
    {

        $url = "https://aris.mnt.ee/ark/andmevahetus/veh_service12?username=carish&password=R2ytrKpHtNb5HFRH&executor=14584163&regmark=" . $number;
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //  curl_setopt($ch,CURLOPT_HEADER, false); 
        $output = curl_exec($ch);
        curl_close($ch);
        $ob           = simplexml_load_string($output);
        $json         = json_encode($ob);
        $configData   = json_decode($json, true);
        $combineArray = array();
        $finalAaary   = array();
        if (isset($configData['ERROR']['CODE']) &&  $configData['ERROR']['CODE'] == '006') {
            $finalAaary['status'] = 'error';
            $finalAaary['message'] = 'No Data Found';
        } else {


            $combineArray['car_number'] = @$configData['SISENDPARAMEETRID']['REGMARK'];
            $finalAaary['status'] = 'success';
            $finalAaary['message'] = 'Data Found';
            $combineArray['category']   = $configData['SOIDUKID']['SOIDUK']['KAT_LYHEND'];
            $combineArray['model']      = @$configData['SOIDUKID']['SOIDUK']['NIMETUS'];
            $combineArray['make']       = @$configData['SOIDUKID']['SOIDUK']['MARK'];

            $combineArray['variant']    = @$configData['SOIDUKID']['SOIDUK']['VARIANT'];
            $combineArray['version']    = @$configData['SOIDUKID']['SOIDUK']['VERSIOON'];

            $combineArray['cc']         = round((@$configData['SOIDUKID']['SOIDUK']['MOOTORI_MAHT']) * (0.001), 1, PHP_ROUND_HALF_UP);
            $combineArray['enginPower'] = @$configData['SOIDUKID']['SOIDUK']['MOOTORI_VOIMSUS'];

            $combineArray['number_of_door']      = @$configData['SOIDUKID']['SOIDUK']['UKSI'];
            $combineArray['length']     = @$configData['SOIDUKID']['SOIDUK']['PIKKUS'];
            $combineArray['width']      = @$configData['SOIDUKID']['SOIDUK']['LAIUS'];
            $combineArray['height']     = @$configData['SOIDUKID']['SOIDUK']['KORGUS'];
            $combineArray['weight']     = @$configData['SOIDUKID']['SOIDUK']['TAISMASS'];
            $combineArray['curb_weight']      = @$configData['SOIDUKID']['SOIDUK']['TYHIMASS'];
            $combineArray['wheel_base']       = @$configData['SOIDUKID']['SOIDUK']['TELGEDE_VAHED'];
            $combineArray['seating_capacity'] = @$configData['SOIDUKID']['SOIDUK']['ISTEKOHTI'];
            $combineArray['torque']           = @$configData['SOIDUKID']['SOIDUK']['MOOTORI_POORDED']; // ENGINE ROTATION
            $combineArray['max_speed']        = @$configData['SOIDUKID']['SOIDUK']['SUURIM_KIIRUS'];
            $combineArray['transmission_type'] = strtolower(@$configData['SOIDUKID']['SOIDUK']['KAIGUKASTI_TYYP']);
            $combineArray['fuel_type']        = strtolower(@$configData['SOIDUKID']['SOIDUK']['MOOTORI_TYYP']);
            $wheelsArray = @$configData['SOIDUKID']['SOIDUK']['TELJED']['TELG'];

            if (!empty($wheelsArray)) {
                $combineArray['front_tyre_size']  = @$wheelsArray[0]['A'];
                $combineArray['back_tyre_size']   = @$wheelsArray[0]['B'];
                $combineArray['front_wheel_size'] = @$wheelsArray[1]['A'];
                $combineArray['back_wheel_size']  = @$wheelsArray[1]['B'];
            }



            //$combineArray['country_name']  = @$configData['SOIDUKID']['SOIDUK']['RIIK'];
            $combineArray['fuel_average']  = @$configData['SOIDUKID']['SOIDUK']['KYTUSEKULU_KESK'];
            $combineArray['cost_in_city']  = @$configData['SOIDUKID']['SOIDUK']['KYTUSEKULU_LINNAS'];
            $combineArray['cost_on_road']  = @$configData['SOIDUKID']['SOIDUK']['KYTUSEKULU_TEEL'];
            $combineArray['year']          = date("Y", strtotime(@$configData['SOIDUKID']['SOIDUK']['ESMAREG_KP']));

            $combineArray['color']         = @$configData['SOIDUKID']['SOIDUK']['VARV'];
            $finalAaary['data']            = @$combineArray;
        } // END OF ELSE FOR FINDING CARS

        return $finalAaary;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //upload_imagedd($request->all());
        $settings = GeneralSetting::first();

        if ($settings == '') {
            $settings = new  GeneralSetting;
        }

        $file = Input::file('upload_image');
        if ($request->hasFile('upload_image')) {
            $name = $request['upload_image']->getClientOriginalName();
            $extension = $request['upload_image']->getClientOriginalExtension();
            $filename = date('m-d-Y') . mt_rand(999, 999999) . '__' . time() . '.' . $name/*.$extension*/;
            $request['upload_image']->move(public_path('/uploads'), $filename);
            $settings->logo       = $filename;
        }

        $file = Input::file('upload_small_logo');
        if ($request->hasFile('upload_small_logo')) {
            $name = $request['upload_small_logo']->getClientOriginalName();
            $extension = $request['upload_small_logo']->getClientOriginalExtension();
            $filename = date('m-d-Y') . mt_rand(999, 999999) . '__' . time() . '.' . $name/*.$extension*/;
            $request['upload_small_logo']->move(public_path('/uploads'), $filename);
            $settings->small_logo       = $filename;
        }

        $file = Input::file('upload_favicon');
        if ($request->hasFile('upload_favicon')) {
            $name = $request['upload_favicon']->getClientOriginalName();
            $extension = $request['upload_favicon']->getClientOriginalExtension();
            $filename = date('m-d-Y') . mt_rand(999, 999999) . '__' . time() . '.' . $name/*.$extension*/;
            $request['upload_favicon']->move(public_path('/uploads'), $filename);
            $settings->favicon       = $filename;
        }

        /*

        $settings->title = $request->title;
        $settings->default_language = $request->default_language;
        $settings->business_email = $request->email;
        $settings->business_name = $request->business_name;
        $settings->website_link = $request->website_link;
        $settings->registry_number = $request->registry_number;
        $settings->complaint_email = $request->comp_email;
        $settings->other_info = $request->otherhospitalinfo;
        $settings->address = $request->hospitaladdress;
        $settings->bank_detail = $request->bank_detail;
        $settings->fax = $request->faxnumber;
        $settings->phone_number = $request->number;
        $settings->ads_limit = $request->ads_limit;
        $settings->spare_parts_limit = $request->spare_parts_limit;*/
        $settings->save();


        return redirect('admin/general-settings')->with('success', 'General Settings Updated Successfully');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $settings = GeneralSetting::first();
        return view('admin.settings.editGeneralSetting', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function base64_to_jpeg($base64_string, $output_file)
    {
        $output_file_name = time() . '.jpg';
        $output_file = $output_file . '/' . $output_file_name;
        $ifp = fopen($output_file, 'wb');
        $data = explode(',', $base64_string);
        fwrite($ifp, base64_decode($data[1]));
        fclose($ifp);
        return $output_file_name;
    }

    public function uploadlogo(Request $request)
    {

        if (empty($request['image']))
            die("missing string base64");
        $base = $request['image'];
        if (!empty($base)) {
            $image = $this->upload($base, $request['image']);
            $logo = GeneralSetting::where('id', '<>', '')->first();
            $logo->logo = $image;
            $logo->save();
        }
        return json_encode(
            ['success' => 'added']
        );
    }

    public function uploadsmalllogo(Request $request)
    {

        if (empty($request['image']))
            die("missing string base64");
        $base = $request['image'];
        if (!empty($base)) {
            $image = $this->uploadsmall($base, $request['image']);
            $small_logo = GeneralSettings::where('id', '<>', '')->first();
            $small_logo->small_logo = $image;
            $small_logo->save();
        }
        return json_encode(
            ['success' => 'added']
        );
    }

    private function upload($base64_string, $image)
    {
        $data = explode(';', $base64_string);
        $dataa = explode(',', $base64_string);
        $part = explode("/", $data[0]);
        $basic_paht = str_replace('\\', '/', public_path());
        $directory = $basic_paht . '/uploads';
        if (empty($part) or @$part[1] == null or empty(@$part[1])) {
            return false;
        } else {
            $file = md5(uniqid(rand(), true)) . ".{$part[1]}";

            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }
            $file = $this->base64_to_jpeg($image, $directory);
            return $file;
        }
    }

    private function uploadsmall($base64_string, $image)
    {
        $data = explode(';', $base64_string);
        $dataa = explode(',', $base64_string);
        $part = explode("/", $data[0]);
        $basic_paht = str_replace('\\', '/', public_path());
        $directory = $basic_paht . '/uploads';
        if (empty($part) or @$part[1] == null or empty(@$part[1])) {
            return false;
        } else {
            $file = md5(uniqid(rand(), true)) . ".{$part[1]}";

            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }
            $file = $this->base64_to_jpeg_small($image, $directory);
            return $file;
        }
    }

    public function base64_to_jpeg_small($base64_string, $output_file)
    {
        $output_file_name = time() . '.jpg';
        $output_file = $output_file . '/' . $output_file_name;
        $ifp = fopen($output_file, 'wb');
        $data = explode(',', $base64_string);
        fwrite($ifp, base64_decode($data[1]));
        fclose($ifp);
        return $output_file_name;
    }

    public function uploadfavicon(Request $request)
    {

        if (empty($request['image']))
            die("missing string base64");
        $base = $request['image'];
        if (!empty($base)) {
            $image = $this->uploadfaviconimage($base, $request['image']);
            $favicon = GeneralSettings::where('id', '<>', '')->first();
            $favicon->favicon = $image;
            $favicon->save();
        }
        return json_encode(
            ['success' => 'added']
        );
    }

    private function uploadfaviconimage($base64_string, $image)
    {
        $data = explode(';', $base64_string);
        $dataa = explode(',', $base64_string);
        $part = explode("/", $data[0]);
        $basic_paht = str_replace('\\', '/', public_path());
        $directory = $basic_paht . '/uploads';
        if (empty($part) or @$part[1] == null or empty(@$part[1])) {
            return false;
        } else {
            $file = md5(uniqid(rand(), true)) . ".{$part[1]}";

            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }
            $file = $this->base64_to_jpeg_favicon($image, $directory);
            return $file;
        }
    }

    public function base64_to_jpeg_favicon($base64_string, $output_file)
    {
        $output_file_name = time() . '.jpg';
        $output_file = $output_file . '/' . $output_file_name;
        $ifp = fopen($output_file, 'wb');
        $data = explode(',', $base64_string);
        fwrite($ifp, base64_decode($data[1]));
        fclose($ifp);
        return $output_file_name;
    }

    public function saveGeneralSettingData(Request $request)
    {
        $setting = GeneralSetting::find($request->setting_id);

        foreach ($request->except('setting_id', 'old_value') as $key => $value) {
            if ($key == 'facebook_link') {
                $setting->$key = $value;
            } else {
                $setting->$key = $value;
            }
            $setting->save();
        }
        return response()->json(['facebook_link' => $setting->facebook_link]);
    }
}
