<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hotel;
use App\Models\Pos;
use App\Models\Inventory;
use App\Models\Count;

class BakuunController extends Controller
{
    
    public function launchActivity()
    {
        $data_arr = $this->convertXMLToJSON('xml/bakuun.xml');

        $hotel = $this->saveHotel($data_arr['@attributes']);
        $this->savePos($data_arr['POS'], $hotel->id);
        $this->saveInventories($data_arr['Inventories'], $hotel->id);
    }

    public function convertXMLToJSON($xml_file)
    {
        $xml_object     = simplexml_load_file($xml_file);
        $hotel_inv_json = json_encode($xml_object);
        $hotel_inv_arr  = json_decode($hotel_inv_json, true);
        return $hotel_inv_arr;
    }

    public function saveHotel($htl_arr)
    {
        $htl = new Hotel();
        $htl->version    = $htl_arr['Version'];
        $htl->timestamp  = $htl_arr['TimeStamp'];
        $htl->echo_token = $htl_arr['EchoToken'];
        $htl->xmlns      = $htl_arr['Xmlns'];
        $htl->save();

        return $htl;
    }

    public function savePos($pos_arr, $hotel_id)
    {
        $pos = new Pos();
        $pos->hotel_id              = $hotel_id;
        $pos->booking_channel_type  = $pos_arr['Source']['BookingChannel']['@attributes']['Type'];
        $pos->company_name_code     = $pos_arr['Source']['BookingChannel']['CompanyName']['@attributes']['Code'];
        $pos->company_name_value    = $pos_arr['Source']['BookingChannel']['CompanyName']['@attributes']['Value'];
        $pos->save();
    }

    public function saveInventories($inventory_arr, $hotel_id)
    {
        foreach ($inventory_arr['Inventory'] as $inv) {
            $inventory = new Inventory();
            $inventory->hotel_id       = $hotel_id;
            $inventory->hotel_code     = $inventory_arr['@attributes']['HotelCode'];
            $inventory->start          = $inv['StatusApplicationControl']['@attributes']['Start'];
            $inventory->end            = $inv['StatusApplicationControl']['@attributes']['End'];
            $inventory->inv_type_code  = $inv['StatusApplicationControl']['@attributes']['InvTypeCode'];
            $inventory->rate_plan_code = $inv['StatusApplicationControl']['@attributes']['RatePlanCode'];
            $inventory->save();
            $this->saveCount($inv, $inventory->id);
        }

        if ($inventory) {
            echo "Successfully Saved!";
        }

    }

    public function saveCount($inv, $inventory_id)
    {
        $count = new Count();
        $count->inventory_id   = $inventory_id;
        $count->count          = $inv['InvCounts']['InvCount']['@attributes']['Count'];
        $count->count_type     = $inv['InvCounts']['InvCount']['@attributes']['CountType'];
        $count->save();
    }

}
