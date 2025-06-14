<!-- get template -->
<?= $this->extend('template/layout'); ?>
<!-- end get template -->

<!-- initiate section or render page title page name and pageSlash -->
<?= $this->section('pageTitle'); ?>
Form Penyewaan Alat
<?= $this->endSection(); ?>

<?= $this->section('page'); ?>
Form Penyewaan Alat
<?= $this->endSection(); ?>

<?= $this->section('pageSlash'); ?>
Form Penyewaan Alat
<?= $this->endSection(); ?>
<!-- end initiate -->

<?= $this->section('content'); ?>
<div class="flex flex-wrap -mx-2">
  <div class="flex-none w-full max-w-full px-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
      <div class="space-x-4 justify-between flex p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="dark:text-white">Penyewaan Alat</h6>
      </div>
      <div class="flex px-0 pt-0 pb-2">
        <div class="p-6 overflow-x-auto w-1/2">
          <form role="form text-left" action="<?= base_url() ?>penyewaan-save" method="POST">
            <div class="mb-4">
              <label for="alat" class="block text-sm font-medium text-gray-700 mb-1">Pilih Alat</label>
              <select id="alat" name="alat" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <?php foreach ($alats as $val): ?>
                  <option value="<?= $val['id_alat'] ?>" data-harga="<?= $val['harga_alat'] ?>"><?= $val['nama_alat'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-4">
              <label for="jadwal">Pilih Jadwal:</label>
              <input placeholder="Select date ..." type="text" id="jadwal" name="jadwal" class="block appearance-none bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" />
            </div>
            <div class="mb-4">
              <label for="pembayaran-metode" class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
              <select name="pembayaran-metode" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option value="TRANSFER">TRANSFER</option>
                <option value="CASH">CASH</option>
              </select>
            </div>
            <div class="mb-4">
              <input readonly id="hargasewalabel" autocomplete="off" type="int" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Harga Sewa" aria-label="hargasewa" aria-describedby="email-addon" />
              <input readonly id="hargasewa" autocomplete="off" name="hargasewa" required type="hidden" class="placeholder:text-gray-500 text-sm focus:shadow-primary-outline leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-blue-500 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" placeholder="Harga Sewa" aria-label="hargasewa" aria-describedby="email-addon" />
            </div>
            <div class="text-center">
              <button type="submit" class="inline-block w-full px-5 py-2.5 mt-6 mb-2 font-bold text-center text-white align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer active:opacity-85 hover:-translate-y-px hover:shadow-xs leading-normal text-sm ease-in tracking-tight-rem shadow-md bg-150 bg-x-25 bg-gradient-to-tl from-zinc-800 to-zinc-700 hover:border-slate-700 hover:bg-slate-700 hover:text-white">Tambah</button>
            </div>
          </form>
        </div>
        <div class="p-6 overflow-x-auto w-1/2 ">
          <div class="relative w-full rounded-lg overflow-hidden border-2 border-gray-300">
            <img id="alatImage" alt="Equipment Preview" class="w-full max-h-full mx-auto object-contain transition-all duration-300 ease-in-out" height="400px">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  const base_url = "<?= base_url() ?>"
  const select = document.getElementById('alat');
  const idAlat = select.options[select.selectedIndex].value;

  function updatePrice() {
    const select = document.getElementById('alat');
    const selected = select.options[select.selectedIndex];
    const harga = selected.getAttribute('data-harga');
    console.log(harga);
    document.getElementById('hargasewalabel').value = harga ? `Rp ${parseInt(harga).toLocaleString('id-ID')}` : '';
    document.getElementById('hargasewa').value = harga ? harga : '';
  }


  function getAlatImage(baseUrl, idAlat) {
    console.log("start get alat image id alat : " + idAlat)
    $.ajax({
      url: base_url + `/alat/get-image/${idAlat}`,
      method: 'GET',
      success: function(response) {
        if (response.status === 'success') {
          // Update the image source with base64 data
          document.getElementById('alatImage').src = `${base_url}` + response.data.imagePath;

          // // Update equipment name and description
          // document.getElementById('alatName').textContent = response.data.nama_alat;
          // document.getElementById('alatDesc').textContent = response.data.deskripsi || 'No description available';
        } else {
          console.error('Failed to fetch equipment image');
        }
      },
      error: function(xhr, status, error) {
        console.error('Error fetching equipment image:', error);
      }
    });
  }

  document.getElementById('alat').addEventListener('change', function() {
    const idAlat = this.value;
    console.log("id jasa " + idAlat);
    updatePrice();
    getJadwalPenyewaanAlat(base_url, idAlat);
    getAlatImage(base_url, idAlat);
  });


  window.onload = function() {
    updatePrice();
    getJadwalPenyewaanAlat(base_url, idAlat);
    getAlatImage(base_url, idAlat);
  };
</script>
<?= $this->endSection(); ?>