<?php

namespace App\Http\Controllers\panel;

use App\Helpers\Reply;
//use App\Models\CsvData;
use App\Models\Field;
use App\Models\Form;
use App\Models\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
//use Excel;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $check = $this->checkExistField($request->form_id,$request->name);
        if(! $check){
            $order = 1;
            $field = Field::orderBy('order','desc')->first();

            if($field){
                $order = $field->order + 1;
            }

            Field::create([
                'name' => $request->name,
                'description' => $request->description,
                'active' => (isset($request->active) ? 1 : 0),
                'question' => (isset($request->question) ? 1 : 0),
                'type' => $request->type,
                'mark' => ($request->mark ? $request->mark : 0),
                'required' => (isset($request->required) ? 1 : 0),
                'filter' => (isset($request->filter) ? 1 : 0),
                'sync' => (isset($request->sync) ? 1 : 0),
                'order' => $order,
                'form_id' => $request->form_id
            ]);
            return Reply::successJson('admin.save_succeeded', '', 201);
        }

        return Reply::errorJson('admin.key_has_duplicate', '', 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $form = Form::findOrFail($id);

        $types = [
            'text' => 'متن',
            'textarea' => 'متن زیاد',
            'select' => 'انتخابی',
            'multi-select' => 'چند انتخابی',
            'number' => 'عدد',
            'date' => 'تاریخ',
            'time' => 'زمان',
        ];
        return view('panel.field.create',[
            'form' => $form,
            'types' => $types
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = Field::findOrFail($id);
        $options = $field->option;
        $types = [
            'text' => 'متن',
            'textarea' => 'متن زیاد',
            'select' => 'انتخابی',
            'multi-select' => 'چند انتخابی',
            'number' => 'عدد',
            'date' => 'تاریخ',
            'time' => 'زمان',
        ];
        return view('panel.field.edit',[
            'field' => $field,
            'options' => $options,
            'types' => $types
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $field = Field::find($id);

        $field->update([
            'name' => $request->name,
            'description' => $request->description,
            'active' => (isset($request->active) ? 1 : 0),
            'question' => (isset($request->question) ? 1 : 0),
            'type' => $request->type,
            'required' => (isset($request->required) ? 1 : 0),
            'filter' => (isset($request->filter) ? 1 : 0),
            'sync' => (isset($request->sync) ? 1 : 0)
        ]);

        return Reply::successJson('عملیات موفق', '', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function field($id)
    {
        $form = Form::find($id);
        $fields = $form->field()->orderBy('order', 'asc')->get();
        $options = [
            'text' => 'متن',
            'textarea' => 'متن زیاد',
            'select' => 'انتخابی',
            'multi-select' => 'چند انتخابی',
            'number' => 'عدد',
            'date' => 'تاریخ',
            'time' => 'زمان',

        ];
        return view('panel.form.field', [
            'form' => $form,
            'fields' => $fields,
            'options' => $options
        ]);
    }

    public function destroyField($id)
    {
        $field = Field::find($id);
        if($field){
            $field->delete();
            return Reply::successJson('admin.delete_succeeded', '', 201);
        }
        return Reply::errorJson('admin.not_found', '', 404);
    }

    public function updateOrderField(Request $request, $id)
    {
        $fields = Field::where('form_id', $id)->get();

        foreach ($fields as $field) {
            $field->timestamps = false; // To disable update_at field updation
            $id = $field->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $field->update(['order' => $order['position']]);
                }
            }
        }

        return response('Update Successfully.', 200);
    }

    public function fieldAjaxStatus(Request $request, $id)
    {
        $field = Field::findOrFail($id);
        $field->active = $request->status;
        if ($field->update()) {
            return Reply::successJson('عملیات موفق', '', 201);
        }
        return Reply::errorJson('admin.failed', '', 404);
    }

    public function fieldAjaxRequiredStatus(Request $request, $id)
    {
        $field = Field::findOrFail($id);
        $field->required = $request->status;
        if ($field->update()) {
            return Reply::successJson('عملیات موفق', '', 201);
        }
        return Reply::errorJson('admin.failed', '', 404);
    }

    public function parseImport(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $path = $request->file('csv_file')->getRealPath();

        if ($request->has('header')) {
            $data = Excel::load($path, function ($reader) {
            })->get()->toArray();
        } else {
            $data = array_map('str_getcsv', file($path));
        }

        if (count($data) > 0) {
            $csv_header_fields = [];
            if ($request->has('header')) {
                foreach ($data[0] as $key => $value) {
                    $csv_header_fields[] = $key;
                }
            }
            $csv_data = array_slice($data, 0, 2);

            $csv_data_file = CsvData::create([
                'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                'csv_header' => $request->has('header'),
                'csv_data' => json_encode($data),
            ]);
        } else {
            return Reply::errorJson('هیچ دیتایی در فایل یافت نشد!');
        }
        $fields = ['name', 'key', 'active', 'question', 'type', 'required', 'sync', 'filter', 'report'];


        return view('panel.form.import', [
            'csv_header_fields' => $csv_header_fields,
            'csv_data' => $csv_data,
            'csv_data_file' => $csv_data_file,
            'fields' => $fields,
            'form_id' => $id
        ]);

    }

    public function processImport(Request $request)
    {
        $data = CsvData::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        $fields = ['name', 'key', 'active', 'question', 'type', 'required', 'sync', 'filter', 'report'];

        $order = Field::where('form_id',$request->form_id)->orderBy('order','desc')->first();
        if($order){
            $order = $order->order + 1;
        } else {
            $order = 1;
        }

        foreach ($csv_data as $row) {

            $item = new Field();
            foreach ($fields as $index => $field) {
                if ($data->csv_header) {
                    if ($row[$request->fields[$field]]) {
                        $item->$field = $row[$request->fields[$field]];
                    }

                } else {
                    if ($row[$request->fields[$index]]) {
                        $item->$field = $row[$request->fields[$index]];
                    }
                }
            }

            $item->form_id = $request->form_id;
            $item->order = $order;

            $check = $this->checkExistField($request->form_id, $item->key);

            if (!$check) {
                $item->save();
                $order += 1;
            }

        }

        return view('panel.form.success');
    }

    public function checkExistField($form_id,$name)
    {
        $check = Field::where('form_id', $form_id)->where('name',$name)->first();
        if ($check) {
            return true;
        }
        return false;
    }

    public function changeTypeAjax(Request $request,$id)
    {
        $field = Field::find($id);
        if($field){
            $field->update([
                'type' => $request->type
            ]);
            return Reply::successJson('admin.refresh_succeeded', '', 201);
        }
        return Reply::errorJson('admin.not_found', '', 404);
    }

    public function option($id)
    {
        $field = Field::findOrFail($id);
        $options = $field->option()->orderBy('order','asc')->get();
        return view('panel.field.option',[
            'options' => $options,
            'field' => $field
        ]);
    }

    public function optionLoad($id)
    {
        $field = Field::findOrFail($id);
        $options = $field->option()->orderBy('order','asc')->get();
        return view('panel.field.load',[
            'options' => $options,
            'field' => $field
        ])->render();
    }

    public function optionStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $order = 1;
        $last = Option::where('field_id',$request->field_id)->orderBy('order','desc')->first();
        if($last){
            $order = $last->order + 1;
        }
        $check = Option::where('field_id',$request->field_id)->where('code', $request->code)->first();
        if(!$check){
            Option::create([
                'field_id' => $request->field_id,
                'value' => $request->name,
                'order' => $order,
                'active' => (isset($request->active) ? 1 : 0),
                'mark' => (isset($request->mark) ? $request->mark : 0),
                'code' => $request->code,
            ]);
            return Reply::successJson('admin.save_succeeded', '', 201);
        }
        return Reply::errorJson('admin.key_has_duplicate', '', 400);
    }



    public function optionAjaxStatus(Request $request, $id)
    {
        $option = Option::findOrFail($id);
        $option->active = $request->status;
        if ($option->update()) {
            return Reply::successJson('عملیات موفق', '', 201);
        }
        return Reply::errorJson('admin.failed', '', 404);
    }


    public function updateOrderOption(Request $request, $id)
    {
        $fields = Option::where('field_id',$id)->get();
        foreach ($fields as $field) {
            $field->timestamps = false; // To disable update_at field updation
            $id = $field->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $field->update(['order' => $order['position']]);
                }
            }
        }

        return response('Update Successfully.', 200);
    }


    public function destroyOption($id)
    {
        $option = Option::find($id);
        if($option){
            $option->delete();
            return Reply::successJson('admin.delete_succeeded', '', 201);
        }
        return Reply::errorJson('admin.not_found', '', 404);
    }

    public function formFieldGetAjax(Request $request)
    {
        $fields = Field::whereActive(1)->where("form_id", $request->form_id)->where('question', 0)
            ->pluck("name", "key");
        return response()->json($fields);
    }

}
