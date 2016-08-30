<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DashboardController extends Controller
{
    private $endpoints_uri = 'https://graph-na02-useast1.api.smartthings.comapi/smartapps/endpoints';
    private $hub_uri = "https://graph-na02-useast1.api.smartthings.com:443/api/smartapps/installations/1afc4265-ac54-411b-8648-b8db9a821f5e";
   // private $endpoints_uri = 'https://graph-na02-useast1.api.smartthings.com';

    private function get($url, $token = '2ebf7781-9f56-4465-92bf-53b6ef732ece')
    {
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'http://www.wholecrowd.com',
            CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $token)
        ));
        // Send the request & save response to $resp
        $resp   = curl_exec($curl);
        $decode = json_decode($resp);
        // Close request to clear up some resources
        curl_close($curl);

        // $ch = curl_init();

        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_HEADER , false);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token));

        // var_dump($ch);

        // $raw    = curl_exec($ch);
        // var_dump($raw);

        // $decode = json_decode($raw);

        
        // var_dump($decode);

        // curl_close($ch);

        return $decode;
    }    

    public function getIndex() 
    {
    	$devices = \App\Device::all();
    	$power3  = \App\Event::getByDeviceName(9, 'power3');
    	$power4  = \App\Event::getByDeviceName(9, 'power4');
    	$power2  = \App\Event::getByDeviceName(9, 'power2');

     //    $energy3 = \App\Event::getByDeviceName(9, 'energy3');
    	// $energy2 = \App\Event::getByDeviceName(9, 'energy2');
    	// $energy4 = \App\Event::getByDeviceName(9, 'energy4');

        $energy2mm =  \App\Event::getMinMax(9, 'energy2');
        $energy3mm =  \App\Event::getMinMax(9, 'energy3');
        $energy4mm =  \App\Event::getMinMax(9, 'energy4');

    	$temp1 = \App\Event::getMinMax(1, 'temperature'); //front
    	$temp4 = \App\Event::getMinMax(4, 'temperature'); // left
    	$temp6 = \App\Event::getMinMax(6, 'temperature'); // patiop
    	$temp7 = \App\Event::getMinMax(7, 'temperature'); // steps
        $temp8 = \App\Event::getMinMax(268, 'temperature'); // current

    	return view('dashboard', [ 'devices' => $devices, 
    			'power2' => $power2, 
    			//'energy2' => $energy2, 
    			'power3' => $power3, 
    			//'energy3' => $energy3, 
                'energy2mm' =>$energy2mm,
                'energy3mm' =>$energy3mm,
                'energy4mm' =>$energy4mm,
    			'power4' => $power4, 
    			//'energy4' => $energy4, 
    			'temp1' => $temp1,
    			'temp4' => $temp4,
    			'temp6' => $temp6,
    			'temp7' => $temp7,
                'temp8' => $temp8,
    			'energy3day' => [],
                'response' => $this->get($this->hub_uri . '/ping') 
    	]);

    }
}
