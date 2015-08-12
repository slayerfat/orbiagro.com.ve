<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Intervention;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mamarrachismo\Upload\Image as Upload;

use App\Image;

class ImagesController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('user.admin');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $image = Image::findOrFail($id);

    return view('images.edit', compact('image'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  Request  $request
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request, $id, Upload $upload)
  {
    $upload->userId = Auth::id();

    $image = Image::with('imageable')->findOrFail($id);

    if ($request->file('image'))
    {
      // se iteran las imagenes y se guardan los modelos
      $image = $upload->updateImage($request->file('image'), $image->imageable, $image);
    }

    $updatedImage = Intervention::make($image->path);
    $updatedImage->crop(
      $request->input('dataWidth'),
      $request->input('dataHeight'),
      $request->input('dataX'),
      $request->input('dataY')
    );

    $upload->updateImage($updatedImage, $image->imageable, $image);

    flash()->success('Imagen Actualizada exitosamente.');
    return redirect()->action('ProductsController@show', $image->imageable->id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $image = Image::with('imageable')->findOrFail($id);

    $product = $image->imageable;

    flash()->success('Imagen Eliminada exitosamente.');
    return redirect()->action('ProductsController@show', $product->id);
  }
}
