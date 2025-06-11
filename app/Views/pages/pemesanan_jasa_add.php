<!-- get template -->
<?= $this->extend('template/layout'); ?>
<!-- end get template -->

<!-- initiate section or render page title page name and pageSlash -->
<?= $this->section('pageTitle');?>
Form Pemesanan Jasa
<?= $this->endSection();?>

<?= $this->section('page');?>
Form Pemesanan Jasa
<?= $this->endSection();?>

<?= $this->section('pageSlash');?>
Form Pemesanan Jasa
<?= $this->endSection();?>
<!-- end initiate -->

<?= $this->section('content');?>
<div class="flex flex-wrap -mx-2">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            <div class="space-x-4 justify-between flex p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6 class="dark:text-white">Form Pemesanan Jasa</h6>
            </div>
            <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-6 overflow-x-auto">
                  <form role="form text-left" action="<?=base_url()?>pemesanan-save" method="POST">
                    <div class="mb-4">
                      <label for="jasa" class="block text-sm font-medium text-gray-700 mb-1">Pilih Jasa</label>
                       <select id="jasa" name="jasa" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <?php foreach ($jasas as $val):?>
                          <option value="<?=$val['id_jasa']?>" data-harga="<?=$val['harga_jasa']?>"><?=$val['nama_jasa']?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="mb-4">
                          <label for="jadwal">Pilih Jadwal:</label>
                    <input type="datetime-local" id="jadwal" name="jadwal" class="block appearance-none w-50 bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" />
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
            </div>
            </div>
        </div>
</div>
<script>
  function updatePrice(){
    const select = document.getElementById('jasa');
    const selected = select.options[select.selectedIndex];
    const harga = selected.getAttribute('data-harga');
    console.log(harga);
    document.getElementById('hargasewalabel').value = harga ? `Rp ${parseInt(harga).toLocaleString('id-ID')}` : '';
    document.getElementById('hargasewa').value = harga ? harga : '';
  }
  // Pasang event listener untuk saat select berubah
  document.getElementById('jasa').addEventListener('change', updatePrice);

  // Panggil sekali saat halaman dimuat untuk tampilkan harga default
  window.onload = function () {
    updatePrice();
  };
</script>
<?= $this->endSection();?>