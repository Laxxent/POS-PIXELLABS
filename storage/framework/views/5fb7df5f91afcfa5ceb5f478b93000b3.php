<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><?php echo e(__('Suppliers')); ?></span>
                    <a href="<?php echo e(route('suppliers.create')); ?>" class="btn btn-primary btn-sm">Tambah Data Supplier</a>
                </div>

                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('ID')); ?></th>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Email')); ?></th>
                                    <th><?php echo e(__('Phone')); ?></th>
                                    <th><?php echo e(__('Address')); ?></th>
                                    <th><?php echo e(__('Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $suppliers ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($supplier->id); ?></td>
                                    <td><?php echo e($supplier->name); ?></td>
                                    <td><?php echo e($supplier->email); ?></td>
                                    <td><?php echo e($supplier->phone); ?></td>
                                    <td><?php echo e($supplier->address); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('suppliers.edit', $supplier->id)); ?>" class="btn btn-primary btn-sm"><?php echo e(__('Edit')); ?></a>
                                        <form action="<?php echo e(route('suppliers.destroy', $supplier->id)); ?>" method="POST" style="display: inline-block;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><?php echo e(__('Delete')); ?></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center"><?php echo e(__('No suppliers found.')); ?></td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if(isset($suppliers) && $suppliers->hasPages()): ?>
                        <div class="mt-4">
                            <?php echo e($suppliers->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PIXELLABS\Aplikasi POS Cursor\resources\views/suppliers/index.blade.php ENDPATH**/ ?>