<?php
/**
 * Respond all ajax calls for the daft search widget
 *
 */
include_once dirname( __FILE__ ) . '/helper.php'; 

$ajaxDaft = new ajaxDaft();

class ajaxDaft {
    
    public $request;
    public $helper;
    
    public function __construct() {
        $this->request = $_POST;
        $this->helper = new DaftSearchHelper();
        if(!empty($this->request['method']))
        {
            $method = $this->request['method'];
            if(method_exists($this, $method))
            {
                $this->$method();
            }
            else
            {
                return json_encode(null);
            }
        }
        else
        {
            return json_encode(null);
        }
    }
    
    public function areas()
    {
        if(!empty($this->request['ad_type']))
        {
            $ad_type = $this->request['ad_type'];
            $areas = $this->helper->loadLocations(1,$ad_type);
            echo $areas;
        }
    }
    
    public function propertyTypes()
    {
        if(!empty($this->request['ad_type']))
        {
            $ad_type = $this->request['ad_type'];
            $property_types = $this->helper->loadPropertyTypes($ad_type,1);
            echo $property_types;
        }
    }
}
?>
