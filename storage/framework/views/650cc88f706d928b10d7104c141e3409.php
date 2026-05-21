
<?php $__env->startSection('page-title', 'Detail Diskusi'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-5 max-w-3xl" x-data="forumDetail()">

    
    <div class="flex items-center gap-2 text-sm text-gray-500">
        <a href="<?php echo e(route('dashboard.forum')); ?>" class="hover:text-green-600">
            <i class="fas fa-comments mr-1"></i> Forum Diskusi
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-700 truncate"><?php echo e(\Str::limit($topic->title, 50)); ?></span>
    </div>

    
    <?php if(session('success')): ?>
    <div class="flex items-center gap-2 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
        <i class="fas fa-check-circle text-green-500"></i> <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
    <div class="flex items-center gap-2 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">
        <i class="fas fa-exclamation-circle text-red-500"></i> <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-wrap gap-2 mb-3">
                <?php if($topic->is_pinned): ?>
                <span class="text-xs px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 font-medium">📌 Disematkan</span>
                <?php endif; ?>
                <?php if($topic->is_locked): ?>
                <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 font-medium">🔒 Dikunci Admin</span>
                <?php endif; ?>
                <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700 font-medium">
                    <?php echo e(ucwords(str_replace('_', ' ', $topic->category))); ?>

                </span>
            </div>

            <h1 class="text-xl font-bold text-gray-800 leading-snug"><?php echo e($topic->title); ?></h1>

            <div class="flex items-center gap-4 mt-2 text-xs text-gray-400 flex-wrap">
                <span class="flex items-center gap-1.5">
                    <img src="<?php echo e($topic->user->foto_profil_url); ?>"
                         alt="<?php echo e($topic->user->name); ?>"
                         class="w-5 h-5 rounded-full object-cover">
                    <span class="font-medium text-gray-600"><?php echo e($topic->user->name ?? '-'); ?></span>
                </span>
                <span><?php echo e($topic->created_at->locale('id')->isoFormat('D MMMM Y, HH:mm')); ?></span>
                <span><i class="fas fa-eye mr-1"></i><?php echo e(number_format($topic->views)); ?></span>
                <span><i class="fas fa-comment mr-1"></i><?php echo e($topic->replies->count()); ?> balasan</span>
            </div>
        </div>

        <div class="p-6">
            <div class="text-gray-700 text-sm leading-relaxed whitespace-pre-wrap"><?php echo e($topic->content); ?></div>
        </div>

        <?php if($topic->is_locked && $topic->admin_note): ?>
        <div class="mx-6 mb-4 p-3 bg-orange-50 border border-orange-200 rounded-lg text-sm text-orange-700 flex items-start gap-2">
            <i class="fas fa-info-circle mt-0.5 flex-shrink-0"></i>
            <div><span class="font-medium">Catatan Admin:</span> <?php echo e($topic->admin_note); ?></div>
        </div>
        <?php endif; ?>

        <div class="px-6 pb-5 flex items-center gap-4 border-t border-gray-100 pt-4">
            <form action="<?php echo e(route('dashboard.forum.like', $topic->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-colors
                        <?php echo e($sudahLike ? 'bg-red-100 text-red-600 hover:bg-red-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'); ?>">
                    <i class="fas fa-heart"></i>
                    <?php echo e($sudahLike ? 'Tidak Suka' : 'Suka'); ?>

                    <span class="font-bold"><?php echo e($topic->likes); ?></span>
                </button>
            </form>
            <a href="<?php echo e(route('dashboard.forum')); ?>"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm text-gray-500 hover:bg-gray-100">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    
    <div id="komentar">
        <h3 class="text-base font-semibold text-gray-700 mb-3">
            <?php echo e($topic->replies->count()); ?> Komentar
        </h3>

        <?php if($topic->replies->isEmpty()): ?>
        <div class="bg-white rounded-xl shadow p-10 text-center text-gray-400">
            <i class="fas fa-comment-slash text-4xl mb-2 block"></i>
            <p class="text-sm">Belum ada komentar. Jadilah yang pertama!</p>
        </div>
        <?php else: ?>
        <div class="space-y-4">
            <?php $__currentLoopData = $topic->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $isAdmin = $reply->user?->role === 'admin';
                $isOwn   = $reply->user_id === auth()->id();
            ?>

            
            <div class="bg-white rounded-xl shadow overflow-hidden
                <?php echo e($isAdmin ? 'border-l-4 border-green-500' : ''); ?>">
                <div class="p-5">
                    <div class="flex items-start gap-3">

                        
                        <img src="<?php echo e($reply->user?->foto_profil_url ?? 'https://ui-avatars.com/api/?name=?&background=9ca3af&color=fff&size=128'); ?>"
                             alt="<?php echo e($reply->user?->name); ?>"
                             class="flex-shrink-0 w-9 h-9 rounded-full object-cover">

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap mb-1">
                                <span class="font-semibold text-gray-800 text-sm"><?php echo e($reply->user?->name ?? 'Pengguna'); ?></span>
                                <?php if($isAdmin): ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                    Admin PATANI
                                </span>
                                <?php endif; ?>
                                <?php if($isOwn && !$isAdmin): ?>
                                <span class="text-xs px-2 py-0.5 rounded-full bg-blue-100 text-blue-600">Anda</span>
                                <?php endif; ?>
                                <span class="text-xs text-gray-400"><?php echo e($reply->created_at->diffForHumans()); ?></span>
                            </div>

                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap"><?php echo e($reply->content); ?></p>

                            
                            <?php if(!$topic->is_locked): ?>
                            <button
                                @click="toggleReplyForm(<?php echo e($reply->id); ?>, '<?php echo e(addslashes($reply->user?->name ?? '')); ?>')"
                                class="mt-2 text-xs text-green-600 hover:text-green-800 font-medium flex items-center gap-1">
                                <i class="fas fa-reply"></i>
                                <span x-text="activeReply === <?php echo e($reply->id); ?> ? 'Tutup' : 'Balas'"></span>
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <?php if(!$topic->is_locked): ?>
                    <div x-show="activeReply === <?php echo e($reply->id); ?>" x-cloak class="mt-4 ml-12">
                        <form action="<?php echo e(route('dashboard.forum.reply', $topic->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="parent_id" value="<?php echo e($reply->id); ?>">
                            <div class="flex items-start gap-2">
                                <img src="<?php echo e(auth()->user()->foto_profil_url); ?>"
                                     alt="<?php echo e(auth()->user()->name); ?>"
                                     class="flex-shrink-0 w-7 h-7 rounded-full object-cover">
                                <div class="flex-1">
                                    <p class="text-xs text-gray-400 mb-1">
                                        Membalas <span class="font-medium text-gray-600" x-text="replyingTo"></span>
                                    </p>
                                    <textarea name="content" rows="2" required minlength="3"
                                        placeholder="Tulis balasan..."
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 resize-none"></textarea>
                                    <div class="flex gap-2 mt-2">
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-green-600 text-white text-xs font-medium rounded-lg hover:bg-green-700">
                                            <i class="fas fa-paper-plane mr-1"></i> Kirim
                                        </button>
                                        <button type="button" @click="activeReply = null"
                                            class="px-3 py-1.5 border border-gray-300 text-gray-600 text-xs rounded-lg hover:bg-gray-50">
                                            Batal
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>

                
                <?php if($reply->children->isNotEmpty()): ?>
                <div class="border-t border-gray-100 bg-gray-50/60">
                    <?php $__currentLoopData = $reply->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $childIsAdmin = $child->user?->role === 'admin';
                        $childIsOwn   = $child->user_id === auth()->id();
                    ?>
                    <div class="px-5 py-4 flex items-start gap-3 border-b border-gray-100 last:border-0
                        <?php echo e($childIsAdmin ? 'bg-green-50/50' : ''); ?>">

                        
                        <div class="flex-shrink-0 flex items-center gap-2 ml-8">
                            <div class="w-4 h-px bg-gray-300"></div>
                            <img src="<?php echo e($child->user?->foto_profil_url ?? 'https://ui-avatars.com/api/?name=?&background=9ca3af&color=fff&size=128'); ?>"
                                 alt="<?php echo e($child->user?->name); ?>"
                                 class="flex-shrink-0 w-7 h-7 rounded-full object-cover">
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap mb-0.5">
                                <span class="font-semibold text-gray-800 text-sm"><?php echo e($child->user?->name ?? 'Pengguna'); ?></span>
                                <?php if($childIsAdmin): ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                    Admin PATANI
                                </span>
                                <?php endif; ?>
                                <?php if($childIsOwn && !$childIsAdmin): ?>
                                <span class="text-xs px-2 py-0.5 rounded-full bg-blue-100 text-blue-600">Anda</span>
                                <?php endif; ?>
                                <span class="text-xs text-gray-400"><?php echo e($child->created_at->diffForHumans()); ?></span>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap"><?php echo e($child->content); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </div>
            

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>

    
    <?php if($topic->is_locked): ?>
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 text-center text-gray-500">
        <i class="fas fa-lock text-2xl mb-2 block text-gray-400"></i>
        <p class="text-sm font-medium">Topik ini dikunci oleh admin — komentar tidak bisa ditambahkan.</p>
        <?php if($topic->admin_note): ?>
        <p class="text-xs text-orange-600 mt-1"><?php echo e($topic->admin_note); ?></p>
        <?php endif; ?>
    </div>
    <?php else: ?>
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
            <img src="<?php echo e(auth()->user()->foto_profil_url); ?>"
                 alt="<?php echo e(auth()->user()->name); ?>"
                 class="w-7 h-7 rounded-full object-cover">
            Tulis Komentar
        </h4>
        <form action="<?php echo e(route('dashboard.forum.reply', $topic->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="parent_id" value="">
            <textarea name="content" rows="3" required minlength="3"
                placeholder="Tulis komentar Anda di sini..."
                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 resize-none"><?php echo e(old('content')); ?></textarea>
            <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div class="flex justify-end mt-3">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg">
                    <i class="fas fa-paper-plane"></i> Kirim Komentar
                </button>
            </div>
        </form>
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function forumDetail() {
    return {
        activeReply: null,
        replyingTo: '',

        toggleReplyForm(replyId, userName) {
            if (this.activeReply === replyId) {
                this.activeReply = null;
                this.replyingTo  = '';
            } else {
                this.activeReply = replyId;
                this.replyingTo  = userName;
                this.$nextTick(() => {
                    const el = document.querySelector(`[x-show="activeReply === ${replyId}"]`);
                    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                });
            }
        }
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\patani\laravel-patani\resources\views/dashboard/forum-detail.blade.php ENDPATH**/ ?>