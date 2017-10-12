<?php
/*
 * The following if block will apply when settings are saved
 */
if($_POST['save_daft_data'] == 'Y') 
{    
    $daft_results_page_id = $_POST['daft_results_page_id'];    
    update_option('daft_results_page_id', $daft_results_page_id);
    $daft_debug_mode = $_POST['daft_debug_mode'];    
    update_option('daft_debug_mode', $daft_debug_mode);
?>  
<div class="updated"><p><strong><?php _e('Daft Widget Display Options Saved.' ); ?></strong></p></div>  
<?php  
} 
/*
 * The following applies when the form is loaded, to retreive the current values of the 
 * plugin options
 */
else 
{  
    $daft_results_page_id = get_option('daft_results_page_id');
    $daft_debug_mode = get_option('daft_debug_mode');
}  
?>  
<div class="wrap">  
    <h2>Daft Search Widget Settings</h2>
    
    <form name="daft_form" method="post" >    
    
        <input type="hidden" name="save_daft_data" value="Y">  
        
        <p>
            <?php _e("PAGE ID to display property results : " ); ?>
            <input type="text" name="daft_results_page_id" value="<?php echo $daft_results_page_id; ?>" size="20">
        </p> 
        
        <p>
            <?php _e("Switch debug mode on/off : " ); ?>
            <input type="text" name="daft_debug_mode" value="<?php echo $daft_debug_mode; ?>" size="20">
        </p> 
        
        <p class="submit">  
           <input type="submit" name="update" value="update" />  
        </p>  
        
    </form>  
</div>  
