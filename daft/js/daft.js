jQuery(function(){
    jQuery("select#adType").change(DaftSearch.getAll(jQuery("select#adType option:selected").val()));
});

function ajaxPost(postData, successFunc, errorFunc){
    jQuery.post(ajaxPath, postData, function(data){
        if(data._fail == true){
            errorFunc(data);
	}else{				
            successFunc(data);
	}
    }, 'json').error( function(){
        alert("Error:\n\nWe're sorry, but there was a problem with this request.\nPlease try again later.")
    });
}

var DaftSearch = {};

DaftSearch.getAll = function(adType) {
    
    DaftSearch.getPropertyTypes(adType);
    DaftSearch.getAreas(adType);
    
    var arrSale = ['sale','new_development'];
    var arrRent = ['shortterm','sharing','rental'];
    
    if(adType!='')
    {
        if(jQuery.inArray(adType,arrSale)>-1){
            jQuery('#rentPrices').hide();
            jQuery('#salesPrices').show();
        }

        else if(jQuery.inArray(adType,arrRent)>-1){
            jQuery('#salesPrices').hide();
            jQuery('#rentPrices').show();
        }
        
        else {
            jQuery('#rentPrices').hide();
            jQuery('#salesPrices').hide();
        }
    }
    else {
        jQuery('#rentPrices').hide();
        jQuery('#salesPrices').hide();
    }
}

DaftSearch.getAreas = function(adType) {
    jQuery('select#areas')
    .find('option')
    .remove()
    .end();
    
    if(adType!='')
    {
        var data = {
            method: 'areas',
            ad_type : adType
        };

        ajaxPost(data, this.populateAreas, this.errPost); 
    }
}

DaftSearch.getPropertyTypes = function(adType){
    
    
    jQuery('select#propertyType')
    .find('option')
    .remove()
    .end();
    
    if(adType!='')
    {
        var data = {
            method: 'propertyTypes',
            ad_type : adType
        };

        ajaxPost(data, this.populatePropertyTypes, this.errPost); 
    }
};

DaftSearch.populatePropertyTypes = function(data){
    jQuery.each( data, function(index , item ) {
        jQuery('select#propertyType').append(jQuery('<option>', { 
            value: item.key,
            text : item.plural 
        }));
    });
};

DaftSearch.populateAreas = function(data){
    jQuery.each( data, function(index , item ) {
        jQuery('select#areas').append(jQuery('<option>', { 
            value: item.id,
            text : item.name 
        }));
    });
};

DaftSearch.errPost = function(data){
    /*
     * @TODO error handling!
     */
};