<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductsRequest;
use App\Http\Requests\Admin\UpdateProductsRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class ProductsController extends Controller
{
    /**
     * Display a listing of Product.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('product_access')) {
            return abort(401);
        }
        if ($filterBy = Input::get('filter')) {
            if ($filterBy == 'all') {
                Session::put('Product.filter', 'all');
            } elseif ($filterBy == 'my') {
                Session::put('Product.filter', 'my');
            }
        }

        if (request('show_deleted') == 1) {
            if (! Gate::allows('product_delete')) {
                return abort(401);
            }
            $products = Product::onlyTrashed()->get();
        } else {
            $products = Product::all();
        }

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating new Product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('product_create')) {
            return abort(401);
        }

        $created_by_teams = Team::has('members')->get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $created_by_ids = Team::with('members')->findOrFail(session('team_id'))
            ->members->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.products.create', compact('created_by_teams', 'created_by_ids'));
    }

    /**
     * Store a newly created Product in storage.
     *
     * @param  \App\Http\Requests\StoreProductsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductsRequest $request)
    {
        if (! Gate::allows('product_create')) {
            return abort(401);
        }

        $data = $request->all();
        $data['created_by_team_id'] = $data['created_by_team_id'] ?? session('team_id');
        $data['created_by_id'] = $data['created_by_id'] ?? Auth::id();

        $product = Product::create($data);

        return redirect()->route('admin.products.index');
    }


    /**
     * Show the form for editing Product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('product_edit')) {
            return abort(401);
        }

        $created_by_teams = Team::has('members')->get()->pluck('name', 'id')->prepend(trans('quickadmin.qa_please_select'), '');
        $created_by_ids = User::all()->pluck('name', 'id');

        $product = Product::findOrFail($id);

        return view('admin.products.edit', compact('product', 'created_by_teams', 'created_by_ids'));
    }

    /**
     * Update Product in storage.
     *
     * @param  \App\Http\Requests\UpdateProductsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductsRequest $request, $id)
    {
        if (! Gate::allows('product_edit')) {
            return abort(401);
        }
        $data = $request->all();
        $data['created_by_team_id'] = $data['created_by_team_id'] ?? session('team_id');
        $data['created_by_id'] = $data['created_by_id'] ?? Auth::id();

        $product = Product::findOrFail($id);
        $product->update($data);

        return redirect()->route('admin.products.index');
    }


    /**
     * Display Product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('product_view')) {
            return abort(401);
        }
        $product = Product::findOrFail($id);

        return view('admin.products.show', compact('product'));
    }


    /**
     * Remove Product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('product_delete')) {
            return abort(401);
        }
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index');
    }

    /**
     * Delete all selected Product at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('product_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Product::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('product_delete')) {
            return abort(401);
        }
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.index');
    }

    /**
     * Permanently delete Product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('product_delete')) {
            return abort(401);
        }
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        return redirect()->route('admin.products.index');
    }
}
