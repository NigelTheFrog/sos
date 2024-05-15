<?php $__env->startSection('title', 'Konfirmasi WRH'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-wrapper mt-4">
    <!-- Main content -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header bg-secondary text-white">
                    <h3 class="card-title">Konfirmasi WRH </h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="input-group">
                                <!-- <div class="input-group-prepend"> -->
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <!-- </div> -->
                                <select  id="select-pelaku" name="pelaku" placeholder="Daftar Nama Pelaku" >
                                    
                                    <?php $__currentLoopData = $pelaku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pelaku): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($pelaku->userid); ?>"><?php echo e($pelaku->username); ?> - <?php echo e($pelaku->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                    
                                </select>
                                <button class="btn btn-secondary" onclick="showData(this)" type="button" id="search-button" style="height: 36px;">Cari</button>
                            </div>
                        </div>
                    </div>
                    <div id="listsearch"></div>


                </div>
            </div>
    </section>
</div>

<script>
    document.getElementById("select-pelaku").selectedIndex = -1;
    VirtualSelect.init({
        search: true,
        ele: '#select-pelaku',
        silentInitialValueSet: false,
        maxWidth: '92%',
        noSearchResultsText: "Nama Pelaku tidak ditemukan"
    });

    function showData(button) {
        let pelaku = $('#select-pelaku').val();
        $.ajax({
                url: "<?php echo e(route('konfirmasi-wrh.store')); ?>",
                method: "POST",
                data: {
                    pelaku: pelaku,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('#listsearch').html(data);
                },
                
            });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/sos-dev/resources/views/admin/konfirmasi/konfirmasi-wrh.blade.php ENDPATH**/ ?>