@extends('layouts.app', ['title' => 'Riwayat Pemeriksaan Pasien'])

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Riwayat Pemeriksaan</h1>
  </div>
  <div class="row">
    <div class="col-md-12 col-12 col-sm-12">

      @include('layouts.flash-message')

      <div class="card">
        <div class="card-header">
          <h4>Data Riwayat Pemeriksaan</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-md">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Pasien</th>
                  <th>Diagnosa</th>
                  <th>Ditangani Oleh</th>
                  <th>Total Resep</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($riwayatPemeriksaanPasien as $riwayat)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                      {{ $riwayat->pasien }} <br>
                      <span class="badge badge-primary">{{ $riwayat->jenis_kelamin == 'pr' ? 'Perempuan' : 'Laki - Laki' }}</span>
                    </td>
                    <td>{{ $riwayat->diagnosa }}</td>
                    <td>{{ $riwayat->dokter }}</td>
                    <td>Rp. {{ number_format($riwayat->total_nominal) }}</td>
                    <td>
                      <button class="btn btn-success btn-md" onclick="show_data({{ $riwayat->id }}, '{{ $riwayat->pasien_id }}', '{{ $riwayat->nama_pasien }}', '{{ $riwayat->alamat }}', '{{ $riwayat->no_telp }}', '{{ $riwayat->jenis_kelamin }}', '{{ $riwayat->umur }}', '{{ $riwayat->status_umur }}')" data-toggle="tooltip" data-placement="left" title="Detail Pemeriksaan">
                        <i class="fa fa-info"></i>
                      </button>
                      <button class="btn btn-info btn-md" onclick="print_riwayat({{ $riwayat->id }})" data-toggle="tooltip" data-placement="left" title="Print Nota"><i class="fa fa-print"></i></button>
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
            {{ $riwayatPemeriksaanPasien->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>

</section>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-detail">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Pemeriksaan Pasien & Resep Obat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="detail-pasien-tab" data-toggle="tab" href="#detail-pasien" role="tab" aria-controls="detail-pasien" aria-selected="true">Detail Pasien</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="resep-obat-tab" data-toggle="tab" href="#resep-obat" role="tab" aria-controls="resep-obat" aria-selected="false">Resep Obat</a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="detail-pasien" role="tabpanel" aria-labelledby="detail-pasien-tab">
                <div class="form-group row">
                  <label for="nama-pasien" class="col-form-label col-sm-2">Nama Pasien</label>
                  <div class="col-sm-10">
                    <input type="text" readonly="" class="form-control" id="nama-pasien">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="no-telp" class="col-form-label col-sm-2">No Telp</label>
                  <div class="col-sm-10">
                    <input type="text" readonly="" class="form-control" id="no-telp">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="alamat" class="col-form-label col-sm-2">Alamat</label>
                  <div class="col-sm-10">
                    <input type="text" readonly="" class="form-control" id="alamat">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="jenis-kelamin" class="col-form-label col-sm-2">Jenis Kelamin</label>
                  <div class="col-sm-10">
                    <input type="text" readonly="" class="form-control" id="jenis-kelamin">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="umur" class="col-form-label col-sm-2">Umur</label>
                  <div class="col-sm-10">
                    <input type="text" readonly="" class="form-control" id="umur">
                  </div>
                </div>
            </div>
            <div class="tab-pane fade" id="resep-obat" role="tabpanel" aria-labelledby="resep-obat-tab">
              <div class="table-responsive">
                <table class="table table-striped" id="table-resep-obat">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Obat</th>
                      <th>Jumlah</th>
                      <th>Harga Jual</th>
                      <th>Total Harga</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4" class="text-right"><b>Total :</b></td>
                      <td class="text-left"><b id="text-total-harga"></b></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
        </div>
    </div>
  </div>
</div>

<script>
  
  function show_data(id, pasien_id, nama_pasien, alamat, no_telp, jenis_kelamin, umur, status_umur) {
    $(`#nama-pasien`).val(nama_pasien)
    $(`#no-telp`).val(no_telp)
    $(`#alamat`).val(alamat)
    $(`#jenis-kelamin`).val(jenis_kelamin == 'pr' ? 'Perempuan' : 'Laki - Laki')
    $(`#umur`).val(`${umur} ${status_umur}`)

    $(`#modal-detail`).modal('toggle')

    get_resep_obat(id)
  }

  function get_resep_obat(id) {
    $.ajax({
      url: "{{ route('riwayat-pemeriksaan-pasien.detail-obat') }}",
      method: 'GET',
      data: {id},
      dataType: 'json',
      success: function (res) {
        let table = ''
        let total_harga = 0;

        if(res.length > 0) {
          let no = 0;
          for(const item of res) {
            table += `
              <tr>
                <td>${++no}</td>
                <td>${item.nama_obat}</td>
                <td>${item.jumlah_beli}</td>
                <td>${formatRupiah(item.harga_jual)}</td>
                <td>${formatRupiah(item.total_harga)}</td>
              </tr> 
            `

            total_harga += item.total_harga
          }
        } else {
          table = `
            <tr>
              <td colspan="4">Data Kosong</td>
            </tr>
          `
        }

        $(`#table-resep-obat tbody`).html(table)
        $(`#text-total-harga`).text(formatRupiah(total_harga))
      }

    })
  }

</script>

@stop