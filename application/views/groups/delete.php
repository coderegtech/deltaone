<!-- Modern Tailwind Users Delete Confirmation UI -->
<div class="w-full max-w-none p-4 sm:p-6 lg:p-8">
    <!-- Content Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Delete User</h1>
                <p class="text-slate-600 mt-1">User management</p>
            </div>
            <nav class="flex items-center space-x-2 text-sm text-slate-500">
                <a href="#" class="flex items-center hover:text-blue-600 transition-colors duration-200">
                    <i class="fas fa-home mr-1"></i>
                    Home
                </a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="<?php echo base_url('users/') ?>"
                    class="hover:text-blue-600 transition-colors duration-200">Users</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-slate-900 font-medium">Delete</span>
            </nav>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <div
            class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                <span class="font-medium"><?php echo $this->session->flashdata('success'); ?></span>
            </div>
            <button type="button" class="text-emerald-500 hover:text-emerald-700 transition-colors"
                onclick="this.parentElement.style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php elseif ($this->session->flashdata('error')): ?>
        <div
            class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center justify-between shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <span class="font-medium"><?php echo $this->session->flashdata('error'); ?></span>
            </div>
            <button type="button" class="text-red-500 hover:text-red-700 transition-colors"
                onclick="this.parentElement.style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>

    <!-- Delete Confirmation Card -->
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200/60 overflow-hidden">
        <div class="bg-gradient-to-r from-slate-50 to-red-50 px-6 py-5 border-b border-slate-200">
            <div class="flex items-center">
                <div class="bg-red-600 p-2 rounded-lg mr-3">
                    <i class="fas fa-user-times text-white"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-slate-900">Confirm User Deletion</h3>
                    <p class="text-slate-600 text-sm">This action cannot be undone</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation text-red-600"></i>
                </div>
                <h3 class="text-lg font-medium text-slate-900 mb-2">Are you sure you want to delete this user account?
                </h3>
                <p class="text-slate-600">All data associated with this user will be permanently removed. This action
                    cannot be undone.</p>
            </div>

            <form action="<?php echo base_url('groups/delete/' . $id) ?>" method="post"
                class="flex justify-center space-x-4">
                <a href="<?php echo base_url('groups') ?>"
                    class="inline-flex items-center px-6 py-3 border border-slate-300 text-sm font-medium rounded-xl text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                    Cancel
                </a>
                <button type="submit" name="confirm" value="1"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-xl text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 shadow-sm">
                    Confirm Delete
                </button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#mainUserNav").addClass('active');
        $("#manageUserNav").addClass('active');
    });
</script>