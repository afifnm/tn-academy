<!DOCTYPE html>
<html lang="en" class="light">
    <!-- BEGIN: Head -->
    <head>
        <?php require_once('layout/_header.php');?>

        <!-- BEGIN: CSS Assets-->
        <?php require_once('layout/_css.php');?>
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->

    <body class="main">
        <!-- BEGIN: Mobile Menu -->
        <?php require_once('layout/_mobile_menu.php');?>
        <!-- END: Mobile Menu -->
        <!-- BEGIN: Top Bar -->
        <?php require_once('layout/_topBar.php');?>
        <!-- END: Top Bar -->
        <!-- BEGIN: Top Menu -->
        <?php require_once('layout/_menu.php');?>
        <!-- END: Top Menu -->
        <!-- BEGIN: Content -->
         <div class="wrapper wrapper--top-nav">
            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-12 2xl:col-span-9">
                            <div class="grid grid-cols-12 gap-6">
                                <div class="col-span-12 mt-8">
                                    <?=$contents?>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- END: Content -->
            </div>
        </div>
        <!-- END: Content -->
        <!-- BEGIN: Dark Mode Switcher-->
        <!-- <div data-url="<?= base_url('assets/') ?>top-menu-dark-dashboard-overview-1.html" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
            <div class="mr-4 text-slate-600 dark:text-slate-200">Dark Mode</div>
            <div class="dark-mode-switcher__toggle border"></div>
        </div> -->
        <!-- END: Dark Mode Switcher-->
        
        <!-- BEGIN: JS Assets-->
        <?php require_once('layout/_js.php');?>

        <!-- END: JS Assets-->
    </body>
</html>