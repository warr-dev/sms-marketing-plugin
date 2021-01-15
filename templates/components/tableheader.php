<div class="pt-2 relative mx-auto text-gray-600 flex justify-between items-baseline">
    <div class="flex items-baseline">
        <?php include 'searchbar.php'; ?>
        <button  type="button" class="border border-indigo-500 text-indigo-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-indigo-600 focus:outline-none focus:shadow-outline mx-3" onclick="openModal()">Send SMS</button>
        <button  type="button" class="border border-teal-500 text-teal-500 rounded-md px-2 py-2 transition duration-500 ease select-none hover:text-white hover:bg-teal-600 focus:outline-none focus:shadow-outline mx-3" onclick="window.location.href='public.php?templating'">SMS Templates</button>
    </div>
    <div>
        <span>Remaining credits: <span class="text-blue-500 px-5"><?php echo $balance; ?></span></span>
    </div>
</div>