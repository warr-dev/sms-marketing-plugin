        <?php $tab=$pageinfo['tab']; ?>
        <div style='border-bottom: 2px solid #eaeaea' class="pt-4">
            <ul class='flex cursor-pointer'>
              <li class='py-2 px-6 bg-white rounded-t-lg <?php echo $tab=='all'?' font-medium':' text-gray-500 bg-gray-200'; ?>' onclick="window.location.href='public.php?tab=all'">All</li>
              <li class='py-2 px-6 bg-white rounded-t-lg <?php echo $tab=='active'?' font-medium':' text-gray-500 bg-gray-200'; ?>' onclick="window.location.href='public.php?tab=active'">Active Client</li>
              <li class='py-2 px-6 bg-white rounded-t-lg <?php echo $tab=='lead'?' font-medium':' text-gray-500 bg-gray-200'; ?>' onclick="window.location.href='public.php?tab=lead'">Client Leads</li>
            </ul>
        </div>