@extends('layouts.app', ['title' => 'Obat'])

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Obat</h1>
  </div>
  <div class="row">
    <div class="col-md-12 col-12 col-sm-12">

      @include('layouts.flash-message')

      <div class="card">
        <div class="card-header">
          <h4>Data Obat</h4>
        </div>
        <div class="card-body">
          <button class="btn btn-primary mb-3" data-target="#modal-tambah" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Data</button>
          <div class="table-responsive">
            <table class="table table-striped table-md">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Obat</th>
                  <th>Harga Awal(Rp)</th>
                  <th>Harga Jual(Rp)</th>
                  <th>Stok</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($obat as $obt)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                      {{ $obt->nama_obat }}
                      <span class="badge badge-primary">{{ $obt->jenis_obat }}</span>
                    </td>
                    <td>Rp. {{ $obt->harga_awal }}</td>
                    <td>Rp. {{ $obt->harga_jual }}</td>
                    <td>{{ $obt->stok }}</td>
                    <td>
                      <button class="btn btn-info btn-sm" onclick="edit_data({{ $obt->id }}, '{{ $obt->nama_obat }}', '{{ $obt->jenis_obat_id }}', '{{ $obt->harga_awal }}', '{{ $obt->harga_jual }}', '{{ $obt->stok }}')" data-toggle="tooltip" data-placement="left" title="Edit">
                        <i class="fa fa-pencil-alt"></i>
                      </button>
                      <button class="btn btn-danger btn-sm" onclick="delete_data({{ $obt->id }})" data-toggle="tooltip" data-placement="left" title="Hapus"><i class="fa fa-trash"></i></button>
                      <form action="/obat/{{ $obt->id }}/delete" method="POST" id="form-edit-{{ $obt->id }}">
                        @csrf
                        @method('delete')
                      </form>
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
            {{ $obat->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>

</section>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-tambah">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Obat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('obat.store') }}">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="nama-obat">Nama Obat</label>
            <input type="text" name="nama_obat" class="form-control" id="nama-obat">
          </div>
          <div class="form-group">
            <label for="jenis-obat">Jenis Obat</label>
            <select name="jenis_obat_id" id="jenis-obat" class="form-control">
              @foreach ($jenis_obat as $jo)
                <option value="{{ $jo->id }}">{{ $jo->jenis_obat }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="harga-awal">Harga Awal</label>
            <input type="text" name="harga_awal" class="form-control" id="harga-awal">
          </div>
          <div class="form-group">
            <label for="harga-jual">Harga Jual</label>
            <input type="text" name="harga_jual" class="form-control" id="harga-jual">
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-edit">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Obat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('obat.edit') }}">
        @csrf
        @method('put')
        <input type="hidden" name="id" id="edit-id-obat">
        <div class="modal-body">
          <div class="form-group">
            <label for="edit-nama-obat">Nama Obat</label>
            <input type="text" name="nama_obat" class="form-control" id="edit-nama-obat">
          </div>
          <div class="form-group">
            <label for="edit-jenis-obat">Jenis Obat</label>
            <select name="jenis_obat_id" id="edit-jenis-obat" class="form-control">
              @foreach ($jenis_obat as $jo)
                <option value="{{ $jo->id }}">{{ $jo->jenis_obat }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="edit-harga-awal">Harga Awal</label>
            <input type="text" name="harga_awal" class="form-control" id="edit-harga-awal">
          </div>
          <div class="form-group">
            <label for="edit-harga-jual">Harga Jual</label>
            <input type="text" name="harga_jual" class="form-control" id="edit-harga-jual">
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  
  function edit_data(id, nama_obat, jenis_obat_id, harga_awal, harga_jual) {
    $(`#edit-id-obat`).val(id)
    $(`#edit-nama-obat`).val(nama_obat)
    $(`#edit-jenis-obat`).val(jenis_obat_id).change()
    $(`#edit-harga-awal`).val(harga_awal)
    $(`#edit-harga-jual`).val(harga_jual)

    $(`#modal-edit`).modal('toggle')
  }

  function delete_data(id) {
    swal({
      title: 'Apakah Anda Yakin?',
      text: 'Ingin Menghapus Data Ini!',
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $(`#form-edit-${id}`).submit()
      }
    });
  }

</script>

@stop