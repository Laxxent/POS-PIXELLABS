<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><?php echo e(__('Sales')); ?></span>
                    <a href="<?php echo e(route('sales.create')); ?>" class="btn btn-primary btn-sm">Tambah Data Penjualan</a>
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
                                    <th><?php echo e(__('Date')); ?></th>
                                    <th><?php echo e(__('Customer')); ?></th>
                                    <th><?php echo e(__('Total')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $sales ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($sale->id); ?></td>
                                    <td><?php echo e($sale->date); ?></td>
                                    <td><?php echo e($sale->customer->name ?? 'N/A'); ?></td>
                                    <td><?php echo e(number_format($sale->total, 2)); ?></td>
                                    <td><?php echo e($sale->status); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('sales.show', $sale->id)); ?>" class="btn btn-info btn-sm"><?php echo e(__('View')); ?></a>
                                        <a href="<?php echo e(route('sales.edit', $sale->id)); ?>" class="btn btn-primary btn-sm"><?php echo e(__('Edit')); ?></a>
                                        <form action="<?php echo e(route('sales.destroy', $sale->id)); ?>" method="POST" style="display: inline-block;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><?php echo e(__('Delete')); ?></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center"><?php echo e(__('No sales found.')); ?></td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if(isset($sales) && $sales->hasPages()): ?>
                        <div class="mt-4">
                            <?php echo e($sales->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\PIXELLABS\Aplikasi POS Cursor\resources\views/sales/index.blade.php ENDPATH**/ ?>