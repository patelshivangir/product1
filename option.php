<?php 
$count = $_REQUEST['count'];

?>
<div id='mainOption_<?php echo $count; ?>' class="singleOption" style="background-color:#DFEAEA; margin-top:2px;">
<div class="row" id="Option_<?php echo $count; ?>" data-id="<?php echo $count; ?>">
    <div class='col-md-5'>
        <div class='form-group opTitleDiv'>
            <label for='title'>Title <span class="error">*</span> :</label>
            <input type='text' class='form-control' id='title_<?php echo $count; ?>' name='optitle[<?php echo $count; ?>][0]' value="">
        </div>
        <span></span>
    </div>
    <div class='col-md-5'>
        <div class='form-group opTypeDiv'>
            <label for='optype'>Option Type <span class="error">*</span> :</label>
            <select id='type_<?php echo $count; ?>' name='optype[<?php echo $count; ?>][0]' class="optype">
                <option value=0 selected>Select option type</option>
                <option value='1'>Field</option>
                <option value='2'>Dropdown</option>
                <option value='3'>Radio</option>
                <option value='4'>checkbox</option>
            </select>
        </div>
        <span></span>
    </div>
    <div class='col-md-1' style="margin-top:5px;">
        <div class='form-group'>
            <label for=''>&nbsp;</label>  
            <button type='button' id='<?php echo $count; ?>' class='opremove'><i class='fa fa-trash' aria-hidden='true' style="color:red;" ></i></button>
        </div>
    </div>
    
</div>