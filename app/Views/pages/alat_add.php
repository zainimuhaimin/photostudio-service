<!-- get template -->
<?= $this->extend('template/layout'); ?>
<!-- end get template -->

<!-- initiate section or render page title page name and pageSlash -->
<?= $this->section('pageTitle'); ?>
Form Tambah Alat
<?= $this->endSection(); ?>

<?= $this->section('page'); ?>
Form Tambah Alat
<?= $this->endSection(); ?>

<?= $this->section('pageSlash'); ?>
Form Tambah Alat
<?= $this->endSection(); ?>
<!-- end initiate -->

<?= $this->section('content'); ?>
<div class="flex flex-wrap -mx-2">
  <div class="flex-none w-full max-w-full px-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="space-x-4 justify-between flex p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="dark:text-white">Tambah Alat</h6>
      </div>
      <div class="flex-auto px-0 pt-0 pb-2">
        <div class="p-6 overflow-x-auto">
          <form enctype="multipart/form-data" role="form text-left" action="<?= base_url() ?>alat-save" method="POST">
            <div class="mb-4">
              <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Nama Alat</label>
              <input autocomplete="off" name="namaalat" required type="text" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Nama Alat" aria-label="namaalat" aria-describedby="email-addon" />
            </div>
            <div class="mb-4">
              <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Harga Sewa</label>
              <input autocomplete="off" name="hargasewa-format" required type="text" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Harga Sewa" aria-label="hargasewa" aria-describedby="email-addon" oninput="formatHarga(this)" />
              <input type="hidden" name="hargasewa" id="harga-real" value="">
            </div>
            <div class="mb-4">
              <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Deskripsi</label>
              <input autocomplete="off" name="deskripsi" required type="textarea" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Deskripsi" aria-label="deskripsi" aria-describedby="email-addon" />
            </div>
            <div class="mb-4">
              <label for="file">Foto Alat</label>
              <input type="file" name="file" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
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
  function formatHarga(el) {
    let raw = el.value.replace(/[^\d]/g, ''); // hanya angka
    let formatted = new Intl.NumberFormat('id-ID').format(raw);

    el.value = 'Rp ' + formatted;
    document.getElementById('harga-real').value = raw;
  }
</script>
<?= $this->endSection(); ?>