@extends('layouts.app', ['title' => 'Pasien'])

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Pasien</h1>
  </div>
  <div class="row">
    <div class="col-md-12 col-12 col-sm-12">

      @include('layouts.flash-message')

      <div class="card">
        <div class="card-header">
          <h4>Data Pasien</h4>
        </div>
        <div class="card-body">
          <button class="btn btn-primary mb-3" data-target="#modal-tambah" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Data</button>
          <div class="table-responsive">
            <table class="table table-striped table-md">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Pasien</th>
                  <th>Alamat</th>
                  <th>No Telp</th>
                  <th>JK/Umur</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($pasien as $psi)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $psi->nama_pasien }}</td>
                    <td>{{ $psi->alamat }}</td>
                    <td>{{ $psi->no_telp }}</td>
                    <td>{{ $psi->jenis_kelamin == 'lk' ? 'Laki - Laki' : 'Perempuan' }}/{{ $psi->umur }} {{ $psi->status_umur }}</td>
                    <td>
                      <button class="btn btn-info btn-sm" onclick="edit_data({{ $psi->id }}, '{{ $psi->nama_pasien }}', '{{ $psi->alamat }}', '{{ $psi->no_telp }}', '{{ $psi->jenis_kelamin }}', '{{ $psi->umur }}', '{{ $psi->status_umur }}')" data-toggle="tooltip" data-placement="left" title="Edit">
                        <i class="fa fa-pencil-alt"></i>
                      </button>
                      <button class="btn btn-danger btn-sm" onclick="delete_data({{ $psi->id }})" data-toggle="tooltip" data-placement="left" title="Hapus"><i class="fa fa-trash"></i></button>
                      <form action="/pasien/{{ $psi->id }}/delete" method="POST" id="form-edit-{{ $psi->id }}">
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
            {{ $pasien->links() }}
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
        <h5 class="modal-title">Tambah Pasien</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('pasien.store') }}">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="nama-pasien">Nama Pasien</label>
            <input type="text" name="nama_pasien" class="form-control" id="nama-pasien">
          </div>
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" class="form-control" id="alamat">
          </div>
          <div class="form-group">
            <label for="no-telp">No Telp</label>
            <input type="text" name="no_telp" class="form-control" id="no-telp">
          </div>
          <div class="form-group">
            <label for="jenis-kelamin">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis-kelamin" class="form-control">
              <option value="lk">Laki - Laki</option>
              <option value="pr">Perempuan</option>
            </select>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="umur">Umur</label>
                <input type="text" name="umur" class="form-control" id="umur">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="status-umur">Status Umur</label>
                <select name="status_umur" id="status-umur" class="form-control">
                  <option value="tahun">Tahun</option>
                  <option value="bulan">Bulan</option>
                  <option value="hari">Hari</option>
                </select>
              </div>
            </div>
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
        <h5 class="modal-title">Edit Pasien</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('pasien.edit') }}">
        @csrf
        @method('put')
        <input type="hidden" name="id" id="edit-id-pasien">
        <div class="modal-body">
          <div class="form-group">
            <label for="edit-nama-pasien">Nama Pasien</label>
            <input type="text" name="nama_pasien" class="form-control" id="edit-nama-pasien">
          </div>
          <div class="form-group">
            <label for="edit-alamat">Alamat</label>
            <input type="text" name="alamat" class="form-control" id="edit-alamat">
          </div>
          <div class="form-group">
            <label for="edit-no-telp">No Telp</label>
            <input type="text" name="no_telp" class="form-control" id="edit-no-telp">
          </div>
          <div class="form-group">
            <label for="edit-jenis-kelamin">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="edit-jenis-kelamin" class="form-control">
              <option value="lk">Laki - Laki</option>
              <option value="pr">Perempuan</option>
            </select>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="edit-umur">Umur</label>
                <input type="text" name="umur" class="form-control" id="edit-umur">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="edit-status-umur">Status Umur</label>
                <select name="status_umur" id="edit-status-umur" class="form-control">
                  <option value="tahun">Tahun</option>
                  <option value="bulan">Bulan</option>
                  <option value="hari">Hari</option>
                </select>
              </div>
            </div>
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
  
  function edit_data(id, nama_pasien, alamat, no_telp, jenis_kelamin, umur, status_umur) {
    $(`#edit-id-pasien`).val(id)
    $(`#edit-nama-pasien`).val(nama_pasien)
    $(`#edit-alamat`).val(alamat)
    $(`#edit-no-telp`).val(no_telp)
    $(`#edit-umur`).val(umur)
    $(`#edit-status-umur`).val(status_umur).change()
    $(`#edit-jenis-kelamin`).val(jenis_kelamin).change()

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