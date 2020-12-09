@if($shortLinks->count() != 0)
    @php $cou = 100 @endphp
    @foreach($shortLinks as $row)
        <div class="col-12 col-sm-6 col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{$cou}}" style="margin-bottom: 10px;">
            <div class="media-entry h-100">
                <div class="bg-white m-body">
                    <span class="date">{{date_format($row->created_at,'M').' '.date_format($row->created_at,'d').', '.date_format($row->created_at,'Y')}}</span>
                    <h3><a href="{{ route('shorten.link', $row->code) }}">{{ $row->name }}</a></h3>

                    <div class="row">
                        <a data-id="{{$row->code}}" class="btn_edit  col-6 more d-flex justify-content-start">
                            <span class="label">Edit</span>
                            <span class="arrow"><span class="icon-edit"></span></span>
                        </a>

                        <a data-id="{{$row->code}}" class="btn_delete more d-flex justify-content-end">
                            <span class="label">Delete</span>
                            <span class="arrow"><span class="icon-trash"></span></span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        @php $cou = 100 + $cou @endphp
    @endforeach
@else
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center alert alert-danger">
        <p> Empty table</p>
    </div>
@endif

<div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top: 10px;">
    <nav class="navigation">
        {{$shortLinks->render()}}
    </nav>
</div>
