<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\TotalContribution;
use App\Models\ExpenseReport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
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
                "date",
                "created_at"
            ];

            $total = Event::with(['user'])
                ->where("title", 'LIKE', "%$search%")
                ->orWhere("date", 'LIKE', "%$search%")
                ->orWhere("created_at", 'LIKE', "%$search%")
                ->count();

            $data = Event::with(['user'])
                ->where("title", 'LIKE', "%$search%")
                ->orWhere("date", 'LIKE', "%$search%")
                ->orWhere("created_at", 'LIKE', "%$search%")
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
            'title'         => 'required|string',
            'date'          => 'required|date',
            'description'   => 'required|string',
            'image'         => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);

        $statusRes = false;

        DB::transaction(function () use ($request, &$statusRes) {
            $event                  = new Event();
            $event->image           = $request->file('image')->store('event/' . Auth::user()->id);
            $event->title           = $request->title;
            $event->description     = $request->description;
            $event->date            = $request->date;
            $event->user_id         = Auth::user()->id;

            if (!$event->save()) {
                if ($request->hasFile('image')) {
                    $fileDelete = Event::where('image', '=', $event->image)->first();
                    Storage::delete($fileDelete->image);
                    $fileDelete->delete();
                }
                $statusRes = false;
            } else {
                $statusRes = true;
            }
        });

        if (!$statusRes) {
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
            'title'         => 'required|string',
            'description'   => 'required|string',
            'date'          => 'required|date',
            'image'         => 'mimes:jpeg,jpg,png|max:5000',
        ]);

        $event                 = Event::find($request->id);
        $event->title          = $request->title;
        $event->description    = $request->description;


        if ($request->image != null) {
            if ($event->image != null) {
                $picture = Event::where('image', '=', $event->image)->first();
                Storage::delete($picture->image);
            }

            $event->image = $request->file('image')->store('event/' . Auth::user()->id);
        }

        if (!$event->save()) {
            if ($request->hasFile('image')) {
                $fileDelete = Event::where('image', '=', $event->image)->first();
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
        $statusRes = false;

        DB::transaction(function () use ($id, &$statusRes) {
            $event = Event::find($id);
            Storage::delete($event->image);

            if ($event->delete()) {
                $statusRes = true;
            }
        });

        if ($statusRes) {
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

    public function show($id)
    {
        return $this->view([
            'data' => Event::find($id),
            'total_contribution' => TotalContribution::find(1)
        ]);
    }

    public function salurkanDana(Request $request)
    {
        $validator = $request->validate([
            'id_event'   => 'required|numeric',
            'nominal'       => 'required|numeric',
            'description'   => 'nullable',
        ]);

        $event = Event::find($request->id_event);
        $event->total_dana += $request->nominal;
        $event->save();

        $expenseReport              = new ExpenseReport();
        $expenseReport->out_date    = date("Y-m-d");
        $expenseReport->type        = "Salurkan Galang Dana untuk " . $event->title;
        $expenseReport->nominal     = $request->nominal;
        $expenseReport->description = $request->description;

        if ($expenseReport->save()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Salurkan Galang Dana'
            ]);
        } else {
            return response()->json([
                'success'  => true,
                'message'  => 'Gagal Salurkan Galang Dana'
            ]);
        }
    }

    public function keluarkanIuran(Request $request)
    {
        $validator = $request->validate([
            'id_event'      => 'required|numeric',
            'nominal'       => 'required|numeric',
            'description'   => 'nullable',
        ]);

        $event = Event::find($request->id_event);
        $event->total_contribution += $request->nominal;
        $event->save();

        $expenseReport              = new ExpenseReport();
        $expenseReport->out_date    = date("Y-m-d");
        $expenseReport->type        = "Pengeluaran Iuran untuk " . $event->title;
        $expenseReport->nominal     = $request->nominal;
        $expenseReport->description = $request->description;

        if ($expenseReport->save()) {
            $totalContribution = TotalContribution::find(1);
            $totalContribution->dana -= $request->nominal;
            $totalContribution->save();

            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Salurkan Iuran'
            ]);
        } else {
            return response()->json([
                'success'  => true,
                'message'  => 'Gagal Salurkan Iuran'
            ]);
        }
    }
}
