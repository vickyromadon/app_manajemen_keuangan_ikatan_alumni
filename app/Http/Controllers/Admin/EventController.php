<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Accountancy;
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
            'title'         => 'required|string|max:20',
            'date'          => 'required|date',
            'image'         => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);

        if ($request->description == "") {
            return response()->json([
                'success'   => false,
                'message'   => 'Harap Isi, Deskripsi Terlebih Dahulu.'
            ]);
        }

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
            'title'         => 'required|string|max:20',
            'date'          => 'required|date',
            'image'         => 'mimes:jpeg,jpg,png|max:5000',
        ]);

        if ($request->description == "") {
            return response()->json([
                'success'   => false,
                'message'   => 'Harap Isi, Deskripsi Terlebih Dahulu.'
            ]);
        }

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
            'id_event'      => 'required|numeric',
            'nominal'       => 'required|numeric',
            'receiver'      => 'required|string',
            'description'   => 'required|string',
            'bank_name'      => 'required|string',
            'bank_number'      => 'required|numeric',
            'bank_owner'      => 'required|string',
            'proof'         => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);

        $event = Event::find($request->id_event);
        $event->total_dana += $request->nominal;
        $event->save();

        $expenseReport              = new ExpenseReport();
        $expenseReport->code        = "OUT/EVT/" . date("YmdHms");
        $expenseReport->out_date    = date("Y-m-d");
        $expenseReport->type        = "Salurkan Galang Dana untuk " . $event->title;
        $expenseReport->nominal     = $request->nominal;
        $expenseReport->description = $request->description;
        $expenseReport->receiver    = $request->receiver;
        $expenseReport->sender      = Auth::user()->name;
        $expenseReport->bank_name   = $request->bank_name;
        $expenseReport->bank_number = $request->bank_number;
        $expenseReport->bank_owner  = $request->bank_owner;
        $expenseReport->proof          = $request->file('proof')->store('expense_report');


        if ($expenseReport->save()) {
            $accountancy                = new Accountancy();
            $accountancy->code          = $expenseReport->code;
            $accountancy->date          = $expenseReport->out_date;
            $accountancy->type          = $expenseReport->type;
            $accountancy->income        = 0;
            $accountancy->expense       = $expenseReport->nominal;
            $accountancy->total         = $expenseReport->nominal;
            $accountancy->save();

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
            'description'   => 'required|string',
            'receiver'      => 'required|string'
        ]);

        $event = Event::find($request->id_event);
        $event->total_contribution += $request->nominal;
        $event->save();

        $expenseReport              = new ExpenseReport();
        $expenseReport->code        = "OUT/CTB-EVT/" . date("YmdHms");
        $expenseReport->out_date    = date("Y-m-d");
        $expenseReport->type        = "Pengeluaran Iuran untuk " . $event->title;
        $expenseReport->nominal     = $request->nominal;
        $expenseReport->description = $request->description;
        $expenseReport->sender      = Auth::user()->name;
        $expenseReport->receiver    = $request->receiver;

        if ($expenseReport->save()) {
            $totalContribution = TotalContribution::find(1);
            $totalContribution->dana -= $request->nominal;
            $totalContribution->save();

            $accountancy                = new Accountancy();
            $accountancy->code          = $expenseReport->code;
            $accountancy->date          = $expenseReport->out_date;
            $accountancy->type          = $expenseReport->type;
            $accountancy->income        = 0;
            $accountancy->expense       = $expenseReport->nominal;
            $accountancy->total         = $expenseReport->nominal;
            $accountancy->save();

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
