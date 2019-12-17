<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $search;
            $start = $request->start;
            $length = $request->length;

            if (!empty($request->search))
                $search = $request->search['value'];
            else
                $search = null;

            $column = [
                "title",
                "created_at"
            ];

            $total = Slider::where("title", 'LIKE', "%$search%")
                ->count();

            $data = Slider::where("title", 'LIKE', "%$search%")
                ->orderBy($column[$request->order[0]['column'] - 1], $request->order[0]['dir'])
                ->skip($start)
                ->take($length)
                ->get();

            $response = [
                'data' => $data,
                'draw' => intval($request->draw),
                'recordsTotal' => $total,
                'recordsFiltered' => $total
            ];

            return response()->json($response);
        }

        return $this->view();
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'title'            => 'required|string|max:191|unique:sliders',
            'description'   => 'required|string',
            'image'         => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);

        $slider                 = new Slider();
        $slider->title          = $request->title;
        $slider->description    = $request->description;
        $slider->image          = $request->file('image')->store('slider');

        if (!$slider->save()) {
            if ($request->hasFile('image')) {
                $fileDelete = Slider::where('image', '=', $slider->image)->first();
                Storage::delete($fileDelete->image);
                $fileDelete->delete();
            }

            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menambahkan'
            ]);
        } else {
            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Menambahkan'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'title'            => 'required', 'string', 'max:191', Rule::unique('sliders')->ignore($id),
            'description'   => 'required|string',
            'image'         => 'mimes:jpeg,jpg,png|max:5000',
        ]);

        $slider                 = Slider::find($request->id);
        $slider->title          = $request->title;
        $slider->description    = $request->description;


        if ($request->image != null) {
            if ($slider->image != null) {
                $picture = Slider::where('image', '=', $slider->image)->first();
                Storage::delete($picture->image);
            }

            $slider->image = $request->file('image')->store('slider');
        }

        if (!$slider->save()) {
            if ($request->hasFile('image')) {
                $fileDelete = Slider::where('image', '=', $slider->image)->first();
                Storage::delete($fileDelete->image);
                $fileDelete->delete();
            }

            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Merubah'
            ]);
        } else {
            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Merubah'
            ]);
        }
    }

    public function destroy($id)
    {
        $slider = Slider::find($id);
        Storage::delete($slider->image);

        if ($slider->delete()) {
            return response()->json([
                'success'   => true,
                'message'   => 'Berhasil Menghapus'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menghapus'
            ]);
        }
    }
}
