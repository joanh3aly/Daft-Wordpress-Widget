<?php
/*
 * Include jQuery only if it hasn't been loaded somewhere else...
 * Also remove if appropriate
 */
?>
<script type="text/javascript">
if(typeof jQuery == 'undefined')
{
    document.write('<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></'+'script>');
}
</script>

<?php
/*
 * Include the plugin JS which takes care of populating the drop downs...
 * Initialize the ajaxPath variable
 */
?>
<script type="text/javascript">
var ajaxPath = '<?php echo plugin_dir_url('daft/ajax.php').'ajax.php';  ?>';
</script>
<script src="<?php echo plugin_dir_url('daft/js/daft.js').'daft.js';?>"></script>
<?php
/*
 * The rest is the actual search form. It can be customised using css 
 * using the daft-search class
 */
?>
<style>
   .daft-search #adType{width:100%}
   .daft-search #areas{width:100%}  
   .daft-search #propertyType{width:100%}
   .daft-search #salesPrices{width:100%}
   .daft-search #rentPrices{width:100%}
   .daft-search .minMaxBed{clear: left;width:31%}    
   .daft-search select {font-size: 12px; margin-bottom: 4px; padding: 3px 0;} 
   .daft-search fieldset {border:0;padding:0;margin:0}
</style>
<form name="daftSearch" method="POST" action="<?php echo get_page_link($data->page); ?>" class="daft-search">
    <fieldset>
        <select  id="adType" name="ad_type" onchange="DaftSearch.getAll(this.value)">
            <option value="">Select an ad type...</option> 
            <?php
            foreach($data->ad_types as $ad_type)
            {
            ?>
            <option value="<?php echo $ad_type->name; ?>"><?php echo $ad_type->desc_plural; ?></option>
            <?php
            }
            ?>
        </select>
        <select id="propertyType" name="property_type">
            <option value="">---</option>
        </select>
        <select id="areas" name="area">
            <option value="">---</option>
        </select>
        <div id="salesPrices" style="display: none;">
        
            
            <select id="saleMinPrice" name="sale_min_price" class="minMaxBed">
                <option value="">No Min</option>
                <option value="25000">&euro;25,000</option><option value="50000">&euro;50,000</option><option value="75000">&euro;75,000</option><option value="100000">&euro;100,000</option><option value="125000">&euro;125,000</option><option value="150000">&euro;150,000</option><option value="175000">&euro;175,000</option><option value="200000">&euro;200,000</option><option value="225000">&euro;225,000</option><option value="250000">&euro;250,000</option><option value="275000">&euro;275,000</option><option value="300000">&euro;300,000</option><option value="325000">&euro;325,000</option><option value="350000">&euro;350,000</option><option value="375000">&euro;375,000</option><option value="400000">&euro;400,000</option><option value="425000">&euro;425,000</option><option value="450000">&euro;450,000</option><option value="475000">&euro;475,000</option><option value="500000">&euro;500,000</option><option value="550000">&euro;550,000</option><option value="600000">&euro;600,000</option><option value="650000">&euro;650,000</option><option value="700000">&euro;700,000</option><option value="750000">&euro;750,000</option><option value="800000">&euro;800,000</option><option value="850000">&euro;850,000</option><option value="900000">&euro;900,000</option><option value="950000">&euro;950,000</option><option value="1000000">&euro;1,000,000</option><option value="1250000">&euro;1,250,000</option><option value="1500000">&euro;1,500,000</option><option value="1750000">&euro;1,750,000</option><option value="2000000">&euro;2,000,000</option><option value="2250000">&euro;2,250,000</option><option value="2500000">&euro;2,500,000</option><option value="2750000">&euro;2,750,000</option><option value="3000000">&euro;3,000,000</option><option value="3500000">&euro;3,500,000</option><option value="4000000">&euro;4,000,000</option><option value="4500000">&euro;4,500,000</option><option value="5000000">&euro;5,000,000</option>                
            </select>
            
            <select id="saleMaxPrice" name="sale_max_price" class="minMaxBed">
                <option value="">No Max</option>
                <option value="25000">&euro;25,000</option><option value="50000">&euro;50,000</option><option value="75000">&euro;75,000</option><option value="100000">&euro;100,000</option><option value="125000">&euro;125,000</option><option value="150000">&euro;150,000</option><option value="175000">&euro;175,000</option><option value="200000">&euro;200,000</option><option value="225000">&euro;225,000</option><option value="250000">&euro;250,000</option><option value="275000">&euro;275,000</option><option value="300000">&euro;300,000</option><option value="325000">&euro;325,000</option><option value="350000">&euro;350,000</option><option value="375000">&euro;375,000</option><option value="400000">&euro;400,000</option><option value="425000">&euro;425,000</option><option value="450000">&euro;450,000</option><option value="475000">&euro;475,000</option><option value="500000">&euro;500,000</option><option value="550000">&euro;550,000</option><option value="600000">&euro;600,000</option><option value="650000">&euro;650,000</option><option value="700000">&euro;700,000</option><option value="750000">&euro;750,000</option><option value="800000">&euro;800,000</option><option value="850000">&euro;850,000</option><option value="900000">&euro;900,000</option><option value="950000">&euro;950,000</option><option value="1000000">&euro;1,000,000</option><option value="1250000">&euro;1,250,000</option><option value="1500000">&euro;1,500,000</option><option value="1750000">&euro;1,750,000</option><option value="2000000">&euro;2,000,000</option><option value="2250000">&euro;2,250,000</option><option value="2500000">&euro;2,500,000</option><option value="2750000">&euro;2,750,000</option><option value="3000000">&euro;3,000,000</option><option value="3500000">&euro;3,500,000</option><option value="4000000">&euro;4,000,000</option><option value="4500000">&euro;4,500,000</option><option value="5000000">&euro;5,000,000</option>                
            </select>
            
            <select id="bedrooms" name="bedrooms" class="minMaxBed">
                <option value="">Rooms</option>
                <option value="1|2">1-2 Bed</option>
                <option value="2|3">2-3 Bed</option>
                <option value="3|4">3-4 Bed</option>
                <option value="5">5+ Bed</option>      
            </select>
        </div>
       
        <div id="rentPrices" style="display: none;">
            
            <select id="rentMinPrice" name="rent_min_price" class="minMaxBed">
                <option value="">No Min</option>
                <option value="300">&euro;300</option><option value="400">&euro;400</option><option value="500">&euro;500</option><option value="600">&euro;600</option><option value="700">&euro;700</option><option value="800">&euro;800</option><option value="900">&euro;900</option><option value="1000">&euro;1,000</option><option value="1100">&euro;1,100</option><option value="1200">&euro;1,200</option><option value="1300">&euro;1,300</option><option value="1400">&euro;1,400</option><option value="1500">&euro;1,500</option><option value="1600">&euro;1,600</option><option value="1700">&euro;1,700</option><option value="1800">&euro;1,800</option><option value="1900">&euro;1,900</option><option value="2000">&euro;2,000</option><option value="2100">&euro;2,100</option><option value="2200">&euro;2,200</option><option value="2300">&euro;2,300</option><option value="2400">&euro;2,400</option><option value="2500">&euro;2,500</option><option value="2600">&euro;2,600</option><option value="2700">&euro;2,700</option><option value="2800">&euro;2,800</option><option value="2900">&euro;2,900</option><option value="3000">&euro;3,000</option><option value="3100">&euro;3,100</option><option value="3200">&euro;3,200</option><option value="3300">&euro;3,300</option><option value="3400">&euro;3,400</option><option value="3500">&euro;3,500</option><option value="3600">&euro;3,600</option><option value="3700">&euro;3,700</option><option value="3800">&euro;3,800</option><option value="3900">&euro;3,900</option><option value="4000">&euro;4,000</option><option value="4100">&euro;4,100</option><option value="4200">&euro;4,200</option><option value="4300">&euro;4,300</option><option value="4400">&euro;4,400</option><option value="4500">&euro;4,500</option><option value="4600">&euro;4,600</option><option value="4700">&euro;4,700</option><option value="4800">&euro;4,800</option><option value="4900">&euro;4,900</option><option value="5000">&euro;5,000</option>                    
            </select>
           
            <select id="rentMaxPrice" name="rent_max_price" class="minMaxBed">
                <option value="">No Max</option>
                <option value="300">&euro;300</option><option value="400">&euro;400</option><option value="500">&euro;500</option><option value="600">&euro;600</option><option value="700">&euro;700</option><option value="800">&euro;800</option><option value="900">&euro;900</option><option value="1000">&euro;1,000</option><option value="1100">&euro;1,100</option><option value="1200">&euro;1,200</option><option value="1300">&euro;1,300</option><option value="1400">&euro;1,400</option><option value="1500">&euro;1,500</option><option value="1600">&euro;1,600</option><option value="1700">&euro;1,700</option><option value="1800">&euro;1,800</option><option value="1900">&euro;1,900</option><option value="2000">&euro;2,000</option><option value="2100">&euro;2,100</option><option value="2200">&euro;2,200</option><option value="2300">&euro;2,300</option><option value="2400">&euro;2,400</option><option value="2500">&euro;2,500</option><option value="2600">&euro;2,600</option><option value="2700">&euro;2,700</option><option value="2800">&euro;2,800</option><option value="2900">&euro;2,900</option><option value="3000">&euro;3,000</option><option value="3100">&euro;3,100</option><option value="3200">&euro;3,200</option><option value="3300">&euro;3,300</option><option value="3400">&euro;3,400</option><option value="3500">&euro;3,500</option><option value="3600">&euro;3,600</option><option value="3700">&euro;3,700</option><option value="3800">&euro;3,800</option><option value="3900">&euro;3,900</option><option value="4000">&euro;4,000</option><option value="4100">&euro;4,100</option><option value="4200">&euro;4,200</option><option value="4300">&euro;4,300</option><option value="4400">&euro;4,400</option><option value="4500">&euro;4,500</option><option value="4600">&euro;4,600</option><option value="4700">&euro;4,700</option><option value="4800">&euro;4,800</option><option value="4900">&euro;4,900</option><option value="5000">&euro;5,000</option>                    
            </select>
           
            <select id="bedrooms" name="bedrooms" class="minMaxBed">
                <option value="">Rooms</option>
                <option value="1|2">1-2 Bed</option>
                <option value="2|3">2-3 Bed</option>
                <option value="3|4">3-4 Bed</option>
                <option value="5">5+ Bed</option>      
            </select>
            
        </div>
        <button type="submit" class="searchsubmit search-submit">Search</button>
    </fieldset>
</form>
<?php 
echo $dbhost;

?>