<div class="dropdown">
    <a href="#" class="dropdown-toggle card-drop waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="mdi mdi-link font-size-18"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <button type="button" id="check-online" class="dropdown-item waves-effect waves-light" data-id="{{$data->id}}">
                <i class="mdi mdi-connection font-size-16 text-primary me-1"></i>
                {{__('Cek Online')}}
            </button>
        </li>
        <li>
            <button type="button" class="dropdown-item waves-effect waves-light update-server" data-bs-toggle="modal" data-id="{{$data->slug}}" data-bs-target="#editMikrotikServerModal">
                <i class="mdi mdi-pencil font-size-16 text-success me-1"></i>
                {{__('Ubah')}}
            </button>
        </li>
        <li>
            <button data-id="{{$data->slug}}" type="button" id="btn-hapus-server" class="dropdown-item">
                <i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i>
                {{__('Hapus')}}
            </button>
        </li>
    </ul>
</div>
