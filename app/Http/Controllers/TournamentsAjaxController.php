<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Yajra\DataTables\Facades\DataTables;

class TournamentsAjaxController extends Controller
{
    public function getData(Request $request)
    {
        if ($request->has('search')) {
            $search_parameter = $request->get('search')['value'];
            $order_by = $request->get('order');
            $start = $request->get('start');
            $length = $request->get('length');
            $draw = $request->get('draw');
            return $this->getTournaments($draw, $search_parameter, $order_by, $start, $length);
        }
    }

    private function getTournaments($draw, $search_parameter, $order_by, $start, $length)
    {

        $query = Tournament::query();
        $query->search($search_parameter);
        $query->limit_by($start, $length)->get();
        $numberOfTotalRows = Tournament::all()->count();
        $numberOfFilteredRows = Tournament::search($search_parameter)->get()->count();
        $query = $query->get();
        return $this->yajraData($query, $numberOfFilteredRows, $numberOfTotalRows);
    }

    private function yajraData(
        Collection $query,
        int $numberOfFilteredRows,
        int $numberOfTotalRows
    ) {
        return DataTables::of($query)
            ->skipPaging()
            ->addColumn('id', function($tournament) {
                return $tournament->id;
            })
            ->addColumn('name', function($tournament) {
                return $tournament->name;
            })
            ->addColumn('no_of_teams', function($tournament) {
                return $tournament->no_of_teams;
            })
            ->addColumn('no_of_overs', function($tournament) {
                return $tournament->no_of_overs;
            })
            ->addColumn('Start Date', function($tournament) {
                return $tournament->start_date;
            })
            ->addColumn('Organized By', function($tournament) {
                return $tournament->organizer->name;
            })
            ->addColumn('action', function ($tournament) {
                if($tournament->tournament_teams()->count() > 0) {
                    $route = route('teams.index', $tournament->id);
                    return "<a href='$route' class='btn btn-outline-info'><i class='fa fa-eye'></i></a>";
                }
                $route = route('teams.create', $tournament->id);
                return "<a href='$route' class='btn btn-dark text-warning'><i class='fa fa-plus'></i></a>";
            })
            ->rawColumns(['action'])
            ->setFilteredRecords($numberOfFilteredRows)
            ->setTotalRecords($numberOfTotalRows)
            ->make(true);
    }
}
