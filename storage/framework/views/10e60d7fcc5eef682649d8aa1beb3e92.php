
<?php $__env->startSection('page-title', 'Notifikasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-5 max-w-3xl">

    
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Notifikasi</h1>
        <p class="text-gray-500 text-sm mt-0.5">Pesan dan pemberitahuan dari Admin PATANI</p>
    </div>

    
    <?php if($notifikasi->isEmpty()): ?>
        <div class="bg-white rounded-xl shadow p-16 text-center text-gray-400">
            <i class="fas fa-bell-slash text-5xl mb-3 block"></i>
            <p class="text-base font-medium">Belum ada notifikasi</p>
            <p class="text-sm mt-1">Notifikasi dari admin akan muncul di sini</p>
        </div>
    <?php else: ?>
        <div class="space-y-3">
            <?php $__currentLoopData = $notifikasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $info = $item->tipe_info;
                $colorMap = [
                    'green'  => ['bg' => 'bg-green-50',  'border' => 'border-green-300', 'icon' => 'bg-green-100 text-green-600'],
                    'red'    => ['bg' => 'bg-red-50',    'border' => 'border-red-300',   'icon' => 'bg-red-100 text-red-600'],
                    'orange' => ['bg' => 'bg-orange-50', 'border' => 'border-orange-300','icon' => 'bg-orange-100 text-orange-600'],
                    'blue'   => ['bg' => 'bg-blue-50',   'border' => 'border-blue-300',  'icon' => 'bg-blue-100 text-blue-600'],
                    'purple' => ['bg' => 'bg-purple-50', 'border' => 'border-purple-300','icon' => 'bg-purple-100 text-purple-600'],
                    'gray'   => ['bg' => 'bg-gray-50',   'border' => 'border-gray-300',  'icon' => 'bg-gray-100 text-gray-500'],
                ];
                $c = $colorMap[$info['color']] ?? $colorMap['gray'];
            ?>

            <div class="bg-white rounded-xl shadow border-l-4 <?php echo e($c['border']); ?> p-5 flex gap-4 items-start">

                
                <div class="flex-shrink-0 w-10 h-10 rounded-full <?php echo e($c['icon']); ?> flex items-center justify-center text-lg">
                    <i class="fas <?php echo e($info['icon']); ?>"></i>
                </div>

                
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2 flex-wrap">
                        <div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium <?php echo e($c['bg']); ?> <?php echo e(str_replace('bg-', 'text-', $c['border'])); ?> mb-1">
                                <?php echo e($info['label']); ?>

                            </span>
                            <h3 class="font-semibold text-gray-800 text-sm leading-snug"><?php echo e($item->judul); ?></h3>
                        </div>
                        <span class="text-xs text-gray-400 whitespace-nowrap flex-shrink-0">
                            <?php echo e($item->created_at->diffForHumans()); ?>

                        </span>
                    </div>

                    <p class="text-sm text-gray-600 mt-1.5 leading-relaxed"><?php echo e($item->pesan); ?></p>

                    
                    <?php if($item->sawah): ?>
                    <div class="mt-2 flex items-center gap-1.5 text-xs text-gray-500">
                        <i class="fas fa-map-marker-alt text-green-500"></i>
                        <span>Sawah: <strong><?php echo e($item->sawah->nama_sawah); ?></strong>
                            — <?php echo e($item->sawah->desa); ?>, <?php echo e($item->sawah->kecamatan); ?>

                        </span>
                    </div>
                    <?php endif; ?>

                    <p class="text-xs text-gray-400 mt-2">
                        <?php echo e($item->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm')); ?> WIB
                        · <span class="text-green-600 font-medium">Admin PATANI</span>
                    </p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <?php if($notifikasi->hasPages()): ?>
        <div class="mt-4"><?php echo e($notifikasi->links()); ?></div>
        <?php endif; ?>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\patani\laravel-patani\resources\views/dashboard/notifikasi.blade.php ENDPATH**/ ?>