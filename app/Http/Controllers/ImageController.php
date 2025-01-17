<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify'); // Protección de rutas por JWT
    }

    // Leer todas las imágenes de un usuario
    public function index()
    {
        $images = Image::where('user_id', Auth::id())->get();
        return response()->json($images);
    }
    
    //ver imagen
    public function viewImage($id)
    {
        $image = Image::findOrFail($id);

        // Verificar que el usuario autenticado sea el propietario de la imagen
        if ($image->user_id !== Auth::id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        // Proveer el archivo de la imagen desde la ubicación privada
        if (Storage::exists($image->path)) {
            return response()->download(Storage::path($image->path));
        }

        return response()->json(['message' => 'Imagen no encontrada'], 404);
    }

    // Crear una imagen
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,gif|max:2048',
            'title' => 'required|max:200',
            'description' => 'required',
        ]);

        $image = $request->file('image');
        $imageName = Str::random(10) . '.' . $image->getClientOriginalExtension();
        
        // Almacenar la imagen en el disco 'private'
        $imagePath = $image->storeAs('private/images', $imageName);

        // Guardar la información de la imagen en la base de datos
        $imageRecord = Image::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'user_id' => Auth::id(),
        ]);

        return response()->json($imageRecord, 201);
    }

    // Actualizar una imagen
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:200',
            'description' => 'required',
        ]);

        $image = Image::findOrFail($id);        

        // Actualizar la base de datos con la nueva información
        $image->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json($image, 200);
    }

    // Eliminar una imagen
    public function destroy($id)
    {
        $image = Image::findOrFail($id);

        // Eliminar el archivo de la imagen en el servidor
        if (Storage::exists($image->path)) {
            Storage::delete($image->path);
        }

        $image->delete();

        return response()->json(['message' => 'Imagen eliminada con éxito'], 200);
    }
}
