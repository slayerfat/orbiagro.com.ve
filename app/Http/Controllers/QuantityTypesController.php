<?php

namespace Orbiagro\Http\Controllers;

use Orbiagro\Http\Requests;
use Orbiagro\Http\Requests\QuantityTypeRequest;
use Orbiagro\Models\QuantityType;
use Orbiagro\Repositories\Interfaces\QuantityTypeRepositoryInterface;

class QuantityTypesController extends Controller
{

    /**
     * @var QuantityTypeRepositoryInterface
     */
    private $quantityTypeRepo;

    /**
     * @param QuantityTypeRepositoryInterface $quantityType
     */
    public function __construct(QuantityTypeRepositoryInterface $quantityType)
    {
        $this->middleware('auth');
        $this->middleware('user.admin');

        $this->quantityTypeRepo = $quantityType;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quantityTypes = $this->quantityTypeRepo->getAll();

        return view('quantityType.index', compact('quantityTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $quantityType = $this->quantityTypeRepo->getEmptyInstance();

        return view('quantityType.create', compact('quantityType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Orbiagro\Http\Requests\QuantityTypeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuantityTypeRequest $request)
    {
        $quantityType = $this->quantityTypeRepo->create($request->all());

        return view('quantityType.show', compact('quantityType'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quantityType = $this->quantityTypeRepo->getById($id);

        return view('quantityType.show', compact('quantityType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quantityType = $this->quantityTypeRepo->getById($id);

        return view('quantityType.edit', compact('quantityType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuantityTypeRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @see MakersController::create()
     */
    public function update(QuantityTypeRequest $request, $id)
    {
        /** @var QuantityType $quantityType */
        $quantityType = $this->quantityTypeRepo->update($id, $request->all());

        flash('El Tipo de cantidad ha sido actualizado correctamente.');

        return redirect()->route('quantityTypes.show', $quantityType->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
