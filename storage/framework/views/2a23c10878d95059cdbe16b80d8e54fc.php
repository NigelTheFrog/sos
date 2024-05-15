    
    <form method="post" action="<?php echo e(route('user.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="container-lg" style="height: 70vh;">
            <?php if($importedUser > 0): ?>
                <input type="text" name="type" value="2" hidden>
                <div class="ms-4 mb-3">
                    <input class="form-check-input" type="checkbox" value="" id="ceksemuauser">
                    <label for="ceksemuauser" class="form-check-label">
                        Centang Semua
                    </label>
                </div>
                <div style="overflow: auto; max-height: 66vh;">
                    <table id="tableUser" class="mb-2 table table-sm table-hover table-striped table-bordered text-nowrap">
                        <thead class="table-dark">
                            <tr class="text-center ">
                                <th></th>
                                <th scope="col">Nama</th>
                                <th scope="col">NIK</th>
                                <th scope="col">Username</th>  
                                <th scope="col">User Id</th>                              
                            </tr>
                        </thead>
                        <tbody class="small">
                            <?php $__currentLoopData = $importedUser->data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" name="checkboxImport[]"
                                                    class="form-check-input cekboxsemuauser"
                                                    value=<?php echo e($user->UserID); ?>>
                                            </div>
                                        </td>
                                        <td><?php echo e($user->FullName); ?></td>
                                        <td><?php echo e($user->NIK); ?></td>
                                        <td><?php echo e($user->username); ?></td>
                                        <td><?php echo e($user->UserID); ?></td>                                        
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        <hr>
        <?php if($importedUser > 0): ?>
            <div class="float-end d-flex" >
                <button type="submit" class="btn btn-primary float-end">Impor</button>
                <button type="button" class="ms-2 btn btn-primary float-end" data-bs-dismiss="modal"
                    aria-label="Close">Keluar</button>
            </div>
        <?php endif; ?>
    </form>
    
    <script>
        $(function() {
        $("#tableUser").DataTable({
            "responsive": true,
        });
    });
        $(document).ready(function() {
            $("#ceksemuauser").click(function() {
                if ($(".cekboxsemuauser").prop("checked")) {
                    $(".cekboxsemuauser").prop("checked", false);
                } else {
                    $(".cekboxsemuauser").prop("checked", true);
                }
            });
        });
    </script>
<?php /**PATH /var/www/html/sos-dev/resources/views/admin/master/table/table-user.blade.php ENDPATH**/ ?>