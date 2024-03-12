<div class="form-group" id="common_message_box_excel">
    <div class="form-group row">
        <div class="col-sm-4">
            <label for="column_list">Seletc Columns</label>
            <select class="form-select @error('area') is-invalid @enderror" id="column_list">
                <option value="">-- Select One --</option>
                @if(count($columns) > 0)
                    @foreach($columns as $col_index=>$col)
                        <option value="{{ strtolower($col) }}"> {{ ucfirst($col) }} </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="form-group mt-2">
        <label>Custom Message</label>
        <textarea class="form-control" id="custom_message" name="custom_message" col="5" row="5" placeholder="Custom Message"></textarea>
    </div>
    <br>

    {{--    excel data to table --}}
    <div class="table-wrapper-scroll-y my-custom-scrollbar">
        <table class="table table-bordered table-sm text-center">
            <thead>
            <tr>
                <th style="width:3%;">
                    <div class="icheck-success border-success">
                        <input type="checkbox" name="check_all" id="custom_check_all"/>
                    </div>
                </th>
                @foreach($columns as $col_index=>$col)
                    <th>{{ ucfirst($col) }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @if(count($data)>0)
                @foreach($data as $data_index=>$datum)
                    <tr>
                        <td>
                            <div class="icheck-success border-success">
                                <input type="checkbox" class="row-select" id="row_id_{{ $data_index }}"
                                       data-row="{{ $data_index }}"/>
                            </div>
                        </td>

{{--                        @for($i=0; $i<count($columns); $i++)--}}
{{--                            <td>--}}
{{--                                {{ array_values($datum)[$i] }}--}}
{{--                                <input type="hidden" name="{{array_keys($datum)[$i]}}[{{$data_index}}]"--}}
{{--                                       value="{{ array_values($datum)[$i] }}">--}}
{{--                            </td>--}}
{{--                        @endfor--}}

                        @foreach($columns as $index=>$col)
                            <td>
                                {{ $datum[$col] }}
                                <input type="hidden" name="{{ $col.'['.$data_index.']' }}" value="{{ $datum[$col] }}">
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            @else
                <tr colspan="{{count($columns)}}">No available Data</tr>
            @endif
            </tbody>
        </table>
    </div>
    <div class="text-center">
        <button type="button" id="generate_msg" class="btn btn-success">Generate Message</button>
    </div>
</div>
