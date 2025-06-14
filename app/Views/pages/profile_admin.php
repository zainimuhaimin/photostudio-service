<!-- get template -->
<?= $this->extend('template/layout'); ?>
<!-- end get template -->

<!-- initiate section or render page title page name and pageSlash -->
<?= $this->section('pageTitle'); ?>
Detail Profile
<?= $this->endSection(); ?>

<?= $this->section('page'); ?>
Detail Profile
<?= $this->endSection(); ?>

<?= $this->section('pageSlash'); ?>
Detail Profile
<?= $this->endSection(); ?>
<!-- end initiate -->

<!-- render content -->
<?= $this->section('content'); ?>
<div class="h-screen flex items-center">
    <div class="container px-4 py-8">
        <!-- Welcome Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8 w-1/2 mx-auto">
            <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-6 overflow-x-auto">
                    <h3>Profile</h3>
                    <form role="form text-left" action="<?= base_url() ?>profile-update-admin" method="POST">
                        <input type="hidden" name="id_user" value="<?= $userData['id_user'] ?>">
                        <div class="mb-4">
                            <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Username</label>
                            <input value="<?= $userData['username'] ?>" autocomplete="off" name="username" required type="text" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Nama / Username" aria-label="Username" aria-describedby="email-addon" />
                        </div>
                        <div class="mb-4">
                            <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Password</label>
                            <div class="flex gap-2">
                                <div class="w-3/4">
                                    <input id="password-input" autocomplete="off" name="password" required type="password" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Password" aria-label="Password" aria-describedby="password-addon" />
                                </div>
                                <div class="w-1/4">
                                    <button type="button" onclick="togglePassword()" class="w-full h-full flex items-center justify-center border border-gray-300 rounded text-gray-500 hover:text-blue-600 focus:outline-none">
                                        <i id="password-icon" class="fa fa-eye-slash text-gray-400"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="inline-block w-full px-5 py-2.5 mt-6 mb-2 font-bold text-center text-white align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer active:opacity-85 hover:-translate-y-px hover:shadow-xs leading-normal text-sm ease-in tracking-tight-rem shadow-md bg-150 bg-x-25 bg-gradient-to-tl from-zinc-800 to-zinc-700 hover:border-slate-700 hover:bg-slate-700 hover:text-white">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password-input');
        const passwordIcon = document.getElementById('password-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        }
    }
</script>
<?= $this->endSection(); ?>
<!-- end render content -->