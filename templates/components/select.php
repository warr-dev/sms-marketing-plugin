<?php
    function select($options=[]){
        ?>

            <select disabled name="template" class="tracking-wide py-2 px-4 mb-3 leading-relaxed appearance-none block w-full bg-gray-200 border border-gray-200 rounded focus:outline-none focus:bg-white focus:border-gray-500" id="select"
                onchange="templated()"
            >
                <?php
                    foreach($options as $option=>$value){
                        echo '<option value="'.$value.'">'.$option.'</option>';
                    }
                ?>
            </select>

        <?php
    }
?>  