
<?php
function table($headers,$datas=[],$class=[])
{ 

    ?>

            <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 md:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 md:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider text-center"><input type="checkbox" id="selall" onchange="toggleall(event)" /></th>
                        <?php
                            foreach($headers as $header){
                                echo '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider text-center">'.$header.'</th>';
                            }
                        ?>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="tbody">
                    <?php
                    $i=0;
                    foreach($datas as $data){//row
                        echo '<tr>';
                        echo '<td class="text-center"><input type="checkbox" id="cb'.$data['Id'].'" value="'.$data['Id'].'" /></td>';
                        foreach($data as $d=>$val){//column
                            $className='px-6 py-4 whitespace-nowrap text';//default class\
                            $td='p-3';
                            // if($class!==[]){
                            //     $keys=array_keys($class);
                            //     if($headers[$i]===$keys[$i]){
                            //         switch($class[$keys[$i]]){
                            //             case 'status-yellow':
                            //                 $className='px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-yellow-800';
                            //             break;
                            //         }
                            //     }
                            // }
                            if(in_array($d,array_keys($class))){
                                $className='';
                                if(strpos($class[$d],'status')!==false){
                                    $className.='px-2 inline-flex text-xs leading-5 font-semibold rounded-full';
                                    if(strpos($class[$d],'yellow')!==false)
                                        $className.=' bg-yellow-500 text-yellow-800';
                                    else
                                        $className.=' bg-gray-500 text-gray-800';
                                }
                                // if(strpos($class[$d],'txtcenter')!==false)
                                //     $className.='text-center';
                                if(strpos($class[$d],'td')!==false){
                                    if(strpos($class[$d],'center')!==false)
                                        $td.=' text-center';
                                }
                            }
                            if(is_array($val)){
                                
                                // foreach($val as $k=>$v)
                                //     echo "<span class='$className'>$v</span><b>dfsd</b>";
                            }
                            else{
                                echo "<td class='$td'>";
                                echo "<span class='$className'>$val</span>";
                                echo "</td>";
                            }
                            $i++;
                        }
                        echo '</tr>';
                    }
                    ?>
                        <!-- <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                        </span> -->
        
                    <!-- More rows... -->
                    </tbody>
                </table>
                </div>
            </div>
            </div>
        </div>

  <?php
}

?>
      