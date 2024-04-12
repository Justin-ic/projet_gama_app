@extends('voyager::master')

    @section('page_title', $dataType->getTranslatedAttribute('display_name_plural') . ' ' . __('voyager::bread.order'))

    @section('page_header')
    <h1 class="page-title">
        <i class="voyager-list"></i>{{ $dataType->getTranslatedAttribute('display_name_plural') }} {{ __('voyager::bread.order') }}
    </h1>
    @stop

    @section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-bordered">
                    <div class="panel-heading">
                        <p class="panel-title" style="color:rgb(10, 10, 10)">{{ 'Cliquez sur une page pour ordonner ses sections' }}</p>
                    </div>

                    <div class="panel-body" style="padding:30px;">
                        <div class="dd">
                            <ul style="list-style: none">
                                @foreach ($lesPages AS $pid => $laPage)
                                <li class="">
                                    @php($class = $page_id == $pid ? "success" : "primary")
                                    <a href="{{ route('voyager.page-sections.order', ['page_id' => $pid]) }}"
                                        class="btn btn-{{ $class }}  btn-add-new">
                                        <i class="voyager-plus"></i> {{ $laPage['name'] }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            @if($page_id)
                <div class="col-md-9">
                    <div class="panel panel-bordered">
                        <div class="panel-heading">
                            <p class="panel-title" style="color:#777">{{ __('voyager::generic.drag_drop_info') }}</p>
                        </div>

                        <div class="panel-body" style="padding:30px;">
                            <div class="dd">
                                <ol class="dd-list">
                                    @foreach ($results as $result)
                                    <li class="dd-item" data-id="{{ $result->getKey() }}">
                                        <div class="dd-handle" style="height:inherit">
                                            @if (isset($dataRow->details->view))
                                                @include($dataRow->details->view, ['row' => $dataRow, 'dataType' => $dataType, 'dataTypeContent' => $result, 'content' => $result->{$display_column}, 'action' => 'order'])
                                            @elseif($dataRow->type == 'image')
                                                <span>
                                                    <img src="@if( !filter_var($result->{$display_column}, FILTER_VALIDATE_URL)){{ Voyager::image( $result->{$display_column} ) }}@else{{ $result->{$display_column} }}@endif" style="height:100px">
                                                </span>
                                            @else
                                                <span>{{ $lesSections[$result->{$display_column}] }}</span>
                                            @endif
                                        </div>
                                    </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @stop

    @section('javascript')

    <script>
    $(document).ready(function () {
        $('.dd').nestable({
            maxDepth: 1
        });

        /**
        * Reorder items
        */
        $('.dd').on('change', function (e) {
            $.post('{{ route('voyager.'.$dataType->slug.'.order') }}', {
                order: JSON.stringify($('.dd').nestable('serialize')),
                _token: '{{ csrf_token() }}'
            }, function (data) {
                toastr.success("{{ __('voyager::bread.updated_order') }}");
            });
        });
    });
    </script>
    @stop