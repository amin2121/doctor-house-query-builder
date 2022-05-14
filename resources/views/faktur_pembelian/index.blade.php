@extends('layouts.app', ['title' => 'Faktur Pembelian'])

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Faktur Pembelian</h1>
  </div>
  <div class="row">
    <div class="col-md-12 col-12 col-sm-12">

      @include('layouts.flash-message')

      <div class="card">
        <div class="card-header">
          <h4>Data Faktur Pembelian</h4>
        </div>
        <div class="card-body">
          <a href="{{ route('faktur-pembelian.create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Tambah Data</a>
          <div class="table-responsive">
            <table class="table table-striped table-md">
              <thead>
                <tr>
                  <th>No</th>
                  <th>No Faktur</th>
                  <th>Supplier</th>
                  <th>Tanggal Faktur</th>
                  <th>Total Pembelian</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($faktur_pembelian as $f_pembelian)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $f_pembelian->no_faktur }}</td>
                    <td>{{ $f_pembelian->nama_supplier }}</td>
                    <td>{{ $f_pembelian->tanggal_faktur }}</td>
                    <td>Rp. {{ $f_pembelian->total_harga }}</td>
                    <td>
                      <button class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Detail Pembelian" onclick="get_faktur_pembelian_detail({{ $f_pembelian->id }})">
                        <i class="fa fa-info"></i>
                      </button>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="6" class="text-center">Data Kosong</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="mt-2">
            {{ $faktur_pembelian->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>

</section>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-detail-faktur">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Faktur Pembelian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="table-detail-faktur">
            <thead>
              <tr>
                <th>Nama Obat</th>
                <th>Kategori</th>
                <th>Jumlah Beli</th>
                <th>Harga Pembelian</th>
                <th>Total Harga</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
              <tr>
                <td colspan="4" class="text-right">Total Keseluruhan : </td>
                <th class="text-right"><span id="span-total-keseluruhan" class="text-right"></span></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
      </div>
    </div>
  </div>
</div>

<script>
  function get_faktur_pembelian_detail(id_faktur_pembelian) {
    $.ajax({
      url: '{{ route('faktur-pembelian.show') }}',
      method: 'GET',
      data: {id_faktur_pembelian},
      dataType: 'json',
      success: function(res) {
        let row = ''
        let total_keseluruhan = 0
        if(res.length > 0) {
          for(const item of res) {
            let total_harga = getNumberInt(item.jumlah_beli) * getNumberInt(item.harga_awal)
            total_keseluruhan += total_harga

            row += `
              <tr>
                <td>${item.nama_obat}</td>
                <td>${item.jenis_obat}</td>
                <td class="text-center">${item.jumlah_beli}</td>
                <td class="text-right">Rp. ${item.harga_awal}</td>
                <td class="text-right">Rp. ${total_harga}</td>
              </tr> 
            `
          }
        } else {
          row = `
            <tr>
              <td colspan="5" class="text-center">Data Kosong</td>
            </tr>
          `
        }

        $(`#span-total-keseluruhan`).html(`Rp. ${total_keseluruhan}`)
        $(`#table-detail-faktur tbody`).html(row)

      },
      complete: function() {
        $(`#modal-detail-faktur`).modal('toggle')
      }
    })
  }
</script>

@stop