<?php

    namespace App\Http\Controllers;

    use App\Models\Page;
    use App\Models\Section;
    use Illuminate\Http\Request;
    use TCG\Voyager\Http\Controllers\VoyagerBaseController;
    use TCG\Voyager\Facades\Voyager;

    class PageSectionOrderController extends VoyagerBaseController
    {
        //

        /**
         * Order BREAD items.
         *
         * @param string $table
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function order(Request $request, $page_id = 0)
        {
            $slug = "page-sections";

            $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

            // Check permission
            $this->authorize('edit', app($dataType->model_name));

            if (empty($dataType->order_column) || empty($dataType->order_display_column)) {
                return redirect()
                ->route("voyager.{$dataType->slug}.index")
                ->with([
                    'message'    => __('voyager::bread.ordering_not_set'),
                    'alert-type' => 'error',
                ]);
            }

            $model = app($dataType->model_name);
            $query = $model->query();
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
                $query = $query->withTrashed();
            }
            $lesSections = [];
            $lesPages = [];
            $results = [];
            if($page_id):
                $results = $query->where('page_id', $page_id)->orderBy($dataType->order_column, $dataType->order_direction)->get();
                $lesSectionsBrutes = Section::get(['id','name'])->toArray();
                $lesSections = [];
                foreach ($lesSectionsBrutes as $v) :
                    $lesSections[$v['id']] = $v['name'] ;
                endforeach;
            endif;
            $pages = Page::orderBy('name', 'ASC')->get(['id', 'name', 'slug'])->toArray();
            foreach($pages AS $page):
                $lesPages[$page['id']] = $page;
            endforeach;
            $display_column = $dataType->order_display_column;

            $dataRow = Voyager::model('DataRow')->whereDataTypeId($dataType->id)->whereField($display_column)->first();

            $view = 'voyager::bread.order';

            if (view()->exists("voyager::$slug.order")) {
                $view = "voyager::$slug.order";
            }

            return Voyager::view($view, compact(
                'dataType',
                'display_column',
                'dataRow',
                'results',
                'page_id',
                'lesSections',
                'lesPages'
            ));
        }

    }