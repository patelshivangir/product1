<?php 
$counter = $_REQUEST['counter'];
$optionID = $_REQUEST['optionID'];


?>
<div class='row value_row' id="valueRow_<?php echo $optionID.'_'.$counter; ?>" data-id=<?php echo $optionID.'_'.$counter; ?>>
    <div class='col-md-6'>
        <div class='form-group' id="title_div_<?php echo $optionID.'_'.$counter; ?>">
            <input type='text' class='form-control' id="multiValueTitle_<?php echo $optionID.'_'.$counter; ?>" name="multiValueTitle[<?php echo $optionID; ?>][<?php echo $counter; ?>][0]" value="">
        </div>
   </div>
    <div class='col-md-5'>
        <div class='form-group'>
            <input type='text' class='form-control multiValuePrice' id='multiValuePrice_<?php echo $optionID.'_'.$counter; ?>' name="multiValuePrice[<?php echo $optionID; ?>][<?php echo $counter; ?>][0]" value="">
        </div>
    </div>
    <div class='col-md-1'>
        <div class='form-group'>
            <button type='button' id='<?php echo $optionID.'_'.$counter; ?>' class='valremove error' data-option-id="<?php echo $optionID; ?>"><span><i class='fa fa-trash' aria-hidden='true'></i></span></button>
        </div>
    </div>
</div>