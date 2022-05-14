@extends('layouts.app', ['title' => 'Supplier'])

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Supplier</h1>
  </div>
  <div class="row">
    <div class="col-md-12 col-12 col-sm-12">

      @include('layouts.flash-message')

      <div class="card">
        <div class="card-header">
          <h4>Data Supplier</h4>
        </div>
        <div class="card-body">
          <button class="btn btn-primary mb-3" data-target="#modal-tambah" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Data</button>
          <div class="table-responsive">
            <table class="table table-striped table-md">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Supplier</th>
                  <th>Alamat</th>
                  <th>No Telp</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($supplier as $spl)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $spl->nama_supplier }}</td>
                    <td>{{ $spl->alamat }}</td>
                    <td>{{ $spl->no_telp }}</td>
                    <td>
                      <button class="btn btn-info btn-sm" onclick="edit_data({{ $spl->id }}, '{{ $spl->nama_supplier }}', '{{ $spl->alamat }}', '{{ $spl->no_telp }}')" data-toggle="tooltip" data-placement="left" title="Edit">
                        <i class="fa fa-pencil-alt"></i>
                      </button>
                      <button class="btn btn-danger btn-sm" onclick="delete_data({{ $spl->id }})" data-toggle="tooltip" data-placement="left" title="Hapus"><i class="fa fa-trash"></i></button>
                      <form action="/supplier/{{ $spl->id }}/delete" method="POST" id="form-edit-{{ $spl->id }}">
                        @csrf
                        @method('delete')
                      </form>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" class="text-center">Data Kosong</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="mt-2">
            {{ $supplier->links() }}
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
        <h5 class="modal-title">Tambah Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('supplier.store') }}">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="nama-supplier">Nama Supplier</label>
            <input type="text" name="nama_supplier" id="nama-supplier" class="form-control">
          </div>
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control">
          </div>
          <div class="form-group">
            <label for="no-telp">No Telepon</label>
            <input type="text" name="no_telp" id="no-telp" class="form-control">
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
        <h5 class="modal-title">Edit Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('supplier.edit') }}">
        @csrf
        @method('put')
        <input type="hidden" name="id" id="edit-id-supplier">
        <div class="modal-body">
          <div class="form-group">
            <label for="edit-nama-supplier">Nama Supplier</label>
            <input type="text" name="nama_supplier" id="edit-nama-supplier" class="form-control">
          </div>
          <div class="form-group">
            <label for="edit-alamat">Alamat</label>
            <input type="text" name="alamat" id="edit-alamat" class="form-control">
          </div>
          <div class="form-group">
            <label for="edit-no-telp">No Telepon</label>
            <input type="text" name="no_telp" id="edit-no-telp" class="form-control">
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
  
  function edit_data(id, nama_supplier, alamat, no_telp) {
    $(`#edit-id-supplier`).val(id)
    $(`#edit-nama-supplier`).val(nama_supplier)
    $(`#edit-alamat`).val(alamat)
    $(`#edit-no-telp`).val(no_telp)

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