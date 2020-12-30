<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS Plugin</title>
    <link rel="stylesheet" href="public/tw.css">
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
    <?php include 'components/controller.php'; ?>
    <?php include 'components/header.php'; ?>

    <!-- contents go inside here -->
    <div class="m-10 p-5 border-black-800 border-solid bg-gray-300 rounded-md shadow divide-y">
        <?php
            include 'components/tableheader.php';
            include 'components/tabletabs.php';
            table($cols,$clients,$styles);
            pagination($pageinfo);
        ?>
    </div>
    
    <?php include 'components/scripts.php'; ?>
</body>
</html>