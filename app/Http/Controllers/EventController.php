<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    } 

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        return view('home');
    }

    public function post()
    {
		//$device = [];

		$debug = false;

		// $device['7e21ac85-2df6-4aa4-93ba-a5a1ee65132e'] = 1; //Front Door
		// $device['02e04d66-8899-42de-9fb4-304fa67eeb08'] = 4; //Left Door
		// $device['814ba2b5-0e15-4098-931c-6e3232eacf0d'] = 5; //Living Room Smoke Detector
		// $device['da56e088-7cac-43bc-87b5-2de8cc828c7c'] = 6; //patio door
		// $device['d860d4bc-79ec-4a44-90ff-29ca5cfd9ba2'] = 7; //steps
		// $device['2a89e751-d29a-4ed8-b7d4-8ef696252082'] = 9; //basement
		// $device['34d8762c-fb22-4848-b7ee-1ecbca5840d5'] = 10; //fridge
		// $device['0145a854-196b-4d88-a891-d1666fea0c85'] = 11; //outlet
		// $device['7b2da9f2-cff9-4edf-956a-da3bb2180747'] = 35; // rebecca
		// $device['32ef5f49-c818-49d0-89a8-6a8cabe64e03'] = 58; //christopher
		// $device['93704325-640d-4e18-9be7-954aea953303'] = 267;
		// $device['22af7a10-6a42-11e6-bdf4-0800200c9a66'] = 268; // current temp
		// $device['e5415490-6ace-11e6-bdf4-0800200c9a66'] = 269; //sunrise
		// $device['f0beeb70-6ace-11e6-bdf4-0800200c9a66'] = 270; //sunset


		$event_input = Input::get('event');//['date'];

		$event_date_raw = $event_input['date']

		if ($debug) {
			// $this->logger->addInfo(trim($allPostPutVars['event']['deviceId']));
			// $this->logger->addInfo('DATE: ' . $event_date_raw);
		}

		$device_uuid = trim($event_input['deviceId']);
		$device = Device::getByUniqueId($device_uuid);

		if ($device === null) {
			// TODO:: Send to Queue and query hub
			$device = Device::create(['uuid' => $uuid, 'name' => 'unknown']);
		}

		$unit_value = trim($event_input['unit']);
		$zwave_value = trim($event_input['description']);
		$description_value = trim($event_input['descriptionText']);
		
		$name = trim($event_input['name']);
		$value = trim($event_input['value']);
		$data_value = trim($event_input['data']);
		$event_date = DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $event_date_raw);

		$event_array = [
			'name' => $name,
			'value' => $value,
			'date' => $event_date->format('Y-m-d H:i:s')
		];

		if ($unit_value !== '')
			$event_array['unit'] = $unit_value;

		if ($data_value !== '')
			$event_array['data'] = $data_value;

		if ($zwave_value !== '')
			$event_array['zwave'] = $zwave_value;

		if ($description_value !== '')
			$event_array['display'] = $description_value;		

		$device->events()->save(Event::create($event_array));
		$latest = $device->getLatestName();

		if ($latest === null) {

			$latest_array = [
				'name' => $name,
				'value' => $value,
				'date' => $event_date->format('Y-m-d H:i:s')
			];		

			if ($unit_value !== '')
				$latest_array['unit'] = $unit_value;				

			$device->latest()->save(Latest::create($latest_array));
		} else {
			$latest->value = $value;
			$latest->date = $event_date->format('Y-m-d H:i:s')

			if ($unit_value !== '')
				$latest->unit = $unit_value;				

			$latest->save();
		}

		$device->lastcontact = $event_date->format('Y-m-d H:i:s');
		$device->save();



    }

}
