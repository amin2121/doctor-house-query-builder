@extends('layouts.app', ['title' => 'Tambah Faktur Pembelian'])

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Tambah Faktur Pembelian</h1>
  </div>
  <div class="row">
    <div class="col-md-12 col-12 col-sm-12">

      @include('layouts.flash-message')

      <div class="card">
        <div class="card-header">
          <h4>Tambah Faktur Pembelian</h4>
        </div>
        <div class="card-body">
          <form action="{{ route('faktur-pembelian.store') }}" method="POST">
            @csrf
            <div class="form-group row">
              <label for="no-faktur" class="col-form-label col-sm-2">No Faktur</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="no_faktur" id="no-faktur">
              </div>
            </div>
            <div class="form-group row">
              <label for="supplier" class="col-form-label col-sm-2">Supplier</label>
              <div class="col-sm-10">
                <select name="supplier" id="supplier" class="form-control select2">
                  @foreach ($supplier as $spl)
                    <option value="{{ $spl->id }}">{{ $spl->nama_supplier }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="tanggal-faktur" class="col-form-label col-sm-2">Tanggal Faktur</label>
              <div class="col-sm-10">
                <input type="date" class="form-control datepicker" name="tanggal_faktur" id="tanggal-faktur">
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-border table-striped" id="table-obat">
                <thead>
                  <tr>
                    <th style="width: 200px;">Obat</th>
                    <th>Harga Awal</th>
                    <th>Harga Jual</th>
                    <th>Jumlah Beli</th>
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
                      <input type="text" class="form-control" name="harga_awal[]" id="harga-awal-1" onkeyup="hitung_total(1); hitung_total_akhir();">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="harga_jual[]" id="harga-jual-1" onkeyup="hitung_total(1); hitung_total_akhir();">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="jumlah_beli[]" id="jumlah-beli-1" onkeyup="hitung_total(1); hitung_total_akhir();">
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

              <button class="btn btn-default btn-sm" type="button" onclick="tambah_baris()"><i class="fa fa-plus"></i> Tambah Baris</button>
            </div>
            <br><br>
            <div class="form-group row">
              <label for="total-harga" class="col-form-label col-sm-2">Total Harga</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" readonly="" name="total_harga_akhir" id="total-harga-akhir">
                <input type="text" class="form-control" readonly="" name="total_laba_akhir" id="total-laba-akhir">
              </div>
            </div>
            <button class="btn btn-primary" type="submit" id="btn-faktur" disabled=""><i class="fa fa-save"></i> Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</section>

<script>
  let index_baris = 1

  function tambah_baris() {
    index_baris += 1

    let baris = `
      <tr>
        <td>
          <select name="obat[]" id="obat-${index_baris}" class="form-control select2" onchange="set_harga(${index_baris})">
            <option value="">Pilih Obat</option>
            @foreach ($obat as $obt)
              <option value="{{ $obt->id }}" data-harga-awal="{{ $obt->harga_awal }}" data-harga-jual="{{ $obt->harga_jual }}">{{ $obt->nama_obat }}</option>
            @endforeach
          </select>
        </td>
        <td>
          <input type="text" class="form-control" name="harga_awal[]" id="harga-awal-${index_baris}" onkeyup="hitung_total(${index_baris}); hitung_total_akhir();">
        </td>
        <td>
          <input type="text" class="form-control" name="harga_jual[]" id="harga-jual-${index_baris}" onkeyup="hitung_total(${index_baris}); hitung_total_akhir();">
        </td>
        <td>
          <input type="text" class="form-control" name="jumlah_beli[]" id="jumlah-beli-${index_baris}" onkeyup="hitung_total(${index_baris}); hitung_total_akhir();">
        </td>
        <td>
          <button class="btn btn-sm btn-danger" type="button" onclick="hapus_baris(this)"><i class="fa fa-trash"></i></button>
          <input type="text" id="total-harga-${index_baris}" class="total-harga" name="total_harga[]">
          <input type="text" id="laba-${index_baris}" name="laba[]">
          <input type="text" id="total-laba-${index_baris}" class="total-laba" name="total_laba[]">
        </td>
      </tr>
    `

    $(`#table-obat tbody`).append(baris)
  }

  function hapus_baris(e) {
    e.parentElement.parentElement.remove()
  }

  function set_harga(idx) {
    let harga_awal = $(`#obat-${idx} option:selected`).data('harga-awal')
    let harga_jual = $(`#obat-${idx} option:selected`).data('harga-jual')

    $(`#harga-awal-${idx}`).val(harga_awal)
    $(`#harga-jual-${idx}`).val(harga_jual)
  }

  function hitung_total(idx) {

    if($(`.total-harga-akhir`).val() == null || $(`.total-harga-akhir`).val() == 0) {
      $(`#btn-faktur`).prop('disabled', false)
    } else {
      $(`#btn-faktur`).prop('disabled', true)
    }

    let input_harga_awal = $(`#harga-awal-${idx}`)
    let input_harga_jual = $(`#harga-jual-${idx}`)
    let input_laba = $(`#laba-${idx}`)
    let input_jumlah_beli = $(`#jumlah-beli-${idx}`)
    
    let input_total_harga = $(`#total-harga-${idx}`)
    let input_total_laba = $(`#total-laba-${idx}`)

    let laba = getNumberInt(input_harga_jual.val()) - getNumberInt(input_harga_awal.val())
    let total_harga = getNumberInt(input_harga_awal.val()) * getNumberInt(input_jumlah_beli.val())

    input_total_harga.val(total_harga)
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

    $(`#total-harga-akhir`).val(total_harga)
    $(`#total-laba-akhir`).val(total_laba)
  }

</script>
@stop