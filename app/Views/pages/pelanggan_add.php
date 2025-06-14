<!-- get template -->
<?= $this->extend('template/layout'); ?>
<!-- end get template -->

<!-- initiate section or render page title page name and pageSlash -->
<?= $this->section('pageTitle'); ?>
Form Tambah Pelanggan
<?= $this->endSection(); ?>

<?= $this->section('page'); ?>
Form Tambah Pelanggan
<?= $this->endSection(); ?>

<?= $this->section('pageSlash'); ?>
Form Tambah Pelanggan
<?= $this->endSection(); ?>
<!-- end initiate -->

<?= $this->section('content'); ?>
<div class="flex flex-wrap -mx-2">
  <div class="flex-none w-full max-w-full px-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="space-x-4 justify-between flex p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="dark:text-white">Tambah Pelanggan</h6>
      </div>
      <div class="flex-auto px-0 pt-0 pb-2">
        <div class="p-6 overflow-x-auto">
          <form role="form text-left" action="<?= base_url() ?>pelanggan-save" method="POST">
            <div class="mb-4">
              <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Username</label>
              <input autocomplete="off" name="username" required type="text" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Nama / Username" aria-label="Username" aria-describedby="email-addon" />
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
            <div class="mb-4">
              <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Email</label>
              <input autocomplete="off" name="email" required type="email" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Email" aria-label="Email" aria-describedby="email-addon" />
            </div>
            <div class="mb-4">
              <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Nomor HandPhone</label>
              <input autocomplete="off" name="phoneNumber" required type="number" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Nomor Telephone" aria-label="Nomor Telephone" aria-describedby="email-addon" />
            </div>
            <div class="mb-4">
              <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Alamat</label>
              <input autocomplete="off" name="alamat" required type="text" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Alamat" aria-label="Alamat" aria-describedby="email-addon" />
            </div>
            <div class="mb-4">
              <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Pilih Role</label>
              <select name="role" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <?php foreach ($roles as $val): ?>
                  <option value="<?= $val['id_role'] ?>"><?= $val['value'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="text-center">
              <button type="submit" class="inline-block w-full px-5 py-2.5 mt-6 mb-2 font-bold text-center text-white align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer active:opacity-85 hover:-translate-y-px hover:shadow-xs leading-normal text-sm ease-in tracking-tight-rem shadow-md bg-150 bg-x-25 bg-gradient-to-tl from-zinc-800 to-zinc-700 hover:border-slate-700 hover:bg-slate-700 hover:text-white">Tambah</button>
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