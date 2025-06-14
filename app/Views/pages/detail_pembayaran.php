<!-- get template -->
<?= $this->extend('template/layout'); ?>
<!-- end get template -->

<!-- initiate section or render page title page name and pageSlash -->
<?= $this->section('pageTitle'); ?>
Detail Pembayaran
<?= $this->endSection(); ?>

<?= $this->section('page'); ?>
Detail Pembayaran
<?= $this->endSection(); ?>

<?= $this->section('pageSlash'); ?>
Detail Pembayaran
<?= $this->endSection(); ?>
<!-- end initiate -->

<?= $this->section('content'); ?>
<div class="flex flex-wrap -mx-2">
  <div class="flex-none w-full max-w-full px-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="space-x-4 justify-between flex p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="dark:text-white">Detail Pembayaran</h6>
      </div>

      <div class="flex-auto px-0 pt-0 pb-2">
        <div class="p-4 overflow-x-auto">
          <div class="mb-4">
            <p>* Silahkan lakukan pembayaran sesuai dengan metode pembayaran yang di pilih,
              simpan bukti pembayaran dan upload di form ini lalu tunjukan bukti bayar kepada pegawai untuk di validasi sekali lagi!. terima kasih</p>
          </div>
          <form enctype="multipart/form-data" role="form text-left" action="<?= base_url() ?>pembayaran-update" method="POST">
            <input type="hidden" name="id_pembayaran" value="<?= $pembayaran->id_pembayaran ?>">
            <div class="mb-4">
              <label for="pemesan">Nama Pemesan</label>
              <input id="pemesan" readonly value="<?= $pembayaran->nama_pelanggan_sewa_alat == null ? $pembayaran->nama_pelanggan_pemesan_jasa : $pembayaran->nama_pelanggan_sewa_alat ?>" id="hargasewa" autocomplete="off" type="int" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" aria-label="hargasewa" aria-describedby="email-addon" />
            </div>
            <div class="mb-4">
              <label for="jasa">Jenis Pembayaran Untuk</label>
              <input readonly value="<?= null == $pembayaran->nama_jasa ? $pembayaran->nama_alat : $pembayaran->nama_jasa ?>" id="jasa" autocomplete="off" type="int" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="<?= null == $pembayaran->nama_jasa ? $pembayaran->nama_alat : $pembayaran->nama_jasa ?>" aria-label="hargasewa" aria-describedby="email-addon" />
            </div>
            <div class="mb-4">
              <label for="hargasewa">Harga Pembayaran</label>
              <input id="hargasewaLabel" readonly id="hargasewa" autocomplete="off" type="int" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" aria-label="hargasewa" aria-describedby="email-addon" />
              <input type="hidden" id="hargasewa" readonly value="<?= null == $pembayaran->harga_jasa ? $pembayaran->harga_alat : $pembayaran->harga_jasa ?>" id="hargasewa" autocomplete="off" type="int" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="<?= null == $pembayaran->harga_jasa ? $pembayaran->harga_alat : $pembayaran->harga_jasa ?>" aria-label="hargasewa" aria-describedby="email-addon" />
            </div>
            <div class="mb-4">
              <label for="jadwal">Jadwal:</label>
              <input readonly value="<?= null == $pembayaran->tanggal_penyewaan ? $pembayaran->tanggal_pemesanan_jasa : $pembayaran->tanggal_penyewaan ?>" type="datetime-local" id="jadwal" name="jadwal" class="block appearance-none w-50 bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" />
            </div>
            <div class="mb-4">
              <label for="file">Bukti Pembayaran</label>
              <input type="file" name="file" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
              <label for="pembayaran-metode" class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
              <select name="pembayaran-metode" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <!-- TODO bawa option dari controller biar dinamis -->
                <option value="TRANSFER" <?= $pembayaran->metode_pembayaran == 'TRANSFER' ? 'selected' : '' ?>>TRANSFER</option>
                <option value="CASH" <?= $pembayaran->metode_pembayaran == 'CASH' ? 'selected' : '' ?>>CASH</option>
              </select>
            </div>
            <?php if ($pembayaran->status_pembayaran == "BOOKED" || session()->get('role_name') == "ADMIN"): ?>
              <div class="text-center">
                <button type="submit" class="inline-block w-full px-5 py-2.5 mt-6 mb-2 font-bold text-center text-white align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer active:opacity-85 hover:-translate-y-px hover:shadow-xs leading-normal text-sm ease-in tracking-tight-rem shadow-md bg-150 bg-x-25 bg-gradient-to-tl from-zinc-800 to-zinc-700 hover:border-slate-700 hover:bg-slate-700 hover:text-white">Bayar</button>
              </div>
            <?php endif; ?>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function updatePrice() {
    const input = document.getElementById('hargasewa');
    const harga = input.value;
    console.log(harga);
    input.setAttribute('placeholder', harga ? `Rp ${parseInt(harga).toLocaleString('id-ID')}` : '');
    document.getElementById('hargasewaLabel').value = harga ? `Rp ${parseInt(harga).toLocaleString('id-ID')}` : '';
  }

  // Panggil sekali saat halaman dimuat untuk tampilkan harga default
  window.onload = function() {
    updatePrice();
  };
</script>
<?= $this->endSection(); ?>