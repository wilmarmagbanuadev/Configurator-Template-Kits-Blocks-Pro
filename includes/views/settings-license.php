<?php
$widgets_class = new Blank_Elements_Pro_Admin_Settings;
$license_key = $widgets_class -> license_key();
$license_key_con = ! empty( $blank_elements_options['license_key'] ) ? $blank_elements_options['license_key'] : ''; 

$license_key_v = $widgets_class -> license_key_v();
$license_key_v_con = ! empty( $blank_elements_options['license_key_v'] ) ? $blank_elements_options['license_key_v'] : ''; 
?>

<div class="elements-list-container">
    <div class="elements-list-section">
        <?php 
        //var_dump(get_option('blank-elements-pro'));
        $l_key = get_option('blank-elements-pro')['license_key'];
        $valid_check =  ($GLOBALS['validator']==1)?'valid':'invalid';
        ?>
        <?php 
        if($l_key==null){
            //do nothing
        }else{
            echo ($l_key != null && $GLOBALS['validator']==1)?'<h5 style="color:green;">Congrats! Valid Key..</h5>':'<h5 style="color:red;">Please input a valid key</h5>';
        }
        
         ?>
        <?php
            $widgets_class->input([
                'type' => 'text',
                'name' => 'blank-elements-pro[license_key]',
                'class' => ($l_key==null)?null:$valid_check,
                'placeholder' => '24550c8cb06076751a80274a52878-us20',
                'value' => $license_key_con,
            ]);
        ?>         
        </div>
    </div>
</div>
