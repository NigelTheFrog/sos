<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title'); ?></title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/font-bunny/fonts.bunny.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/styles.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap4-1-3.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap5-3-2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap-icon/bootstrap-icons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/virtual-select.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/sweet-alert2.min.css')); ?>">

    <script src="<?php echo e(asset('assets/js/bootstrap@5.3.2.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/fontawesome.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery-3-3-1.slim.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/scripts.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/ajax.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery-3.3.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/virtual-select.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/sweet-alert2.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery-3.7.0.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery.dataTables.1.13.7.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/dataTables.searchBuilder.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/dataTables.dateTime.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/dataTables.bootstrap5.min.js')); ?>"></script>
    <?php echo $__env->yieldContent('styles'); ?>
    
</head>

<body>
    <?php echo $__env->make('layouts.inc.admin-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div id="layoutSidenav">
        <?php echo $__env->make('layouts.inc.admin-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div id="layoutSidenav_content">
            <main class="pb-3" style="background-color:rgb(234, 234, 234); height: 100%;">
                <?php if(session('status')): ?>
                    <div class="alert alert-success"><?php echo e(session('status')); ?></div>
                <?php elseif(session('error')): ?>
                    <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                <?php endif; ?>
                <?php echo $__env->yieldContent('content'); ?>
            </main>
            <?php echo $__env->make('layouts.inc.admin-footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</body>

</html>
<?php /**PATH /var/www/html/sos-dev/resources/views/layouts/master.blade.php ENDPATH**/ ?>