@extends('frontend.layout.base')

@push('main-container-class')
site-main-inner-push
@endpush

@section('content')
    <section class="block--2 sign-in">
        <div class="container">

            <div class="user-entry">
                <div class="bzg bzg--no-gutter">
                    <div class="bzg_c" data-col="m6" data-offset="m3">
                        <div class="box text-center">
                            <div class="block">
                                <div class="block__head">
                                    <h3 class="title">
                                        Login untuk berbelanja di SMILE
                                    </h3>
                                </div>
                                @if ($errors->count() > 0)
                                    <div class="flash-msg flash-msg--warn">
                                        Data yang Anda masukkan tidak valid, silahkan ulangi kembali!
                                    </div>
                                @endif
                                @if ($errorMessage = Session::get('message_error'))
                                    <div class="flash-msg flash-msg--warn">
                                        {!! $errorMessage !!}
                                    </div>
                                @endif
                                <div class="block__content">
                                    {!!Form::open(['route' => 'smilesessions.store', 'class' => 'text-left'])!!}
                                        <div class="block-half">
                                            <label for="selectCluster"><small>Apartemen</small></label>
                                            <select class="form-input" id="selectCluster" name="cluster" required="required">
                                                @foreach (App\Models\Cluster::all() as $cluster)
                                                    <option value="{{ $cluster->id }}">{{ $cluster->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="block-half">
                                            <label for="selectTower"><small>Nama Tower</small></label>
                                            <select class="form-input" id="selectTower" name="tower" required="required">
                                                <option value="null">-- Pilih Tower --</option>
                                            </select>
                                        </div>
                                        <div class="block-half">
                                            <label for="selectFloor"><small>Lantai</small></label>
                                            <select class="form-input" id="selectFloor" name="floor" required="required">
                                                <option value="null">-- Pilih Lantai --</option>
                                            </select>
                                        </div>
                                        <div class="block-half">
                                            <label for="selectUnit"><small>Unit</small></label>
                                            <select class="form-input" id="selectUnit" name="unit" required="required">
                                                <option value="null">-- Pilih Unit --</option>
                                            </select>
                                        </div>
                                        <div class="block-half">
                                            <label for="selectStatus"><small>Status</small></label>
                                            <select class="form-input" id="selectStatus" name="status" required="required">
                                                <option value="{{ App\Models\UserUnit::OWNER }}">Pemilik</option>
                                                <option value="{{ App\Models\UserUnit::TENANT }}">Penyewa</option>
                                            </select>
                                        </div>
                                        <div class="block-half">
                                            <label for="loginPassword"><small>Password</small></label>
                                            <input class="form-input" id="loginPassword" type="password" name="password" required="required" placeholder="Masukkan password">
                                        </div>
                                        <button class="btn btn--block btn--orange block-half">Log in</button>
                                        <div class="text-center">
                                            <a class="anchor-normal" href="{{ route('frontend.user.forgetpassword') }}"><small>Forgot password?</small></a>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- sing-in -->
@stop

@section('js-script')
    <script>
        var initClusterValue = "{{ old('cluster') }}";
        var initTowerValue = "{{ old('tower') }}";
        var initFloorValue = "{{ old('floor') }}";
        var initUnitValue = "{{ old('unit') }}";
        var initStatusValue = "{{ old('status') }}";
        function inputClusterChange() {
            if ($(this).val() != "") {
                $.get("{{ route('frontend.cluster.fetcher') }}", { id: $(this).val() },
                    function(data) {
                        var model = $('#selectTower');

                        model.empty();
                        model.append("<option value=''>-- Pilih Tower --</option>");
                        $('#selectFloor').empty();
                        $('#selectUnit').empty();
                        $('#selectFloor').append("<option value=''>-- Pilih Lantai --</option>");
                        $('#selectUnit').append("<option value=''>-- Pilih Unit --</option>");

                        $.each(data, function(index, element) {
                            model.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                        });

                        model.val(initTowerValue).trigger("change");
                        initTowerValue = "";
                });
            } else {
                $('#selectCluster').val("").trigger("change");
            }
        }

        function inputTowerChange() {
            if ($(this).val() != "") {
                $.get("{{ route('frontend.tower.fetcher') }}", { id: $(this).val() },
                    function(data) {
                        var model = $('#selectFloor');

                        model.empty();
                        model.append("<option value=''>-- Pilih Lantai --</option>");
                        $('#selectUnit').empty();
                        $('#selectUnit').append("<option value=''>-- Pilih Unit --</option>");

                        $.each(data, function(index, element) {
                            model.append("<option value='"+ element.floor +"'>" + element.floor + "</option>");
                        });

                        model.val(initFloorValue).trigger("change");
                        initFloorValue = "";
                });
            } else {
                $('#selectTower').val("").trigger("change");
            }
        }

        function inputFloorChange(){
            if ($(this).val() != "") {
                $.get("{{route('frontend.floor.fetcher') }}", { floor: $(this).val(), tower: $('#selectTower option:selected').val() },
                    function(data) {
                        var model = $('#selectUnit');
                        model.empty();

                        model.append("<option value=''>-- Pilih Unit --</option>");
                        $.each(data, function(index, element) {
                            model.append("<option value='"+ element.id +"'>" + element.number + "</option>");
                        });

                        model.val(initUnitValue).trigger("change");
                        initUnitValue = "";
                });
            } else {
                $('#selectUnit').val("").trigger("change");
            }
        }

        $('#selectCluster').bind("change", inputClusterChange);
        $('#selectTower').bind("change", inputTowerChange);
        $('#selectFloor').bind("change", inputFloorChange);
        // init trigger
        if (initClusterValue != "") {
            $('#selectCluster').val(initClusterValue).trigger("change");
            initClusterValue = "";
        } else {
            $('#selectCluster').trigger("change");
        }
        if (initStatusValue != "") {
            $('#selectStatus').val(initStatusValue).trigger("change");
            initStatusValue = "";
        } else {
            $('#selectStatus').trigger("change");
        }
    </script>
@endsection
