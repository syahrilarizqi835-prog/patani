
<?php $__env->startSection('page-title', 'Transaksi Premium'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <h1 class="text-2xl font-bold text-gray-800">Manajemen Transaksi Premium</h1>

    <?php if(session('success')): ?>
    <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
        <i class="fas fa-check-circle mr-2"></i> <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-center">
            <p class="text-3xl font-bold text-yellow-600"><?php echo e($stats['pending']); ?></p>
            <p class="text-sm text-yellow-700">Menunggu Bayar</p>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">
            <p class="text-3xl font-bold text-blue-600"><?php echo e($stats['menunggu_konfirmasi']); ?></p>
            <p class="text-sm text-blue-700">Bukti Dikirim</p>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
            <p class="text-3xl font-bold text-green-600"><?php echo e($stats['aktif']); ?></p>
            <p class="text-sm text-green-700">Aktif</p>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow border overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">Petani</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">Paket</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">Harga</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">Metode</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">Bukti</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__currentLoopData = $transaksiList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $badge = $t->status_badge; ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <p class="font-semibold text-gray-800 text-sm"><?php echo e($t->user->name); ?></p>
                        <p class="text-xs text-gray-500"><?php echo e($t->user->email); ?></p>
                        <p class="text-xs text-gray-400"><?php echo e($t->created_at->format('d M Y H:i')); ?></p>
                    </td>
                    <td class="px-4 py-3">
                        <span class="font-semibold text-sm"><?php echo e($t->paket_label); ?></span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="font-bold text-green-600"><?php echo e($t->harga_format); ?></span>
                    </td>
                    <td class="px-4 py-3 text-sm capitalize">
                        <?php echo e(str_replace('_', ' ', $t->metode_bayar ?? '-')); ?>

                    </td>
                    <td class="px-4 py-3">
                        <?php if($t->bukti_bayar): ?>
                            <a href="<?php echo e(Storage::url($t->bukti_bayar)); ?>" target="_blank">
                                <img src="<?php echo e(Storage::url($t->bukti_bayar)); ?>"
                                    class="w-16 h-16 object-cover rounded-lg border hover:opacity-80 transition"
                                    onerror="this.onerror=null;this.parentElement.innerHTML='<span class=\'text-xs text-red-400\'>Gagal muat</span>'">
                            </a>
                        <?php else: ?>
                            <span class="text-xs text-gray-400">Belum ada</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs font-bold rounded-full
                            <?php echo e($badge['color'] === 'green'  ? 'bg-green-100 text-green-700'   :
                               ($badge['color'] === 'yellow' ? 'bg-yellow-100 text-yellow-700' :
                               ($badge['color'] === 'blue'   ? 'bg-blue-100 text-blue-700'     :
                               ($badge['color'] === 'red'    ? 'bg-red-100 text-red-700'       : 'bg-gray-100 text-gray-700')))); ?>">
                            <?php echo e($badge['label']); ?>

                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col gap-2">

                            
                            <?php if($t->status === 'menunggu_konfirmasi'): ?>
                            <div class="flex gap-2">
                                <form action="<?php echo e(route('admin.transaksi.konfirmasi', $t->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit"
                                        class="bg-green-600 text-white text-xs px-3 py-1 rounded-lg hover:bg-green-700"
                                        onclick="return confirm('Konfirmasi transaksi ini?')">
                                        <i class="fas fa-check mr-1"></i>Konfirmasi
                                    </button>
                                </form>
                                <form action="<?php echo e(route('admin.transaksi.tolak', $t->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit"
                                        class="bg-yellow-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-yellow-600"
                                        onclick="return confirm('Tolak transaksi ini?')">
                                        <i class="fas fa-times mr-1"></i>Tolak
                                    </button>
                                </form>
                            </div>
                            <?php endif; ?>

                            
                            <form action="<?php echo e(route('admin.transaksi.hapus', $t->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                    class="bg-red-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-red-600 w-full"
                                    onclick="return confirm('Yakin ingin menghapus transaksi ini? Data tidak bisa dikembalikan.')">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="p-4 border-t"><?php echo e($transaksiList->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\patani\laravel-patani\resources\views/admin/transaksi.blade.php ENDPATH**/ ?>