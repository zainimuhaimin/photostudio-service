<!-- get template -->
<?= $this->extend('template/layout'); ?>
<!-- end get template -->

<!-- initiate section or render page title page name and pageSlash -->
<?= $this->section('pageTitle');?>
Receipt
<?= $this->endSection();?>

<?= $this->section('page');?>
Receipt
<?= $this->endSection();?>

<?= $this->section('pageSlash');?>
Receipt
<?= $this->endSection();?>
<!-- end initiate -->

<?= $this->section('content');?>
 <style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
      background-color: #f7f7f7;
    }
    .invoice-box {
      background: #fff;
      padding: 30px;
      border: 1px solid #eee;
      max-width: 800px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
    }
    h1 {
      font-size: 24px;
      margin-bottom: 20px;
    }
    .company-details, .client-details {
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }
    table th, table td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }
    table th {
      background-color: #f2f2f2;
    }
    .total {
      text-align: right;
      font-weight: bold;
    }
    .footer {
      text-align: center;
      font-size: 12px;
      color: #888;
    }
  </style>
<div class="flex flex-wrap -mx-2">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            <div class="space-x-4 justify-between flex p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                
            </div>
            <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-2 overflow-x-auto">
                  <div class="invoice-box">
                    <h1>Receipt</h1>
                    
                    <div class="company-details">
                      <strong>CV Rahma Grafika</strong><br/>
                      Lorem ipsum dolor sit amet.<br/>
                      Lorem ipsum dolor sit amet.<br/>
                      Email: cvrahma@grafika.com
                    </div>

                    <div class="client-details">
                      <strong>Kepada:</strong><br/>
                      Bapak/Ibu <?=null == $pembayaran->nama_pelanggan_sewa_alat ? $pembayaran->nama_pelanggan_pemesan_jasa : $pembayaran->nama_pelanggan_sewa_alat ?><br/>
                      PT. Contoh Pelanggan<br/>
                      Email: <?=null == $pembayaran->email_sewa_alat ? $pembayaran->email_pesan_jasa : $pembayaran->email_sewa_alat ?>
                    </div>

                    <table>
                      <thead>
                        <tr>
                          <th>Deskripsi</th>
                          <th>Harga Satuan</th>
                          <th>Subtotal</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><?=null == $pembayaran->nama_alat ? $pembayaran->nama_jasa : $pembayaran->nama_alat ?></td>
                          <td><?= "Rp". number_format(null == $pembayaran->harga_alat ? $pembayaran->harga_jasa : $pembayaran->harga_alat ) ?></td>
                          <td><?= "Rp". number_format(null == $pembayaran->harga_alat ? $pembayaran->harga_jasa : $pembayaran->harga_alat)  ?></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="total">Total</td>
                          <td class="total"><?= "Rp". number_format(null == $pembayaran->harga_alat ? $pembayaran->harga_jasa : $pembayaran->harga_alat )?></td>
                        </tr>
                      </tbody>
                    </table>

                    <div class="footer">
                      Terima kasih atas kepercayaan Anda.<br/>
                    </div>
                  </div>
                </div>
            </div>
            </div>
        </div>
</div>
<?= $this->endSection();?>