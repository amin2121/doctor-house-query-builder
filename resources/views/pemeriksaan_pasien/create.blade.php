@extends('layouts.app', ['title' => 'Pemeriksaan Pasien'])

@section('content')
<form action="{{ route('pemeriksaan-pasien.store') }}" method="POST">
<section class="section">
  <div class="section-header">
    <h1>Pemeriksaan Pasien</h1>
  </div>
  <div class="row">
    <div class="col-md-12 col-12 col-sm-12">

      @include('layouts.flash-message')

        <div class="card">
          <div class="card-header">
            <h4>Data Pasien & Diagnosa</h4>
          </div>
          <div class="card-body">
              @csrf
              <div class="form-group">
                <label for="pasien">Pasien</label>
                <select name="pasien" id="pasien" class="form-control select2" onchange="get_data_pasien();">
                  <option value="">-- Pilih Pasien --</option>
                  @foreach ($pasien as $psi)
                    <option value="{{ $psi->id }}" data-alamat="{{ $psi->alamat }}" data-no-telp="{{ $psi->no_telp }}">{{ $psi->nama_pasien }}</option>
                  @endforeach
                </select>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" readonly="" class="form-control" name="alamat" id="alamat">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="no-telp">No Telp</label>
                    <input type="text" readonly="" class="form-control" name="no_telp" id="no-telp">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="dokter">Dokter</label>
                <select name="dokter" id="dokter" class="form-control select2">
                  <option value="">-- Pilih Dokter --</option>
                  @foreach ($dokter as $dkt)
                    <option value="{{ $dkt->id }}">{{ $dkt->nama_dokter }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="diagnosa">Diagnosa</label>
                <input type="text" class="form-control" name="diagnosa" id="diagnosa">
              </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h4>Data Resep Obat</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-border table-striped" id="table-resep-obat">
                <thead>
                  <tr>
                    <th style="width: 200px;">Obat</th>
                    <th>Harga</th>
                    <th>Jumlah Beli</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <select name="obat[]" id="obat-1" class="form-control select2" onchange="set_harga(1);">
                        <option value="">Pilih Obat</option>
                        @foreach ($obat as $obt)
                          <option value="{{ $obt->id }}" data-harga-awal="{{ $obt->harga_awal }}" data-harga-jual="{{ $obt->harga_jual }}">{{ $obt->nama_obat }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <input type="text" class="form-control" name="harga[]" id="harga-1" onkeyup="hitung_total(1); hitung_total_akhir();">
                      <input type="hidden" class="form-control" name="harga_awal[]" id="harga-awal-1">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="jumlah_beli[]" id="jumlah-beli-1" onkeyup="hitung_total(1); hitung_total_akhir();">
                    </td>
                    <td>
                      <span id="span-total-harga-1">Rp. -</span>
                    </td>
                    <td>
                      <button class="btn btn-sm btn-danger" type="button" disabled=""><i class="fa fa-trash"></i></button>
                      <input type="hidden" id="total-harga-1" name="total_harga[]" class="total-harga">
                      <input type="hidden" id="laba-1" name="laba[]">
                      <input type="hidden" id="total-laba-1" name="total_laba[]" class="total-laba">
                    </td>
                  </tr>
                </tbody>
              </table>

              <button class="btn btn-default btn-sm" type="button" onclick="tambah_baris()"><i class="fa fa-plus"></i> Tambah Obat</button>
              <br><br><br>
              <button class="btn btn-primary" type="button" id="btn-modal-pembayaran" onclick="show_modal_pembayaran()"><i class="fa fa-money-bill-alt"></i> Lakukan Pembayaran</button>
            </div>
          </div>
        </div>

    </div>
  </div>

</section>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-pembayaran">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pembayaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="total-nominal">Total Nominal</label>
          <input type="text" name="total_nominal" class="form-control" id="total-nominal">
          <input type="hidden" class="form-control" id="total-nominal-def">
          <input type="hidden" name="total_laba_akhir" id="total-laba">
        </div>
        <div class="form-group">
          <label for="diskon">Diskon</label>
          <input type="text" name="diskon" class="form-control" id="diskon" onkeyup="set_diskon()">
        </div>
        <div class="form-group">
          <label for="pembayaran">Pembayaran</label>
          <input type="text" name="pembayaran" class="form-control" id="pembayaran" onkeyup="set_kembalian()">
        </div>
        <div class="form-group">
          <label for="kembalian">Kembalian</label>
          <input type="text" name="kembalian" readonly="" class="form-control" id="kembalian">
        </div>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
      </div>
    </div>
  </div>
</div>

</form>

<script>
  let index_baris = 1

  function show_modal_pembayaran() {
    $(`#modal-pembayaran`).modal('toggle')
  }

  function set_diskon() {
    let diskon = $(`#diskon`).val()
    let total_nominal = $(`#total-nominal-def`).val()

    let total_nominal_decrease = getNumberInt(total_nominal) - getNumberInt(diskon) 
    $(`#total-nominal`).val(total_nominal_decrease)
  }

  function set_kembalian() {
    let total_nominal = $(`#total-nominal`).val()
    let pembayaran = $(`#pembayaran`).val()

    let kembalian_decrease = getNumberInt(pembayaran) - getNumberInt(total_nominal) 
    $(`#kembalian`).val(kembalian_decrease)
  }

  function get_data_pasien() {
    let alamat = $(`#pasien option:selected`).data('alamat')
    let no_telp = $(`#pasien option:selected`).data('no-telp')

    $(`#alamat`).val(alamat)
    $(`#no-telp`).val(no_telp)
  }

  function tambah_baris() {
    index_baris += 1

    let baris = `
      <tr>
        <td>
          <select name="obat[]" id="obat-${index_baris}" class="form-control select2" onchange="set_harga(${index_baris});">
            <option value="">Pilih Obat</option>
            @foreach ($obat as $obt)
              <option value="{{ $obt->id }}" data-harga-awal="{{ $obt->harga_awal }}" data-harga-jual="{{ $obt->harga_jual }}">{{ $obt->nama_obat }}</option>
            @endforeach
          </select>
        </td>
        <td>
          <input type="text" class="form-control" name="harga[]" id="harga-${index_baris}" onkeyup="hitung_total(${index_baris}); hitung_total_akhir();">
          <input type="hidden" class="form-control" name="harga_awal[]" id="harga-awal-${index_baris}">
        </td>
        <td>
          <input type="text" class="form-control" name="jumlah_beli[]" id="jumlah-beli-${index_baris}" onkeyup="hitung_total(${index_baris}); hitung_total_akhir();">
        </td>
        <td>
          <span id="span-total-harga-${index_baris}">Rp. -</span>
        </td>
        <td>
          <button class="btn btn-sm btn-danger" type="button" disabled=""><i class="fa fa-trash"></i></button>
          <input type="hidden" id="total-harga-${index_baris}" name="total_harga[]" class="total-harga">
          <input type="hidden" id="laba-${index_baris}" name="laba[]">
          <input type="hidden" id="total-laba-${index_baris}" name="total_laba[]" class="total-laba">
        </td>
      </tr>
    `

    $(`#table-resep-obat tbody`).append(baris)
  }

  function hapus_baris(e) {
    e.parentElement.parentElement.remove()
  }

  function set_harga(idx) {
    let harga_awal = $(`#obat-${idx} option:selected`).data('harga-awal')
    let harga_jual = $(`#obat-${idx} option:selected`).data('harga-jual')

    $(`#harga-awal-${idx}`).val(harga_awal)
    $(`#harga-${idx}`).val(harga_jual)
  }

  function hitung_total(idx) {

    if($(`.total-harga-akhir`).val() == null || $(`.total-harga-akhir`).val() == 0) {
      $(`#btn-faktur`).prop('disabled', false)
    } else {
      $(`#btn-faktur`).prop('disabled', true)
    }

    let input_harga_awal = $(`#harga-awal-${idx}`)
    let input_harga_jual = $(`#harga-${idx}`)
    let input_laba = $(`#laba-${idx}`)
    let input_jumlah_beli = $(`#jumlah-beli-${idx}`)
    
    let input_total_harga = $(`#total-harga-${idx}`)
    let input_total_laba = $(`#total-laba-${idx}`)

    let laba = getNumberInt(input_harga_jual.val()) - getNumberInt(input_harga_awal.val())
    let total_harga = getNumberInt(input_harga_jual.val()) * getNumberInt(input_jumlah_beli.val())

    input_total_harga.val(total_harga)
    $(`#span-total-harga-${idx}`).html(`Rp. ${total_harga}`)
    input_laba.val(laba)
    input_total_laba.val(laba * getNumberInt(input_jumlah_beli.val()))
  }

  function hitung_total_akhir() {
    let total_harga = 0
    $(`.total-harga`).each(function() {
      total_harga += getNumberInt($(this).val())
    })

    let total_laba = 0
    $(`.total-laba`).each(function() {
      total_laba += getNumberInt($(this).val())
    })

    $(`#total-nominal`).val(total_harga)
    $(`#total-nominal-def`).val(total_harga)
    $(`#total-laba`).val(total_laba)
  }

</script>
@stop