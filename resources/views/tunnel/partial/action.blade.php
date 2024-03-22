<div class="dropdown">
    <a href="#" class="dropdown-toggle card-drop waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="mdi mdi-link font-size-18"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
           @if($data->status === \App\Models\Enums\TunnelStatus::ACTIVE->value)
                <button type="button" class="dropdown-item waves-effect waves-light disable-tunnel-status" data-id="{{$data->slug}}" data-status="{{\App\Models\Enums\TunnelStatus::OFFLINE->value}}">
                    <i class="mdi mdi-lan-disconnect font-size-16 text-danger me-1"></i>
                    {{__('Nonaktifkan')}}
                </button>
            @else
                <button type="button" class="dropdown-item waves-effect waves-light enable-tunnel-status" data-id="{{$data->slug}}" data-status="{{\App\Models\Enums\TunnelStatus::ACTIVE->value}}">
                    <i class="mdi mdi-lan-check font-size-16 text-success me-1"></i>
                    {{__('Aktifkan')}}
                </button>
            @endif
        </li>
        <li>
            <button type="button" class="dropdown-item waves-effect waves-light update-tunnel" data-bs-toggle="modal" data-id="{{$data->slug}}" data-bs-target="#editTunnelModal">
                <i class="mdi mdi-pencil font-size-16 text-success me-1"></i>
                {{__('Ubah')}}
            </button>
        </li>
        <li>
            <button data-id="{{$data->slug}}" type="button" id="btn-hapus-tunnel" class="dropdown-item">
                <i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i>
                {{__('Hapus')}}
            </button>
        </li>
    </ul>
</div>
