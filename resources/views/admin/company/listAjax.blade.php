<table class="table table-hover text-nowrap">
  <thead>
    <tr>
      <th>No.</th>
      <th>Company Name</th>
      <th>Email</th>
      <th>Logo</th>
      <th><i class="bi bi-gear-wide-connected"></i> Action</th>
    </tr>
  </thead>
  <tbody>

    @if (count($companies) > 0)
    @foreach ($companies as $company)
    <tr>
      <td>{{ $loop->iteration }}.</td>
      <td>{{ $company->name }}</td>
      <td>{{ $company->email }}</td>
      <td>
        @if ($company->logo)
        <img src="{{ asset('storage/images/'.$company->logo) }}" class="attachment-img" width="50" height="50" alt="">
        @else
        <img src="{{ asset('storage/images/noimage.jpg') }}" class="attachment-img" width="50" height="50" alt="">
        @endif
      </td>
      <td>
        <a href="/anm/companies/{{ $company->slug }}/edit" title="Edit" class="btn btn-warning btn-sm rounded-3 shadow-sm"><i class="bi bi-pencil"></i> Edit</a>

        <button type="button" value="{{ $company->slug }}" title="Delete" class="btn btn-danger btn-sm rounded-3 shadow-sm" id="btnDelete" data-toggle="modal" data-target="#modalDelete">
          <i class="bi bi-trash3"></i> Delete
        </button>
      </td>
    </tr>
    @endforeach
    @else
    <tr>
      <td class="text-center" colspan="5">No data results</td>
    </tr>
    @endif

  </tbody>
</table>
<div class="col-md border-top">
  <div class="mt-3 ml-2 mr-2">
    {{ $companies->links() }}
  </div>
</div>