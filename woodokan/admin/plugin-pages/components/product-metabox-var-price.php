<?php
$expcod_post = get_post();
   if(!empty( $expcod_post )){
    $expcod_var_prices       =  get_post_meta($expcod_post->ID,'woodokan_var_price')[0] ;

   }

   if(!empty($expcod_var_prices)){ 
    print_r($expcod_var_prices);
    $wd_var_prices = json_decode($expcod_var_prices);
   }

 
?>
<style>
    .woodoan-var-price-container{
        padding: 10px ;
        background-color: #f4f4f4;
    }
    .woodokan-var-price{
        display: flex;
        justify-content: space-evenly;
        background-color: white;
        padding: 10px;
    }
    .woodokan-var-price input {
        max-width: 100%;
    }
</style>
<script src="<?php echo  EXPCOD_URL .'assets/js/html5sortable.min.js' ?>"></script>
<div class="codexpress">
    <div class="woodoan-var-price-container">
        <?php foreach($wd_var_prices as $price): ?>
        <div class="woodokan-var-price">
            <div class="col-md-6" style="width:40%">
                <input name="input_id" type="text" value="<?php echo $price->var_price_label ?>">
            </div>
            <div class="col-md-6" style="width:40%">
                <input name="input_id" type="text" value="<?php echo $price->var_price_price ?>">
            </div>
            <div class="col-md-6" style="width:40%">
                <input name="input_id" type="text" value="<?php echo $price->var_price_price ?>">
            </div>
            <div class="col-md-6" style="width:20%">
                <a href="javascript:void(0)" class="button button-small button-secondary delete-row">delete</a>
            </div>
        </div>
        <?php endforeach; ?>
      
    </div>
    <input type="hidden" name="woodokan_var_price" id="woodokan_var_price">
    <a href="javascript:void(0)" class="button button-small button-secondary add-row" style="margin-top:20px">add new row</a>
</div>

<script>
    var woodokan_var_price = document.getElementById('woodokan_var_price');
document.addEventListener('DOMContentLoaded', function() {
    // Function to handle input value change
    function handleInputChange() {
        woodokan_var_price.value = JSON.stringify(sortable('.woodoan-var-price-container', 'serialize')[0].items)
       
    }

    // Function to handle row deletion
    function handleRowDeletion() {
       
        var row = this.closest('.woodokan-var-price');
        row.parentNode.removeChild(row);
        woodokan_var_price.value = JSON.stringify(sortable('.woodoan-var-price-container', 'serialize')[0].items)
    }

    // Function to handle row addition
    function handleRowAddition() {
        console.log("Row added");
        var newRow = document.createElement('div');
        newRow.className = 'woodokan-var-price';
        newRow.innerHTML = '<div class="col-md-6" style="width:40%">' +
            '<input name="input_id" type="text" value="">' +
            '</div>' +
            '<div class="col-md-6" style="width:40%">' +
            '<input name="input_id" type="text" value="">' +
            '</div>' +
            '<div class="col-md-6" style="width:20%">' +
            '<a href="javascript:void(0)" class="button button-small button-secondary delete-row">delete</a>' +
            '</div>';
        document.querySelector('.woodoan-var-price-container').appendChild(newRow);

        // Attach event listener to the delete button of the newly added row
        var newDeleteButton = newRow.querySelector('.delete-row');
        newDeleteButton.addEventListener('click', handleRowDeletion);

        // Attach event listeners to the input fields of the newly added row
        var newInputFields = newRow.querySelectorAll('input[name="input_id"]');
        newInputFields.forEach(function(input) {
            input.addEventListener('input', handleInputChange);
        });
        woodokan_var_price.value = JSON.stringify(sortable('.woodoan-var-price-container', 'serialize')[0].items)
    }

    // Attach event listeners to the delete buttons of existing rows
    var deleteButtons = document.getElementsByClassName('delete-row');
    for (var i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', handleRowDeletion);
    }

    // Attach event listener to the add new row button
    var addRowButton = document.getElementsByClassName('add-row')[0];
    addRowButton.addEventListener('click', handleRowAddition);

    // Attach event listeners to the input fields of existing rows
    var inputFields = document.querySelectorAll('.woodokan-var-price input[name="input_id"]');
    inputFields.forEach(function(input) {
        input.addEventListener('input', handleInputChange);
    });
});

sortable('.woodoan-var-price-container',{
        itemSerializer: (serializedItem, sortableContainer) => {
            return {
                position: serializedItem.index,
              var_price_label: serializedItem.node.children[0].children[0].value,
              var_price_price :serializedItem.node.children[1].children[0].value,
              var_price_quantity :serializedItem.node.children[1].children[0].value
            }
        }
    });
    woodokan_var_price.value = JSON.stringify(sortable('.woodoan-var-price-container', 'serialize')[0].items)
</script>
