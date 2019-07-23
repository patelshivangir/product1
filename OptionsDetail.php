<?php
$optionID = $_REQUEST['optionID'];
$value = $_REQUEST['value'];
?>
<div class="card-header optionDetail" id="option_detail_<?php echo $optionID; ?>" style="width:600px;">
    <?php if($value == 1){ ?>
   <div class='singleValue' style='font-size:15px;' id='single_option'>
        <div class='row'>
           <div class='col-md-8 single_value_price_div' style="margin-bottom:20px;">
                <label for='stock'>Price :</label>
                <input type='text' class='form-control singleValuePrice' id='singleValuePrice_<?php echo $optionID; ?>' name='singleValuePrice[<?php echo $optionID; ?>][0]' value="">
            </div>
        </div>
    </div>
    <?php }else{ ?>
    <div style='font-size:15px;'>
        <div class='row'>
            <div class='col-md-6'>
                <label for='title'>Title <span class="error">*</span> :</label>
            </div>
            <div class='col-md-6'>
                <label for='price'>Price :</label>
            </div>
        </div>
    </div>
    <input type="hidden" name="valueCounter[<?php echo $optionID; ?>]" id="valueCounter_<?php echo $optionID; ?>" value="0">
    <div id="multipleValue_<?php echo $optionID; ?>"></div>
    <div class='row'>
        <button type='button' id='addValue_<?php echo $optionID; ?>' class='addValue' style='margin :20px; 0px; 20px; 0px;' data-option-id="<?php echo $optionID; ?>">Add Value</button>
    </div>
    <?php } ?>
</div>