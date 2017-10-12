<?php
/*
 * Base Daft Search widget class
 * Author: Diego Solorzano
 * Author URI: http://www.gorilla-systems.com/
 * Version: 1
 * Description: Search form for Daft properties
 */

class DaftSearchHelper
{
    
    private $_api_key;
    private $_api_url;
    private $_iframe_key;
    private $_debug;
    
    public function __construct() {
        $this->_api_key = '57fdf811af218fa5f74c1b6e0ae4578e42c2a1f4';
        $this->_api_url = 'https://api.daft.ie/v2/json/';
        $this->_iframe_key = 'rqyzqu7fz9ykqd7926';
        
        if(function_exists('get_option'))
        {
            $this->_debug = get_option('daft_debug_mode');
        }
    }
    /*
     * Load all the data from the daft api and then display the widget...
     */
    public function loadWidget()
    {
        $data = (object)array();
        $data->ad_types = $this->loadWinterAdTypes();
        $data->page = get_option('daft_results_page_id');
        include_once dirname( __FILE__ ) . '/winter_view.php'; 
    }
    
    /*
     * Function to load winter properties specific ad types
     */
    public function loadWinterAdTypes()
    {  
        $ad_types = array(
          (object)array('name'=>'sale','desc_plural'=>'Properties for Sale'),
          (object)array('name'=>'rental','desc_plural'=>'Properties to Let'),
          (object)array('name'=>'new_development','desc_plural'=>'New Homes for Sale'),
        );
        return (object)$ad_types;
    }
    
    /*
     * Function to load the ad types
     */
    public function loadAdTypes()
    {
       
       $ad_types = (object)array();
       $params = (object)array();
       $url = 'ad_types';
       
       $params->api_key = $this->_api_key;
       $params_json = json_encode($params);
       
       $ad_types = $this->_execApiCall($url,$params_json);
       
       return $ad_types->result->ad_types;
        
    }
    
    /*
     * Function to load the property types
     */
    public function loadPropertyTypes($ad_type, $json=null)
    {
       $property_types = array();
       $params = (object)array();
       $url = 'property_types';
       
       $params->api_key = $this->_api_key;
       $params->ad_type = $ad_type;
       $params_json = json_encode($params);
       
       $property_types = $this->_execApiCall($url,$params_json,$json);
       if(empty($json))
       {    
           return $property_types->result->property_types;
       }
       else
       {
           return json_encode($property_types->result->property_types);
       }
    }
    
    /*
     * Load all locations from the API
     */
    public function loadAllLocations($json=null)
    {
        /*
         * This code would load all locations from the API
         * For Winter Properties we have a set of locations they want
         */
        
        $areas = (object)array();
        $params = (object)array();
        $url = 'areas/';
        
        $params->api_key = $this->_api_key;
        $params->county = array(11); 
        $params->area_type = "area";
        $params_json = json_encode($params);
        
        $areas = $this->_execApiCall($url,$params_json);
       
        
        if(empty($json))
        {    
           return $areas->result->areas;
        }
        else
        {
           return json_encode($areas->result->areas);
        }
        
    }        
    
    /*
     * Load areas/locations
     */
    public function loadLocations($json=null,$ad_type=null)
    {
        $areas = array(
            array('id'=>'','name'=>'All Areas'),
            array('id'=>3585, 'name'=>'Galway City Centre'),
            array('id'=>3804, 'name'=>'Ardrathan'),
            array('id'=>2029, 'name'=>'Athenry'),
            array('id'=>3573, 'name'=>'Ballybane'),
            array('id'=>3574, 'name'=>'Ballybrit'),
            array('id'=>1955, 'name'=>'Barna'),            
            array('id'=>2589, 'name'=>'Claregalway'),           
            array('id'=>3806, 'name'=>'Doughiska'),
            array('id'=>3978, 'name'=>'Headford Road'),
            array('id'=>2025, 'name'=>'Kilcolgan'),
            array('id'=>3667, 'name'=>'Knocknacarra'),
            array('id'=>4000, 'name'=>'Mervue'),
            array('id'=>3568, 'name'=>'Newcastle'),            
            array('id'=>2012, 'name'=>'Oranmore'),
            array('id'=>3582, 'name'=>'Rahoon'),
            array('id'=>3586, 'name'=>'Renmore'),
            array('id'=>3588, 'name'=>'Roscam'),
            array('id'=>3593, 'name'=>'Salthill'),
            array('id'=>1949, 'name'=>'Spiddal'),
            array('id'=>4049, 'name'=>'Taylors Hill'),           
            array('id'=>2574, 'name'=>'Tuam'),
            array('id'=>2587, 'name'=>'Turloughmore'),
            array('id'=>3572, 'name'=>'Wellpark')
                
        );
        if(!empty($ad_type))
        {
            $areas = $this->loadAreasWithProperties($ad_type,$areas);       
        }
        if(empty($json))
        {    
           return (object)$areas;
        }
        else
        {
           return json_encode((object)$areas);
        }
    }
    
