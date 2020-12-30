<?php

    function pagination($pageinfo){
        
        $pages=$pageinfo['pages'];
        $page=$pageinfo['page'];
    ?>

        <div class="flex flex-col items-center my-12">
            <div class="flex text-gray-700">
                <div class="h-12 w-12 mr-1 flex justify-center items-center rounded-full bg-gray-200 cursor-pointer <?php echo $page<=1?' text-gray-300':''; ?>" 
                <?php if($page>1){ ?>
                    onclick="window.location.href='public.php?page=<?php echo $page-1; ?>'"
                <?php } ?>>
                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left w-6 h-6">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </div>
                <div class="flex h-12 font-medium rounded-full bg-gray-200">
                    <?php
                        if($pages>2){
                            if($page<=3){
                                for($i=1;$i<=3;$i++){
                                    $class="w-12 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full  ";
                                    $class=$page==$i?$class.' bg-teal-600 text-white':$class;
                                    echo '<div class="'.$class.'" onclick="pager('.$i.')">'.$i.'</div>';
                                    // echo "page:$page i:$i class:$class <br>";
                                }
                                if($pages==4)
                                    echo '<div class="w-12 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full  " onclick="pager(4)">4</div>';
                                if($pages>4){
                                    echo '<div class="w-12 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full  ">...</div>';
                                    echo '<div class="w-12 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full  " onclick="pager('.$pages.')">'.$pages.'</div>';
                                }
                            }
                            else if($page>=$pages-2){
                                if($pages==4)
                                    echo '<div class="w-12 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full  " onclick="pager(1)">1</div>';
                                if($pages>4){
                                    echo '<div class="w-12 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full  " onclick="pager(1)">1</div>';
                                    echo '<div class="w-12 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full  ">...</div>';
                                }
                                for($i=$pages-2;$i<=$pages;$i++){
                                    $class="w-12 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full  ";
                                    $class= $page==$i?$class.' bg-teal-600 text-white':$class;
                                    echo '<div class="'.$class.'" onclick="pager('.$i.')">'.$i.'</div>';
                                }
                            }
                            else{
                                echo '<div class="w-12 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full  " onclick="pager(1)">1</div>';
                                echo '<div class="w-12 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full  ">...</div>';
                                
                                for($i=$page-1;$i<=$page+1;$i++){
                                    $class="w-12 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full  ";
                                    $class= $page==$i?$class.' bg-teal-600 text-white':$class;
                                    echo '<div class="'.$class.'" onclick="pager('.$i.')">'.$i.'</div>';
                                }

                                echo '<div class="w-12 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full  ">...</div>';
                                echo '<div class="w-12 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full  " onclick="pager('.$pages.')">'.$pages.'</div>';

                            }
                        }
                        else
                            for($i=1;$i<=2;$i++){
                                $class="w-12 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full  ";
                                $class= $page==$i?$class.' bg-teal-600 text-white':$class;
                                echo '<div class="'.$class.'" onclick="pager('.$i.')">'.$i.'</div>';
                            }
                        
                    ?>
                </div>
                <div class="h-12 w-12 ml-1 flex justify-center items-center rounded-full bg-gray-200 cursor-pointer  <?php echo $page>=$pages?' text-gray-300':''; ?>"
                <?php if($page<$pages){ ?>
                    onclick="window.location.href='public.php?page=<?php echo $page+1; ?>'"
                <?php } ?>>
                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right w-6 h-6">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </div>
            </div>

    <?php
    }
?>