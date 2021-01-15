<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS Plugin</title>
    <link rel="stylesheet" href="public/tw.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
		.animated {
			-webkit-animation-duration: 1s;
			animation-duration: 1s;
			-webkit-animation-fill-mode: both;
			animation-fill-mode: both;
		}

		.animated.faster {
			-webkit-animation-duration: 500ms;
			animation-duration: 500ms;
		}

		.fadeIn {
			-webkit-animation-name: fadeIn;
			animation-name: fadeIn;
		}

		.fadeOut {
			-webkit-animation-name: fadeOut;
			animation-name: fadeOut;
		}

		@keyframes fadeIn {
			from {
				opacity: 0;
			}

			to {
				opacity: 1;
			}
		}

		@keyframes fadeOut {
			from {
				opacity: 1;
			}

			to {
				opacity: 0;
			}
		}
	</style>
</head>
<body class="bg-gray-200">
    <?php include 'components/header.php'; ?>
    
    <?php include 'components/alerts.php'; ?>

    <!-- contents go inside here -->
    <div class="m-10 p-5 border-black-800 border-solid bg-gray-300 rounded-md shadow divide-y">
        <div class="flex justify-between pb-3">
            <?php
                include 'components/searchbar.php';
            ?>
            <div class="flex items-start">
                <button type="button" class="border border-indigo-500 text-indigo-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-indigo-600 focus:outline-none focus:shadow-outline mx-4"
                onclick="window.location.href='public.php?download'">
                    Backup Templates
                </button>
                <div>
                    <button type="button" class="border border-teal-500 text-teal-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-teal-600 focus:outline-none focus:shadow-outline mx-4"
                    onclick="dropup(this)">
                        Restore Templates
                    </button>
                    <div class="relative hidden">
                    <div class="absolute p-4 border border-black-400 bg-gray-500 rounded flex rounded-md" style="right:1rem" id="popop">
                        <i class="fa fa-close -ml-4 -mt-4 text-red-800" onclick="this.parentNode.parentNode.classList.add('hidden')"></i>
                        <form action="public.php?upload" method="post" enctype="multipart/form-data" class="flex items-baseline" onsubmit="return validate()">
                            <input accept=".json" type="file" id="rfile" name="template" /><button class="border border-green-500 text-green-500 rounded-md px-2 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-green-600 focus:outline-none focus:shadow-outline bg-gray-300">Restore</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>

        </div>
        
        <div>
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 md:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 md:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-md">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider text-center">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider text-center">Content</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php
                                        foreach($temps as $template){
                                            echo '<tr class="p-1">';
                                            echo '<td class="py-3 px-5">'.$template->name.'</td>';
                                            echo '<td class="py-3 px-5">'.$template->content.'</td>';
                                            echo '<td class="py-3 px-5 text-blue-500"><i class="fa fa-edit" onclick="updatetemp('.$template->id.',this)"></i> | <i class="fa fa-trash" onclick="delcon('.$template->id.')"></i></td>';
                                            echo '</tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <div class="flex justify-between p-3">
                                <button type="button" class="border border-gray-700 text-gray-700 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-gray-800 focus:outline-none focus:shadow-outline"
                                    onclick="window.location.href='public.php'">
                                    <i class="fa fa-arrow-circle-o-left "></i> Back
                                </button>
                                
                                <button type="button" class="border border-green-500 text-green-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-green-600 focus:outline-none focus:shadow-outline mx-4"
                                onclick="addtemp()">
                                Add Template
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'components/tmodal.php' ?>
    <?php include 'components/tscript.php' ?>
</body>
</html>