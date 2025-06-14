<!-- get template -->
<?= $this->extend('template/layout'); ?>
<!-- end get template -->

<!-- initiate section or render page title page name and pageSlash -->
<?= $this->section('pageTitle'); ?>
Form Edit Pelanggan
<?= $this->endSection(); ?>

<?= $this->section('page'); ?>
Form Edit Pelanggan
<?= $this->endSection(); ?>

<?= $this->section('pageSlash'); ?>
Form Edit Pelanggan
<?= $this->endSection(); ?>
<!-- end initiate -->

<?= $this->section('content'); ?>
<div class="flex flex-wrap -mx-2">
  <div class="flex-none w-full max-w-full px-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="space-x-4 justify-between flex p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="dark:text-white">Edit Pelanggan</h6>
      </div>
      <div class="flex-auto px-0 pt-0 pb-2">
        <div class="p-6 overflow-x-auto">
          <form role="form text-left" action="<?= base_url() ?>pelanggan-update" method="POST">
            <input type="hidden" name="id" value="<?= $pelanggan['id_pelanggan'] ?>">
            <div class="mb-4">
              <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Nama</label>
              <input value="<?= $pelanggan['nama'] ?>" autocomplete="off" name="username" type="text" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Nama" aria-label="Username" aria-describedby="email-addon" />
            </div>
            <!-- optional jika ingin di buka gaskan -->
            <!-- <div class="mb-4">
              <input autocomplete="off" name="password" required type="password" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Password" aria-label="Password" aria-describedby="password-addon" />
            </div> -->
            <div class="mb-4">
              <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Email</label>
              <input value="<?= $pelanggan['email'] ?>" autocomplete="off" name="email" required type="email" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Email" aria-label="Email" aria-describedby="email-addon" />
            </div>
            <div class="mb-4">
              <label class="mb-2 ml-1 font-bold text-xs text-slate-700">No HandPhone</label>
              <input value="<?= $pelanggan['no_telp'] ?>" autocomplete="off" name="phoneNumber" required type="number" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Nomor Telephone" aria-label="Nomor Telephone" aria-describedby="email-addon" />
            </div>
            <div class="mb-4">
              <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Alamat</label>
              <input value="<?= $pelanggan['alamat'] ?>" autocomplete="off" name="alamat" required type="text" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Alamat" aria-label="Alamat" aria-describedby="email-addon" />
            </div>
            <div class="text-center">
              <button type="submit" class="inline-block w-full px-5 py-2.5 mt-6 mb-2 font-bold text-center text-white align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer active:opacity-85 hover:-translate-y-px hover:shadow-xs leading-normal text-sm ease-in tracking-tight-rem shadow-md bg-150 bg-x-25 bg-gradient-to-tl from-zinc-800 to-zinc-700 hover:border-slate-700 hover:bg-slate-700 hover:text-white">Ubah Data</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>