    /*
     * Load areas with properties in them...
     */
    public function loadAreasWithProperties($ad_type, $existing_areas)
    {
        $areas = (object)array();
        $params = (object)array();
        $url = 'areas/';
        $new_areas = array();
        
        $params->api_key = $this->_api_key;
        $params->ad_type = $ad_type;
        $params->area_type = "area";
        
        $params_json = json_encode($params);
        
        $call = $this->_execApiCall($url,$params_json);
        $result = $call->result;
        
        if(isset($result->areas))
        {
            foreach($result->areas as $area)
            {
                $new_area = array('id'=>$area->id, 'name'=>$area->name);
                if(!in_array($new_area, $existing_areas))
                {
                    $new_areas[] = $new_area;
                }
            }
        }
        
        $all_areas = array_merge($existing_areas,$new_areas);
        
        return $all_areas;
        
    }
    /*
     * Load the results on the plugin page
     */
    public function loadResults()
    {
        if($this->_debug)
            echo 'Page: '.get_option('daft_results_page_id');
        if ( is_page(get_option('daft_results_page_id')) )     	
        {
            /*
             * Prepare the search options for the URL
             */
            $search = (object)$_POST;
            
            if($this->_debug)
                print_r($search);
            
            $url_params = '&search_type='.$search->ad_type;
            if(!empty($search->property_type))
            {
                $type = $this->getPropertyTypesForIframe($search->ad_type, $search->property_type);
                $url_params.='&s[pt_id]='.$type;
            }
            if(!empty($search->area))
            {
                $url_params.='&s[a_id]='.$search->area;
            }
            if(!empty($search->sale_min_price) || !empty($search->rent_min_price))
            {
                $min_price = empty($search->sale_min_price) ? $search->rent_min_price : $search->sale_min_price;
                $url_params.='&s[mnp]='.$min_price;
            }
            if(!empty($search->sale_max_price) || !empty($search->rent_max_price))
            {
                $max_price = empty($search->sale_max_price) ? $search->rent_max_price : $search->sale_max_price;
                $url_params.='&s[mxp]='.$max_price;
            }
            if(!empty($search->bedrooms))
            {
                $arr_bedrooms = explode('|',$search->bedrooms);
                $url_params.='&s[mnb]='.$arr_bedrooms[0];
                if(isset($arr_bedrooms[1]))
                {
                    $url_params.='&s[mxb]='.$arr_bedrooms[1]; 
                }
            }
            if($this->_debug)
                echo $url_params;
            include_once dirname( __FILE__ ) . '/results_view.php'; 
        }
        
    }
    /*
     * Function to convert property types to the format the iframe would understand
     */
    public function getPropertyTypesForIframe($ad_type,$property_type)
    {
        $type = null;
        
        switch($ad_type)
        {
            case "sale":
                switch($property_type)
                {
                    case "house":
                        $type = 1;
                        break;
                    case "apartment":
                        $type = 2;
                        break;
                    case "duplex":
                        $type = 3;
                        break;
                    case "bungalow":
                        $type = 4;
                        break;
                    case "site":
                        $type = 5;
                        break;
                }
                break;
            case "rental":
                switch($property_type)
                {
                    case "apartment":
                        $type = 1;
                        break;
                    case "house":
                        $type = 2;
                        break;
                    case "studio":
                        $type = 3;
                        break;
                    case "flat":
                        $type = 4;
                        break;
                }
                break;
            case "new_development":
                switch($property_type)
                {
                    case "house":
                        $type = 1;
                        break;
                    case "apartment":
                        $type = 2;
                        break;
                    case "duplex":
                        $type = 3;
                        break;
                    case "bungalow":
                        $type = 4;
                        break;
                }
                break;
        }
        
        return $type;
    }
    /*
     * Function to make all calls to API
     */
    private function _execApiCall($url,$params)
    {
        $request_url = $this->_api_url.$url.'?parameters='.$params;
        
        $json_response = file_get_contents($request_url);
        
        return json_decode($json_response);
    }
    
}
?>